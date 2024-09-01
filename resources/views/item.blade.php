@extends('layouts.index')

@section('files')
    <link href="/light-box/css/lightbox.css" rel="stylesheet"/>
    <script src="/light-box/js/lightbox-plus-jquery.js"></script>
@endsection

@section('body')

    <div class="p-2">
        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif

        <div class="mt-2 grid grid-rows-1  grid-cols-12 gap-2">

            <form id="searchForm" class="col-span-10">
                <input id="searchInput" value="{{$app->request->search}}" placeholder="Search" type="search"
                       name="search"
                       class="w-full input input-bordered">

                <div class="flex gap-2 py-2">
                    <div>
                        <label>Order By</label>
                        <select class="select select-bordered" id="orderBy" name="order">
                            <option @selected($app->request->order == 'code') value="code">Code</option>
                            <option @selected($app->request->order == 'name') value="name">Name</option>
                            <option @selected($app->request->order == 'stock') value="stock">Stock</option>
                        </select>
                    </div>

                    <div>
                        <label>Sort by</label>
                        <select class="select select-bordered" id="sortBy" name="sort">
                            <option @selected($app->request->sort == 'asc') value="asc">Ascending</option>
                            <option @selected($app->request->sort == 'desc') value="desc">Descending</option>
                        </select>
                    </div>
                </div>
            </form>

            <button class="col-span-2 btn bg-slate-400" onclick="itemModal.showModal()">New Item</button>

        </div>
        <div class="mt-3 p-2 shadow rounded bg-white">

            <table class="table">
                <thead>
                <tr>
                    <td>Code</td>
                    <td>Name</td>
                    <td>Image</td>
                    <td>Description</td>
                    <td>Status</td>
                    <td>Stock</td>
                    <td>Action</td>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{$item->code}}</td>
                        <td>{{$item->name}}</td>
                        <td>
                            @if($item->attachment)
                                <div class="avatar">
                                    <div class="w-24 rounded">
                                        <a data-lightbox="{{$item->attachment->file}}"
                                           href="{{\Illuminate\Support\Facades\Storage::url($item->attachment->file)}}">
                                            <img class="thumbnail"
                                                 src="{{\Illuminate\Support\Facades\Storage::url($item->attachment->file)}}">
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td>{{$item->description}}</td>
                        <td>
                            @if($item->status == 'enabled')
                                <div class="badge badge-success">{{$item->status}}</div>
                            @else
                                <div class="badge disabled">{{$item->status}}</div>
                            @endif
                        </td>
                        <td>{{$item->stock}}</td>
                        <td>
                            <div class="flex gap-2">
                                <button>
                                    <i class='bx bx-sm bx-pencil'></i>
                                </button>
                                <form method="POST" action="/item/{{$item->id}}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">
                                        <i class='bx bx-sm bx-trash text-rose-500'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="py-2">
                {{ $items->links() }}
            </div>
        </div>
    </div>


    <dialog id="itemModal" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>

            <h3 class="text-lg font-bold">Add Item</h3>

            <form enctype="multipart/form-data" class="w-full" method="POST" action="/item">
                @csrf

                <div>
                    <div class="label">
                        <span class="label-text">Image</span>
                    </div>
                    <input name="image" type="file" accept="image/*"
                           class="file-input w-full file-input-bordered file-input-success"/>
                </div>

                <div>
                    <div class="label">
                        <span class="label-text">Code</span>
                    </div>
                    <input name="code" type="text" placeholder="Type here" class="input input-bordered w-full"/>
                </div>

                <div>
                    <div class="label">
                        <span class="label-text">Name</span>
                    </div>
                    <input name="name" type="text" placeholder="Type here" class="input input-bordered w-full"/>
                </div>

                <div>
                    <div class="label">
                        <span class="label-text">Description</span>
                    </div>
                    <textarea name="description" class="textarea  textarea-md  textarea-bordered w-full"
                              placeholder="Bio"></textarea>
                </div>

                <div>
                    <div class="label">
                        <span class="label-text">Status</span>
                    </div>
                    <select name="status" class="select select-bordered w-full">
                        <option disabled selected>Select</option>
                        @foreach(\App\Enums\ItemStatus::cases() as $status)
                            <option value="{{$status->value}}">{{$status->value}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <div class="label">
                        <span class="label-text">Stock</span>
                    </div>
                    <input name="stock" type="number" placeholder="Type here" class="input input-bordered w-full"/>
                </div>

                <button type="submit" class="mt-2 btn-block btn btn-primary mx-auto">Add</button>
            </form>
        </div>
    </dialog>

@endsection

@section('scripts')
    <script>
        window.addEventListener('load', () => {
            reloadOnEmpty('#searchForm', '#searchInput');
            submitFormOnChange('#searchForm', '#orderBy', '#sortBy');
        })
    </script>
@endsection
