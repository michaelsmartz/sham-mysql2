<?php

namespace App\Support;

use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class Collection extends BaseCollection
{
    public function paginate($perPage, $total = null, $page = null, $pageName = 'page')
    {
        $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
      
        return new LengthAwarePaginator(
            $this->forPage($page, $perPage),
            $total ?: $this->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]
        );
    }

    public function toJsonTags($key='id', $value='description')
    {

        $res['temp'] = array();
        foreach($this->items as $i => $j) {

            $o = new \stdClass;
            $o->$key = $i;
            $o->value = $j;
            $res['temp'][] = $o;
            unset($o);
            
        }

        return json_encode($res['temp']);
    }
}