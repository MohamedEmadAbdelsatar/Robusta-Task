<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvailabiltyRequest;
use App\Http\Requests\BookRequest;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\SeatResource;
use App\Models\CrossOverStation;
use App\Models\Reservation;
use App\Models\Seat;
use App\Models\Station;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReservationsController extends Controller
{
    public function book(BookRequest $request)
    {
        $seat = Seat::query()->findOrFail($request->seat_id);
        $from = Station::query()->where('name', $request->from)->first();
        $to = Station::query()->where('name', $request->to)->first();

        if (!$this->checkSeatAvailability($seat, $from, $to)) {
            return "can't book this seat";
        }

        $reservation = new Reservation([
            'seat_id' => $request->seat_id,
            'trip_id' => $seat->trip_id,
            'from' => $from->id,
            'to' => $to->id,
        ]);

        $reservation->save();

        return ReservationResource::make($reservation);
    }

    public function getAvailableSeats(AvailabiltyRequest $request)
    {
        $from = Station::query()->where('name', $request->from)->first();
        $to = Station::query()->where('name', $request->to)->first();

        $trips = Trip::query()->where('start_station_id', $from->id)
            ->orWhere('end_station_id', $to->id)
            ->orWhereHas('crossOverStations', function ($q) use($from, $to) {
                $q->whereIn('stations.id', [$from->id, $to->id]);
            })->get();

        $usedTrips = [];
        foreach ($trips as $trip) {
            if (in_array($request->from, $trip->stations) && in_array($request->to, $trip->stations)) {
                $usedTrips[] = $trip;
            }
        }


        if (count($usedTrips)) {
            $seats = [];
            foreach ($usedTrips as $trip) {
                $fromOrder = array_search($from->name, $trip->stations);
                $toOrder = array_search($to->name, $trip->stations);

                if(($fromOrder < $toOrder)) {
                    foreach ($trip->seats as $seat) {
                        if ($this->checkSeatAvailability($seat, $from, $to)) {
                            $seats[] = $seat;
                        }
                    }
                }
            }

            return SeatResource::collection($seats);
        } else {
            return [];
        }

    }

    private function checkSeatAvailability($seat, $from, $to): bool
    {
        if(!in_array($from->name, $seat->trip->stations) || !in_array($to->name, $seat->trip->stations)) {
            return false;
        }

        if (!count($seat->reservations)) {
            return true;
        }
        $fromOrder = array_search($from->name, $seat->trip->stations);
        $toOrder = array_search($to->name, $seat->trip->stations);

        if ($fromOrder >= $toOrder) {
            return false;
        }

        foreach ($seat->reservations as $reservation) {
            $reservationFrom = array_search($reservation->fromStation->name, $seat->trip->stations);
            $reservationTo = array_search($reservation->toStation->name, $seat->trip->stations);

            if($fromOrder == $reservationFrom && $toOrder == $reservationTo) {
                return false;
            }

            if ($fromOrder < $reservationFrom && $toOrder > $reservationTo) {
                return false;
            }

            if ($fromOrder < $reservationFrom && ($toOrder > $reservationFrom && $toOrder < $reservationTo)) {
                return false;
            }

            if (($fromOrder > $reservationFrom && $fromOrder < $reservationTo) && ($toOrder > $reservationFrom && $toOrder < $reservationTo)) {
                return false;
            }

            if (($fromOrder > $reservationFrom && $fromOrder < $reservationTo) && $toOrder < $reservationTo) {
                return false;
            }
        }

        return true;
    }
}
