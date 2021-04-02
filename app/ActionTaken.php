<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionTaken extends Model
{
  protected $table = 'action_taken';
  protected $fillable = ['name'];
}
