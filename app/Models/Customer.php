<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idCustomer';
    protected $table = 'customers';
    protected $guarded =  ['created_at', 'updated_at', 'deleted_at'];
}
