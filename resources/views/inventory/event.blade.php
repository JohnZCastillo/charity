@extends('layouts.index')

@section('body')

    <div class="container-fluid h-100 bg-light pb-3">
        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif

        <form method="POST" action="/inventory/events/{{$event->id}}">

            @csrf
            @method('PATCH')

            <div>
                <img style="max-height: 600px" class="img-fluid d-block mx-auto" src="{{\Illuminate\Support\Facades\Storage::url($event->image)}}">
            </div>

            <div class="form-group">
                <label for="title">Image</label>
                <input class="form-control" id="image" type="file" accept="image/*" name="image">
            </div>

            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control" id="title" type="text" name="title" value="{{$event->title}}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description">{{$event->description}}</textarea>
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input class="form-control" id="location" type="text" name="location" value="{{$event->location}}" required>
            </div>


            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <label for="start">Start</label>
                    <input value="{{$event->start}}" class="form-control" type="datetime-local" name="start" id="start" required>
                </div>

                <div class="col-sm-12 col-md-6">
                    <label for="end">End</label>
                    <input value="{{$event->end}}" class="form-control" type="datetime-local" name="end" id="end" required>
                </div>
            </div>

            <div class="d-flex gap-3 align-items-center mt-2 ">
                <a class="btn btn-secondary" type="button" href="/inventory/events">Cancel</a>
                <button class="btn btn-primary">Save</button>
            </div>

        </form>
    </div>

@endsection
