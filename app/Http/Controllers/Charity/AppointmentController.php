<?php

namespace App\Http\Controllers\Charity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{

    public function index()
    {
        return view('charity.appointment');
    }
}
