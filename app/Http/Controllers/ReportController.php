<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use View;
use Redirect;
//use Request;
use Validator;
use Session;
use App\SystemModule;
use App\ReportTemplate;

class ReportController extends CustomController
{

    // global validation rules for Announcement

    private $rules = array(
    );

    private $cipher = 'aes-256-gcm';
    private $key = "E4HD9h4DhS23DYfhHemkS3Nf";// 24 bit Key
    //private $iv = "fYfhHeDm";// 8 bit IV
    private $input = "Text to encrypt";// text to encrypt
    private $bit_check = 8;// bit amount for diff algor.
    private $sArr;



    /**
     * Create a new controller instance.
     *
     */
    public function __construct(){
        $this->contextObj = new ReportTemplate();
        $this->baseViewPath = 'dashboard-report';
        $this->baseFlash = 'Report Template details ';
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $reportMenu = $submenu = [];

        $reportTemplatesCentralHr = $this->contextObj::select(['id','source','title','system_module_id'])
            ->where('system_module_id',SystemModule::CONST_CENTRAL_HR)->get()->all();

        if(!empty($reportTemplatesCentralHr)) {
            // Main and SubMenus for CentralHR Reports
            $reportMenu[] = self::reportMenu($reportTemplatesCentralHr, SystemModule::CONST_CENTRAL_HR, "Central HR", "Smartz-Ham");

        }

        $reportTemplatesQA = $this->contextObj::select(['id','source','title','system_module_id'])
            ->where('system_module_id',SystemModule::CONST_QUALITY_ASSURANCE)->get()->all();

        if(!empty($reportTemplatesQA)){
            // Main and SubMenus for Quality Assurance Reports
            $reportMenu[] = self::reportMenu($reportTemplatesQA, SystemModule::CONST_QUALITY_ASSURANCE, "Quality Assurance", "Smartz-Ham");

        }

        $reportTemplatesTraining = $this->contextObj::select(['id','source','title','system_module_id'])
            ->where('system_module_id',SystemModule::CONST_TRAINING)->get()->all();

        if(!empty($reportTemplatesTraining)) {
            // Main and SubMenus for Elearning Reports
            $reportMenu[] = self::reportMenu($reportTemplatesTraining, SystemModule::CONST_TRAINING, "Elearning", "Smartz-Ham");

        }
        $this->sArr = serialize($reportMenu);
        $str = $this->encrypt($this->sArr,$this->cipher, $this->key, $this->bit_check);

        return view($this->baseViewPath . '.reports', compact('str'));
    }


    private function reportMenu($reportTemplates, $systemModule, $title, $project){
        $subMenu = [];
        $submenuItems = self::getItems($reportTemplates, $systemModule);
        if(sizeof($submenuItems) > 0)
        {
            $subMenu = [
                "project" => $project,
                "title" => $title,
                "items" => $submenuItems,
            ];
        }

        return $subMenu;
    }


    private function encrypt($text, $cipher, $key, $bit_check) {
        $text_num =str_split($text,$bit_check);
        $text_num = $bit_check-strlen($text_num[count($text_num)-1]);
        for ($i=0;$i<$text_num; $i++) {
            $text = $text . chr($text_num);
        }

        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);

        $ciphertext = openssl_encrypt($text, $cipher, $key, $options=0, $iv, $tag);
        //store $cipher, $iv, and $tag for decryption later
        $decrypted = openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv, $tag);

        return base64_encode($decrypted);
    }

    private function getItems($itemsobj,$moduleid)
    {
        $items = array();
        if ($itemsobj!=null)
        {
            foreach ($itemsobj as $itemobj)
            {
                if ($itemobj && $itemobj->system_module_id == $moduleid)
                {
                    $item = array("reportfile" => $itemobj->source, "title" => $itemobj->title);
                    $items[] = $item;
                }
            }
        }
        // Added Sorting by reportfile name
        // LINK: https://stackoverflow.com/questions/2699086/sort-multi-dimensional-array-by-value
        self::array_sort_by_column($items, 'reportfile');

        return $items;
    }

    private function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
        $sort_col = array();
        foreach ($arr as $key=> $row) {
            $sort_col[$key] = $row[$col];
        }

        array_multisort($sort_col, $dir, $arr);
    }
}

