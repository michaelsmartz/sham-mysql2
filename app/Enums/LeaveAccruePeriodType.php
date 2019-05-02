<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class LeaveAccruePeriodType extends Enum
{
    
    const months_12 = 1;
    const month_1  = 2;
    const months_24 = 3;
    const months_36 = 4;

    /**
     * Get the description for an enum value
     *
     * @param  int  $value
     * @return string
     */

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::months_12:
                return 'Every 12 months';
                break;
            case self::month_1:
                return 'Every 1 month';
                break;
            case self::months_24:
                return 'Every 24 months';
                break;
            case self::months_36:
                return 'Every 36 months';
                break;
            default:
                return  self::getKey($value);
        }
    }

    public static function ddList(){
        $values = self::getValues();

        $ret = array_combine( $values,
            array_map(function($v){
            return static::getDescription($v);
        }, $values));


        return $ret;
    }

    public static function keyValueArrayList() {
        $temp = static::ddList();
        $ret = array();

        foreach($temp as $k => $v)
        {
            $ret[] = array('key' => $k, 'value' => $v);
        }

        return $ret;
    }
}
