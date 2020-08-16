<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountCompany extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idAccountCompany';
    protected $table = 'account_company';
    protected $guarded =  ['created_at', 'updated_at', 'deleted_at'];
}
