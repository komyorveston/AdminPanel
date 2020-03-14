<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaticPage extends Model
{
    use SoftDeletes;

    protected $fillable = [

            'title',
            'description',
            'short_description', 
            'img', 
            'alias', 
            'status',
    ];
}
