<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\InventoryItem;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    use ApiResponse;

    // Save borrowing
    public function saveBorrowing(Request $request)
    {
        $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'borrower_name' => 'required|string|max:255',
            'contact_details' => 'nullable|string|max:255',
            'borrow_date' => 'required|date',
            'expected_return_date' => 'required|date',
            'quantity_borrowed' => 'required|integer|min:1',
            'status' => 'required|string'
        ]);

        $inventory = InventoryItem::find($request->inventory_item_id);

        // Check available quantity
        if ($request->quantity_borrowed > $inventory->quantity) {
            return $this->error("Only {$inventory->quantity} items available", 400);
        }

        // Reduce inventory quantity
        $inventory->quantity -= $request->quantity_borrowed;

        // Update inventory status
        if ($inventory->quantity == 0) {
            $inventory->status = "Borrowed";
        }

        $inventory->save();

        $borrowing = Borrowing::create([
            'inventory_item_id' => $request->inventory_item_id,
            'borrower_name' => $request->borrower_name,
            'contact_details' => $request->contact_details,
            'borrow_date' => $request->borrow_date,
            'expected_return_date' => $request->expected_return_date,
            'quantity_borrowed' => $request->quantity_borrowed,
            'status' => $request->status,
        ]);

        return $this->success($borrowing, "Borrowing saved successfully");
    }

    // Get all borrowings
    public function getAllBorrowings()
    {
        $borrowings = Borrowing::with('inventoryItem')->get();
        return $this->success($borrowings, "Borrowings retrieved successfully");
    }

    // Update borrowing
    public function updateBorrowing(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:borrowings,id',
            'status' => 'required|string'
        ]);

        $borrowing = Borrowing::find($request->id);
        $inventory = InventoryItem::find($borrowing->inventory_item_id);

        if ($request->status == "Returned") {

            // add quantity back
            $inventory->quantity += $borrowing->quantity_borrowed;

            $inventory->status = "In-Store";

            $inventory->save();
        }

        $borrowing->status = $request->status;
        $borrowing->save();

        return $this->success($borrowing, "Borrowing updated successfully");
    }

    // Delete borrowing
    public function deleteBorrowing(Request $request)
    {
        $borrowing = Borrowing::find($request->id);

        if (!$borrowing) {
            return $this->error("Borrowing not found", 404);
        }

        $borrowing->delete();

        return $this->success(null, "Borrowing deleted successfully");
    }
}
