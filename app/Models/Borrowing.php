<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $table = 'borrowings';

    protected $fillable = [
        'inventory_item_id',
        'borrower_name',
        'contact_details',
        'borrow_date',
        'expected_return_date',
        'quantity_borrowed',
        'status',
    ];

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }
}
