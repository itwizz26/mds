<?php

namespace App\Http\Controllers;

use PDF;
use App\Calendar;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public $sanitize = [];
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->getHolidays();

        return view('calendar.dashboard', [
                'calendar' => $this->sanitize
            ]
        );
    }

    /**
     * Generate PDF document.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF()
    {
        $this->getHolidays();

        // share data to view
        view()->share ('calendar.dashboard', $this->sanitize);
        $pdf = PDF::loadView ('calendar.dashboard', ['calendar' => $this->getHolidays()]);

        return $pdf->download ('sa_holidays.pdf');
    }

    /**
     * Fetch all calendar info.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHolidays()
    {
        $calendar = json_decode (Calendar::all());

        foreach ($calendar as $cal)
        {
            $date = $cal->date->year . '-' . $cal->date->month . '-' .  $cal->date->day;
            $holiday = date ("D \\t\h\\e jS \o\\f F Y", strtotime ($date));

            $this->sanitize[$cal->id]['date'] = $holiday;
            $this->sanitize[$cal->id]['name'] = $cal->name[0]->text;
        }

        return $this->sanitize;;
    }
}
