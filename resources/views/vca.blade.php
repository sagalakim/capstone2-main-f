@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <h2>Any Cash Advances?</h2>
                </div>
                <div>
                    <a class='btn btn-success' href='{{url("/liquidations")}}'>No Cash Advance</a>
                </div>
                <form action="{{route('update',$liquidation->id)}}" method="Post" enctype="multipart/form-data>"> 
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Amount</strong>
                                <input type='text' name="ca_id" value="{{$liquidation->ca_id}}" class="form-control" placholder="">
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
