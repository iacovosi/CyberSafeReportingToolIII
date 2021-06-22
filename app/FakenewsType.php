<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FakenewsType extends Model
{
    //
    protected $table = 'fakenews_type'; //if i dont hav ethis it think the name of the table is "fakenews_types"...
    
    protected $fillable = ['typename','typename_en','typename_gr'];
}
