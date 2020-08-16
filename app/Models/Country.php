<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idCountry';
    protected $table = 'countries';
    protected $guarded =  ['created_at', 'updated_at', 'deleted_at'];
}
