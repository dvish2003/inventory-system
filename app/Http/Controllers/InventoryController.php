<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class InventoryController extends Controller
{

    use ApiResponse;
    //save inventory item
    public function saveInventoryItem(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'place_id' => 'required|exists:places,id',
            'status' => 'required|string'
        ]);
        //check inventory exsist use name
        $existingItem = InventoryItem::where('name', $request->name)->first();

        if ($existingItem) {
            return $this->error("Inventory All ready added", 500);
        }

        $inventory = InventoryItem::create([
            'name' => $request->name,
            'code' => $request->code,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'place_id' => $request->place_id,
            'status' => $request->status,
        ]);

        return $this->success($inventory, "Inventory save successfully", 200);
    }
    //get all inventory items
    public function getAllInventoryItems()
    {
        $inventories = InventoryItem::all();
        return $this->success($inventories, 'Inventories retrieved successfully');
    }
    //update inventory item
    public function updateInventoryItem(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:inventory_items,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'place_id' => 'required|exists:places,id',
            'status' => 'required|string'
        ]);
        //check inventory exsist use id
$inventoryItem = InventoryItem::find($request->id);
        if ($inventoryItem) {
            $inventoryItem->name = $request->name;
            $inventoryItem->code = $request->code;
            $inventoryItem->quantity = $request->quantity;
            $inventoryItem->description = $request->description;
            $inventoryItem->place_id = $request->place_id;
            $inventoryItem->status = $request->status;
            $saveItem = $inventoryItem->save();

            return $this->success($saveItem, 'update updated successfully');
        }
        return $this->error("Inventory item not exsist", 500);
    }
    //delete inventory item
    public function deleteItem(Request $request)
    {
        $inventoryItem = InventoryItem::find($request->id);
        $inventoryItem->delete();
        return $this->success(null, 'Cupboard deleted successfully');
    }
}
