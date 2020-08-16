<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawalFee extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idWithdrawalFee';
    protected $table = 'withdrawal_fees';
    protected $guarded =  ['created_at', 'updated_at', 'deleted_at'];
}
