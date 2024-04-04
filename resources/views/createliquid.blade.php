@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <h2>Create Liquidation</h2>
                </div>
                <div>
                    <a class='btn btn-success' href='{{url("/liquidations")}}'>Back</a>
                </div>
                @if ($errors->any())
                    <div class='alert alert-danger'>
                        <strong>Whoops!</strong> There were some problem with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{route('lstore')}}" method="Post" enctype="multipart/form-data>"> 
                    @csrf
                    <div class="row">
                        <select class='form-control' name='user_id'>
                            <option value="{{Auth::user()->id}}">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</option>
                        </select>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Travel Itinerary</strong>
                                <input type='text' name="travel_itinerary" class="form-control" placholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Reference</strong>
                                <input type='text' name="reference" class="form-control" placholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Particulars</strong>
                                <input type='text' name="particulars" class="form-control" placholder="">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
