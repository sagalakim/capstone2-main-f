@extends('nsmnonlife.layouts.app')

@section('content')
  <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-primary" style="border-width:2px; width:1020px; margin-left:-85px;">

                <div class="card-body">
                    <h2>Create Itineraries</h2>
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
                <form action="{{route('store')}}" method="Post" enctype="multipart/form-data>"> 
                    @csrf
                    <div class="row">
                        <input type="text" name='area_id' style="display:none;" value="{{Auth::user()->area_id}}">
                        
                        <select class='form-control' name='user_id' style="width: 800px; margin-left: 14px; margin-bottom: 15px;">
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
                                <input type='text' name="municipality" class="form-control" placholder="Coop/Associtae">
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
        
                        <div class="container d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-primary" style="width: 200px;">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

old controller store method without using MODAL

public function store(Request $request)
{
    
    $area_id = $request->area_id;
    $user_id = $request->user_id;
    $date = $request->date;
    $name_of_coop = $request->name_of_coop;
    $municipality = $request->municipality;
    $account_id = $request->account_id;
    $purpose = $request->purpose;
    $product_id = $request->product_id;
    $remarks = $request->remarks;
    $status = $request->status;

    if( $request->date !== null){
    

        for ($i=0; $i < count($name_of_coop); $i++){
            if(empty($name_of_coop[$i]) || empty($municipality[$i]) || empty($account_id[$i]) || empty($purpose[$i]) || empty($product_id[$i])){
                return redirect()->back()->with('error', 'All fields are required.');
            }

            $datasave = [
                "area_id"=>Auth::user()->area_id,
                "user_id"=>Auth::user()->id,
                "date"=>$date[$i],
                "name_of_coop"=>$name_of_coop[$i],
                "municipality"=>$municipality[$i],
                "account_id"=>$account_id[$i],
                "purpose"=>$purpose[$i],
                "product_id"=>$product_id[$i],
                "remarks"=>'',
                "status"=>'Pending',
                "approver_role"=>'',
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            

            ];
            DB::table('itineraries')->insert($datasave);
        }
    
        return redirect()->route('iindex')->with('success', 'Itinerary Created Succesfully');
    }
    else{
        return redirect()->back()->with('error', 'Some fields are required.');
    }
    }



New Storecontroller for MODAL

public function store(Request $request)
{
    if($request->ajax()){
    $area_id = $request->area_id;
    $user_id = $request->user_id;
    $date = $request->date;
    $name_of_coop = $request->name_of_coop;
    $municipality = $request->municipality;
    $account_id = $request->account_id;
    $purpose = $request->purpose;
    $product_id = $request->product_id;
    $remarks = $request->remarks;
    $status = $request->status;

    if( $request->date !== null){
    

        for ($i=0; $i < count($name_of_coop); $i++){
            if(empty($name_of_coop[$i]) || empty($municipality[$i]) || empty($account_id[$i]) || empty($purpose[$i]) || empty($product_id[$i])){
                return response()->json(['error' => 'All fields are required.'], 400);
            }

            $datasave = [
                "area_id"=>Auth::user()->area_id,
                "user_id"=>Auth::user()->id,
                "date"=>$date[$i],
                "name_of_coop"=>$name_of_coop[$i],
                "municipality"=>$municipality[$i],
                "account_id"=>$account_id[$i],
                "purpose"=>$purpose[$i],
                "product_id"=>$product_id[$i],
                "remarks"=>'',
                "status"=>'Pending',
                "approver_role"=>'',
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            

            ];
            $itineraries = DB::table('itineraries')->insert($datasave);
        }
    
        return response()->json(['success' => session('success')], 200);
    }
    else{
        return response()->json(['error' => session('error')], 400);
    }
    }
    }



    <input type="text" name='user_id' style="display:none;" value="{{Auth::user()->id}}">
                        
                        <div class="card-body">
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <span class="input-group-text fw-bold">Activity:</span>
                                <input type='text' name="activity" class="form-control" placholder="">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text fw-bold">Name of Employee</span>
                                <input type='text' value="{{Auth::user()->firstname}} {{Auth::user()->lastname}}" name="name_of_coop" class="form-control" placholder="Coop/Associtae">
                            </div>
                        
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <span class="input-group-text fw-bold">Position</span>
                                <input type='text' value="{{Auth::user()->role}}" name="position" class="form-control" placholder="Enter Municipality">
                            </div>
                        </div>
                        </div>

                        <div class="card-body" style="margin-left:600px; margin-top:-123px;">
                        <div class="col-md-10">
                            <div class="input-group mb-2">
                                <span class="input-group-text fw-bold">Date Filed</span>
                                <input type='date' name="date_filed" class="form-control" placholder="Enter Municipality">
                            </div>
                        </div>
                
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text fw-bold">Inclusive Date</span>
                                <input type='date' name="inclusive_date" class="form-control" placholder="Enter Municipality">
                            </div>
                        </div>
                        </div>






                        <div class="card-body" style="margin-left:600px; margin-top:-20px;">
                        <div class="col-md-10">
                            <div class="input-group mb-2">
                                <span class="input-group-text fw-bold">TOTAL</span>
                                <input type='text' name="total" class="form-control" placholder="Enter Municipality">
                            </div>
                        </div>
                
                        <div class="col-md-10">
                            <div class="input-group mb-2">
                                <span class="input-group-text fw-bold">CA</span>
                                <input type='text' name="cash_advance" class="form-control" placholder="Enter Municipality">
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text fw-bold">For OR</span>
                                <input type='text' name="for_or" class="form-control" placholder="Enter Municipality">
                            </div>
                        </div>
                        </div>