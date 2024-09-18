@extends('layouts.index')

@section('files')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('body')
   <div class="h-100 bg-light">

   </div>
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
