<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Flight;
use App\Models\SeatInPlane;
use App\Models\Ticket;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flights = Flight::query()->with(['airport','airplane','city'])->get();
        return response()->json($flights);
    }

    // public function filter_flights(Request $request){
    //     $res = json_decode($request->flights);

    //     if($request->city_start_id){
    //         $res = $res->
    //     }
    //     // if($request->)
    //     dd($request->all());
    // }
    public function index_valid(Request $request)
    {
        $city_start = City::query()->where('title',$request->city_start)->first();
        $city_finish = City::query()->where('title',$request->city_finish)->first();
        $flights = Flight::query()->where(function ($query) use ($city_finish, $city_start,$request){
            if ($request->city_start != null and $request->city_finish != null and !empty($request->date_start)) {
                if($city_start == null){
                    $city_start = 0;
                    $query->where('city_start_id',$city_start)->where('city_finish_id',$city_finish->id)->whereDate('date_start', $request->date_start);
                }
                elseif($city_finish == null){
                    $city_finish = 0;
                    $query->where('city_start_id',$city_start->id)->where('city_finish_id',$city_finish)->whereDate('date_start', $request->date_start);
                }
                else{
                    $query->where('city_start_id',$city_start->id)->where('city_finish_id',$city_finish->id)->whereDate('date_start', $request->date_start);
                }

            }
            elseif (($request->city_start != null or $request->city_finish != null) and !empty($request->date_start)) {
                if($city_start == null){

                    $query->where('city_finish_id',$city_finish->id)->whereDate('date_start', $request->date_start);
                }
                if($city_finish == null){
                    $query->where('city_start_id',$city_start->id)->whereDate('date_start', $request->date_start);
                }
            }
            elseif ($request->city_start != null and $request->city_finish != null) {
                if($city_start == null){
                    $city_from = 0;
                    $query->where('city_finish_id',$city_finish->id)->where('city_start_id',$city_from);
                }
                if($city_finish == null){
                    $city_to = 0;
                    $query->where('city_finish_id',$city_to)->where('city_start_id',$city_start->id);
                }
            }
            else{
                if (!empty($city_start->id)) {
                $query->where('city_start_id', $city_start->id);
                }

                if (!empty($city_finish->id)) {
                    $query->orWhere('city_finish_id', $city_finish->id);
                }

                if (!empty($request->date_start)) {
                    $query->orWhereDate('date_start', $request->date_start);
                }
            }
        })->with(['airport','airplane','city'])->get();
        return response()->json($flights);
    }
    public function get_flight(Request $request){
        $flight = Flight::query()->where('id',$request->id)->with(['airplane'])->first();
        return response()->json($flight);
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
            'overprice'=>'required',
            'time_start'=>['required','date_format:"H:i"'],
            'time_finish'=>['required','date_format:"H:i"']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $date_start = $request->date_start.' '.$request->time_start;
        $date_finish = $request->date_finish.' '.$request->time_finish;



        $diff = strtotime($date_finish) - strtotime($date_start);
        // dd($diff);
        if($diff<0){
            return response()->json('Неккоректные даты',404);
        }
        $flight = new Flight();
        $flight->city_start_id = $request->city_start_id;
        $flight->city_finish_id = $request->city_finish_id;
        $flight->airport_start_id = $request->airport_start_id;
        $flight->airport_finish_id = $request->airport_finish_id;
        $flight->date_start = $date_start;
        $flight->date_finish = $date_finish;
        $flight->overprice = $request->overprice;
        $flight->airplane_id = $request->airplane_id;
        $flight->time_in_air = $diff;
        $flight->save();
        return response()->json('Сохранено',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Flight $flight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flight $flight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Flight $flight)
    {
        // dd($request->all());
        $valid = Validator::make($request->all(),[
            'overprice'=>['required'],
            'date_start'=>['required'],
            'date_finish'=>['required'],

        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $flight = Flight::query()->where('id',$request->id)->first();
        $flight->overprice = $request->overprice;
        $flight->status = $request->status;
        if($request->status == 'выполнен'){
            $seats = SeatInPlane::query()->where('airplane_id',$flight->airplane_id)->get();
            foreach($seats as $s){
                $seat = SeatInPlane::query()->where('id',$s->id)->first();
                $seat->status = 'свободно';
                $seat->update();
            }
            $tickets = Ticket::query()->where('flight_id',$flight->id);
            foreach($tickets as $t){
                $ticket = Ticket::query()->where('id',$t->id)->first();
                $ticket->status = 'использован';
                $ticket->update();
            }
        }
        if($request->status == 'отменен'){
            $seats = SeatInPlane::query()->where('airplane_id',$flight->airplane_id)->get();
            foreach($seats as $s){
                $seat = SeatInPlane::query()->where('id',$s->id)->first();
                $seat->status = 'свободно';
                $seat->update();
            }
            $tickets = Ticket::query()->where('flight_id',$flight->id);
            foreach($tickets as $t){
                $ticket = Ticket::query()->where('id',$t->id)->first();
                $ticket->status = 'рейс отменен';
                $ticket->update();
            }
        }
        $flight->date_start = $request->date_start.' '.$request->time_start;
        $flight->date_finish = $request->date_finish.' '.$request->time_finish;

        if($request->airplane_id != 0){
            $flight->airplane_id = $request->airplane_id;

        }
        if($request->city_start_id != 0){
            $flight->city_start_id = $request->city_start_id;

        }
        if($request->city_finish_id != 0){
            $flight->city_finish_id = $request->city_finish_id;

        }
        if($request->airport_start_id != 0){
            $flight->airport_start_id = $request->airport_start_id;

        }
        if($request->airport_finish_id != 0){
            $flight->airport_finish_id = $request->airport_finish_id;

        }

        // if($request->time_start != null){
        //     $date_start = $flight->date_start.' '.$request->time_start;
        //     $flight->date_start = $date_start;
        // }
        // if($request->time_finish != null){
        //     $date_finish = $flight->date_finish.' '.$request->time_finish;
        //     $flight->date_finish = $date_finish;
        //     dd($flight);
        // }
        if($request->date_start_fact != null){
            $flight->date_start_fact = $request->date_start_fact;

        }
        if($request->date_finish_fact != null){
            $flight->date_finish_fact = $request->date_finish_fact;

        }
        if($request->time_start_fact != null){
            $flight->time_start_fact = $request->time_start_fact;

        }
        if($request->time_finish_fact != null){
            $flight->time_finish_fact = $request->time_finish_fact;

        }
        $flight->update();
        if($flight->date_start_fact && $flight->date_finish_fact){
            $diff = strtotime($flight->date_finish_fact) - strtotime($flight->date_start_fact);
        }
        else{
            $diff = strtotime($flight->date_finish) - strtotime($flight->date_start);
        }
        // dd($flight);
        if($diff<0){
            return response()->json('Неккоректные даты',404);
        }
        $flight->time_in_air = $diff;

        $flight->update();
        return response()->json('Изменено',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flight $flight, $id)
    {
        $flight = Flight::query()->where('id',$id)->first();
        $seats = SeatInPlane::query()->where('airplane_id',$flight->airplane_id)->get();
        foreach($seats as $s){
            $seat = SeatInPlane::query()->where('id',$s->id)->first();
            $seat->status = 'свободно';
            $seat->update();
        }
        $flight->delete();
        return redirect()->back();
    }
}
