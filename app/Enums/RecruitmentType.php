<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RecruitmentType extends Enum
{
    const INTERNAL = 1;
    const EXTERNAL = 2;
    const BOTH = 3;
    /**
     * Get the description for an enum value
     *
     * @param  int  $value
     * @return string
     */

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::INTERNAL:
                return 'internal';
                break;
            case self::EXTERNAL:
                return 'external';
                break;
            case self::BOTH:
                return 'both';
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
