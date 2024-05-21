@extends('layouts.main_adminkit')

@section('content')
    {{-- <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>

    </x-app-layout> --}}
    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-xl-6 col-xxl-5 d-flex">
            <div class="w-100">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Sales</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="truck"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">{{ formatRupiah($totalToday, true) }}</h1>
                                <div class="mb-0">
                                    {{-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span> --}}
                                    <span class="text-muted">{{ \Carbon\Carbon::now()->format('jS F Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Total Sales</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="users"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">{{ formatRupiah($totalMonth, true) }}</h1>
                                <div class="mb-0">
                                    {{-- <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 5.25% </span> --}}
                                    <span class="text-muted">{{ \Carbon\Carbon::now()->format('F') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Order Toko 1</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="dollar-sign"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">{{ formatRupiah($totalFirst, true) }}</h1>
                                <div class="mb-0">
                                    {{-- <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 6.65% </span> --}}
                                    <span class="text-muted">{{ \Carbon\Carbon::now()->format('F') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Order Toko 2</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle" data-feather="dollar-sign"></i>
                                            {{-- <i class="align-middle" data-feather="shopping-cart"></i> --}}
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">{{ formatRupiah($totalSecond, true) }}</h1>
                                <div class="mb-0">
                                    {{-- <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -2.25% </span> --}}
                                    <span class="text-muted">{{ \Carbon\Carbon::now()->format('F') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-xxl-7">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Total Order Grafik</h5>
                </div>
                <div class="card-body py-3">
                    <div class="chart chart-sm">
                        <canvas id="chartjs-dashboard-line"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h5 class="card-title">Order Grafik</h5>
                    <h6 class="card-subtitle text-muted">Total Order @hari</h6>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="chartjs-line"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- chart 1 --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Line chart
            fetch('/dashboard/chart')
                .then(response => response.json())
                .then(data => {
                    // console.log(data);

                    // if (!data.shop1 || !data.shop2) {
                    //     console.error("Data shop1 or shop2 is undefined.");
                    //     return;
                    // }

                    const labelsShop1 = data.shop1.map(order => order.date);
                    const totalsShop1 = data.shop1.map(order => order.totals);
                    const labelsShop2 = data.shop2.map(order => order.date);
                    const totalsShop2 = data.shop2.map(order => order.totals);

                    const labels = [...new Set([...labelsShop1, ...labelsShop2])];

                    var ctx = document.getElementById("chartjs-line").getContext("2d");
                    var gradient = ctx.createLinearGradient(0, 0, 0, 225);
                    gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
                    gradient.addColorStop(1, "rgba(215, 227, 244, 0)");

                    new Chart(document.getElementById("chartjs-line"), {
                        type: "line",
                        data: {
                            labels: labels,
                            datasets: [{
                                label: "Order (Rp)",
                                fill: true,
                                backgroundColor: gradient,
                                borderColor: window.theme.primary,
                                data: labels.map(label => {
                                    const order = data.shop1.find(order => order
                                        .date === label);
                                    return order ? order.totals : 0;
                                })
                            }, {
                                label: "Shop 2 Sales",
                                fill: true,
                                backgroundColor: "rgba(255, 99, 132, 0.1)",
                                borderColor: "rgba(255, 99, 132, 1)",
                                data: labels.map(label => {
                                    const order = data.shop2.find(order => order
                                        .date === label);
                                    return order ? order.totals : 0;
                                })
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            legend: {
                                display: false
                            },
                            tooltips: {
                                intersect: false
                            },
                            hover: {
                                intersect: true
                            },
                            plugins: {
                                filler: {
                                    propagate: false
                                }
                            },
                            scales: {
                                xAxes: [{
                                    reverse: true,
                                    gridLines: {
                                        color: "rgba(0,0,0,0.05)"
                                    }
                                }],
                                yAxes: [{
                                    ticks: {
                                        stepSize: 1000000,
                                    },
                                    display: true,
                                    borderDash: [5, 5],
                                    gridLines: {
                                        color: "rgba(0,0,0,0)",
                                        fontColor: "#fff"
                                    }
                                }]
                            }
                        }
                    });

                    new Chart(document.getElementById("chartjs-dashboard-line"), {
                        type: "line",
                        data: {
                            labels: data.labelsOrder,
                            datasets: [{
                                label: "Sales ($)",
                                fill: true,
                                backgroundColor: "transparent",
                                borderColor: window.theme.primary,
                                data: data.valuesOrder
                            }, ]
                        },
                        options: {
                            maintainAspectRatio: false,
                            legend: {
                                display: false
                            },
                            tooltips: {
                                intersect: false
                            },
                            hover: {
                                intersect: true
                            },
                            plugins: {
                                filler: {
                                    propagate: false
                                }
                            },
                            scales: {
                                xAxes: [{
                                    reverse: true,
                                    gridLines: {
                                        color: "rgba(0,0,0,0.05)"
                                    }
                                }],
                                yAxes: [{
                                    ticks: {
                                        stepSize: 1000000
                                    },
                                    display: true,
                                    borderDash: [5, 5],
                                    gridLines: {
                                        color: "rgba(0,0,0,0)",
                                        fontColor: "#fff"
                                    }
                                }]
                            }
                        }
                    });
                });
        });
    </script>
@endsection
