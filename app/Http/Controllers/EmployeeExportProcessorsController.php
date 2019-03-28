<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Controllers\CustomController;
use App\Models\EmployeeProcessor;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
//use Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Exception;
use App\EmployeeExport;
use App\Title;
use App\TelephoneNumber;

class EmployeeExportProcessorsController extends CustomController
{
    /**
     * Show the form for creating a new employee processor.
     *
     * @return Illuminate\View\View
     */
    public function showForm()
    {
        return view('employee_processors.download');
    }

    /**
     * Store a new employee processor in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function download(Request $request)
    {

        $title = ["Company","Employee","Title","First name","Second name","Surname","Id number/Co. No.","Date of birth",
            "Date engaged","Date terminated","Passport no.","Passport country","Group","Gender","Marital status",
            "Home number","Cell number","E-mail","SOS name","SOS cell","Tax number","Tax status","Job title code",
            "Job title","Department","Manager","Rep. addr1","Rep. addr2","Rep. addr3","Rep. post code"];

        $data = [
            $title
        ];

        $auditItems = \OwenIt\Auditing\Models\Audit::where('event','updated')
            ->whereDate('created_at', '>', '2019-03-25') ->get();

        foreach ($auditItems as $auditItem) {
            $auditItemArray = array_fill(0, 30, "");
            $newvalues =  $auditItem->new_values;

            if($auditItem->auditable_type == "App\Employee")
            {
                $employee = Employee::find($auditItem->auditable_id);
                $employee_no = $employee->employee_no;

                // 02 Employee
                $auditItemArray[1] = $employee_no;

                // 03 First Name
                if(array_key_exists('title_id',$newvalues)){
                    $title_id = $newvalues['title_id'];

                    $title = Title::find($title_id);
                    $auditItemArray[2] = $title->description;
                }

                // 04 First Name
                if(array_key_exists('first_name',$newvalues)){
                    $auditItemArray[3] = $newvalues['first_name'];
                }

                // 05 Second Name
                if(array_key_exists('known_as',$newvalues)){
                    $auditItemArray[4] = $newvalues['known_as'];
                }

                // 06 Surname
                if(array_key_exists('surname',$newvalues)){
                    $auditItemArray[5] = $newvalues['surname'];
                }

                // 07 Id number/Co. No.
                if(array_key_exists('id_number',$newvalues)){
                    $auditItemArray[6] = $newvalues['id_number'];
                }

                // 08 Date of Birth
                if(array_key_exists('birth_date',$newvalues)){
                    $auditItemArray[7] = $newvalues['birth_date'];
                }

                // 09 Date engaged
                if(array_key_exists('date_joined',$newvalues)){
                    $auditItemArray[8] = $newvalues['date_joined'];
                }

                // 10 Date terminated
                if(array_key_exists('date_terminated',$newvalues)){
                    $auditItemArray[9] = $newvalues['date_terminated'];
                }

                // 11 Passport no.
                if(array_key_exists('passport_no',$newvalues)){
                    $auditItemArray[10] = $newvalues['passport_no'];
                }

                // 13 Group '{"ethnic_group_id":1}'
                if(array_key_exists('ethnic_group_id',$newvalues)){
                    $ethnic_group_id = $newvalues['ethnic_group_id'];
                    // find and search ethinic group code
                    $auditItemArray[12] = $newvalues['ethnic_group_id'];
                }

                // 14 Gender '{"gender_id":1}'
                if(array_key_exists('gender_id',$newvalues)){
                    $gender_id = $newvalues['gender_id'];
                    // find and search ethinic group code
                    $auditItemArray[13] = $newvalues['gender_id'];
                }

                // 15 Gender '{"marital_status_id":1}'
                if(array_key_exists('marital_status_id',$newvalues)){
                    $marital_status_id = $newvalues['marital_status_id'];
                    // find and search ethinic group code
                    $auditItemArray[14] = $newvalues['marital_status_id'];
                }

                // 21 Tax number
                if(array_key_exists('tax_number',$newvalues)){
                    $auditItemArray[20] = $newvalues['tax_number'];
                }
            }

            // 16 Home number
            if($auditItem->auditable_type == "App\TelephoneNumber"){

                if(array_key_exists('tel_number',$newvalues)){
                    $tel_no = $newvalues['tel_number'];
                    $telephone_number_id = $auditItem->auditable_id;

                    $telephone_number = TelephoneNumber::find($telephone_number_id);
                    $employee_id = $telephone_number->employee_id;

                    $employee = Employee::find($employee_id);
                    $employee_no = $employee->employee_no;

                    // 02 Employee
                    $auditItemArray[1] = $employee_no;

                    if($telephone_number->telephone_number_type_id == 1){
                        $auditItemArray[15] = $tel_no;
                    }
                    elseif($telephone_number->telephone_number_type_id == 2){
                        $auditItemArray[16] = $tel_no;
                    }
                }
            }

            $data[] = $auditItemArray;
        }


        $export = new EmployeeExport();
        $export->employees($data);

//        if(!is_null($data))
//            $this->fixedWidthFileProcess($export->array());

        $filedateformat = date("Ymdhms");

        return Excel::download($export, 'Employee_Change_'.$filedateformat.'.xlsx');
    }

    private function fixedWidthFileProcess($files){

        //dd($files);

        $result = [];
        foreach ($files as $lines) {
            foreach ($lines as $key => $line) {
                $result[] = $this->str_pad_unicode($line, $key, ' ', STR_PAD_BOTH);
                //$result[] = $this->str_pad_html($line, $key, ' ', STR_PAD_BOTH);
            }
        }

        dd($result);
    }

    /**
     * @param $str
     * @param $pad_len
     * @param string $pad_str
     * @param int $dir
     * @return null|string
     */
    function str_pad_unicode($str, $pad_len, $pad_str = ' ', $dir = STR_PAD_RIGHT) {

        $str_len = mb_strlen($str);
        $pad_str_len = mb_strlen($pad_str);

        if (!$str_len && ($dir == STR_PAD_RIGHT || $dir == STR_PAD_LEFT)) {
            $str_len = 1; // @debug
        }

        if (!$pad_len || !$pad_str_len || $pad_len <= $str_len) {
            return $str;
        }

        $result = null;
        $repeat = ceil($str_len - $pad_str_len + $pad_len);

        if ($dir == STR_PAD_RIGHT) {
            $result = $str . str_repeat($pad_str, $repeat);
            $result = mb_substr($result, 0, $pad_len);
        }
        else if ($dir == STR_PAD_LEFT) {
            $result = str_repeat($pad_str, $repeat) . $str;
            $result = mb_substr($result, -$pad_len);
        }
        else if ($dir == STR_PAD_BOTH) {
            $length = ($pad_len - $str_len) / 2;
            $repeat = ceil($length / $pad_str_len);
            $result = mb_substr(str_repeat($pad_str, $repeat), 0, floor($length))
                . $str
                . mb_substr(str_repeat($pad_str, $repeat), 0, ceil($length));
        }

        return $result;
    }

