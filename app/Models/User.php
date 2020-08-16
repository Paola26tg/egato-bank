<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idUser';
    protected $table = 'users';
    protected $guarded =  ['created_at', 'updated_at', 'deleted_at'];
}
