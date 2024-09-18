@extends('layouts.charity')

@section('title','Charity')


@section('body')
    <div class="container-fluid p-2">
        @foreach($announcements as $announcement)
            <div class="mx-auto">
                <h2>{{$announcement->title}}</h2>

                <div>
                    {!! $announcement->content !!}
                </div>
            </div>

            <hr class="mb-2">
        @endforeach
    </div>
@endsection
