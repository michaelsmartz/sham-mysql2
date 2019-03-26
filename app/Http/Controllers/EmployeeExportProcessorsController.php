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

            if($auditItem->auditable_type == "App\Employee")
            {
                $employee = Employee::find($auditItem->auditable_id);

                $employee_no = $employee->employee_no;
                $newvalues =  $auditItem->new_values;

                // 02 Employee
                $auditItemArray[1] = $employee_no;

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

                // 21 Tax number
                if(array_key_exists('tax_number',$newvalues)){
                    $auditItemArray[20] = $newvalues['tax_number'];
                }
            }

            $data[] = $auditItemArray;
        }

        //dump($audit);
        //die;

        $export = new EmployeeExport();
        $export->employees($data);

        $filedateformat = date("Ymdhms");

        return Excel::download($export, 'Employee_Change_'.$filedateformat.'.xlsx');
    }


}
