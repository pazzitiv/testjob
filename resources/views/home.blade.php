@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @can('read', 'chart')
                            <div id="chart"></div>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    var chart = Highcharts.chart('chart', {
                                        legend: {
                                            enabled: true
                                        },
                                        series: [{
                                            name: 'Example',
                                            type: 'column',
                                            data: [Math.random() * 1000, Math.random() * 1000, Math.random() * 1000, Math.random() * 1000, Math.random() * 1000]
                                        }, {
                                            name: 'Example #2',
                                            type: 'spline',
                                            data: [Math.random() * 1000, Math.random() * 1000, Math.random() * 1000, Math.random() * 1000, Math.random() * 1000]
                                        }]
                                    });
                                })
                            </script>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
