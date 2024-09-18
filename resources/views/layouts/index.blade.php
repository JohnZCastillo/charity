<!DOCTYPE html >
<html data-theme="cupcake" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="/css/sweet-alert.css">
    <script src="/js/sweet-alert.js"></script>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>

    {{--    @vite('resources/css/app.css')--}}

    @yield('files')

    @yield('styles')

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .full-screen {
            height: 100vh;
            max-height: calc(100vh - 56px);
        }

        .active {
            background-color: #f1faee
        }

        .link:hover {
            background-color: #f1faee
        }

        /**{*/
        /*    outline: solid 1px red;*/
        /*}*/
    </style>
</head>
<body>


<div class="bg-gray-200 h-screen">

    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #a8dadc !important;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Inventory System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-md-none">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/items">Items</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/donors">Donors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/recipients">Recipients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/announcements">Announcements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/events">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/account">Account</a>
                    </li>
                </ul>
            </div>
            <form data-confirmation="Are you sure you want to logout?" class="confirmation d-none d-md-block"
                  action="/inventory/logout" method="POST">
                @csrf
                <button class="btn btn-secondary" type="Submit">Logout</button>
            </form>
        </div>
    </nav>

    <main class="row mx-0 full-screen">
        <aside class="px-0 d-none d-md-block col-md-2">
            <ul class="h-100 list-group list-group-flush">
                <li class="link {{ request()->is('inventory/dashboard') ? 'active' : '' }}">
                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/dashboard">
                        <i class="bx bx-sm bx-bar-chart"></i>
                        Dashboard
                    </a>
                </li>
                <li class="link {{ request()->is('inventory/items') ? 'active' : '' }}">
                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/items">
                        <i class="bx bx-sm bx-package"></i>
                        Items
                    </a>
                </li>
                <li class="link {{ request()->is('inventory/donors') ? 'active' : '' }}">
                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/donors">
                        <i class="bx bx-sm bx-user-check"></i>
                        Donors
                    </a>
                </li>
                <li class="link {{ request()->is('inventory/recipients') ? 'active' : '' }}">
                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/recipients">
                        <i class="bx bx-sm bx-user-minus"></i>
                        Recipients
                    </a>
                </li>
                <li class="link {{ request()->is('inventory/announcements') ? 'active' : '' }}">

                <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/announcements">
                        <i class="bx bx-sm bx-notepad"></i>
                        Announcements
                    </a>
                </li>
                <li class="link {{ request()->is('inventory/events') ? 'active' : '' }}">

                <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/events">
                        <i class="bx bx-sm bx-calendar-event"></i>
                        Events
                    </a>
                </li>
                <li class="link {{ request()->is('inventory/account') ? 'active' : '' }}">
                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/account">
                        <i class='bx bx-sm bx-user-circle'></i>
                        Account
                    </a>
                </li>
            </ul>
        </aside>
        <section class="col-sm-12 col-md-10 px-0">
            @yield('body')
        </section>
    </main>
</div>

<script>

    const confirmation = document.querySelectorAll('.confirmation');

    function reloadOnEmpty(formID, searchID) {

        const form = document.querySelector(formID);
        const search = document.querySelector(searchID);

        search.addEventListener('input', () => {
            if (!search.value.length) {
                form.submit();
            }
        })
    }

    function submitFormOnChange(formID, ...inputs) {

        const form = document.querySelector(formID);

        inputs.forEach(input => {

            console.log(input);

            const formControl = document.querySelector(input);

            formControl.addEventListener('change', () => {
                form.submit();
            })
        })
    }

    confirmation.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const message = form.dataset.confirmation;

            Swal.fire({
                title: message,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        })
    })

</script>
@yield('scripts')

</body>
</html>
