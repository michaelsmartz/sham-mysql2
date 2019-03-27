<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Controllers\CustomController;
use App\SysConfigValue;
use DB;
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
            dd($exception->getMessage());
            \Session::put('error', 'import was not successful!');
        }

        return redirect()->route('employeeProcessors.show-form');
    }

    private function updateCreateEmployee($array_csv){
        //dd($array_csv);
        //TODO and missing entry in Hams employee table addresses, phone numbers
        ini_set('max_execution_time', 1000);
        $insert = [];
        foreach ($array_csv as $key => $row){

            //header array
            if($key != 1){ //data to be updated or inserted

                $existing_employees = Employee::all()->toArray();

                if(array_search($row[1], array_column($existing_employees, 'employee_no')) !== False) {

                    $row = $this->removeEmptyMapperUnset($row);

                    if(!empty($row) && !is_null($row['employee_no'])){
                        try{
                            $employee = Employee::where(['employee_no'=>$row['employee_no']]);

                            if(isset($row['employee_no']))
                                unset($row['employee_no']);

                            $employee->update($row);
                        } catch (Exception $exception) {
                            dd($exception->getMessage());
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

                    $row = $this->removeEmptyMapperUnset($row);

                    //dump($row);

                    $insert[] = [
                        'id_number' => isset($row['id_number'])?$row['id_number']:null,
                        'employee_no' => isset($row['employee_no'])?$row['employee_no']:null,
                        'employee_code' => $sfeCodeUnique,
                        "birth_date" => isset($row['birth_date'])?$row['birth_date']:null,
                        "gender_id" => isset($row['gender_id'])?$row['gender_id']:null,
                        "title_id" => isset($row['title_id'])?$row['title_id']:null,
                        "marital_status_id" => isset($row['marital_status_id'])?$row['marital_status_id']:null,
                        "first_name" => isset($row['first_name'])?$row['first_name']:null,
                        "known_as" => isset($row['known_as'])?$row['known_as']:null,
                        "surname" => isset($row['surname'])?$row['surname']:null,
                        "passport_country_id" => isset($row['passport_country_id'])?$row['passport_country_id']:null,
                        "department_id" => isset($row['department_id'])?$row['department_id']:null,
                        "job_title_id" => isset($row['job_title_id'])?$row['job_title_id']:null,
                        "tax_status_id" => isset($row['tax_status_id'])?$row['tax_status_id']:null,
                        "tax_number" => isset($row['tax_number'])?$row['tax_number']:null
                    ];
                }
            }
        }

        try{
            //dd($insert);
            DB::table('employees')->insert($insert);
        } catch (Exception $exception) {
            dd($exception->getMessage());
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

    private function removeEmptyMapperUnset($csv_row){
        $csv_row = $this->removeNullEmptyValue($csv_row);

        $csv_row = $this->mapper($csv_row);

        //unset what is not needed in update
        if(isset($csv_row['division_id']))
            unset($csv_row['division_id']);
        if(isset($csv_row['branch_id']))
            unset($csv_row['branch_id']);
        if(isset($csv_row['team_id']))
            unset($csv_row['team_id']);
        if(isset($csv_row['physical_file_no']))
            unset($csv_row['physical_file_no']);

        return $csv_row;
    }

    /**
     * if key exist in mapper replace $arr with value in mapper
     * @param $arr
     * @return array
     */
    private function mapper($arr){
        $array_new = [];

        $arr = $this->lookupEmployeeForeignKey($arr);

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
            22=>"job_title_id",
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
     * lookup for definition of ids in hams e.g title_id, gender_id, marital_status_id
     * @param $csv_row
     * @return mixed
     */
    private function lookupEmployeeForeignKey($csv_row){
        foreach($csv_row as $column_position => $vip_header_name)
        {
            switch($column_position)
            {
                //title
                case 2:
                    $csv_row = $this->replaceColumnNameWithId($csv_row, $vip_header_name, 'Title', 'title_code');
                    break;
                //passport country
                case 11:
                    $csv_row = $this->replaceColumnNameWithId($csv_row, $vip_header_name, 'Country', 'country_code');
                    break;
                //ethnic group
                case 12:
                    $csv_row = $this->replaceColumnNameWithId($csv_row, $vip_header_name, 'EthnicGroup', 'ethnic_group_code');
                    break;
                //gender
                case 13:
                    $csv_row = $this->replaceColumnNameWithId($csv_row, $vip_header_name, 'Gender', 'gender_code');
                    break;
                //marital status
                case 14:
                    $csv_row = $this->replaceColumnNameWithId($csv_row, $vip_header_name, 'MaritalStatus', 'marital_status_code');
                    break;
                //tax status
                case 21:
                    $csv_row = $this->replaceColumnNameWithId($csv_row, $vip_header_name, 'TaxStatus', 'tax_status_code');
                    break;
                //job title
                case 22:
                    $csv_row = $this->replaceColumnNameWithId($csv_row, $vip_header_name, 'JobTitle', 'job_title_code');
                    break;
                //department
                case 24:
                    $csv_row = $this->replaceColumnNameWithId($csv_row, $vip_header_name, 'Department', 'department_code');
                    break;
                default:
                    break;
            }
        }
        return $csv_row;
    }

    /**
     * Function to replace column name from vip to match id in tables like titles, genders,...etc
     * @param $csv_row
     * @param $header_name
     * @param $model
     * @param $table_field_code
     * @return mixed
     */
    private function replaceColumnNameWithId($csv_row, $header_name, $model, $table_field_code){
        $modelClass = 'App\\'.$model;
        $data = $modelClass::where([$table_field_code => $header_name])->get(['id'])->first();

        $arr_key = array_search($header_name, $csv_row); // returns the first key whose value is e.g. "MR"
        $csv_row[$arr_key] = $data->id; // replace e.g 'MR' with '14' id in title table

        return $csv_row;
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
