<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopGallery extends Model
{
    use SoftDeletes;

    protected $fillable = [

		'title',
		'img' ,
		'status',
    ];
}
