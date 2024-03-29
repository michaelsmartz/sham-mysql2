<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvImportRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use App\Imports\UsersImport;
use App\CsvDatum;

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

    public function parseImport(Request $request)
    {
        if (!is_null($request->request->get('attachment'))) {
            try {
                $file = $request->request->get('attachment')[0];

                $thefile = $file['title'];
                $content = $file['value'];
                $path = \Storage::disk('uploads')->getAdapter()->getPathPrefix(). $thefile;
                $savedPath = $this->base64ToFile($content, $path);

            } catch (Exception $e) {
                Session::put('error', $e->getMessage());
            }
        }

        if ($request->has('header')) {
            $data = (new UsersImport)->toArray($thefile,'uploads');
        }

        if (count($data) > 0) {
            if ($request->has('header')) {
                $csv_header_fields = [];
                foreach ($data[0][0] as $key => $value) {
                    if(\strlen($key) < 1) {
                        continue;
                    }
                    $csv_header_fields[] = $key;
                }
            }

            $csv_data = array_slice($data[0], 0, 2);

            foreach ($csv_data as &$value) {
                $value = array_filter($value);
            }

            $csv_data_file = CsvDatum::create([
                'csv_filename' => $thefile,
                'csv_header' => $request->has('header'),
                'csv_data' => json_encode($csv_data)
            ]);
        } else {
            return redirect()->back();
        }

        return view($this->baseViewPath .'.import_fields', compact( 'csv_header_fields', 'csv_data', 'csv_data_file'));

    }

    public function processImport(Request $request)
    {
        $data = CsvDatum::find($request->csv_data_file_id);
        $csv_data = json_decode($data->csv_data, true);
        $skippedColumns = [];

        foreach($request->fields as $column => $value){
            if(trim(strtoupper($value)) === 'SKIP') {
                $skippedColumns[] = $column;
            }
        }

        foreach ($csv_data as $row) {

            $contact = new \stdClass();
            foreach (CsvDatum::$dbFields as $index => $field) {
                //dump($index); dump($field);

                try{
                    if(in_array($field, $skippedColumns) ){
                        continue;
                    }
                    //if ($data->csv_header) {
                    $contact->$field = $row[$request->fields[$field]];
                    //} else {
                    //    $contact->$field = $row[$request->fields[$index]];
                    //}
                } catch(Exception $e) {

                }
            }
            dump($contact);
            //$contact->save();
        }

        return view($this->baseViewPath .'.import_success');
    }

    protected function base64ToFile($base64String, $outputFile) {
        $ifp = fopen($outputFile, "wb"); 
    
        $data = explode(',', $base64String);
    
        fwrite($ifp, base64_decode($data[1])); 
        fclose($ifp); 
    
        return $outputFile; 
    }

}
