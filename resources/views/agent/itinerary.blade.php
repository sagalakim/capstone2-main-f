@extends('agent.layouts.app')
@include('agent.cmodal')
@include('agent.alertmodal')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-20">
            <div class="card border-primary" style="border-width:2px; height:530px;">

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
                    <h2>My Itineraries</h2>
                
                @if($lastItinerary)
                  @if ( $lastItinerary->status == 'Disapproved')
                    <button style="margin-bottom:-50px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agentitineraryCreateModal">
                            Create new
                    </button>
                  @elseif($Itinerary_accomplishment)
                          @if($Itinerary_accomplishment->status == 'Approved')
                            <button style="margin-bottom:-50px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agentitineraryCreateModal">
                              Create new
                            </button>
                          @elseif($Itinerary_accomplishment->status == 'Pending') 
                            <button style="margin-bottom:-50px;" type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#createAlertModal">
                              Create new
                            </button>
                          @endif
                  @else
                  <button style="margin-bottom:-50px;" type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#createAlertModal">
                          Create new
                  </button>
                  @endif
                @else
                <button style="margin-bottom:-50px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agentitineraryCreateModal">
                        Create new
                </button>
                @endif
                
                <div style="margin-bottom:-10px; margin-top:-20px;">
                  <form method="GET" action="{{route('safilter')}}">
                    <div class="row">
                      <div class="input-group mb-2" style="margin-left:360px; width:280px; margin-top:20px;">
                        <span class="input-group-text fw-bold">Start Date:</span>
                        <input type="date" name="start_date" class="form-control">
                      </div>

                      <div class="input-group mb-2" style="width:280px; margin-top:20px;">
                        <span class="input-group-text fw-bold">End Date:</span>
                        <input type="date" name="end_date" class="form-control">
                      </div>

                      <div class="col-md-1 pt-4" style="margin-top:-4px; margin-left:-8px;">
                        <button type="submit" class="btn btn-primary">Filter</button>
                      </div>
                    </div>
                  </form>
                  </div>

                
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
                            <td >{{$itinerary->status}}</td>
                            @if ($itinerary->approved_by !== null)
                            <td style="width:350px">{{$itinerary->approver->firstname}} on {{date('M d, Y h:i A', strtotime($itinerary->updated_at))}}</td>
                            @else
                            <td></td>
                            @endif
                            <td>{{$itinerary->approver_role}}</td>
                            <td style="width:300px">
                                <form action"" method="POST">
                                    <a class="btn btn-info" href="{{route('agent_showitinerary',$itinerary->id)}}">Details</a>
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
<script>
 $(document).ready(function() {
    $('#agentsubmitForm').on('click', function(e) {
      e.preventDefault(); // Prevent the form from submitting normally

      // Collect the form data
      var formData = $('#agentitineraryForm').serialize();

      // Submit the form data to the server using an AJAX request
      $.ajax({
        url: "{{route('agentstore')}}",
        type: 'POST',
        data: formData,
        success: function(response) {
          console.log('Form submitted successfully');
          $('#agentitineraryForm')[0].reset();
          $('#agentitineraryCreateModal').modal('hide');
          location.reload();
          
        },
        error: function(xhr, status, error) {
            var errorObj = JSON.parse(xhr.responseText);
            alert(errorObj.error);
        }
      });
    });
 });
</script>
@endsection
