@extends('layouts.index')

@section('files')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('body')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="grid grid-cols-5 gap-2 px-2 mt-2 h-28">
                <div class="bg-white rounded shadow p-2 h-full">
                    <p class="text-gray-800">Donors</p>
                    <div class="flex justify-between items-center">
                        <h2 class="text-5xl text-indigo-800 font-bold">100</h2>
                        <i class="bx bx-lg bx-sm bx-user-check text-indigo-800 "></i>
                    </div>
                </div>
                <div class="bg-white rounded shadow p-2 h-full">
                    <p class="text-gray-800">Recipients</p>
                    <div class="flex justify-between items-center">
                        <h2 class="text-5xl text-indigo-800 font-bold">100</h2>
                        <i class="bx bx-lg bx-sm bx-user-check text-indigo-800 "></i>
                    </div>
                </div>
                <div class="bg-white rounded shadow p-2 h-full">
                    <p class="text-gray-800">Items</p>
                    <div class="flex justify-between items-center">
                        <h2 class="text-5xl text-indigo-800 font-bold">100</h2>
                        <i class="bx bx-lg bx-sm bx-user-check text-indigo-800 "></i>
                    </div>
                </div>
                <div class="bg-white rounded shadow p-2 h-full">
                    <p class="text-gray-800">Announcements</p>
                    <div class="flex justify-between items-center">
                        <h2 class="text-5xl text-indigo-800 font-bold">100</h2>
                        <i class="bx bx-lg bx-sm bx-user-check text-indigo-800 "></i>
                    </div>
                </div>
                <div class="bg-white rounded shadow p-2 h-full">
                    <p class="text-gray-800">Events</p>
                    <div class="flex justify-between items-center">
                        <h2 class="text-5xl text-indigo-800 font-bold">100</h2>
                        <i class="bx bx-lg bx-sm bx-user-check text-indigo-800 "></i>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        const ctx = document.getElementById('myChart');

        // new Chart(ctx, {
        //     type: 'bar',
        //     data: {
        //         labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        //         datasets: [{
        //             label: '# of Votes',
        //             data: [12, 19, 3, 5, 2, 3],
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         scales: {
        //             y: {
        //                 beginAtZero: true
        //             }
        //         }
        //     }
        // });
    </script>
@endsection
