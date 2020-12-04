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

                        <form action="{{route('category.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class=" form-group ">
                                <label for="type">{{trans('category.type')}}</label>
                                <select name="type" class="form-control pb-2" id="time" style="width: 100%">
                                    <option value="">Select Type of category</option>
                                    <option value="0">Income</option>
                                    <option value="1">Expenses</option>
                                </select>
                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label for="name">{{trans('category.name')}}</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name of category">
                            </div>


                                <button type="submit" class="btn btn-primary">{{trans('category.submit')}}</button>
                        </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
