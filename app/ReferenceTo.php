<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferenceTo extends Model
{
    //
    protected $table = "references_to";

    protected $fillable = ['name','display_name_gr', 'display_name_en','description_gr','description_en'];
}
