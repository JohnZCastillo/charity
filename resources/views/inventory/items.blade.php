@extends('layouts.index')

@section('files')
    <link href="/light-box/css/lightbox.css" rel="stylesheet"/>
    <script src="/light-box/js/lightbox-plus-jquery.js"></script>
@endsection

@section('styles')
    <style>

        .thumbnail {
            width: 100px;
            height: 50px;
            object-fit: contain;
        }

        td {
            vertical-align: center;
        }

        .pill-enabled {
            background-color: var(--bs-success);
        }

        .pill-disabled {
            background-color: var(--bs-secondary);
        }
    </style>
@endsection

@section('body')


    <div class="p-2 bg-light h-100">

        @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                 {{$errors->first()}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <form id="searchForm">
            <div class="row mx-0">

                <div class="col-12 d-flex align-items-center gap-2 mb-2">
                    <input id="searchInput" value="{{$app->request->search}}" placeholder="Search" type="search"
                           name="search"
                           class="form-control">

                    <button type="button" class="btn btn-secondary text-nowrap" data-bs-toggle="modal"
                            data-bs-target="#itemModal">New Item
                    </button>

                </div>

                <div class="col-6 col-md-3 d-flex align-items-center gap-2">
                    <label class="text-nowrap">Order By</label>
                    <select class="form-select" id="orderBy" name="order">
                        <option @selected($app->request->order == 'code') value="code">Code</option>
                        <option @selected($app->request->order == 'name') value="name">Name</option>
                        <option @selected($app->request->order == 'stock') value="stock">Stock</option>
                    </select>
                </div>

                <div class="col-6 col-md-3 d-flex align-items-center gap-2">
                    <label class="text-nowrap">Sort by</label>
                    <select class="form-select" id="sortBy" name="sort">
                        <option @selected($app->request->sort == 'asc') value="asc">Ascending</option>
                        <option @selected($app->request->sort == 'desc') value="desc">Descending</option>
                    </select>
                </div>

                <div class="col-6 col-md-3 d-flex align-items-center gap-2">
                    <label class="text-nowrap">Status</label>
                    <select class="form-select text-uppercase" id="searchStatus" name="status">
                        <option value="ALL">All</option>
                        @foreach(\App\Enums\ItemStatus::cases() as $status)
                            <option class="text-uppercase" @selected($app->request->status ==$status->value) value="{{$status->value}}">{{$status->value}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-3 mt-2 mt-md-0 d-flex align-items-center gap-2">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-warning">
                        Donate
                    </button>
                </div>

            </div>
        </form>

        <!-- Modal -->
        <x-donation />

        <div class="mt-3 p-2 shadow rounded bg-white">

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
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
                                    <div>
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
                                <span class="badge pill-{{$item->status}}">{{$item->status}}</span>
                            </td>
                            <td>{{$item->stock}}</td>
                            <td>
                                <div class="d-flex gap-2 align-items-center flex-nowrap">

                                    <a class="btn btn-secondary" type="button" href="/item/edit/{{$item->id}}">
                                        edit
                                    </a>

                                    <form data-confirmation="Are you sure you want to delete this item?"
                                          class="confirmation" method="POST" action="/item/{{$item->id}}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">
                                            delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="py-2">
                {{ $items->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form enctype="multipart/form-data" class="w-full" method="POST" action="/item">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf

                        <div class="form-group">
                            <label class="label-text">Image</label>
                            <input name="image" type="file" accept="image/*" class="form-control" required/>
                        </div>


                        <div class="form-group">
                            <label class="label-text">Code</label>
                            <input name="code" type="text" class="form-control" required/>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Name</label>
                            <input name="name" type="text" class="form-control" required/>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Description</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Status</label>
                            <select name="status" class="form-select" required>
                                <option disabled selected>Select</option>
                                @foreach(\App\Enums\ItemStatus::cases() as $status)
                                    <option value="{{$status->value}}">{{$status->value}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Stock</label>
                            <input name="stock" type="number" min="1" class="form-control" required/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        window.addEventListener('load', () => {
            reloadOnEmpty('#searchForm', '#searchInput',);
            submitFormOnChange('#searchForm', '#orderBy', '#sortBy','#searchStatus');
        })
    </script>
@endsection
