<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Seat;
use App\Models\SeatInPlane;
use App\Models\Ticket;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::with(['flight'])->get();
        return response()->json($tickets);
    }

    public function welcome_get_popular(){
        $cities = DB::table('tickets')->join('flights','tickets.flight_id','=','flights.id')->
        select('flights.city_finish_id',DB::raw('count(*) as total'))->
        groupBy('flights.city_finish_id')->orderByDesc('total')->take(4)->get();
        return response()->json($cities);
    }

    public function my_index(){
        $tickets = Ticket::with(['flight.airplane','flight.city'])->where('user_id',Auth::id())->get();
        foreach($tickets as $ticket){
            $seat = SeatInPlane::with(['seat'])->where('id',$ticket->seat_in_plane_id)->first();
            $ticket->seat_in_plane = $seat;
        }
        return response()->json($tickets);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function cancel($id)
    {
        $ticket = Ticket::query()->where('id',$id)->first();
        $ticket->status = 'отменен';
        $seat_in_plane = SeatInPlane::query()->where('id',$ticket->seat_in_plane_id)->first();
        $seat_in_plane->status = 'свободно';
        $seat_in_plane->update();
        $ticket->update();
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'rule'=>['required'],
            'fio'=>['required','regex:/[а-яА-ЯЁё -]/u'],
            'birthday'=>['required'],
            'password'=>['required']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $user = Auth::user();

        if(md5($request->password) !== $user->password){
            return response()->json('Пароль неверный',404);
        }
        $ticket = new Ticket();
        $ticket->user_id = $user->id;
        $ticket->fio = $request->fio;
        $ticket->birthday = $request->birthday;
        if($request->passport_data){
            $ticket->passport_data = $request->passport_data;
        }
        if($request->birth_certificate){
            $ticket->birth_certificate= $request->birth_certificate;
        }
        $flight = Flight::query()->where('id',$request->flight_id)->first();
        $seat_in_plane = SeatInPlane::query()->where('id',$request->seat_id)->first();
        $seat = Seat::query()->where('id',$seat_in_plane->seat_id)->first();
        $ticket->flight_id = $flight->id;
        $seat_in_plane->status = 'занято';
        $seat_in_plane->update();
        $ticket->seat_in_plane_id = $seat_in_plane->id;
        $ticket->price = $seat->cost + $seat->cost*($flight->overprice/100);
        $ticket->save();
        return response()->json('Сохранено',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function sort_tickets(Request $request)
    {
        $tickets = Ticket::with(['flight','flight.airplane','flight.city'])->join('flights','tickets.flight_id','=','flights.id')
        ->where('user_id',Auth::id())->orderByDesc($request[0])->get();
        foreach($tickets as $ticket){
            $seat = SeatInPlane::with(['seat'])->where('id',$ticket->seat_in_plane_id)->first();
            $ticket->seat_in_plane = $seat;
        }
        return response()->json($tickets);

    }
    public function filter_tickets(Request $request)
    {
        $tickets = Ticket::with(['flight','flight.airplane','flight.city'])->where('user_id',Auth::id())
        ->where('status',$request[0])->get();
        foreach($tickets as $ticket){
            $seat = SeatInPlane::with(['seat'])->where('id',$ticket->seat_in_plane_id)->first();
            $ticket->seat_in_plane = $seat;
        }
        return response()->json($tickets);
    }

    public function admin_filter_tickets(Request $request)
    {
        $tickets = Ticket::with(['flight','flight.airplane','flight.city'])->where('status',$request[0])->get();
        // foreach($tickets as $ticket){
        //     $seat = SeatInPlane::with(['seat'])->where('id',$ticket->seat_in_plane_id)->first();
        //     $ticket->seat_in_plane = $seat;
        // }

        return response()->json($tickets);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
