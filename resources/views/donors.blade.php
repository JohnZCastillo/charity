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

            <button class="col-span-2 btn bg-slate-400" onclick="donorModal.showModal()">New Donor</button>

        </div>
        <div class="mt-3 p-2 shadow rounded bg-white">

            <table class="table">
                <thead>
                <tr>
                    <td>Donor ID</td>
                    <td>Name</td>
                    <td>Mobile</td>
                    <td>Email</td>
                    <td>Address</td>
                    <td>Status</td>
                    <td>Action</td>
                </tr>
                </thead>
                <tbody>
                @foreach($donors as $donor)
                    <tr>
                        <td>{{$donor->code}}</td>
                        <td>{{$donor->name}}</td>
                        <td>{{$donor->mobile}}</td>
                        <td>{{$donor->email}}</td>
                        <td>{{$donor->address->address}}</td>
                        <td>
                            @if($donor->status == 'enabled')
                                <div class="badge badge-success">{{$donor->status}}</div>
                            @else
                                <div class="badge disabled">{{$donor->status}}</div>
                            @endif
                        </td>
                        <td>
                            <div class="flex gap-2">
                                <a type="button" href="/item/edit/{{$donor->id}}">
                                    <i class='bx bx-sm bx-pencil'></i>
                                </a>
                                <form method="POST" action="/item/{{$donor->id}}">
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
                {{ $donors->links() }}
            </div>
        </div>
    </div>


    <dialog id="donorModal" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>

            <h3 class="text-lg font-bold">Add Donor</h3>

            <form enctype="multipart/form-data" class="w-full" method="POST" action="/donor">
                @csrf

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
                        <span class="label-text">Email</span>
                    </div>
                    <input name="email" type="email" placeholder="Type here" class="input input-bordered w-full"/>
                </div>

                <div>
                    <div class="label">
                        <span class="label-text">Mobile</span>
                    </div>
                    <input name="mobile" type="text" placeholder="Type here" class="input input-bordered w-full"/>
                </div>

                <div>
                    <div class="label">
                        <span class="label-text">Address</span>
                    </div>
                    <input name="address" type="text" placeholder="Type here" class="input input-bordered w-full"/>
                </div>

                <div>
                    <div class="label">
                        <span class="label-text">Status</span>
                    </div>
                    <select name="status" class="select select-bordered w-full">
                        <option disabled selected>Select</option>
                        @foreach(\App\Enums\UserStatus::cases() as $status)
                            <option value="{{$status->value}}">{{$status->value}}</option>
                        @endforeach
                    </select>
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
