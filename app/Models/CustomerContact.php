<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerContact extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idCustomerContact';
    protected $table = 'customer_contacts';
    protected $guarded =  ['created_at', 'updated_at', 'deleted_at'];
}
