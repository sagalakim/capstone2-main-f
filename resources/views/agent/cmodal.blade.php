<!-- Modal -->
<div class="modal fade" id="agentitineraryCreateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-dialog-wide">
    <div class="modal-content">
      <div class="modal-header">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <h1 class="modal-title fs-5" id="exampleModalLabel">Create Itinerary</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
    <div class="container-fluid">
      <form id="agentitineraryForm" action="{{route('agentstore')}}" method="Post" enctype="multipart/form-data"> 
                    @csrf
                    <div class="row">
                        <input type="text" name='area_id' style="display:none;" value="{{Auth::user()->area_id}}">
                        <input type="text" name='remarks' style="display:none;" value="-">
                        <input style="display:none;" name="user_id" value="{{Auth::user()->id}}">
                        
                        <div class="input-group mb-2" style="width:250px;">
                            <span class="input-group-text fw-bold">Date For:</span>
                            <input type='date' name="date_from" min="{{ date('Y-m-d') }}" class="form-control date" placholder="">
                        </div>

                        <div class="input-group mb-2" style="width:220px;">
                            <span class="input-group-text fw-bold">To:</span>
                            <input type='date' name="date_to" min="{{ date('Y-m-d') }}" class="form-control date" placholder="">
                        </div>

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
                            <tbody id="citinerary">
                                <tr>
                                    <td><input type='date' name="date[]" min="{{ date('Y-m-d') }}" class="form-control date" placholder=""></td>
                                    <td><input type='text' name="name_of_coop[]" class="form-control" placholder=""></td>
                                    <td><input type='text' name="municipality[]" class="form-control" placholder=""></td>
                                    <td>
                                        <select class='form-control' name='account_id[]'>
                                            <option value="0">--Select--</option>
                                            @foreach ($accounts as $account)
                                            <option value="{{$account->id}}">{{$account->account_name}} {{$account->account_type}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type='text' name="purpose[]" class="form-control" placholder="Purpose"></td>
                                    <td>
                                        <select class='form-control' name='product_id[]'>
                                            <option value="0">--Select--</option>
                                            @foreach ($products as $product)
                                            <option value="{{$product->id}}">{{$product->product_name}} {{$product->product_type}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <input type="text" name='status' style="display:none;" value="Pending">
                                    <th><a href="javascript:void(0)" class="btn btn-danger deleteRow">-</a></th>
                                </tr>
                            </tbody>
                            </table>
                        </div>
        
                        <div class="container d-flex justify-content-center align-items-center">
                        </div>
                    </div>
                </form>
      </div>
      </div> 
      <script>
            $('thead').on('click', '.addRow', function(){
                var tr = "<tr>" +
                            '<td><input type="date" name="date[]" min="{{ date("Y-m-d") }}" class="form-control" placholder=""></td>' +
                            '<td><input type="text" name="name_of_coop[]" class="form-control" placholder=""></td>' +
                            '<td><input type="text" name="municipality[]" class="form-control" placholder=""></td>' +
                            '<td>' +
                                "<select class='form-control' name='account_id[]'>" +
                                    '<option value="0">--Select--</option>' +
                                    '@foreach ($accounts as $account)' +
                                    '<option value="{{$account->id}}">{{$account->account_name}} {{$account->account_type}}</option>' +
                                    '@endforeach' +
                                '</select>' +
                            '</td>' +
                            '<td><input type="text" name="purpose[]" class="form-control" placholder="Purpose"></td>' +
                            '<td>' +
                                "<select class='form-control' name='product_id[]'>" +
                                    '<option value="0">--Select--</option>' +
                                    '@foreach ($products as $product)' +
                                    '<option value="{{$product->id}}">{{$product->product_name}} {{$product->product_type}}</option>' +
                                    '@endforeach' +
                                '</select>' +
                            '</td>' +
                                '<th><a href="javascript:void(0)" class="btn btn-danger deleteRow">-</a></th>' +
                            '</tr>' 
                $('#citinerary').append(tr);
            });

            $('tbody').on('click','.deleteRow', function(){
                $(this).parent().parent().remove();
            })
        </script>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="agentsubmitForm" class="btn btn-primary">Submit</button>
      </div>
    </div>
 </div>
</div>