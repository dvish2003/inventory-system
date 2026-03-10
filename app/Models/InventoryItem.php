<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $table = 'inventory_items';

    protected $fillable = [
        'name',
        'code',          // Unique code
        'quantity',
        'description',
        'place_id',      // FK to Place
        'status',        // In-Store, Borrowed, Damaged, Missing
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
