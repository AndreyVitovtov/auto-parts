<?php

namespace App\Models;

class Currency extends Model
{
	protected $table = 'currencies';
	protected $fields = [
		'title', 'code'
	];
}