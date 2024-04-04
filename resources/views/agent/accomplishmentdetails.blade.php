@extends('agent.layouts.app')

@section('content')
<div class="row justify-content-center">
        <div class="col-md-20">
            <div class="card border-primary" style="border-width:2px; height:535px;">

                    @if(session('already'))
                    <div class="alert alert-success text-center" style="margin-bottom:-20px; height:10px;">
                        <p style="margin-top:-12px;">{{ session('already') }}<p>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success text-center" style="margin-bottom:-20px; height:10px;">
                        <p style="margin-top:-12px;">{{ session('success') }}<p>
                    </div>
                    @endif
                

                <div class="card-body">
                    <h2>Accomplishment</h2>

                    @if ($accomplishment->status === 'Approved')
                    <a href="{{route('downloadaccomplishment',$accomplishment->id)}}" class="btn btn-success btn-sm " style="margin-left:690px;"><i class="fas fa-download me-2"></i>Download as PDF</a>
                    <a href="{{route('adownloadpreview',$accomplishment->id)}}" target="_blank" class="btn btn-warning btn-sm mx-1"><i class="fas fa-eye me-2"></i>Preview as file</a>
                    @else
                    <a class="btn btn-default btn-sm" style="margin-left:780px;"><i class="fas fa-edit me-2"></i>Waiting for Approval</a>
                    @endif
                    <div class="row" style="margin-top:-30px;">
                        <div class="input-group mb-2" style="margin-top:20px; width:300px;">
                            <span class="input-group-text fw-bold">For: </span>
                            <input type='text'  name="date_filed" class="form-control locked" value="{{date('M d, Y', strtotime($accomplishment->date_from))}} - {{date('M d, Y', strtotime($accomplishment->date_to))}}">
                        </div>

                        @if ($accomplishment->status === 'Approved')
                        <div class="input-group mb-2" style="margin-top:20px; width:300px; height: 30px;">
                            <span class="input-group-text fw-bold">Status: </span>
                            <input type='text'  name="date_filed" class="form-control locked" value="{{$accomplishment->status}}">
                        </div>
                        @else
                        <div class="input-group mb-2" style="margin-top:20px; width:200px; margin-left:0px;">
                            <span class="input-group-text fw-bold">Status: </span>
                            <input type='text'  name="date_filed" class="form-control locked" value="{{$accomplishment->status}}">
                        </div>
                        @endif
                    </div>
                <form method="POST" action="{{route('save')}}" enctype="multipart/form-data">
                    @csrf
                <table class='table table-bordered scrollable-table' style="margin-top:20px;">
                    <tr >
                        <th>Date</th>
                        <th>Name of Coop</th>
                        <th>Municipality</th>
                        <th>Account</th>
                        <th>Purpose</th>
                        <th>Product</th>
                        <th>Remarks</th>
                        
                    </tr>

                    @if ($data->count()>0)
                        @foreach($data as $data)
                        <input style="font-size:14px;display:none;" type="text" value="{{$data->id}}" name="id[]" class="form-control locked">
                        <tr> 
                        <td><input style="width:120px;" type="date" value="{{$data->date}}" class="form-control date locked" name="date[]"></td>
                            <td><input style="font-size:14px;" type="text" class="form-control locked" name="name_of_coop[]" value="{{$data->name_of_coop}}"></td>
                            <td><input style="font-size:14px;" type="text" value="{{$data->municipality}}" name="municipality[]" class="form-control locked"></td>
                            <td><input style="font-size:14px;display:none;" type="text" value="{{$data->account_id}}" name="account_id[]" class="form-control locked"> <input style="font-size:14px;" type="text" value="{{$data->account->account_name}}"  class="form-control locked"> </td>
                            <td><input style="font-size:14px;" type="text" value="{{$data->purpose}}" name="purpose[]" class="form-control locked"></td>
                            <td><input style="font-size:14px;display:none;" type="text" value="{{$data->product_id}}" name="product_id[]" class="form-control locked"> <input style="font-size:14px;" type="text" value="{{$data->product->product_name}}" class="form-control locked"></td>
                            @if ($data->remarks === '')
                            <td><textarea style="font-size:13px;" type="text" name="remarks[]" class="form-control"></textarea></td>
                            @else
                            <td><input type="text" value="{{$data->remarks}}" name='remarks[]' class="form-control locked"></td>
                            @endif
                        </tr>
                        @endforeach
                    @endif
                </table>
                    <button type="submit" class="btn btn-primary btn-sm " style="margin-left:890px; font-size:18px; margin-top:10px;"><i class="fas fa-save me-2"></i>Save</button>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection