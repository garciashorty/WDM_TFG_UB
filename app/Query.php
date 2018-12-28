<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $fillable = ['user_id', 'relatedQuery_id', 'area_id', 'result', 'image', 'comment', 'resolved'];
}
