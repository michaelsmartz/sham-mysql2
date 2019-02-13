<?php

namespace App\Support;

use Exception;

class Helper {

    public static function getAllowedActions($sub_module_id){
        $temp = session('modulePermissions');

        try {
            $result = $temp[$sub_module_id];

            return $result;

        } catch(exception $e) {
            return collect([]);
        }
    }

    public static function increment($string) { 
        return preg_replace_callback('/^([^0-9]*)([0-9]+)([^0-9]*)$/', array('self', "subfunc"), $string); 
    }

    public static function subfunc($m) { 
        return $m[1].str_pad($m[2]+1, strlen($m[2]), '0', STR_PAD_LEFT).$m[3]; 
    }
}