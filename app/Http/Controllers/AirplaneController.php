<?php

namespace App\Http\Controllers;

use App\Models\Airplane;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AirplaneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $airplanes = Airplane::all();
        return response()->json($airplanes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function get_airplane(Request $request)
    {
        // dd($request->all());
        $airplane = Airplane::query()->where('id',$request->id)->with(['seatinplanes','seatinplanes.seat'])->first();
        return response()->json($airplane);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'name'=>['required','unique:airplanes']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $airplane = new Airplane();
        $airplane->name = $request->name;
        if($request->status){
            $airplane->status = $request->status;
        }
        $airplane->save();
        return response()->json('Сохранено',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Airplane $airplane)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Airplane $airplane)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Airplane $airplane)
    {
        $valid = Validator::make($request->all(),[
            'name'=>['required']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $airplane = Airplane::query()->where('id', $request->id)->first();
        $airplane->name = $request->name;
        $airplane->status = $request->status;
        $airplane->update();
        return response()->json('Изменено',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Airplane $airplane, $id)
    {
        Airplane::find($id)->delete();
        return redirect()->back();
    }
}
