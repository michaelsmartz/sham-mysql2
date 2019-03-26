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

       // Excel::create('Filename', function($excel) {

       // })->download('xlss');

        //$excel = App::make('excel');

       // Excel::create('ExcelName')
       //     ->sheet('SheetName')
       //     ->with(array('data', 'data'))
       //     ->export('xls');

        /*return Excel::create('hdtuto_demo', function($excel) {

            $excel->sheet('sheet name', function($sheet)

            {

                $sheet->fromArray(['a','b']);

            });

        })->download("xlsx");*/

        //return Excel::download(new Employee, 'users.xlsx');

        $data = [];

        $data = [
            ['Name','Surname','Address'],
            [1, 2, 3],
            [4, 5, 6]
        ];

        $export = new EmployeeExport();
        $export->employees($data);

        return Excel::download($export, 'invoices.xlsx');


        //return 1;
    }


}
