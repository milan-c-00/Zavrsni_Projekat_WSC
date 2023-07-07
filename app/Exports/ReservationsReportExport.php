<?php

namespace App\Exports;

use App\Models\Reservation;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReservationsReportExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected  $reservations;
    public function __construct($reservations)
    {
        $this->reservations = $reservations;
    }

    public function view(): View
    {
        return view('exports.reservations-report-export', ['reservations' => $this->reservations]);
    }

}
