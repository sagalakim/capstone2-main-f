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
                    <a class='btn btn-success' href='{{url("/create/liquidations")}}'>Create liquidations</a>
                </div>
                <table class='table table-bordered'>
                    <tr>
                        <th>Travel itinerary</th>
                        <th>Reference</th>
                        <th>Particulars</th>
                    </tr>

                    @foreach($liquidation as $liquidation)
                    <tr> 
                        <td>{{$liquidation->travel_itinerary}}</td>
                        <td>{{$liquidation->reference}}</td>
                        <td>{{$liquidation->particulars}}</td>
                        <td>
                            <form action"" method="POST">
                                <a class="btn btn-info" href="{{route('show',$liquidation->id)}}">Show</a>
                                <a class="btn btn-info" href="{{route('edit',$liquidation->id)}}">Edit</a>
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button> 
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
