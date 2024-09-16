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

            <a href="/create-announcement" class="col-span-2 btn bg-slate-400">New Announcement</a>

        </div>

        <div class="mt-3 p-2 shadow rounded bg-white">

            <table class="table">
                <thead>
                <tr>
                    <td>Title</td>
                    <td>Created By</td>
                    <td>Date</td>
                    <td>Status</td>
                    <td>Action</td>
                </tr>
                </thead>
                <tbody>

                @foreach($announcements as $announcement)
                    {!! $announcement->content !!}
                @endforeach

{{--                @foreach($donors as $donor)--}}
{{--                    <tr>--}}
{{--                        <td>{{$donor->code}}</td>--}}
{{--                        <td>{{$donor->name}}</td>--}}
{{--                        <td>{{$donor->mobile}}</td>--}}
{{--                        <td>{{$donor->email}}</td>--}}
{{--                        <td>{{$donor->address->address}}</td>--}}
{{--                        <td>--}}
{{--                            @if($donor->status == 'enabled')--}}
{{--                                <div class="badge badge-success">{{$donor->status}}</div>--}}
{{--                            @else--}}
{{--                                <div class="badge disabled">{{$donor->status}}</div>--}}
{{--                            @endif--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <div class="flex gap-2">--}}
{{--                                <a type="button" href="/item/edit/{{$donor->id}}">--}}
{{--                                    <i class='bx bx-sm bx-pencil'></i>--}}
{{--                                </a>--}}
{{--                                <form method="POST" action="/item/{{$donor->id}}">--}}
{{--                                    @csrf--}}
{{--                                    @method('DELETE')--}}
{{--                                    <button type="submit">--}}
{{--                                        <i class='bx bx-sm bx-trash text-rose-500'></i>--}}
{{--                                    </button>--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
                </tbody>
            </table>
            <div class="py-2">
{{--                {{ $donors->links() }}--}}
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        // window.addEventListener('load', () => {
        //     reloadOnEmpty('#searchForm', '#searchInput');
        //     submitFormOnChange('#searchForm', '#orderBy', '#sortBy');
        // })
    </script>
@endsection
