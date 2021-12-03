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
        .text-right {
            text-align: right;
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
                        <div class="text-danger d-value todays_visitor">0</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-white">
                    <div class="card-body text-center">
                        <div class="mb-3 d-title">Today's Log In</div>
                        <div class="text-danger d-value todays_login">0</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-white">
                    <div class="card-body text-center">
                        <div class="mb-3 d-title">Last 30 days Log In</div>
                        <div class="text-danger d-value last_30days_login">0</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-white">
                    <div class="card-body text-center">
                        <div class="mb-3 d-title">Total User</div>
                        <div class="text-danger d-value total_user">0</div>
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
                        <h5><i class="fa fa-user fa-fw"></i> Last 30 days login</h5>
                        <div style="max-height:300px;overflow-y:auto">
                            <table class="table">
                                <tbody class="last_30days_data">
                                    <tr>
                                        <th>User</th>
                                        <th class="text-right">Login At</th>
                                    </tr>
                                    <tr>
                                        <td>Safrin</td>
                                        <td class="text-success text-right">2021-12-02 09:00:00</td>
                                    </tr>
                                    <tr>
                                        <td>Safrin</td>
                                        <td class="text-success text-right">2021-12-02 09:00:00</td>
                                    </tr>
                                    <tr>
                                        <td>Safrin</td>
                                        <td class="text-success text-right">2021-12-02 09:00:00</td>
                                    </tr>
                                    <tr>
                                        <td>Safrin</td>
                                        <td class="text-success text-right">2021-12-02 09:00:00</td>
                                    </tr>
                                    <tr>
                                        <td>Safrin</td>
                                        <td class="text-success text-right">2021-12-02 09:00:00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5><i class="fa fa-user fa-fw"></i> Current Active User</h5>
                        <div style="max-height:300px;overflow-y:auto;">
                            <table class="table">
                                <tbody class="current_active"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5><i class="fa fa-user fa-fw"></i> Most Active User</h5>
                        <table class="table">
                            <tbody class="most_active"></tbody>
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
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script>
        $(document).ready(function() {
            getDailyLogin();
        });
        function getDailyLogin() {
            $.ajax({
                url: "{{ url('admin/analysis/data') }}",
                type: "GET",
                success: function(response) {
                    console.log(response);
                    $(".todays_visitor").html(parseInt(response.todays_visitor));
                    $(".todays_login").html(parseInt(response.todays_login));
                    $(".last_30days_login").html(parseInt(response.last_30days));
                    $(".total_user").html(parseInt(response.total_user));

                    runningNumber();

                    var last_30days = '';
                    $.each(response.last_30days_data, function(index,value) {
                        last_30days += '<tr>'+
                            '<td>'+ value.user_name +'</td>'+
                            '<td class="text-success text-right">'+ value.created_at +'</td>'+
                        '</tr>'
                    });
                    $(".last_30days_data").html(
                        '<tr>'+
                            '<th>User</th>'+
                            '<th class="text-right">Login At</th>'+
                        '</tr>'+
                        last_30days
                    );

                    var current_active = '';
                    $.each(response.current_active, function(index,value) {
                        current_active += '<tr>'+
                            '<td>'+ value.user_name +'</td>'+
                            '<td class="text-success text-right">'+ value.last_activity_date +'</td>'+
                        '</tr>'
                    });
                    $(".current_active").html(
                        '<tr>'+
                            '<th>User</th>'+
                            '<th class="text-right">Last Activity</th>'+
                        '</tr>'+
                        current_active
                    );

                    var most_active = '';
                    $.each(response.most_active_user, function(index,value) {
                        most_active += '<tr>'+
                            '<td>'+ value.user_name +'</td>'+
                        '</tr>'
                    });
                    $(".most_active").html(
                        '<tr>'+
                            '<th>User</th>'+
                        '</tr>'+
                        most_active
                    );

                    // =====================

                    var timeline_categories = [];
                    var timeline_data = [];
                    $.each(response.daily_login.reverse(), function(index,value) {
                        timeline_categories.push(value.date);
                        timeline_data.push(parseInt(value.total));
                    });

                    Highcharts.chart('container', {
                        credits: {
                            enabled: false
                        },
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
                            categories: timeline_categories,
                            allowDecimals: false,
                            labels: {
                                formatter: function () {
                                    return this.value; // clean, unformatted number for year
                                }
                            },
                        },
                        yAxis: {
                            title: {
                                text: 'Number of user'
                            },
                            // labels: {
                            //     formatter: function () {
                            //         return this.value / 1000 + 'k';
                            //     }
                            // }
                        },
                        tooltip: {
                            // pointFormat: '<b>{point.y:,.0f}</b> user logged in on {point.x}'
                            formatter: function(d) {
                                return '<b>'+this.x+'</b><br/><b>'+this.y.toLocaleString()+'</b> user has logged in on '+this.x;
                            }
                        },
                        plotOptions: {
                            area: {
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
                            name: 'User',
                            data: timeline_data
                        }]
                    });
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
        
        function runningNumber() {
            $('.d-value').each(function () {
                $(this).prop('Counter',0).animate({
                    Counter: $(this).text()
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function (now) {
                        $(this).text(Math.ceil(now).toLocaleString());
                    }
                });
            });
        }
    </script>

@endsection