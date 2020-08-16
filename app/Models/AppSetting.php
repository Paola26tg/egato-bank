<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppSetting extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idAppSetting';
    protected $table = 'app_settings';
    protected $guarded =  ['created_at', 'updated_at', 'deleted_at'];
}
