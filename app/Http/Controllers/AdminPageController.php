<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    public function control_city(){
        return view('admin.control.control',['type'=>'city']);
    }
    public function control_airport(){
        return view('admin.control.control',['type'=>'airport']);
    }
    public function control_airplane(){
        return view('admin.control.control',['type'=>'airplane']);
    }
    public function control_seat(){
        return view('admin.control.control',['type'=>'seat']);
    }
    public function control_seat_in_plane(){
        return view('admin.control.control',['type'=>'seat_in_plane']);
    }
    public function control_flight(){
        return view('admin.control.control',['type'=>'flight']);
    }
    public function control_ticket(){
        return view('admin.control.control',['type'=>'ticket']);
    }
    public function control_user(){
        return view('admin.control.control',['type'=>'user']);
    }
}
