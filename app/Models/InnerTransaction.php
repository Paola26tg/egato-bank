<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InnerTransaction extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idInnerTransaction';
    protected $table = 'inner_transactions';
    protected $guarded =  ['created_at', 'updated_at', 'deleted_at'];
}
