@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <h2>Edit Liquidation</h2>
                </div>
                <div>
                    <a class='btn btn-success' href='{{url("/liquidations")}}'>Back</a>
                </div>
                <form action="{{route('update',$liquidation->id)}}" method="Post" enctype="multipart/form-data>"> 
                    @csrf
                    @method('PUT') 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Travel Itinerary</strong>
                                <input type='text' name="travel_itinerary" value="{{$liquidation->travel_itinerary}}" class="form-control" placholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Reference</strong>
                                <input type='text' name="reference" value="{{$liquidation->reference}}" class="form-control" placholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Particulars</strong>
                                <input type='text' name="particulars" value="{{$liquidation->particulars}}" class="form-control" placholder="">
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
