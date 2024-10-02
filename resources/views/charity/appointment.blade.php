@extends('layouts.charity')

@section('files')
    <link rel="stylesheet" href="/css/appointment.css">
@endsection

@section('title','Appointment')

@section('body')
    <div id="container">
        <!--This is a division tag for body container-->
        <div id="body_header">
            <!--This is a division tag for body header-->
            <h1>Appointment Request Form</h1>
            <p>Make your appointments more easier</p>

        </div>
        <form action="index.html" method="post">
            <fieldset>
                <legend><span class="number">1 </span>Your basic details</legend>
                <label for="name">Name:</label>
                <input type="text" id="name" name="user_name" placeholder="Atchyut (only first names)" required pattern="[a-zA-Z0-9]+">

                <label for="mail">Email:</label>
                <input type="email" id="mail" name="user_email" placeholder="abc@xyz.com" required>

                <label for="tel">Contact Number:</label>
                <input type="tel" id="tel" placeholder="Include country code" name="user_num">

            </fieldset>

            <fieldset>
                <legend><span class="number">2 </span>Appointment Details</legend>
                <label for="appointment_for">Appointment for:</label>
                <select id="appointment_for" name="appointment_for" required>
                    <option value="coffee">Donations</option>
                    <option value="meeting">Meeting</option>
                    <option value="Business">Visit</option>
                    <option value="lunch">Asking for Help</option>
                </select>
                <label for="appointment_description">Appointment Description:</label>
                <textarea id="appointment_description" name="appointment_description" placeholder="I wish to get an appointment to give donations"></textarea>
                <label for="date">Date*:</label>
                <input type="date" name="date" value="" required></input>
                <br>
                <label for="time">Time*:</label>
                <input type="time" name="time" value="" required></input>
                <br>
                <label for="duration">How Long??(Minutes)</label>
                <input type="radio" name="duration" value="30" checked> 30
                <input type="radio" name="duration" value="60"> 60
                <input type="radio" name="duration" value="90"> 90
                <input type="radio" name="duration" value="more"> more
            </fieldset>
            <button type="submit">Request For Appointment</button>
        </form>
    </div>
@endsection
