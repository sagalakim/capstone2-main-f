@extends('nsmnonlife.layouts.app')

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
                    <h2>{{$itinerary->owner->firstname}}'s Itinerary</h2>

                    <div class="row">
                        <div class="input-group mb-2" style="width:300px;margin-top:20px;">
                            <span class="input-group-text fw-bold">For: </span>
                            <input type='text'  name="date_filed" class="form-control locked" value="{{date('M d, Y', strtotime($itinerary->date_from))}} - {{date('M d, Y', strtotime($itinerary->date_to))}}">
                        </div>
                        <a class="btn btn-success" style="width:40px; height:35px;margin-right:20px; margin-top:25px; margin-left:550px;" href="{{route('approve',$itinerary->id)}}"><i class="fas fa-check me-2"></i></a>
                        <a class="btn btn-danger" style="width:40px;height:35px; margin-top:25px;" href="{{route('disapprove',$itinerary->id)}}"><i class="fas fa-x me-2"></i></a>
                        @if ($itinerary->status === 'Accomplishment Created')
                        <div class="input-group mb-2" style="margin-top:-45px; width:300px; margin-left:300px;">
                            <span class="input-group-text fw-bold">Status: </span>
                            <input type='text'  name="date_filed" class="form-control locked" value="{{$itinerary->status}}">
                        </div>
                        @else
                        <div class="input-group mb-2" style="margin-top:-45px; width:200px; margin-left:300px;">
                            <span class="input-group-text fw-bold">Status: </span>
                            <input type='text'  name="date_filed" class="form-control locked" value="{{$itinerary->status}}">
                        </div>
                        @endif
                    </div> 
                
                <table class='table table-bordered scrollable-table' style="margin-top:20px;">
                    <thead>
                    <tr style="border:2px solid #414ab1;">
                        <th>Date</th>
                        <th>Name of Coop</th>
                        <th>Municipality</th>
                        <th>Account</th>
                        <th>Purpose</th>
                        <th>Product</th>
                        <th>Remarks</th>
                        
                    </tr>
                    </thead>

                    @if ($data->count()>0)
                        @foreach($data as $data)
                        <tr style="border:1px solid gray; font-size:14px;"> 
                            <td>{{$data->date}}</td>
                            <td>{{$data->name_of_coop}}</td>
                            <td>{{$data->municipality}}</td>
                            <td>{{$data->account->account_name}}</td>
                            <td style="width:300px;">{{$data->purpose}}</td>
                            <td>{{$data->product->product_name}}</td>
                            <td>{{$data->remarks}}</td>
                            
                        </tr>
                        @endforeach
                    @endif
                </table>
                </div>
            </div>
        </div>
    </div>
@endsection