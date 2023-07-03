<?php

namespace App\Policies;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

class ReservationPolicy
{

    /*
     * Ensure that user can only make reservation related to himself
     */
    public function store(User $user, StoreReservationRequest $request)
    {
        return $request->user_id == $user->id
            ? Response::allow()
            : Response::deny('You are not allowed to make this reservation!');
    }
    /**
     * Determine whether the user can view the model.
     * Only allowed if reservation belongs to user
     */
    public function show(User $user, Reservation $reservation)
    {
        return $reservation->user_id === $user->id
            ? Response::allow()
            : Response::deny('You are not allowed to view this reservation!');
    }

    /**
     * Determine whether the user can update the model.
     * Only allowed if reservation belongs to user
     */
    public function update(User $user, Reservation $reservation)
    {
        return $reservation->user_id === $user->id
            ? Response::allow()
            : Response::deny('You are not allowed to update this reservation!');
    }

    /**
     * Determine whether the user can delete the model.
     * Only allowed if reservation belongs to user
     */
    public function destroy(User $user, Reservation $reservation)
    {
        return $reservation->user_id === $user->id
            ? Response::allow()
            : Response::deny('You are not allowed to delete this reservation!');
    }

}
