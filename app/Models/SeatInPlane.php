<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatInPlane extends Model
{
    use HasFactory;
    public function seat(){
        return $this->belongsTo(Seat::class);
    }

    public function airplane(){
        return $this->belongsTo(Airplane::class);
    }

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }
}
