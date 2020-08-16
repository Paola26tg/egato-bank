<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountCustomer extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idAccountCustomer';
    protected $table = 'account_customers';
    protected $guarded =  ['created_at', 'updated_at', 'deleted_at'];
}
