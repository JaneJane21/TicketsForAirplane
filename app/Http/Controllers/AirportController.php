<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AirportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $airports = Airport::all();
        return response()->json($airports);
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
            'title'=>['required','unique:airports'],
            'code'=>['required','unique:airports'],
            'address'=>['required','unique:airports'],
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $airport = new Airport();
        $airport->title = $request->title;
        $airport->code = $request->code;
        $airport->address = $request->address;
        $airport->save();
        return response()->json('Сохранено',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Airport $airport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Airport $airport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Airport $airport)
    {
        $valid = Validator::make($request->all(),[
            'title'=>['required'],
            'code'=>['required'],
            'address'=>['required'],
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $airport = Airport::query()->where('id', $request->id)->first();
        $airport->title = $request->title;
        $airport->code = $request->code;
        $airport->address = $request->address;
        $airport->update();
        return response()->json('Изменено',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Airport $airport, $id)
    {
        Airport::find($id)->delete();
        return redirect()->back();
    }
}
