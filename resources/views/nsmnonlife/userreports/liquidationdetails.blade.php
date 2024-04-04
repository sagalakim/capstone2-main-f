@extends('nsmnonlife.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-primary" style="border-width:2px; width:1020px; margin-left:-180px;">

                <div class="card-body">

                    @if(session('already'))
                    <div class="alert alert-success text-center" style="margin-bottom:20px; height:10px;">
                        <p style="margin-top:-12px;">{{ session('already') }}<p>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success text-center" style="margin-bottom:20px; height:10px;">
                        <p style="margin-top:-12px;">{{ session('success') }}<p>
                    </div>
                    @endif

                    <h2>{{$liquidation->owner->firstname}}'s Liquidation details</h2>
                    <a href="{{route('nsmagentdownloadliquidation',$liquidation->id)}}" class="btn btn-success btn-sm " style="margin-left:650px;"><i class="fas fa-download me-2"></i>Download liquidation</a>
                    <a href="{{route('nsmagentdownloadpreview',$liquidation->id)}}" target="_blank" class="btn btn-warning btn-sm mx-1"><i class="fas fa-eye me-2"></i>Preview as file</a>
                
                    <div class="row">
                    <input type="text" name='user_id' style="display:none;" value="{{Auth::user()->id}}">
                        
                        <div class="card-body">
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <span class="input-group-text fw-bold">Activity:</span>
                                <input type='text' value="{{$liquidation->activity}}" name="activity" class="form-control locked" placholder="">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text fw-bold">Name of Employee</span>
                                <input type='text' value="{{$liquidation->owner->firstname}} {{$liquidation->owner->lastname}}" name="employee_name" class="form-control locked" placholder="">
                            </div>
                        
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <span class="input-group-text fw-bold">Position</span>
                                <input type='text' value="{{$liquidation->owner->role}}" name="position" class="form-control locked" placholder="">
                            </div>
                        </div>
                        </div>

                        <div class="card-body" style="margin-left:600px; margin-top:-123px;">
                        <div class="col-md-10">
                            <div class="input-group mb-2">
                                <span class="input-group-text fw-bold">Date Filed</span>
                                <a type='date' name="date_filed" class="form-control locked" placholder="">{{date('M d, Y', strtotime($liquidation->date_filed))}}</a>
                            </div>
                        </div>
                
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text fw-bold">Inclusive Date</span>
                                <a type='date' name="inclusive_date" class="form-control locked" placholder="Enter Municipality">{{date('M d, Y', strtotime($liquidation->inclusive_date))}}</a>
                            </div>
                        </div>
                        </div>

                        <div class="form-group col-x1-12 col-lg-12 col-md-12 col-sm-12 col-12 child-repeater-table">
                            <table class="table table-bordered table-responsive scrollable-table">
                            <thead>
                                <tr>
                                    <th >Date</th>
                                    <th >Travel Itinerary From</th>
                                    <th >Travel Itinerary To</th>
                                    <th>Reference</th>
                                    <th>Particulars</th>
                                    <th >Transpo</th>
                                    <th >Hotel</th>
                                    <th>Meals</th>
                                    <th>Sundry</th>
                                    <th>Amount</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data->count()>0)
                                @foreach($data as $data)
                                <tr>
                                    <td>{{$data->date}}</td>
                                    <td>{{$data->travel_itinerary_from}}</td>
                                    <td>{{$data->travel_itinerary_to}}</td>
                                    <td>{{$data->reference}}</td>
                                    <td>{{$data->particulars}}</td>
                                    <td>{{$data->transpo}}</td>
                                    <td>{{$data->hotel}}</td>
                                    <td>{{$data->meals}}</td>
                                    <td>{{$data->sundry}}</td>
                                    <td>{{$data->amount}}</td>
                                    <td>{{$data->row_total}}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                            </table>
                        </div>

                        <div class="card-body" style="margin-left:600px; margin-top:-20px;">
                        <div class="col-md-10">
                            <div class="input-group mb-2">
                                <span class="input-group-text fw-bold">TOTAL</span>
                                <input type='text' name="total" class="form-control locked" value="{{$data->total}}" placholder="Enter Municipality">
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group mb-2">
                                <span class="input-group-text fw-bold">CA</span>
                                <input type='text' name="cash_advance" class="form-control locked" value="{{$data->cash_advance}}" placholder="Enter Municipality">
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text fw-bold">For OR</span>
                                <a class="form-control" href="{{ route('agentliquidationreceipt', $liquidation->id) }}" target="_blank" style="height:40px;"> View receipts</a>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="input-group mb-2" style=" width:200px; margin-left:170px; margin-top:0px;">
                        <span class="input-group-text fw-bold">Status: </span>
                        <input type='text'  name="date_filed" class="form-control locked" value="{{$liquidation->status}}">
                    </div>
                    <a href="{{route('approve3',$liquidation->id)}}" class="btn btn-primary btn-sm " style="margin-top:-85px;">Approve</a>
                    <a href="{{route('approve3',$liquidation->id)}}" class="btn btn-danger btn-sm " style="margin-top:-85px;">Disapprove</a>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('thead').on('click', '.addRow', function(){
        var tr = "<tr>" +
                    '<td><input type="date" style="width:150px;" name="date[]" class="form-control" placholder=""></td>' +
                    '<td><input type="text" style="width:160px;" name="travel_itinerary_from[]" class="form-control" placholder=""></td>' +
                    '<td><input type="text" style="width:160px;" name="travel_itinerary_to[]" class="form-control" placholder=""></td>' +
                    '<td><input type="text" name="reference[]" class="form-control" placholder=""></td>' +
                    '<td><input type="text" name="particulars[]" class="form-control" placholder=""></td>' +
                    '<td><input type="number" style="width:80px;" name="transpo[]" class="form-control" placholder=""></td>' +
                    '<td><input type="number" style="width:80px;" name="hotel[]" class="form-control" placholder=""></td>' +
                    '<td><input type="text" style="width:80px;" name="meals[]" class="form-control" placholder=""></td>' +
                    '<td><input type="text" style="width:80px;" name="sundry[]" class="form-control" placholder=""></td>' +
                    '<td><input type="text" style="width:80px;" name="amount[]" class="form-control" placholder=""></td>' +
                    '<td><input type="text" class="locked" style="width:100px;" name="row_total[]" value=" --- " class="form-control" placholder=""></td>' +
                    '<th><a href="javascript:void(0)" class="btn btn-danger deleteRow">-</a></th>' +
                '</tr>' 
        $('tbody').append(tr);
    });

    $('tbody').on('click','.deleteRow', function(){
        $(this).parent().parent().remove();
    })
</script>
@endsection
