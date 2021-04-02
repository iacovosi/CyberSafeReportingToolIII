<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferenceBy extends Model
{
    //
    protected $table = "references_by";

    // Select which values are allowed to be mass asigned
    protected $fillable = ['name','display_name_gr', 'display_name_en','description_gr','description_en'];

    // Alternative inverse option
    // protected $guarded = [];
}
