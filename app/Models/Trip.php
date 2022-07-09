<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = ['start_station_id', 'end_station_id'];

    public function startStation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Station::class, 'start_station_id');
    }

    public function endStation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Station::class, 'end_station_id');
    }

    public function getNameAttribute()
    {
        return $this->startStation->name . ' - ' . $this->endStation->name;
    }

    public function crossOverStations()
    {
        return $this->belongsToMany(Station::class, 'cross_over_stations', 'trip_id', 'station_id')->withPivot('order');
    }

    public function seats()
    {
        return $this->hasMany(Seat::class, 'trip_id');
    }

    public function getStationsAttribute()
    {
        $stations = [];
        $stations[] = $this->startStation->name;

        if (count($this->crossOverStations)) {
            foreach ($this->crossOverStations as $crossOverStation) {
                $stations[] = $crossOverStation->name;
            }
        }

        $stations[] = $this->endStation->name;

        return $stations;
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'seat_id');
    }
}
