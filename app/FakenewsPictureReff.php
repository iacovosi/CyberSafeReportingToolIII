<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FakenewsPictureReff extends Model
{
    //
    public $timestamps = false;
    protected $table = 'fakenews_pictures_reff';
    protected $fillable = ['fakenews_reference_id','picture_reference_id'];
}
