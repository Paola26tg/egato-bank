<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OuterTransaction extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idOuterTransaction';
    protected $table = 'outer_transactions';
    protected $guarded =  ['created_at', 'updated_at', 'deleted_at'];
}
