@extends('layouts.index')

@section('body')

    <div class="p-2 h-100 bg-light">

        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif


        <div class="h-100">

            <form method="POST" action="/inventory/account" class="w-75 mx-auto">
                @csrf

                <h1>User Account</h1>
                <hr>
                <div class="form-group">
                    <label>Email</label>
                    <input value="{{$user->email}}" name="text" type="text" class="form-control">
                </div>

                <div class="form-group">
                    <label>Name</label>
                    <input value="{{$user->name}}" name="text" type="text" class="form-control">
                </div>

            </form>

            <form data-confirmation="Are you sure you want to logout?" class="d-md-none confirmation  mt-3 w-75 mx-auto"
                  action="/inventory/logout" method="POST">
                @csrf
                <button class="btn btn-secondary" type="Submit">Logout</button>
            </form>
        </div>

    </div>

@endsection
