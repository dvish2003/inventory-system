<?php

namespace App\Http\Controllers;

use App\Models\Cupboard;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CupboardController extends Controller
{
    use ApiResponse;
    //save
    public function saveCupboard(Request $request){
           $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);
        $cupboard = Cupboard::create([
            'name' => $request->name,
            'location' => $request->location,
        ]);
        return $this->success($cupboard, 'Cupboard created successfully');
    }
    //get all cupboards
    public function getAllCupboards(){
        $cupboards = Cupboard::all();
        return $this->success($cupboards, 'Cupboards retrieved successfully');
    }
    //update cupboard
    public function updateCupboard(Request $request){
        $request->validate([
            'id' => 'required|exists:cupboards,id',
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);
        $cupboard = Cupboard::find($request->id);
        $cupboard->name = $request->name;
        $cupboard->location = $request->location;
        $cupboard->save();
        return $this->success($cupboard, 'Cupboard updated successfully');
    }
    //delete cupboard
    public function deleteCupboard(Request $request){
        $cupboard = Cupboard::find($request->id);
        $cupboard->delete();
        return $this->success(null, 'Cupboard deleted successfully');
    }
}
