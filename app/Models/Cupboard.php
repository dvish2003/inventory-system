<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cupboard extends Model
{
    protected $table = 'cupboards';

    protected $fillable = ['name', 'location'];

    public function places()
    {
        return $this->hasMany(Place::class);
    }}
