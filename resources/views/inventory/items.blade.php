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

        .container .searchInput {
            background: #fff;
            width: 100%;
            border-radius: 5px;
            position: relative;
            box-shadow: 0px 1px 5px 3px rgba(0, 0, 0, 0.12);
        }

        .searchInput input {
            height: 55px;
            width: 100%;
            outline: none;
            border: none;
            border-radius: 5px;
            padding: 0 60px 0 20px;
            font-size: 18px;
            box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.1);
        }

        .searchInput.active input {
            border-radius: 5px 5px 0 0;
        }

        .searchInput .resultBox {
            padding: 0;
            opacity: 0;
            pointer-events: none;
            max-height: 280px;
            overflow-y: auto;
        }

        .searchInput.active .resultBox {
            padding: 10px 8px;
            opacity: 1;
            pointer-events: auto;
        }

        .resultBox li {
            list-style: none;
            padding: 8px 12px;
            display: none;
            width: 100%;
            cursor: default;
            border-radius: 3px;
        }

        .searchInput.active .resultBox li {
            display: block;
        }

        .resultBox li:hover {
            background: #efefef;
        }

        .searchInput .icon {
            position: absolute;
            right: 0px;
            top: 0px;
            height: 55px;
            width: 55px;
            text-align: center;
            line-height: 55px;
            font-size: 20px;
            color: #644bff;
            cursor: pointer;
        }

        #resultBox:empty {
            display: none;
        }

    </style>
@endsection

@section('body')

    <div class="p-2 bg-light h-100">

        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
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

                <div class="col-3 d-flex align-items-center gap-2">
                    <label class="text-nowrap">Order By</label>
                    <select class="form-select" id="orderBy" name="order">
                        <option @selected($app->request->order == 'code') value="code">Code</option>
                        <option @selected($app->request->order == 'name') value="name">Name</option>
                        <option @selected($app->request->order == 'stock') value="stock">Stock</option>
                    </select>
                </div>

                <div class="col-3 d-flex align-items-center gap-2">
                    <label class="text-nowrap">Sort by</label>
                    <select class="form-select" id="sortBy" name="sort">
                        <option @selected($app->request->sort == 'asc') value="asc">Ascending</option>
                        <option @selected($app->request->sort == 'desc') value="desc">Descending</option>
                    </select>
                </div>
            </div>
        </form>

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

    <div class="container">
        <div class="searchInput">
            <input type="text" placeholder="Saisir une adresse..">
            <div class="resultBox">
                <!-- here list are inserted from javascript -->
            </div>
            <div class="icon"><i class="fas fa-search"></i></div>
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
                            <input name="image" type="file" accept="image/*" class="form-control"/>
                        </div>


                        <div class="form-group">
                            <label class="label-text">Code</label>
                            <input name="code" type="text" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Name</label>
                            <input name="name" type="text" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Status</label>
                            <select name="status" class="form-select">
                                <option disabled selected>Select</option>
                                @foreach(\App\Enums\ItemStatus::cases() as $status)
                                    <option value="{{$status->value}}">{{$status->value}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Stock</label>
                            <input name="stock" type="number" class="form-control"/>
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
            reloadOnEmpty('#searchForm', '#searchInput');
            submitFormOnChange('#searchForm', '#orderBy', '#sortBy');
        })

        let database = [
            "Channel",
            "CodingLab",
            "CodingNepal",
            "YouTube",
            "YouTuber",
            "YouTube Channel",
            "Blogger",
            "Bollywood",
            "Vlogger",
            "Vechiles",
            "Facebook",
            "Freelancer",
            "Facebook Page",
            "Designer",
            "Developer",
            "Web Designer",
            "Web Developer",
            "Login Form in HTML & CSS",
            "How to learn HTML & CSS",
            "How to learn JavaScript",
            "How to became Freelancer",
            "How to became Web Designer",
            "How to start Gaming Channel",
            "How to start YouTube Channel",
            "What does HTML stands for?",
            "What does CSS stands for?",
        ];

        // getting all required elements
        const searchInput = document.querySelector(".searchInput");
        const input = searchInput.querySelector("input");
        const resultBox = searchInput.querySelector(".resultBox");
        const icon = searchInput.querySelector(".icon");
        let linkTag = searchInput.querySelector("a");
        let webLink;

        input.addEventListener('keyup', (e) => {

            const searchQuery = e.target.value;
            let suggestions = [];

            if (!searchQuery || searchQuery === ' ') {
                searchInput.classList.remove("active");
                return;
            }

            suggestions = database.filter((data) => {
                return data.toLocaleLowerCase().startsWith(searchQuery.toLocaleLowerCase());
            });

            if (!suggestions.length) {
                resultBox.innerHTML = null;
                return;
            }

            suggestions = suggestions.map(suggestion => `<li>${suggestion}</li>`);


            searchInput.classList.add("active"); //show autocomplete box

            showSuggestions(suggestions);

            let selections = resultBox.querySelectorAll("li");

            selections.forEach(selection => {
                selection.addEventListener('click', () => {
                    searchInput.value = selection.innerText;
                    searchInput.classList.remove("active")
                    resultBox.innerHTML = null;
                })
            })

            function showSuggestions(suggestions) {
                resultBox.innerHTML = suggestions ?? null;
            }
        })

    </script>
@endsection
