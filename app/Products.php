<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = "products";
    public $timestamps = true;

    protected $fillable = [
		'oem','model_no'
	];
}
