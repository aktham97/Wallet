@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-15">
                <div class="card">
                    <div class="card-header">Users</div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{trans('admin.name')}}</th>
                            <th scope="col">{{trans('admin.email')}}</th>
                            <th scope="col">{{trans('admin.phone')}}</th>
                            <th scope="col">{{trans('admin.birthdate')}}</th>
                            <th scope="col">{{trans('admin.total_expenses')}}</th>
                            <th scope="col">{{trans('admin.total_income')}}</th>
                            <th scope="col">{{trans('admin.registered_date')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->country_code.'-'.$user->phone_code}}</td>
                                @if($user->birthdate == null)
                                <td>No Data</td>
                                @else
                                    <td>{{$user->birthdate}}</td>
                                @endif
                                @if($user->wallet == null)
                                    <td>No Data</td>
                                <td>No data</td>
                                @else
                                <td>{{$user->wallet->total_expenses}}</td>
                                <td>{{$user->wallet->total_income}}</td>
                                @endif
                                <td>{{$user->created_at}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="8">No Users</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{$users->appends(Request::all())->render() }}



                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
