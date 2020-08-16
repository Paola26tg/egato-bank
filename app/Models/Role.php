<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idRole';
    protected $table = 'roles';
    protected $guarded =  ['created_at', 'updated_at', 'deleted_at'];
}
