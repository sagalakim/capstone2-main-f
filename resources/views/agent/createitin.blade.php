@extends('agent.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-primary" style="border-width:2px; width:1020px; margin-left:-180px;">

                <div class="card-body">
                    <h2>Create Itineraries</h2>
                
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
                <form action="{{route('agentstore')}}" method="Post" enctype="multipart/form-data>"> 
                    @csrf
                    <div class="row">
                        <input type="text" name='area_id' style="display:none;" value="{{Auth::user()->area_id}}">
                        
                        <select class='form-control' name='user_id'>
                            <option value="{{Auth::user()->id}}">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</option>
                        </select>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Date:</strong>
                                <input type='date' name="date" class="form-control" placholder="">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Name of Coop</strong>
                                <input type='text' name="name_of_coop" class="form-control" placholder="Coop/Associtae">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Municipality</strong>
                                <input type='text' name="municipality" class="form-control" placholder="Enter Municipality">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Account</strong>
                                <select class='form-control' name='account_id'>
                                    @foreach ($accounts as $account)
                                    <option value="{{$account->id}}">{{$account->account_name}} {{$account->account_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Purpose</strong>
                                <input type='text' name="purpose" class="form-control" placholder="Coop/Associtae">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Product</strong>
                                <select class='form-control' name='product_id'>
                                    @foreach ($products as $product)
                                    <option value="{{$product->id}}">{{$product->product_name}} {{$product->product_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="margin-top:10px;">Submit</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
