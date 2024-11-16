<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sapi extends Model
{

  protected $casts = [
    'value' => 'integer',
    // atau 'string'
  ];
}
