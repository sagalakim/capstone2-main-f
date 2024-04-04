@extends('agent.layouts.app')

@section('content')
<div class="row justify-content-center">
        <div class="col-md-20">
            <div class="card border-primary" style="border-width:2px; height:535px;">

                @if(session('success'))
                    <div class="alert alert-success text-center" style="margin-bottom:-20px; height:10px;">
                        <p style="margin-top:-12px;">{{ session('success') }}<p>
                    </div>
                @endif

                <div class="card-body">
                    <h2>My Liquidations</h2>
                
                <table class='table table-striped table-bordered scrollable-table' style="margin-top:30px;">
                    <tr>
                        <th>Date filed</th>
                        <th>Activity</th>
                        <th>Status</th>
                        <th>See more</th>
                        
                        
                    </tr>

                    @if ($liquidations->count()>0)
                        @foreach($liquidations as $liquidation)
                        <tr> 
                            <td style="width:300px">{{date('M d, Y', strtotime($liquidation->date_filed))}}</td>
                            <td style="width:350px">{{$liquidation->activity}}</td>
                            <td style="width:300px">{{$liquidation->status}}</td>
                            <td>
                                <form action"" method="POST">
                                    <a class="btn btn-info" href="{{route('sashowliquidation',$liquidation->id)}}">Details</a>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </table>
                </div>
            </div>
        </div>
    </div>
@endsection