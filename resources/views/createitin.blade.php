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

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger">
                        <p>{{$message}}</p>
                    </div>
                @endif

                <form action="{{route('store')}}" method="Post" enctype="multipart/form-data>"> 
                    @csrf
                    <div class="row">
                        <input type="text" name='area_id' style="display:none;" value="{{Auth::user()->area_id}}">
                        <input type="text" name='remarks' style="display:none;" value="-">
                        <input type="text" name='status' style="display:none;" value="Pending">
                        <select class='form-control' name='user_id' style="width: 800px; margin-left: 14px; margin-bottom: 15px;">
                            <option value="{{Auth::user()->id}}">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</option>
                        </select>

                        <div class="form-group col-x1-12 col-lg-12 col-md-12 col-sm-12 col-12 child-repeater-table">
                            <table class="table table-bordered table-responsive scrollable-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name of Coop</th>
                                    <th>Municipality</th>
                                    <th>Account</th>
                                    <th>Purpose</th>
                                    <th>Product</th>
                                    <th><a href="javascript:void(0)" class="btn btn-success addRow">+</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type='date' name="date[]" class="form-control" placholder=""></td>
                                    <td><input type='text' name="name_of_coop[]" class="form-control" placholder=""></td>
                                    <td><input type='text' name="municipality[]" class="form-control" placholder=""></td>
                                    <td>
                                        <select class='form-control' name='account_id[]'>
                                            <option>--Select--</option>
                                            @foreach ($accounts as $account)
                                            <option value="{{$account->id}}">{{$account->account_name}} {{$account->account_type}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type='text' name="purpose[]" class="form-control" placholder="Purpose"></td>
                                    <td>
                                        <select class='form-control' name='product_id[]'>
                                            <option>--Select--</option>
                                            @foreach ($products as $product)
                                            <option value="{{$product->id}}">{{$product->product_name}} {{$product->product_type}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <th><a href="javascript:void(0)" class="btn btn-danger deleteRow">-</a></th>
                                </tr>
                            </tbody>
                            </table>
                        </div>
        
                        <div class="container d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-primary" style="width: 200px;">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    $('thead').on('click', '.addRow', function(){
        var tr = "<tr>" +
                    '<td><input type="date" name="date[]" class="form-control" placholder=""></td>' +
                    '<td><input type="text" name="name_of_coop[]" class="form-control" placholder=""></td>' +
                    '<td><input type="text" name="municipality[]" class="form-control" placholder=""></td>' +
                    '<td>' +
                        "<select class='form-control' name='account_id[]'>" +
                            '<option>--Select--</option>' +
                            '@foreach ($accounts as $account)' +
                            '<option value="{{$account->id}}">{{$account->account_name}} {{$account->account_type}}</option>' +
                            '@endforeach' +
                        '</select>' +
                    '</td>' +
                    '<td><input type="text" name="purpose[]" class="form-control" placholder="Purpose"></td>' +
                    '<td>' +
                        "<select class='form-control' name='product_id[]'>" +
                            '<option>--Select--</option>' +
                            '@foreach ($products as $product)' +
                            '<option value="{{$product->id}}">{{$product->product_name}} {{$product->product_type}}</option>' +
                            '@endforeach' +
                        '</select>' +
                    '</td>' +
                        '<th><a href="javascript:void(0)" class="btn btn-danger deleteRow">-</a></th>' +
                    '</tr>' 
        $('tbody').append(tr);
    });

    $('tbody').on('click','.deleteRow', function(){
        $(this).parent().parent().remove();
    })
</script>
@endsection