<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentType extends Model
{
    //
    protected $fillable = ['name','is_for','display_name_en','display_name_gr','description_en','description_gr'];

    public function scopeFor($query, $is_for)
    {
        return $query->where('is_for', $is_for);
    }
}
