@extends('layouts.index')

@section('body')

    <div class="container-fluid h-100 bg-light">
        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif

        <form method="POST" action="/inventory/event/{{$event->id}}">

            @csrf
            @method('PATCH')

            <div>
                <img class="img-fluid" src="{{\Illuminate\Support\Facades\Storage::url($event->image)}}">
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control" id="title" type="text" name="title" value="{{$event->title}}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description">{{$event->description}}</textarea>
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <label for="start">Start</label>
                    <input class="form-control" type="date" name="start" id="start" required>
                </div>

                <div class="col-sm-12 col-md-6">
                    <label for="end">End</label>
                    <input class="form-control" type="date" name="end" id="end" required>
                </div>
            </div>

            <div class="d-flex gap-3 align-items-center mt-2 ">
                <a class="btn btn-secondary" type="button" href="/inventory/events">Cancel</a>
                <button class="btn btn-primary">Save</button>
            </div>

        </form>
    </div>

@endsection
