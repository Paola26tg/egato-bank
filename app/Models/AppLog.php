<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppLog extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idAppLog';
    protected $table = 'app_logs';
    protected $guarded =  ['created_at', 'updated_at', 'deleted_at'];
}
