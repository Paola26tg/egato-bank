<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepositTransaction extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idDepositTransaction';
    protected $table = 'deposit_transactions';
    protected $guarded =  ['created_at', 'updated_at', 'deleted_at'];
}
