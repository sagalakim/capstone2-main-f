@extends('agent.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-primary" style="border-width:2px; height:530px; width:1040px; margin-left:-190px;">

                
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

                <div class="card-body">
                    <h2>Create Accomplishment</h2>
                

                <form action="{{route('createAccomplishment', $itinerary->id)}}" method="Post" enctype="multipart/form-data>"> 
                    @csrf

                    <div class="row">
                        <div class="input-group mb-2" style="margin-top:20px; width:300px;">
                            <span class="input-group-text fw-bold">For: </span>
                            <input type='text'  name="date_filed" class="form-control locked" value="{{$itinerary->date_from}} - {{$itinerary->date_to}}">
                        </div>

                        <div class="input-group mb-2" style="margin-top:20px; width:200px; margin-left:500px;">
                            <span class="input-group-text fw-bold">Status: </span>
                            <input type='text'  name="date_filed" class="form-control locked" value="{{$itinerary->status}}">
                        </div>
                    </div>
                
                <table class='table table-bordered scrollable-table' style="margin-top:20px;">
                    <tr>
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
                        <tr> 
                            <td><input style="width:120px;" type="date" value="{{$data->date}}" class="form-control date locked" name="date[]"></td>
                            <td><input style="font-size:14px;" type="text" class="form-control locked" name="name_of_coop[]" value="{{$data->name_of_coop}}"></td>
                            <td><input style="font-size:14px;" type="text" value="{{$data->municipality}}" name="municipality[]" class="form-control locked"></td>
                            <td><input style="font-size:14px;display:none;" type="text" value="{{$data->account_id}}" name="account_id[]" class="form-control locked"> <input style="font-size:14px;" type="text" value="{{$data->account->account_name}}"  class="form-control locked"> </td>
                            <td><input style="font-size:14px;" type="text" value="{{$data->purpose}}" name="purpose[]" class="form-control locked"></td>
                            <td><input style="font-size:14px;display:none;" type="text" value="{{$data->product_id}}" name="product_id[]" class="form-control locked"> <input style="font-size:14px;" type="text" value="{{$data->product->product_name}}" class="form-control locked"></td>
                            <td><textarea style="font-size:13px;" type="text" value="{{$data->remarks}}" name="remarks[]" class="form-control"></textarea></td>
                            
                        </tr>
                        @endforeach
                    @endif
                </table>

                        <button type="submit" style="margin-left:900px;" class="btn btn-primary">Create</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
