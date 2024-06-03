<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seats = Seat::query()->orderBy('number')->get();
        return response()->json($seats);
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
        $valid = Validator::make($request->all(),[
            'number'=>['required','unique:seats'],
            'cost'=>['required']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $seat = new Seat();
        $seat->number = $request->number;
        $seat->cost = $request->cost;
        $seat->save();
        return response()->json('Сохранено',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Seat $seat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seat $seat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seat $seat)
    {
        $valid = Validator::make($request->all(),[
            'number'=>['required'],
            'cost'=>['required']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $seat = Seat::query()->where('id',$request->id)->first();
        $seat->number = $request->number;
        $seat->cost = $request->cost;
        $seat->save();
        return response()->json('Изменено',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seat $seat, $id)
    {
        Seat::find($id)->delete();
        return redirect()->back();
    }
}
