<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CustomController;
use App\Models\EmployeeProcessor;
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

            return redirect()->route('employee_processors.upload')
                             ->with('success_message', 'Employee details was successfully uploaded');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    private function updateCreateEmployee($array_csv){
        //dd($array_csv);
        foreach ($array_csv as $key => $row){

            dump($row);

            //header array
            if($key == 1){
                $key = array_search ('Employee', $row);
            }
            else{ //data to be updated or inserted

            }
        }
        exit();
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
}
