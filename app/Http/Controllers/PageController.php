<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function welcome(){
        return view('welcome');
    }

    public function login(){
        return view('guest.auth');
    }

    public function reg(){
        return view('guest.reg');
    }

    public function contact(){
        return view('contact');
    }

    public function catalog(Request $request){
        // dd($request->city_start);
        $city_start = City::query()->where('title',$request->city_start)->first();
        $city_finish = City::query()->where('title',$request->city_finish)->first();

        // dd($city_finish);
        // $flights = Flight::query()->orWhere('city_start_id',$city_start->id)->orWhere('city_finish_id',$city_finish->id)->orWhereDate('date_start', $request->date_start)->get();
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
                // else{
                //     $query->where('city_start_id',$city_start->id)->where('city_finish_id',$city_finish->id)->whereDate('date_start', $request->date_start);
                // }

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



        })->get();

        // dd($flights);
        // return view('user.catalog',['flights'=>json_encode($flights)]);
        return redirect()->route('show_catalog',['flights'=>$flights]);
    }
        public function show_catalog(){

            return view('user.catalog');
        }
    public function detail($id){
        return view('user.detail',['id'=>$id]);
    }

    public function profile(){
        $user = Auth::user();
        return view('user.profile',['user'=>$user]);
    }
    public function my_ticket(){
        return view('user.ticket');
    }

}
