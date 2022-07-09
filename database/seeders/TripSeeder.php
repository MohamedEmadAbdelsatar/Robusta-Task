<?php

namespace Database\Seeders;

use App\Models\Seat;
use App\Models\Station;
use App\Models\Trip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trips = [
            ["Cairo", "Qaliubiya", "Menofia", "Gharbiya", "Beheira", "Alexandria"],
            ["Port Said", "Suez", "Ismailia", "Sharkia", "Cairo"],
            ["Cairo", "Giza", "Fayum", "Beni Suef", "Minya", "Asyut", "Sohag", "Qena", "Luxor", "Aswan"],
            ["Matrouh", "Alexandria", "Kafr ElSheikh", "Damietta", "Port Said"],
            ["Aswan", "Luxor", "Qena", "Sohag", "Asyut", "Minya", "Beni Suef", "Fayum", "Giza", "Cairo", "Menofia", "Beheira", "Alexandria"],
        ];

        foreach ($trips as $tripStations) {
            $startStation = Station::query()->where('name', $tripStations[0])->first();
            $endStation = Station::query()->where('name', $tripStations[count($tripStations) - 1])->first();

            $newTrip = new Trip([
                'start_station_id' => $startStation->id,
                'end_station_id' => $endStation->id,
            ]);

            $newTrip->save();

            for ($i=1; $i<=count($tripStations) - 2; $i++) {
                $station = Station::query()->where('name', $tripStations[$i])->first();
                $newTrip->crossOverStations()->attach($station, ['order' => $i]);
            }

            for ($i=1; $i <= 12; $i++) {
                $seat = new Seat([
                    'number' => $i,
                    'trip_id' => $newTrip->id,
                ]);
                $seat->save();
            }
        }
    }
}
