@extends('agent.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-primary" style="border-width:2px; width:1020px; margin-left:-180px;">

                <div class="card-body">
                    <h2>Create liquidation</h2>
                
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
                <form action="{{route('saliquidationstore')}}" method="Post" enctype="multipart/form-data"> 
                    @csrf
                    <div class="row">
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
                                <input type='text' value="{{Auth::user()->firstname}} {{Auth::user()->lastname}}" name="employee_name" class="form-control locked" placholder="Coop/Associtae">
                            </div>
                        
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-2">
                                <span class="input-group-text fw-bold">Position</span>
                                <input type='text' value="{{Auth::user()->role}}" name="position" class="form-control locked" placholder="Enter Municipality">
                            </div>
                        </div>
                        </div>

                        <div class="card-body" style="margin-left:600px; margin-top:-123px;">
                        <div class="col-md-10">
                            <div class="input-group mb-2">
                                <span class="input-group-text fw-bold">Date Filed</span>
                                <input min="{{ date('Y-m-d') }}" type='date' name="date_filed" class="form-control" placholder="Enter Municipality">
                            </div>
                        </div>
                
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text fw-bold">Inclusive Date</span>
                                <input min="{{ date('Y-m-d') }}" type='date' name="inclusive_date" class="form-control" placholder="Enter Municipality">
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
                                    <th><a href="javascript:void(0)" class="btn btn-success addRow">+</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input min="{{ date('Y-m-d') }}" type='date' style="width:150px;" name="date[]" class="form-control" placholder=""></td>
                                    <td><input type='text' style="width:160px;" name="travel_itinerary_from[]" class="form-control" placholder=""></td>
                                    <td><input type='text' style="width:160px;" name="travel_itinerary_to[]" class="form-control" placholder=""></td>
                                    <td><input type='text' name="reference[]" class="form-control" placholder=""></td>
                                    <td><input type='text' name="particulars[]" class="form-control" placholder=""></td>
                                    <td><input type='number' style="width:80px;" name="transpo[]" class="form-control" placeholder="₱"></td>
                                    <td><input type='number' style="width:80px;" name="hotel[]" class="form-control" placeholder="₱"></td>
                                    <td><input type='text' style="width:80px;" name="meals[]" class="form-control" placeholder="₱"></td>
                                    <td><input type='text' style="width:80px;" name="sundry[]" class="form-control" placeholder=""></td>
                                    <td><input type='text' style="width:80px;" name="amount[]" class="form-control" placeholder="₱"></td>
                                    <td><input class="locked" type='text' style="width:100px;" name="row_total[]" class="form-control" value="₱ --- " placholder=""></td>
                                    <th><a href="javascript:void(0)" class="btn btn-danger deleteRow">-</a></th>
                                </tr>
                            </tbody>
                            </table>
                        </div>

                        <div class="card-body" style="margin-left:600px; margin-top:-20px;">
                        <div class="col-md-10">
                            <div class="input-group mb-2">
                                <span class="input-group-text fw-bold">TOTAL</span>
                                <input type='text' name="total" class="form-control locked" value="₱  ---   " placholder="Enter Municipality">
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group mb-2">
                                <span class="input-group-text fw-bold">CA</span>
                                <input type='text' name="cash_advance" class="form-control" placeholder="₱">
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text fw-bold">For OR</span>
                                <input type='file'style="width:200px;" name="receipt[]" class="form-control" multiple>
                            </div>
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
