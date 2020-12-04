@extends('layouts.app')
@section('content')


<!-- jQuery and JS bundle w/ Popper.js -->

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                        <ul class="navbar-nav mr-auto">
                            <li>
                                <a class="nav-link" href="{{ route('transaction.chart','Daily') }}">Daily</a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('transaction.chart','Monthly') }}">Monthly</a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('transaction.chart','Yearly') }}">Yearly</a>
                            </li>
                        </ul>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

    <div id='mainContent'>
        <div class="container-fluid">
            <h4 class="c-grey-900 mT-10 mB-30">{{$type}}</h4>

            <div class="row">
                <div class="col-md-12">
                    <div class="bgc-white bd bdrs-3 p-20 mB-20">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">


    </script>
    <script>
        var data = {!! json_encode($data) !!};
        var count_income = {!! json_encode($total_income) !!};
        var count_expenses = {!! json_encode($total_expenses) !!};


        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                datasets: [{
                    label: 'Bar Expenses',
                    data: count_expenses,
                    backgroundColor: "#143d59",
                }, {
                    label: 'Line Income',
                    data: count_income,
                    backgroundColor: "#fb84b1ff",

                    // Changes this dataset to become a line
                    type: 'bar'
                }],
                labels: data
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }

        });

    </script>
@endsection
