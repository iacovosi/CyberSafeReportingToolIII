<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportRole extends Model
{
    //
    // protected $table = "report_roles";

    protected $fillable = ['name','display_name_gr', 'display_name_en'];

}
