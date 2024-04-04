@extends('nsmnonlife.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-20">
            <div class="card border-primary" style="border-width:2px; height:530px;">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{$message}}</p>
                    </div>
                @endif

                <div class="card-body">
                    <h2>My Accomplishments</h2>
                  

                  <table class="table table-responsive-sm table-bordered scrollable-table" style="margin-top:40px;">
                    <tr>
                        <th>Itinerary For</th>
                        <th>Status</th>
                        <th>Approved By</th>
                        <th>Approver's Role</th>
                        <th>See more</th>
                    </tr>

                    @if ($accomplishment->count()>0)
                        @foreach($accomplishment as $accomplishment)
                        <tr> 
                            <td style="width:300px">{{date('M d, Y', strtotime($accomplishment->date_from))}} - {{date('M d, Y', strtotime($accomplishment->date_to))}}</td>
                            <td >{{$accomplishment->status}}</td>
                            @if ($accomplishment->approved_by !== null)
                            <td style="width:350px">{{$accomplishment->approver->firstname}}</td>
                            @else
                            <td></td>
                            @endif
                            <td>{{$accomplishment->approver_role}}</td>
                            <td style="width:300px">
                                <form action"" method="POST">
                                    <a class="btn btn-info" href="{{route('nsmnl_showaccomplishment',$accomplishment->id)}}">Details</a>
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
</div>
@endsection
