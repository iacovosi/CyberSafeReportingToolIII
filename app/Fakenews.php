<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fakenews extends Model
{
    //
    protected $fillable = ['title','source_document','publication_date','source','source_url',
                            'evaluation','fakenews_type','country','town','specific_area_address',
                        'submission_type'];
}
