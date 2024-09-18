@extends('layouts.charity')

@section('title','Charity')

@section('body')
    <div class="container py-2">

        <h2 class="text-center hero-title mt-6 mb-6">We arrange many social events for charity donations</h2>

        <div class="row justify-content-center">
            @foreach($events as $event)
                <div class="col-lg-9 col-md-12">
                    <div class="single-job-items mb-30">
                        <div class="job-items">
                            <div class="company-img">
                                <a href="#"><img src="{{ \Illuminate\Support\Facades\Storage::url($event->image)}}" alt=""></a>
                            </div>
                            <div class="job-tittle">
                                <a href="#"><h4>{{$event->name}}</h4></a>
                                <ul>
                                    <li><i class="far fa-clock"></i>Time</li>
                                    <li><i class="fas fa-sort-amount-down"></i>Date</li>
                                    <li><i class="fas fa-map-marker-alt"></i>{{$event->location}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
