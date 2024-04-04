@extends('nsmnonlife.layouts.app')

@section('content')
            <div class="row justify-content-center">
        <div class="col-md-20">
            <div class="card border-primary" style="border-width:2px; height:535px;">

                <div class="card-body">
                    <h2>Sales Agent Users : <span id="total_records"></span></h2>
                

                
                  <div class="form-group mb-3" style="margin-top:20px;">
                    <input type="text" id="search" name="search" class="form-control" placeholder="Search Agent Name" >
                  </div>

                <div class="table-responsive">
                <table class='table table-striped table-bordered'>
                  <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
                </div>
                </div>
            </div>
        </div>
            </div>
        </div>

    </div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){

fetch_user_data();

function fetch_user_data(query = ''){
  $.ajax({
    url:"{{ route('action') }}",
    method:'GET',
    data:{query:query},
    dataType:'json',
    success:function(data){
      $('tbody').html(data.table_data);
      $('#total_records').text(data.total_data);
    }
  })
}

$(document).on('keyup', '#search', function(){
  var query = $(this).val();
  fetch_user_data(query);
})
});
</script>
@endsection