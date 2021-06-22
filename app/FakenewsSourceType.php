<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FakenewsSourceType extends Model
{
    //
        //
        protected $table = 'fakenews_source_type'; //if i dont have this it thinka the name of the table is "fakenews_types"...
    
        protected $fillable = ['typename','typename_en','typename_gr'];
}