    /**
     * @param string $strInput
     * @param $intPadLength
     * @param string $strPadString
     * @param int $intPadType
     * @return string
     */
    function str_pad_html($strInput = "", $intPadLength, $strPadString = "&nbsp;", $intPadType = STR_PAD_RIGHT) {
        if (strlen(trim(strip_tags($strInput))) < intval($intPadLength)) {

            switch ($intPadType) {
                // STR_PAD_LEFT
                case 0:
                    $offsetLeft = intval($intPadLength - strlen(trim(strip_tags($strInput))));
                    $offsetRight = 0;
                    break;

                // STR_PAD_RIGHT
                case 1:
                    $offsetLeft = 0;
                    $offsetRight = intval($intPadLength - strlen(trim(strip_tags($strInput))));
                    break;

                // STR_PAD_BOTH
                case 2:
                    $offsetLeft = intval(($intPadLength - strlen(trim(strip_tags($strInput)))) / 2);
                    $offsetRight = round(($intPadLength - strlen(trim(strip_tags($strInput)))) / 2, 0);
                    break;

                // STR_PAD_RIGHT
                default:
                    $offsetLeft = 0;
                    $offsetRight = intval($intPadLength - strlen(trim(strip_tags($strInput))));
                    break;
            }

            $strPadded = str_repeat($strPadString, $offsetLeft) . $strInput . str_repeat($strPadString, $offsetRight);
            unset($strInput, $offsetLeft, $offsetRight);

            return $strPadded;
        }

        else {
            return $strInput;
        }
    }

}
