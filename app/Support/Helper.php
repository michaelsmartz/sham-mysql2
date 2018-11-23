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
}