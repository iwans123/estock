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
        <div class="col-md-12">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h5 class="card-title">Order Grafik</h5>
                    <h6 class="card-subtitle text-muted">Total Order</h6>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="chartjs-line"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Line chart
            fetch('/dashboard/chart')
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(orders => orders.date);
                    const totals = data.map(orders => orders.totals);

                    new Chart(document.getElementById("chartjs-line"), {
                        type: "line",
                        data: {
                            labels: labels,
                            datasets: [{
                                label: "Order (Rp)",
                                fill: true,
                                backgroundColor: "transparent",
                                borderColor: window.theme.primary,
                                data: totals
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
                                        stepSize: 100000,
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

    {{-- <div style="width: 75%; margin: auto;">
        <canvas id="transactionsChart"></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/dashboard/chart')
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(orders => orders.date);
                    const totals = data.map(orders => orders.total);

                    const ctx = document.getElementById('transactionsChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Total Transactions',
                                data: '12500',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
        });
    </script> --}}
@endsection
