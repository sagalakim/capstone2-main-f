@extends('admin.layouts.app')

@section('content')
                <div class="row justify-content-center">
                  <div class="col-md-20">
                      <div class="card border-primary" style="border-width:2px; height:520">

                          <div class="card-body">
                              <h3> {{$user->firstname}}'s Itinerary Reports</h3>
                          

                          @if ($message = Session::get('success'))
                              <div class="alert alert-success text-center" style="margin-bottom:30px;height:40px; margin-top:-10px;">
                                  <p style="margin-top:-10px;">{{$message}}</p>
                              </div>
                          @endif
                          

                          @if ($message = Session::get('already'))
                              <div class="alert alert-info text-center" style="margin-bottom:30px;height:40px; margin-top:-10px;">
                                  <p style="margin-top:-10px;">{{$message}}</p>
                              </div>
                          @endif

                          <div class="col-md-8 pb-1" style="margin-left:0px; margin-top:10px;">
                            <form method="GET" action="{{route('adminfilter',$user->id)}}">
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
                          
                            <div class="card-body" style="height:390px;">
                              <table class="table table-responsive-sm table-bordered scrollable-table">
                                <tr>
                                    <th>Itinerary For</th>
                                    <th>Status</th>
                                    <th>Approved By</th>
                                    <th>Approver's Role</th>
                                    <th>See more</th>
                                </tr>

                                @if ($itinerary->count()>0)
                                    @foreach($itinerary as $itinerary)
                                    <tr> 
                                        <td style="width:300px">{{date('M d, Y', strtotime($itinerary->date_from))}} - {{date('M d, Y', strtotime($itinerary->date_to))}}</td>
                                        <td style="width:100px">{{$itinerary->status}}</td>
                                        @if ($itinerary->approved_by !== null)
                                        <td style="width:300px">{{$itinerary->approver->firstname}}</td>
                                        @else
                                        <td></td>
                                        @endif
                                        <td style="width:300px">{{$itinerary->approver_role}}</td>
                                        <td style="width:300px">
                                            <form action"" method="POST">
                                                <a class="btn btn-info" href="{{route('admin_agent_showitinerarydetails',$itinerary->id)}}">Details</a>
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
            </div>
        </div>


<script>
  $(function(e){
    $('#select_all_ids').click(function(){
      $('.checkbox_ids').prop('checked', $(this).prop('checked'));
    });

    $('#ApproveAllSelectedItinerary').click(function(e){
      e.preventDefault();
      var all_ids = [];
      $('input:checkbox[name=ids]:checked').each(function(){
        all_ids.push($(this).val());
      });

      $.ajax({
        url:"{{ route('itinerary.approve')}}",
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