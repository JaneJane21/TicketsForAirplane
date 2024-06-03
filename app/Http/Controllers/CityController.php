<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::all();
        return response()->json($cities);
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
            'title'=>['required','unique:cities'],
            'img'=>['required']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $city = new City();
        $city->title = $request->title;
        $path = $request->file('img')->store('public');
        if($path){
            $city->img = '/storage/'.$path;
        }
        $city->save();
        return response()->json('Сохранено',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        $valid = Validator::make($request->all(),[
            'title'=>['required'],
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $city = City::query()->where('id',$request->id)->first();
        $city->title = $request->title;
        if($request->img){
            $path = $request->file('img')->store('public');
            $city->img = '/storage/'.$path;
        }
        $city->update();
        return response()->json('Изменено',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city, $id)
    {
        City::find($id)->delete();
        return redirect()->back();
    }
}
