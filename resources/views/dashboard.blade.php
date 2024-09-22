@extends('layouts.index')

@section('files')
    <script src="/js/apexcharts.js"></script>
@endsection

@section('body')
    <div class="h-100 bg-light container-fluid">

        <a href="/inventory/report" type="button" class="btn btn-secondary my-2">
            Inventory Report
        </a>

        <div class="row mx-0 align-items-center gap-2 mb-2">
            <div class="col-12 col-md-3 shadow p-2 rounded">
                <div class="d-flex gap-2 align-items-center justify-content-center">
                    <h1 class="fw-bold mb-0 text-center">{{$donors}}</h1>
                    <i class="text-secondary mt-1 bx bx-lg bx-user-check"></i>
                </div>
                <small class="text-secondary small">Total Donors</small>
            </div>
            <div class="col-12 col-md-3 shadow p-2 rounded">
                <div class="d-flex gap-2 align-items-center justify-content-center">
                    <h1 class="fw-bold mb-0 text-center">{{$recipients}}</h1>
                    <i class="text-secondary mt-1 bx bx-lg bx-user-minus"></i>
                </div>
                <small class="text-secondary small">Total Recipients</small>
            </div>
            <div class="col-12 col-md-3 shadow p-2 rounded">
                <div class="d-flex gap-2 align-items-center justify-content-center">
                    <h1 class="fw-bold mb-0 text-center">{{$items}}</h1>
                    <i class="text-secondary mt-1 bx bx-lg bx-package"></i>
                </div>
                <small class="text-secondary small">Total Items</small>
            </div>

        </div>

        <div id="wrapper">
            <div class="content-area">
                <div class="container-fluid">
                    <div class="main">
                        <div class="box box1">
                            <div id="spark1"></div>
                        </div>
                        <div class="row mt-5 mb-4">
                            <div class="col-md-6">
                                <div class="box">
                                    <div id="bar"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box">
                                    <div id="donut"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <h4 class="text-secondary fw-bold">Low Stock Items</h4>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Item Stock</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lowStockItems as $item)
                    <tr>
                        <td>{{$item->code}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->stock}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        Apex.grid = {
            padding: {
                right: 0,
                left: 0
            }
        }

        Apex.dataLabels = {
            enabled: false
        }

        var colorPalette = ['#00D8B6', '#008FFB', '#FEB019', '#FF4560', '#775DD0']

        var spark1 = {
            chart: {
                id: 'sparkline1',
                group: 'sparklines',
                type: 'area',
                height: 160,
                sparkline: {
                    enabled: true
                },
            },
            stroke: {
                curve: 'straight'
            },
            fill: {
                opacity: 1,
            },
            series: [{
                name: 'New Item History',
                data: @json($newItemsCount)
            }],
            labels: @json($lineChartLabel),
            yaxis: {
                min: 0
            },
            xaxis: {
                type: 'datetime',
            },
            colors: ['#DCE6EC'],
            title: {
                text: '{{$items}}',
                offsetX: 30,
                style: {
                    fontSize: '24px',
                    cssClass: 'apexcharts-yaxis-title'
                }
            },
            subtitle: {
                text: 'New Item History',
                offsetX: 30,
                style: {
                    fontSize: '14px',
                    cssClass: 'apexcharts-yaxis-title'
                }
            }
        }

        new ApexCharts(document.querySelector("#spark1"), spark1).render();

        var optionsBar = {
            chart: {
                type: 'bar',
                height: 380,
                width: '100%',
                stacked: true,
            },
            plotOptions: {
                bar: {
                    columnWidth: '45%',
                }
            },
            colors: colorPalette,
            series: [{
                name: "Donation",
                data: @json($barChartValues),
            }],
            labels: @json($barChartLabels),
            xaxis: {
                labels: {
                    show: false
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
            },
            yaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: '#78909c'
                    }
                }
            },
            title: {
                text: 'Donation History',
                align: 'left',
                style: {
                    fontSize: '18px'
                }
            }

        }

        var chartBar = new ApexCharts(document.querySelector('#bar'), optionsBar);
        chartBar.render();

        var optionDonut = {
            chart: {
                type: 'donut',
                width: '100%',
                height: 400
            },
            dataLabels: {
                enabled: false,
            },
            plotOptions: {
                pie: {
                    customScale: 0.8,
                    donut: {
                        size: '75%',
                    },
                    offsetY: 20,
                },
                stroke: {
                    colors: undefined
                }
            },
            colors: colorPalette,
            title: {
                text: 'Items Category',
                style: {
                    fontSize: '18px'
                }
            },
            series:  @json($donutChartValues),
            labels:  @json($donutChartHeaders),
            legend: {
                position: 'left',
                offsetY: 80
            }
        }

        var donut = new ApexCharts(
            document.querySelector("#donut"),
            optionDonut
        )

        donut.render();

        // on smaller screen, change the legends position for donut
        var mobileDonut = function () {
            if ($(window).width() < 768) {
                donut.updateOptions({
                    plotOptions: {
                        pie: {
                            offsetY: -15,
                        }
                    },
                    legend: {
                        position: 'bottom'
                    }
                }, false, false)
            } else {
                donut.updateOptions({
                    plotOptions: {
                        pie: {
                            offsetY: 20,
                        }
                    },
                    legend: {
                        position: 'left'
                    }
                }, false, false)
            }
        }

        $(window).resize(function () {
            mobileDonut()
        });
    </script>
@endsection
