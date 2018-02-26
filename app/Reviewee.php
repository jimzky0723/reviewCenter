<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviewee extends Model
{
    protected $table = 'reviewee';
    protected $fillable = ['user_id','center_id','class_id'];
}
