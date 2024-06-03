<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    public function airplane(){
        return $this->belongsTo(Airplane::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function seatinplane(){
        return $this->belongsTo(SeatInPlane::class);
    }

    public function flight(){
        return $this->belongsTo(Flight::class);
    }
}
