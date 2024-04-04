@extends('nsmnonlife.layouts.app')

@section('content')
              <div class="row justify-content-center">
                    <div class="col-md-20">
                        <div class="card border-primary" style="border-width:2px; margin-top:-1px;">

                            <div class="card-body">
                                <h2> {{$user->firstname}}'s Liquidation Reports</h2>
                            

                            @if ($message = Session::get('success'))
                                <div class="alert alert-success" style="height:20px;margin-bottom:25px;">
                                    <p style="margin-top:-12px;">{{$message}}</p>
                                </div>
                            @endif

                            @if ($message = Session::get('already'))
                                <div class="alert alert-success" style="height:20px;margin-bottom:25px;">
                                    <p style="margin-top:-12px;">{{$message}}</p>
                                </div>
                            @endif

                            <!--
                            <div class="col-md-8 pb-3" style="margin-left:10px;">
                              <a href="#" class="btn btn-success" id="ApproveAllSelectedLiquidation">Approve All Selected</a>
                            </div>
                            -->

                            <div class="col-md-8 pb-1" style="margin-left:0px; margin-top:8px;">
                            <form method="GET" action="{{route('filter3',$user->id)}}">
                              <input type="text" name='user_id' style="display:none;" value="{{$user->id}}">
                              <div class="row pb-1">
                                <div class="input-group mb-2" style="width:280px; margin-top:20px;">
                                  <span class="input-group-text fw-bold">Start Date:</span>
                                  <input type="date" name="start_date" class="form-control">
                                </div>

                                <div class="input-group mb-2" style="width:280px; margin-top:20px;">
                                  <span class="input-group-text fw-bold">End Date:</span>
                                  <input type="date" name="end_date" class="form-control">
                                </div>

                                <div class="col-md-1 pt-4" style="margin-top: -5px; margin-left:-8px;">
                                  <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                              </div>
                            </form>
                            </div> 

                            <div class="card-body" style="height:400px;">
                            <table class='table table-striped table-bordered scrollable-table' style="margin-top:0px;">
                                <tr>
                                    <!--<th><input type="checkbox" name="" id="select_all_ids"></th> -->
                                    <th>Date filed</th>
                                    <th>Activity</th>
                                    <th>Status</th>
                                    <th>See more</th>
                                    
                                </tr>

                                @if ($liquidations->count()>0)
                                    @foreach($liquidations as $liquidation)
                                    <tr> 
                                        <!--<td><input type="checkbox" name="ids" class="checkbox_ids" id=""  value="{{$liquidation->id}}"></td> -->
                                        <td style="width:200px">{{date('M d, Y', strtotime($liquidation->date_filed))}}</td>
                                        <td style="width:350px">{{$liquidation->activity}}</td>
                                        <td style="width:300px">{{$liquidation->status}}</td>
                                        <td >
                                            <form action"" method="POST">
                                                <a class="btn btn-info" href="{{route('nsmshowagentliquidation',$liquidation->id)}}">Details</a>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                              </table>
                        </div>
                        </div>
                        </div>
                    </div>
                </div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
  $(function(e){
    $('#select_all_ids').click(function(){
      $('.checkbox_ids').prop('checked', $(this).prop('checked'));
    });

    $('#ApproveAllSelectedLiquidation').click(function(e){
      e.preventDefault();
      var all_ids = [];
      $('input:checkbox[name=ids]:checked').each(function(){
        all_ids.push($(this).val());
      });

      $.ajax({
        url:"{{ route('liquidation.approve')}}",
        type:"POST",
        data:{
          ids:all_ids,
          _token:'{{csrf_token()}}'
        },
        success:function(response) {
            console.log('success');
            window.location.href = response.url;
        }
      });

    });
  });
</script>
@endsection