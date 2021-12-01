@extends('layouts.admin')
@section('title', 'Analysis')
@section('headerScripts')

    <style>
        .d-title {
            color: black;
        }
        .d-value {
            font-size: 45px;
            font-weight: 500;
            color: red;
        }
    </style>

@endsection
@section('content')

    <div class="m-4">
        <ul class="breadcrumb d-block mb-3">
            <li><a href="{{ url('/admin/home') }}">Home</a></li>
            <li class="active">System Summary</li>
        </ul>

        <h4>System Summary & Reporting</h4>

        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card bg-white">
                    <div class="card-body text-center">
                        <div class="mb-3 d-title">Today's Visitor</div>
                        <div class="text-danger d-value">9,000</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-white">
                    <div class="card-body text-center">
                        <div class="mb-3 d-title">Today's Log In</div>
                        <div class="text-danger d-value">9,000</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-white">
                    <div class="card-body text-center">
                        <div class="mb-3 d-title">Last 30 days Log In</div>
                        <div class="text-danger d-value">9,000</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-white">
                    <div class="card-body text-center">
                        <div class="mb-3 d-title">Total User</div>
                        <div class="text-danger d-value">9,000</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5>System Daily Log In</h5>
                        <div id="container"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Last 30 days login</h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>asd</td>
                                </tr>
                                <tr>
                                    <td>asd</td>
                                </tr>
                                <tr>
                                    <td>asd</td>
                                </tr>
                                <tr>
                                    <td>asd</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Current Active User</h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>asd</td>
                                </tr>
                                <tr>
                                    <td>asd</td>
                                </tr>
                                <tr>
                                    <td>asd</td>
                                </tr>
                                <tr>
                                    <td>asd</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Most Active User</h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>asd</td>
                                </tr>
                                <tr>
                                    <td>asd</td>
                                </tr>
                                <tr>
                                    <td>asd</td>
                                </tr>
                                <tr>
                                    <td>asd</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footerScripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        $(document).ready(function() {
            getDailyLogin();
        });
        function getDailyLogin() {
            Highcharts.chart('container', {
                exporting: {
                    enabled: false
                },
                chart: {
                    type: 'area'
                },
                accessibility: {
                    description: 'Image description: An area chart compares the nuclear stockpiles of the USA and the USSR/Russia between 1945 and 2017. The number of nuclear weapons is plotted on the Y-axis and the years on the X-axis. The chart is interactive, and the year-on-year stockpile levels can be traced for each country. The US has a stockpile of 6 nuclear weapons at the dawn of the nuclear age in 1945. This number has gradually increased to 369 by 1950 when the USSR enters the arms race with 6 weapons. At this point, the US starts to rapidly build its stockpile culminating in 32,040 warheads by 1966 compared to the USSR’s 7,089. From this peak in 1966, the US stockpile gradually decreases as the USSR’s stockpile expands. By 1978 the USSR has closed the nuclear gap at 25,393. The USSR stockpile continues to grow until it reaches a peak of 45,000 in 1986 compared to the US arsenal of 24,401. From 1986, the nuclear stockpiles of both countries start to fall. By 2000, the numbers have fallen to 10,577 and 21,000 for the US and Russia, respectively. The decreases continue until 2017 at which point the US holds 4,018 weapons compared to Russia’s 4,500.'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    allowDecimals: false,
                    labels: {
                        formatter: function () {
                            return this.value; // clean, unformatted number for year
                        }
                    },
                    accessibility: {
                        rangeDescription: 'Range: 1940 to 2017.'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Nuclear weapon states'
                    },
                    labels: {
                        formatter: function () {
                            return this.value / 1000 + 'k';
                        }
                    }
                },
                tooltip: {
                    pointFormat: '{series.name} had stockpiled <b>{point.y:,.0f}</b><br/>warheads in {point.x}'
                },
                plotOptions: {
                    area: {
                        pointStart: 1940,
                        marker: {
                            enabled: false,
                            symbol: 'circle',
                            radius: 2,
                            states: {
                                hover: {
                                    enabled: true
                                }
                            }
                        }
                    }
                },
                series: [{
                    name: 'USA',
                    data: [
                        null, null, null, null, null, 6, 11, 32, 110, 235,
                        369, 640, 1005, 1436, 2063, 3057, 4618, 6444, 9822, 15468,
                        20434, 24126, 27387, 29459, 31056, 31982, 32040, 31233, 29224, 27342,
                        26662, 26956, 27912, 28999, 28965, 27826, 25579, 25722, 24826, 24605,
                        24304, 23464, 23708, 24099, 24357, 24237, 24401, 24344, 23586, 22380,
                        21004, 17287, 14747, 13076, 12555, 12144, 11009, 10950, 10871, 10824,
                        10577, 10527, 10475, 10421, 10358, 10295, 10104, 9914, 9620, 9326,
                        5113, 5113, 4954, 4804, 4761, 4717, 4368, 4018
                    ]
                }, {
                    name: 'USSR/Russia',
                    data: [null, null, null, null, null, null, null, null, null, null,
                        5, 25, 50, 120, 150, 200, 426, 660, 869, 1060,
                        1605, 2471, 3322, 4238, 5221, 6129, 7089, 8339, 9399, 10538,
                        11643, 13092, 14478, 15915, 17385, 19055, 21205, 23044, 25393, 27935,
                        30062, 32049, 33952, 35804, 37431, 39197, 45000, 43000, 41000, 39000,
                        37000, 35000, 33000, 31000, 29000, 27000, 25000, 24000, 23000, 22000,
                        21000, 20000, 19000, 18000, 18000, 17000, 16000, 15537, 14162, 12787,
                        12600, 11400, 5500, 4512, 4502, 4502, 4500, 4500
                    ]
                }]
            });
        }
    </script>

@endsection