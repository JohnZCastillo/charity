@extends('layouts.index')

@section('styles')
@endsection

@section('body')

    <div class="bg-light p-2">

        @if($errors->any())
            <div class="container-fluid">
                <div class="alert alert-danger" role="alert">
                    {{$errors->first()}}
                </div>
            </div>
        @endif

        <h1 class="text-xl font-bold text-gray-700">EDIT ITEM</h1>

        <div class="p-2 row mx-0">

            <div class="col-sm-12 col-md-6">
                <div class="d-flex align-items-center justify-content-center">
                    @if($item->attachment)
                        <img class="img-fluid"
                             src="{{\Illuminate\Support\Facades\Storage::url($item->attachment->file)}}">
                    @endif
                </div>
            </div>

            <form enctype="multipart/form-data" class="form col-sm-12 col-md-6" method="POST"
                  action="/item/{{$item->id}}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label class="label-text">Image</label>
                    <input name="image" type="file" accept="image/*" class="form-control" />
                </div>

                <div class="form-group">
                    <label class="label-text">Code</label>
                    <input value="{{$item->code}}" name="code" type="text" class="form-control" required/>
                </div>

                <div class="form-group">
                    <label class="label-text">Name</label>
                    <input value="{{$item->name}}" name="name" type="text" class="form-control" required/>
                </div>

                <div class="form-group">
                    <label class="label-text">Description</label>
                    <textarea name="description" class="form-control" required>{{$item->description}}</textarea>
                </div>

                <div class="form-group">
                    <label class="label-text">Status</label>
                    <select name="status" class="form-select" required>
                        <option disabled selected>Select</option>
                        @foreach(\App\Enums\ItemStatus::cases() as $status)
                            <option
                                @selected($item->status == $status) value="{{$status->value}}">{{$status->value}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="label-text">Stock</label>
                    <input value="{{$item->stock}}" name="stock" type="number" class="form-control" required/>
                </div>

                <div class="d-flex gap-2 align-items-center mt-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="/inventory/items" type="button" class="btn btn-secondary">Back</a>
                </div>

            </form>

            @if($errors->any())
                {{ $errors->first() }}
            @endif
        </div>
    </div>
@endsection

