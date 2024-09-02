@extends('layouts.index')

@section('body')
    <div class="p-2 grid grid-cols-2">
        <div class="flex items-center justify-center">
            <div class="max-w-sm">
                @if($item->attachment)
                    <img style="max-width: 400px; max-height:400px"
                         src="{{\Illuminate\Support\Facades\Storage::url($item->attachment->file)}}">
                @endif
            </div>
        </div>
        <form enctype="multipart/form-data" class="p-3 w-full" method="POST"
              action="/item/{{$item->id}}">
            @csrf
            @method('PATCH')

            <h1 class="text-xl font-bold text-gray-700">EDIT ITEM</h1>

            <div>
                <div class="label">
                    <span class="label-text">Image</span>
                </div>
                <input name="image" type="file" accept="image/*"
                       class="file-input w-full file-input-bordered file-input-success"/>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <div class="label">
                        <span class="label-text">Code</span>
                    </div>
                    <input value="{{$item->code}}" name="code" type="text" placeholder="Type here"
                           class="input input-bordered w-full"/>
                </div>

                <div>
                    <div class="label">
                        <span class="label-text">Name</span>
                    </div>
                    <input value="{{$item->name}}" name="name" type="text" placeholder="Type here"
                           class="input input-bordered w-full"/>
                </div>
            </div>

            <div>
                <div class="label">
                    <span class="label-text">Description</span>
                </div>
                <textarea name="description" class="textarea  textarea-md  textarea-bordered w-full"
                          placeholder="Bio">{{$item->description}}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-2">

                <div>
                    <div class="label">
                        <span class="label-text">Status</span>
                    </div>
                    <select name="status" class="select select-bordered w-full">
                        @foreach(\App\Enums\ItemStatus::cases() as $status)
                            <option
                                @selected($item->status == $status)  value="{{$status->value}}">{{$status->value}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <div class="label">
                        <span class="label-text">Stock</span>
                    </div>
                    <input value="{{$item->stock}}" name="stock" type="number" placeholder="Type here"
                           class="input input-bordered w-full"/>
                </div>
            </div>


            <div class="grid grid-cols-2 gap-2 py-2">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="/items" type="button" class="btn bg-gray-600 text-white">Back</a>
            </div>

        </form>

        @if($errors->any())
            {{ $errors->first() }}
        @endif
    </div>
@endsection

