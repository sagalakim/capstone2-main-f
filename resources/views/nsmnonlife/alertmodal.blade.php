<!-- Modal -->
<div class="modal fade" id="nsmcreateAlertModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <h1 class="modal-title fs-5" id="exampleModalLabel">Message</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @if ($Itinerary_accomplishment)
          @if ($Itinerary_accomplishment->status == 'Pending')
          <p>Wait for the Accomplishment approval  before creating a new itinerary.</p>
          
          @elseif ($Itinerary_accomplishment->status == 'Disapproved')
          <p>Create New Accomplishment</p>
          @endif
        @endif

        @if($lastItinerary)
          @if ($lastItinerary->status == 'Approved')
          <p>Create Accomplishment first and wait for its approval before creating an itinerary.</p>
          @elseif ($lastItinerary->status == 'Pending')
          <p>Wait for the Itinerary to be checked.</p>
          @endif
        @endif
      </div> 
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
 </div>
</div>