<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    protected $table = 'news';

    protected $fillable = [

  		'title',
  		'alias',
  		'content',
  		'meta_desc' ,
  		'meta_tags' ,
  		'status',
  		'keywords',
  		'description',
  		'img',
    ];
}
