<?php
/**
 * Created by PhpStorm.
 * User: TaroonG
 * Date: 5/7/2018
 * Time: 8:51 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Facades\Schema;
use App\Traits\HasBaseModel;
use Jedrzej\Searchable\SearchableTrait;
use San4io\EloquentFilter\Traits\Filterable;
use San4io\EloquentFilter\Filters\WhereFilter;
use San4io\EloquentFilter\Filters\LikeFilter;

class Model extends BaseModel
{
    use HasBaseModel, SearchableTrait, Filterable;
}