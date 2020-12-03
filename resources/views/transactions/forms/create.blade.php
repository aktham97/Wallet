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

                        <form action="{{route('transaction.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class=" form-group ">
                                <label for="category_id">{{trans('transactions.category_id')}}</label>
                                <select name="category_id" class="form-control pb-2" id="time" style="width: 100%">
                                    <option value="">Select Type of category</option>
                                    @foreach($category as $item)

                                        <option value="{{$item->id}}" >{{$item->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amount">{{trans('transactions.name')}}</label>
                                <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount of transaction">
                            </div>
                            <div class="form-group">
                                <label for="note">{{trans('transactions.note')}}</label>
                                <input type="text" class="form-control" id="note" name="note" placeholder="Enter note of transaction">
                            </div>


                                <button type="submit" class="btn btn-primary">{{trans('transactions.submit')}}</button>
                        </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
