<!-- Modal -->
<div class="modal fade" id="showUserListModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-wide-enough" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">List Of Created Users</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        <table class='table table-striped table-bordered'>
          <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Position</th>
            </tr>
          </thead>
          <tbody>
            @if ($users->count() > 0)
              @foreach($users as $users)
              <tr>
                <th id="data">{{$users->firstname}}</th>
                <th id="data">{{$users->lastname}}</th>
                <th id="data">{{$users->email}}</th>
                @if($users->role == 'agents')
                  <th id="data">Sales Agent</th>
                @elseif($users->role == 'rsm')
                  <th id="data">Regional Sales Manager</th>
                @elseif($users->role == 'asm')
                  <th id="data">Area Sales Manager</th>
                  @elseif($users->role == 'nsm_nl')
                  <th id="data">National Sales Manager Non-life</th>
                  @elseif($users->role == 'nsm_fl')
                  <th id="data">National Sales Manager Life</th>
                  @elseif($users->role == 'executive_assistant')
                  <th id="data">Executive Assistant</th>
                  @elseif($users->role == 'general_admin')
                  <th id="data">General Admin</th>
                @endif
              </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>