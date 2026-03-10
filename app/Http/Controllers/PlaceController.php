<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    use ApiResponse;

    //save place
    public function savePlace(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'cupboard_id' => 'required|exists:cupboards,id',
        ]);
        $place = Place::create([
            'name' => $request->name,
            'cupboard_id' => $request->cupboard_id,
        ]);
        return $this->success($place, 'Place created successfully');
    }
    //get all places
    public function getAllPlaces(){
        $places = Place::all();
        return $this->success($places, 'Places retrieved successfully');
    }
    //update place
    public function updatePlace(Request $request){
        $request->validate([
            'id' => 'required|exists:places,id',
            'name' => 'required|string|max:255',
            'cupboard_id' => 'required|exists:cupboards,id',
        ]);
        $place = Place::find($request->id);
        $place->name = $request->name;
        $place->cupboard_id = $request->cupboard_id;
        $place->save();
        return $this->success($place, 'Place updated successfully');
    }
    //delete place
    public function deletePlace(Request $request){
        $place = Place::find($request->id);
        $place->delete();
        return $this->success(null, 'Place deleted successfully');
    }
}
