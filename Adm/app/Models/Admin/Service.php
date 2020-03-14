<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [

       'title' ,
       'description',
       'short_description',
       'meta_desc',
       'meta_tags',
       'status' ,
       'img',
    ];
}
