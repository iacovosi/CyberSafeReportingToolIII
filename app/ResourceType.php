<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceType extends Model
{
    //
    protected $fillable = ['name','display_name_en','display_name_gr','description_en','description_gr'];
}
