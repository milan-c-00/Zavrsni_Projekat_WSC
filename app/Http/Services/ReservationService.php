<?php

namespace App\Http\Services;

use App\Http\Requests\ReservationsExportRequest;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Mail\ReservationConfirmationMail;
use App\Models\Reservation;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;

class ReservationService
{

    // List all reservations (only for admin), date based search available
    public function index(Request $request) {

        $reservations = Reservation::query();

        if($request->has('from_date')){
            $from_date = new DateTime($request->from_date);
            $reservations
                ->where('start_date', '>=', $from_date);
        }
        if($request->has('to_date')){
            $to_date = new DateTime($request->to_date);
            $reservations
                ->where('end_date', '<=', $to_date);
        }

        return ReservationResource::collection($reservations->get());
    }

    // Get all reservations (for user)
    public function myReservations(Request $request) {

        $reservations = Reservation::query()->where('user_id', auth()->user()->id);
        if($request->has('from_date')){
            $from_date = new DateTime($request->from_date);
            $reservations->where('start_date', '>=', $from_date);
        }
        if($request->has('to_date')){
            $to_date = new DateTime($request->to_date);
            $reservations->where('end_date', '<=', $to_date);
        }

        return ReservationResource::collection($reservations->get());

    }


    // Get a single reservation
    public function show(Reservation $reservation) {

        return Reservation::query()->where('id', $reservation->id)->exists();

    }

    // Make new reservation, dates conflict handling implemented (for user)
    public function store(StoreReservationRequest $request) {

        $req_start_date = new DateTime($request->start_date);
        $vehicle_reservations = Reservation::query()
            ->where('vehicle_id', $request->vehicle_id)
            ->where('end_date', '>=', now())
            ->get();

        foreach($vehicle_reservations as $vehicle_reservation){
            $res_end_date = new DateTime($vehicle_reservation->end_date);
            if($req_start_date <= $res_end_date)
                return ['state' => false, 'result' => $res_end_date];
        }

        return ['state' => true, 'result' => Reservation::query()->create($request->validated())];

    }

    // Update existing reservation (for user)
    public function update(Reservation $reservation, UpdateReservationRequest $request) {

        $req_start_date = new DateTime($request->start_date);
        $vehicle_reservations = Reservation::query()
            ->where('vehicle_id', $request->vehicle_id)
            ->where('end_date', '>=', now())
            ->whereNot('start_date', $req_start_date)
            ->get();

        foreach($vehicle_reservations as $vehicle_reservation){
            $res_end_date = new DateTime($vehicle_reservation->end_date);
            if($req_start_date <= $res_end_date)
                return ['state' => false, 'result' => $res_end_date];
        }

        return ['state' => true, 'result' => $reservation->update($request->validated())];

    }

    // Cancel reservation (for user)
    public function destroy(Reservation $reservation) {
        return $reservation->delete();
    }

    // Export all desired reservations into excel file (for admin)
    public function export(ReservationsExportRequest $request) {
        return $this->getReservationsReport($request);
    }

    public function getReservationsReport(ReservationsExportRequest $request) {

        $reservations = Reservation::query();
        $reservations->join('vehicles', 'reservations.vehicle_id', '=', 'vehicles.id');

        if($request->has('brand_id')){
            $brand_id = $request->input('brand_id');
            $reservations->join('brands', 'vehicles.brand_id', '=', 'brands.id')
                ->where('brands.id', '=', $brand_id);
        }

        if($request->has('vehicle_model_id')){
            $vehicle_model_id = $request->input('vehicle_model_id');
            $reservations->join('vehicle_models', 'vehicles.vehicle_model_id', '=', 'vehicle_models.id')
                ->where('vehicle_models.id', '=', $vehicle_model_id);
        }

        if($request->has('min_price')){
            $min_price = $request->input('min_price');
            $reservations->where('price', '>=', $min_price);
        }

        if($request->has('max_price')){
            $max_price = $request->input('max_price');
            $reservations->where('price', '<=', $max_price);
        }

        if($request->has('from_date')){
            $from_date = new DateTime($request->from_date);
            $reservations->where('start_date', '>=', $from_date);
        }

        if($request->has('to_date')){
            $to_date = new DateTime($request->to_date);
            $reservations->where('end_date', '<=', $to_date);
        }

        $reservations->select('reservations.*');
        return $reservations->get();

    }

}
