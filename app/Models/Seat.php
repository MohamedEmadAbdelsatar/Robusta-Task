<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $table = 'seats';
    protected $fillable = ['number', 'trip_id'];

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    public function reservations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Reservation::class, 'seat_id');
    }
}
