<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idCity';
    protected $table = 'cities';
    protected $guarded =  ['created_at', 'updated_at', 'deleted_at'];
}
