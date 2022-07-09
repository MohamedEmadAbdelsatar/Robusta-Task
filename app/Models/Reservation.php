<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    protected $fillable = ['seat_id', 'trip_id', 'from', 'to'];

    public function seat()
    {
        return $this->belongsTo(Seat::class, 'seat_id');
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    public function fromStation()
    {
        return $this->belongsTo(Station::class, 'from');
    }

    public function toStation()
    {
        return $this->belongsTo(Station::class, 'to');
    }
}
