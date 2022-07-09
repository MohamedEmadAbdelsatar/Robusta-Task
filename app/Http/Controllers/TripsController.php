<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTripRequest;
use App\Http\Resources\TripResource;
use App\Models\Seat;
use App\Models\Station;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripsController extends Controller
{
    public function index()
    {
        $trips = Trip::all();

        return TripResource::collection($trips);
    }

    public function store(CreateTripRequest $request)
    {
        $startStation = Station::query()->where('name', $request->stations[0])->first();
        $endStation = Station::query()->where('name', $request->stations[count($request->stations) - 1])->first();

        $trip = new Trip([
            'start_station_id' => $startStation->id,
            'end_station_id' => $endStation->id,
        ]);

        $trip->save();

        for ($i=1; $i<=count($request->stations) - 2; $i++) {
            $station = Station::query()->where('name', $request->stations[$i])->first();
            $trip->crossOverStations()->attach($station, ['order' => $i]);
        }

        for ($i=1; $i <= 12; $i++) {
            $seat = new Seat([
                'number' => $i,
                'trip_id' => $trip->id,
            ]);
            $seat->save();
        }

        return TripResource::make($trip);
    }

    public function show(Request $request)
    {
        $trip = Trip::query()->findOrFail($request->trip);

        return TripResource::make($trip);
    }
}
