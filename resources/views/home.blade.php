@extends('nsmnonlife.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-20">
            <div class="card border-primary" style="border-width:2px; height: 500px;">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                <table class='table table-striped table-bordered'>
                        <tr><th colspan="5" class="text-center">APPROVED ITINERARIES</th></tr>
                        <tr style="font-size:15px;">
                            <th>Itinerary For</th>
                            <th>Status</th>
                            <th>Approved By</th>
                            <th>Approver's Role</th>
                            <th>See more</th>
                        </tr>
                        @if ($itinerary->count()>0)
                        @foreach($itinerary as $itinerary)
                        <tr style="font-size:13px;"> 
                            <td style="width:250px">{{date('M d, Y', strtotime($itinerary->date_from))}} - {{date('M d, Y', strtotime($itinerary->date_to))}}</td>
                            <td >{{$itinerary->status}}</td>
                            @if ($itinerary->approved_by !== null)
                            <td style="width:350px">{{$itinerary->approver->firstname}}</td>
                            @else
                            <td></td>
                            @endif
                            <td>{{$itinerary->approver_role}}</td>
                            <td style="width:100px">
                                <form action"" method="POST">
                                    <a class="btn btn-info" style="font-size:12px;" href="{{route('nsmshowitinerary',$itinerary->id)}}">Details</a>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr style="font-size:14px;"><td colspan="5" class="text-center">No Approved Itineraries yet</td></tr>
                    @endif
                    </table>

                    <table class='table table-striped table-bordered'>
                        <tr><th colspan="5" class="text-center">APPROVED ACCOMPLISHMENTS</th></tr>
                        <tr style="font-size:15px;">
                            <th>Itinerary For</th>
                            <th>Status</th>
                            <th>Approved By</th>
                            <th>Approver's Role</th>
                            <th>See more</th>
                        </tr>
                        @if ($accomplishment->count()>0)
                            @foreach($accomplishment as $accomplishment)
                            <tr style="font-size:13px;"> 
                                <td style="width:250px">{{date('M d, Y', strtotime($accomplishment->date_from))}} - {{date('M d, Y', strtotime($accomplishment->date_to))}}</td>
                                <td >{{$accomplishment->status}}</td>
                                @if ($accomplishment->approved_by !== null)
                                <td style="width:350px">{{$accomplishment->approver->firstname}}</td>
                                @else
                                <td></td>
                                @endif
                                <td>{{$accomplishment->approver_role}}</td>
                                <td style="width:100px">
                                    <form action"" method="POST">
                                        <a class="btn btn-info" style="font-size:12px;" href="{{route('nsmnl_showaccomplishment',$accomplishment->id)}}">Details</a>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        @else
                        <tr style="font-size:14px;"><td colspan="5" class="text-center">No Approved Accomplishments yet</td></tr>
                        @endif
                    </table>
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
