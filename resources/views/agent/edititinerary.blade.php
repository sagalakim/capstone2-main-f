@extends('agent.layouts.app')

@section('content')
  <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-primary" style="border-width:2px;">

                <div class="card-body">
                    <h2>Edit Itinerary</h2>
                </div>

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

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{$message}}</p>
                    </div>
                @endif
      
                <div class="card-body">
                <form action="{{route('iupdate',$itinerary->id)}}" method="Post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') 
                    <div class="row">
                        <input type="text" name='area_id' style="display:none;" value="{{Auth::user()->area_id}}">
                        
                        <select class='form-control' name='user_id' style="width: 800px; margin-left: 14px; margin-bottom: 15px;">
                            <option value="{{Auth::user()->id}}">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</option>
                        </select>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Date:</strong>
                                <input type='date' value="{{$itinerary->date}}" name="date"  class="form-control" placholder="">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Name of Coop</strong>
                                <input type='text' name="name_of_coop" value="{{$itinerary->name_of_coop}}" class="form-control" placholder="Coop/Associtae">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Municipality</strong>
                                <input type='text' name="municipality" value="{{$itinerary->municipality}}" class="form-control" placholder="Coop/Associtae">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Account</strong> <strong><a href="{{url('/accountedit',$itinerary->id)}}">Edit</a></strong>
                                <select class='form-control' name='account_id'>
                                    @if($itinerary->status === 'account edited')
                                        @foreach ($accounts as $account)
                                        <option value="{{$account->id}}">{{$account->account_name}} {{$account->account_type}}</option>
                                        @endforeach
                                    @else
                                    <option value="{{$itinerary->account->id}}">{{$itinerary->account->account_name}} {{$itinerary->account->account_type}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Purpose</strong>
                                <input type='text' name="purpose" value="{{$itinerary->purpose}}" class="form-control" placholder="Coop/Associtae">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Product</strong> <strong><a href="{{url('/productedit',$itinerary->id)}}">Edit</a></strong>
                                <select class='form-control' name='product_id'>
                                    @if ($itinerary->status === 'product edited')
                                        @foreach ($products as $product)
                                        <option value="{{$product->id}}">{{$product->product_name}} {{$product->product_type}}</option>
                                        @endforeach
                                    @else
                                        <option value="{{$itinerary->product->id}}">{{$itinerary->product->product_name}} {{$itinerary->product->product_type}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
        
                        <div class="container d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-primary" style="width: 200px;">Submit</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
