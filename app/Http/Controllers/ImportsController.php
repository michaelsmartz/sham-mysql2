<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvImportRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class ImportsController extends Controller
{

    public $baseViewPath;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseViewPath = 'imports';
    }

    public function getImport()
    {
        $uploader = [
            "fieldLabel" => "Upload filled Excel Template file",
            "restrictionMsg" => "Upload Excel file only",
            "acceptedFiles" => "['xls', 'xlsx']",
            "fileMaxSize" => "1.7", // in MB
            "totalMaxSize" => "5", // in MB
            "multiple" => "" // set as empty string for single file, default multiple if not set
        ];
        return view($this->baseViewPath .'.import', compact('uploader'));
    }

    public function parseImport(CsvImportRequest $request)
    {

        $path = $request->file('attachment')->getRealPath();
        dump($path);
        die;
        
        if ($request->has('header')) {
            $data = Excel::load($path, function($reader) {})->get()->toArray();
        } else {
            $data = array_map('str_getcsv', file($path));
        }

        if (count($data) > 0) {
            if ($request->has('header')) {
                $csv_header_fields = [];
                foreach ($data[0] as $key => $value) {
                    $csv_header_fields[] = $key;
                }
            }
            $csv_data = array_slice($data, 0, 2);

            $csv_data_file = CsvData::create([
                'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
                'csv_header' => $request->has('header'),
                'csv_data' => json_encode($data)
            ]);
        } else {
            return redirect()->back();
        }

        return view($this->baseViewPath .'.import_fields', compact( 'csv_header_fields', 'csv_data', 'csv_data_file'));

    }

    public function processImport(Request $request)
    {
        /*$data = CsvData::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        foreach ($csv_data as $row) {
            $contact = new Contact();
            foreach (config('app.db_fields') as $index => $field) {
                if ($data->csv_header) {
                    $contact->$field = $row[$request->fields[$field]];
                } else {
                    $contact->$field = $row[$request->fields[$index]];
                }
            }
            $contact->save();
        }*/

        return view($this->baseViewPath .'.\Dompdf\Positioner\Absoluteimport_success');
    }

}
