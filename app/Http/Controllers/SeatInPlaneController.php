<?php

namespace App\Http\Controllers;

use App\Models\SeatInPlane;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SeatInPlaneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seats_in_plane = SeatInPlane::with(['seat','airplane'])->get();
        return response()->json($seats_in_plane);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        foreach($request->inputSeatsInPlane as $seat){
            $valid = Validator::make($request->all(),[
            $seat => ['required'],
            'airplane_id' => ['required'],
            $seat => [
                Rule::unique('seat_in_planes')->where(function ($query) use ($request) {
                    return $query->where('airplane_id', $request->airplane_id);
                })
            ],
        ]);
        if($valid->fails()){
            return response($valid->errors(),400);
        }
        $newSeat = new SeatInPlane();
            $newSeat->airplane_id = $request->airplane_id;
            $newSeat->seat_id = $seat;
            $newSeat->save();

        }
        return response()->json('Сохранено',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(SeatInPlane $seatInPlane)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SeatInPlane $seatInPlane)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SeatInPlane $seatInPlane)
    {
        $valid = Validator::make($request->all(),[
            'status'=>['required']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $seat = SeatInPlane::query()->where('id', $request->id)->first();
        $seat->status = $request->status;
        $seat->update();
        return response()->json('Изменено',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SeatInPlane $seatInPlane,$id)
    {
        SeatInPlane::find($id)->delete();
        return redirect()->back();
    }
}
