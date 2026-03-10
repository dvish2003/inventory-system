<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table = 'places';

     protected $fillable = ['name', 'cupboard_id'];

    public function cupboard()
    {
        return $this->belongsTo(Cupboard::class);
    }

    public function inventoryItems()
    {
        return $this->hasMany(InventoryItem::class);
    }
}
