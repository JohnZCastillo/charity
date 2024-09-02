<!DOCTYPE html >
<html data-theme="cupcake" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    @vite('resources/css/app.css')

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
    </style>
</head>
<body>


<div class="bg-gray-200 h-screen">

    <div class="h-[10%] bg-white navbar shadow-md">
        <div class="navbar-start">
            <a class="btn btn-ghost text-xl">Inventory System</a>
        </div>

        <div class="navbar-end m-0 p-0">
            <form method="POST" action="/logout">
                @csrf
                <div class="tooltip tooltip-left" data-tip="logout">
                    <button type="submit">
                        <i class='bx bx-sm bx-log-out'></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="h-[90%] grid grid-cols-[200px_1fr]">

        <!-- Side Bar -->
        <aside class="bg-white">
            <ul class="menu">
                <li>
                    <a class="{{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
                        <i class="bx bx-sm bx-bar-chart"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a  class="{{ request()->is('items') ? 'active' : '' }}" href="/items">
                        <i class="bx bx-sm bx-package"></i>
                        Items
                    </a>
                </li>
                <li>
                    <a  class="{{ request()->is('donors') ? 'active' : '' }}" href="/donors">
                        <i class="bx bx-sm bx-user-check"></i>
                        Donors
                    </a>
                </li>
                <li>
                    <a  class="{{ request()->is('recipients') ? 'active' : '' }}" href="/recipients">
                        <i class="bx bx-sm bx-user-minus"></i>
                        Recipients
                    </a>
                </li>
                <li>
                    <a  class="{{ request()->is('announcements') ? 'active' : '' }}" href="/announcements">
                        <i class="bx bx-sm bx-notepad"></i>
                        Announcements
                    </a>
                </li>
                <li>
                    <a class="{{ request()->is('events') ? 'active' : '' }}" href="/events">
                        <i class="bx bx-sm bx-calendar-event"></i>
                        Events
                    </a>
                </li>
                <li>
                    <a class="{{ request()->is('account') ? 'active' : '' }}" href="/account">
                        <i class='bx bx-sm bx-user-circle'></i>
                        Account
                    </a>
                </li>
            </ul>
        </aside>

        @yield('body')
    </div>

</div>

<script>

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

</script>
@yield('scripts')


</body>
</html>
