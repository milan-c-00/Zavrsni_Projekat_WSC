<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Http\Services\ReservationService;
use App\Mail\ReservationConfirmationMail;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ReservationController extends Controller
{

    protected $reservationService;

    public function __construct(ReservationService $reservationService) {
        $this->reservationService = $reservationService;
    }
    /**
     * Get all reservations (for admin)
     */
    public function index(Request $request)
    {
        $reservations = $this->reservationService->index($request);

        if(!$reservations)
            return response(['message' => 'No reservations!'], ResponseAlias::HTTP_NOT_FOUND);
        return response(['reservations' => $reservations], ResponseAlias::HTTP_OK);
    }

    /**
     * Store new reservation (for user)
     */
    public function store(StoreReservationRequest $request)
    {
//        dd(auth()->user()->id, $request->user_id);
        $this->authorize('store', [Reservation::class, $request]);
        $reservation = $this->reservationService->store($request);

        if($reservation['state'] === false)
            return response(['message' => 'Reservation date conflict. Date after '.$reservation['result']->format('Y-m-d').' required'], ResponseAlias::HTTP_BAD_REQUEST);
        else{
            if(!$reservation['result'])
                return response(['message' => 'Invalid request!'], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);

            Mail::to(auth()->user()->email)->queue(new ReservationConfirmationMail($reservation['result']));
            return response(['reservation' => ReservationResource::make($reservation['result'])], ResponseAlias::HTTP_CREATED);
        }
    }

    /*
     * Get all current user's reservations
     */
    public function myReservations(Request $request)
    {
        $reservations = $this->reservationService->myReservations($request);
        if(!$reservations)
            return response(['message' => 'Invalid request!'], ResponseAlias::HTTP_BAD_REQUEST);
        return response(['reservations' => $reservations], ResponseAlias::HTTP_OK);
    }

    /**
     * Display the specified reservation (for user)
     */
    public function show(Reservation $reservation)
    {
        $this->authorize('show', $reservation);
        $res = $this->reservationService->show($reservation);
        if(!$res)
            return response(['message' => 'Not found!'], ResponseAlias::HTTP_NOT_FOUND);
        return response(['reservation' => ReservationResource::make($reservation)], ResponseAlias::HTTP_OK);
    }

    /**
     * Update the specified reservation (for user)
     */
    public function update(Reservation $reservation, UpdateReservationRequest $request)
    {
        $this->authorize('update', $reservation);
        $updated = $this->reservationService->update($reservation, $request);

        if($updated['state'] === false)
            return response(['message' => 'Reservation date conflict. Date after '.$updated['result']->format('Y-m-d').' required'], ResponseAlias::HTTP_BAD_REQUEST);
        else{
            if(!$updated['result'])
                return response(['message' => 'Update failed!'], ResponseAlias::HTTP_BAD_REQUEST);

            Mail::to(auth()->user()->email)->queue(new ReservationConfirmationMail($reservation));
            return response(['message' => 'Update successful!'], ResponseAlias::HTTP_OK);
        }
    }

    /**
     * Cancel reservation (for user)
     */
    public function destroy(Reservation $reservation)
    {
        $this->authorize('destroy', $reservation);
        $deleted = $this->reservationService->destroy($reservation);
        if(!$deleted)
            return response(['message' => 'Delete failed!'], ResponseAlias::HTTP_BAD_REQUEST);
        return response(['message' => 'Delete successful!'], ResponseAlias::HTTP_OK);
    }
}
