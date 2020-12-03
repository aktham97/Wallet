@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{trans('transactions.wallet_balance')}}</th>
                                    <th scope="col">{{trans('transactions.total_income')}}</th>
                                    <th scope="col">{{trans('transactions.total_expenses')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">{{$wallet->id}}</th>

                                        <th scope="row">{{$wallet->wallet_balance}}</th>
                                        <td>{{$wallet->total_income}}</td>
                                        <td>{{$wallet->total_expenses}}</td>
                                    </tr>

                                </tbody>
                            </table>
                            <br>


                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{trans('transactions.category_id')}}</th>
                                <th scope="col">{{trans('transactions.amount')}}</th>
                                <th scope="col">{{trans('transactions.note')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($data as $item)
                                <tr>
                                    <th scope="row">{{$item->id}}</th>

                                    <th scope="row">{{$item->category->name}}</th>
                                    <td>{{$item->amount}}</td>
                                    <td>{{$item->note}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="8">No Transactions</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{$data->appends(Request::all())->render() }}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
