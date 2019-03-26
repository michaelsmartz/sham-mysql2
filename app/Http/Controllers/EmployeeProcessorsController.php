<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Controllers\CustomController;
use App\Models\EmployeeProcessor;
use App\SysConfigValue;
use DB;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Exception;

class EmployeeProcessorsController extends CustomController
{
    /**
     * Show the form for creating a new employee processor.
     *
     * @return Illuminate\View\View
     */
    public function showForm()
    {
        return view('employee_processors.upload');
    }

    /**
     * Store a new employee processor in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $datas = [];

            if (!is_null($request->request->get('attachment'))) {
                $datas = $this->readCSV($request->request->get('attachment'));
            }

            foreach($datas as $data){
                $this->updateCreateEmployee($data);
            }

            \Session::put('success', 'import was successful!');

        } catch (Exception $exception) {
            \Session::put('error', 'import was not successful!');
        }

        return redirect()->route('employeeProcessors.show-form');
    }

    private function updateCreateEmployee($array_csv){
        //dd($array_csv);
        print_r($_SESSION);
        ini_set('max_execution_time', 1000);
        $insert = [];
        foreach ($array_csv as $key => $row){
            //dump($row);

            //header array
            if($key != 1){ //data to be updated or inserted

                $existing_employees = Employee::all()->toArray();

                if(array_search($row[1], array_column($existing_employees, 'employee_no')) !== False) {
                    //unset employee_no
                    $employee_id = $row[1];
                    unset($row[1]);

                    $row = $this->removeNullEmptyValue($row);

                    $row = $this->mapper($row);

                    if(!empty($row) && !is_null($employee_id)){
                        try{
                            $employee = Employee::where(['employee_no'=>$employee_id]);
                            $employee->update($row);
                        } catch (Exception $exception) {
                            //dd($exception->getMessage());
                            \Session::put('error', 'could not update Employee!');
                        }
                    }
                } else {
                    $sfeCode = SysConfigValue::where('key', '=', 'LATEST_SFE_CODE')->first();

                    $sfeCodeUnique = null;
                    if ($sfeCode !== null) {
                        $sfeCodeUnique = $this->increment($sfeCode->value);
                        $sfeCode->value = $sfeCodeUnique;
                    }
                    $sfeCode->save();

                    $insert[] = [
                        'id_number' => $row[6],
                        'employee_no' => $row[1],
                        'employee_code' => $sfeCodeUnique,
                        "birth_date" => $row[7],
                        "gender_id" => null,
                        "title_id" => null,
                        "marital_status_id" => null,
                        "first_name" => $row[3],
                        "known_as" => $row[4],
                        "surname" => $row[5],
                        "passport_country_id" => null,
                        "passport_no" => $row[10],
                        "immigration_status_id" => null,
                        "nationality" => null,
                        "ethnic_group_id" => null,
                        "spouse_full_name" => null,
                        "division_id" => null,
                        "branch_id" => null,
                        "department_id" => null,
                        "team_id" => null,
                        "physical_file_no" => null,
                        "job_title_id" => null,
                        "line_manager_id" => null,
                        "date_joined" => null,
                        "employee_status_id" => null,
                        "tax_status_id" => null,
                        "tax_number" => null
                    ];
                }
            }
        }

        try{
            DB::table('employees')->insert($insert);
        } catch (Exception $exception) {
            //dd($exception->getMessage());
            \Session::put('error', 'could not insert Employee!');
        }
    }

    /**
     * read multiple csv files
     * @param $files
     * @return array
     */
    private function readCSV($files){
        $rows = [];
        foreach($files as $key => $file) {
            $stream = fopen($file['value'], 'r');

            $row = 1;
            if ($stream !== FALSE) {
                while (($data = fgetcsv($stream, 0, ";")) !== FALSE) {
                    $num = count($data);
                    $row++;
                    for ($c=0; $c < $num; $c++) {
                        $rows[$key][$row-1][] = $data[$c];
                    }
                }
                fclose($stream);
            }
        }

        return $rows;
    }

    private function increment($string) {
        return preg_replace_callback('/^([^0-9]*)([0-9]+)([^0-9]*)$/', array($this, "subfunc"), $string);
    }

    private function subfunc($m) {
        return $m[1].str_pad($m[2]+1, strlen($m[2]), '0', STR_PAD_LEFT).$m[3];
    }

    /**
     * if key exist in mapper replace $arr with value in mapper
     * @param $arr
     * @return array
     */
    private function mapper($arr){
        $array_new = [];

        //TODO link with lookup for one-to-many relations and missing entry
        //Note mapper should be same as header in csv file, value should correspond to Hams database table fields
        $mapper = [
            1=>"employee_no",
            2=>"title_id",
            3=>"first_name",
            4=>"known_as",
            5=>"surname",
            6=>"id_number",
            7=>"birth_date",
            8=>"date_joined",
            10=>"passport_no",
            11=>"passport_country_id",
            13 =>"gender_id",
            14=>"marital_status_id",
            15=>"division_id",
            16=>"branch_id",
            18=>"team_id",
            19=>"physical_file_no",
            20=>"tax_number",
            21=>"tax_status_id",
            23=>"job_title_id",
            24=>"department_id"
        ];

        foreach($arr as $key=>$value)
        {
            if(array_key_exists($key, $mapper))
            {
                $array_new[$mapper[$key]] = $arr[$key];
            }
        }

        return $array_new;
    }

    /**
     * remove null or empty value in an array
     * @param $data
     * @return mixed
     */
    private function removeNullEmptyValue($data){
        //unset empty or null values from array $data
        foreach($data as $key=>$value)
        {
            if(is_null($value) || $value == '')
                unset($data[$key]);
        }

        return $data;
    }
}
