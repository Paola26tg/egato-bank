<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agency extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idAgency';
    protected $table = 'agencies';
    protected $guarded =  ['created_at', 'updated_at', 'deleted_at'];
}
