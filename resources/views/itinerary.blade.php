@extends('nsmnonlife.layouts.app')
@include('nsmnonlife.cmodal')
@include('nsmnonlife.alertmodal')
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
                    <h2>My Itineraries</h2>

                    
                    @if($lastItinerary)
                        @if ( $lastItinerary->status == 'Disapproved')
                                <button style="margin-bottom:-12px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#itineraryCreateModal">
                                        Create new
                                </button>
                        @elseif($Itinerary_accomplishment)
                            @if($Itinerary_accomplishment->status == 'Approved')
                                <button style="margin-bottom:-12px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#itineraryCreateModal">
                                        Create new
                                </button>
                            @elseif($Itinerary_accomplishment->status == 'Pending') 
                                <button style="margin-bottom:-12px;" type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#nsmcreateAlertModal">
                                    Create new
                                </button>
                            @endif                        
                        @else
                        <button style="margin-bottom:-12px;" type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#nsmcreateAlertModal">
                                Create new
                        </button>
                        @endif
                    @else
                    <button style="margin-bottom:-12px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#itineraryCreateModal">
                            Create new
                    </button>
                    @endif
                
                    <div class="table-responsive">
                <table class='table table-striped table-bordered scrollable-table' style="margin-top:30px;">
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
                            <td style="width:350px">{{$itinerary->status}}</td>
                            <td>{{$itinerary->approver->firstname}}</td>
                            <td>{{$itinerary->approver_role}}</td>
                            <td style="width:300px">
                                <form action"" method="POST">
                                    <a class="btn btn-info" href="{{route('nsmshowitinerary',$itinerary->id)}}">Details</a>
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
    <script>
 $(document).ready(function() {
    $('#submitForm').on('click', function(e) {
      e.preventDefault(); // Prevent the form from submitting normally

      // Collect the form data
      var formData = $('#itineraryForm').serialize();

      // Submit the form data to the server using an AJAX request
      $.ajax({
        url: "{{route('store')}}",
        type: 'POST',
        data: formData,
        success: function(response) {
          console.log('Form submitted successfully');
          $('#itineraryForm')[0].reset();
          $('#itineraryCreateModal').modal('hide');
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