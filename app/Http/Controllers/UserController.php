<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\SeatInPlane;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return response()->json($users);
    }
    public function store(Request $request){
        $valid = Validator::make($request->all(),[
            'fio'=>['required','regex:/[а-яА-ЯЁё -]/u'],
            'birthday'=>['required'],
            'phone'=>['required','digits:11'],
            'email'=>['required','unique:users','email:dns,rfc'],
            'password'=>['required','min:6','confirmed'],
            'rule'=>['required']
        ]);
        if ($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $user = new User();
        $user->fio = $request->fio;
        $user->birthday = $request->birthday;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = md5($request->password);
        $user->save();
        if($request->flag == 'admin'){
            return response()->json('Сохранено',200);
        }
        else{
            return redirect()->route('welcome');
        }
    }
    public function update(Request $request){
        $valid = Validator::make($request->all(),[
            'fio'=>['required','regex:/[а-яА-ЯЁё -]/u'],
            'birthday'=>['required'],
            'phone'=>['required','digits:11'],
            'email'=>['required','email:dns,rfc'],
            'password'=>['nullable','min:6','confirmed'],
        ]);
        if ($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $user = User::query()->where('id',$request->id)->first();
        $user->fio = $request->fio;
        $user->birthday = $request->birthday;
        $user->phone = $request->phone;
        $user->email = $request->email;
        if($request->password){
            $user->password = md5($request->password);
        }
        $user->update();
        if($request->flag=='admin'){
            return response()->json('Сохранено',200);
        }
        else{
            return redirect()->route('welcome');
        }

    }
    public function auth(Request $request){
        $valid = Validator::make($request->all(),[
            'phone'=>['required','digits:11'],
            'password'=>['required'],
        ]);
        if ($valid->fails()){
            return response()->json($valid->errors(),404);
        }
        $user = User::query()->where('phone',$request->phone)->where('password',md5($request->password))->first();
        if($user){
            Auth::login($user);
            return redirect()->route('welcome');
        }
        else{
            return response()->json('Пользователь не найден',400);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('welcome');
    }

    public function destroy(User $user, $id)
    {
        $user = User::query()->where('id',$id)->first();
        $tickets = Ticket::query()->where('user_id',$user->id)->get();
        foreach($tickets as $t){
            $ticket = Ticket::query()->where('id',$t->id)->first();
            $seat = SeatInPlane::query()->where('id',$ticket->seat_in_plane_id)->first();
            $seat->status = 'свободно';
            $ticket->user_id = NULL;
            $ticket->status = 'отменен';
            $ticket->update();
            $seat->update();

        }
        $user->delete();
        return redirect()->back();
    }

    public function block_data(){
        $user = User::query()->where('id',Auth::id())->first();
        $tickets = Ticket::query()->where('user_id',$user->id)->get();
        foreach($tickets as $t){
            $ticket = Ticket::query()->where('id',$t->id)->first();
            $ticket->passport_data = 'Данные отозваны';
            $ticket->birthday = NULL;
            $ticket->birth_certificate = 'Данные отозваны';
            $ticket->fio = 'Данные отозваны';
            $ticket->status = 'отменен';
            $seat = SeatInPlane::query()->where('id',$t->seat_in_plane_id)->first();
            $seat->status = 'свободно';
            $seat->update();
            $ticket->update();
        }
        $user->phone = '';
        $user->email = '';
        $user->password = '';
        $user->birthday = NULL;
        $user->fio = substr($user->fio, 0, strpos($user->fio, ' '));
        $user->update();
        return redirect()->back();
    }
}
