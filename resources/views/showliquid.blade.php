@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <h2>Liquidations</h2>
                </div>
                <div>
                    <a class='btn btn-success' href='{{url("/liquidations")}}'>Back</a>
                </div>
                <table class='table table-bordered'>
                    <tr>
                        <th>Travel itinerary</th>
                        <th>Reference</th>
                        <th>Particulars</th>
                    </tr>

                    <tr> 
                        <td>{{$liquidation->travel_itinerary}}</td>
                        <td>{{$liquidation->reference}}</td>
                        <td>{{$liquidation->particulars}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
