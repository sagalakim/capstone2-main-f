
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
    body {
      font-family: 'Arial', sans-serif;
      margin: 0; /* Remove default margin */
    }

    #top-layer {
      background: #343a40;
      color: #fff;
      padding: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    #wrapper {
      display: flex;
    }

    #sidebar {
      width: 250px;
      height: 100vh;
      background: #343a40;
      color: #fff;
      padding: 20px;
    }

    #content {
      flex: 1;
      padding: 20px;
    }

    .profile-link {
      /* Adjusted position to fit within the top layer */
      position: relative;
      top: 0;
      right: 0;
    }

    .profile-pic {
      width: 40px;
      height: 40px;
      border-radius: 50%;
    }
  </style>
</head>
<body>

<div id="top-layer">
  <!-- Dashboard title -->
  <h2>Dashboard</h2>
  <!-- Profile link -->

  <!--
  <a class="profile-link" href="">
    <img src="images/profile.jpeg" alt="Profile" class="profile-pic">
  </a>
  -->

  <a class="" href="{{ route('logout') }}"
        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
        {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

<div id="wrapper">
  <!-- Sidebar -->
  <div id="sidebar">
    <ul class="nav flex-column">
    <li class="nav-item">
        <div class="nav-link dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Agent Reports</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ url('/accomplishment/reports') }}">Accomplishment</a>
            <a class="dropdown-item" href="{{ url('/itineraryReports') }}">Itinerary</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <div class="nav-link dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Reports</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ url('/accomplishments') }}">Accomplishment</a>
            <a class="dropdown-item" href="{{ url('/itineraries') }}">Itinerary</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <div class="nav-link dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Create</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="?section=accomplishment">Accomplishment</a>
            <a class="dropdown-item" href="{{ url('/create/itineraries') }}">Itinerary</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">History</a>
      </li>
    </ul>
  </div>

  <!-- Page Content -->
  <div id="content">
  <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">

                <div class="card-body">
                    <h2>Edit Itinerary</h2>
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

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{$message}}</p>
                    </div>
                @endif
      
                <form action="{{route('nsmiupdate',$itinerary->id)}}" method="Post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') 
                    <div class="row">
                        <input type="text" name='area_id' style="display:none;" value="{{Auth::user()->area_id}}">
                        
                        <select class='form-control' name='user_id' style="width: 800px; margin-left: 14px; margin-bottom: 15px;">
                            <option value="{{Auth::user()->id}}">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</option>
                        </select>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Date:</strong>
                                <input type='date' value="{{$itinerary->date}}" name="date"  class="form-control" placholder="">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Name of Coop</strong>
                                <input type='text' name="name_of_coop" value="{{$itinerary->name_of_coop}}" class="form-control" placholder="Coop/Associtae">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Municipality</strong>
                                <input type='text' name="municipality" value="{{$itinerary->municipality}}" class="form-control" placholder="Coop/Associtae">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Account</strong> <a href="{{url('/nsmnl/accountedit',$itinerary->id)}}">Edit</a></strong>
                                <select class='form-control' name='account_id'> 
                                    @if($itinerary->status === 'account edited')
                                        @foreach ($accounts as $account)
                                        <option value="{{$account->id}}">{{$account->account_name}} {{$account->account_type}}</option>
                                        @endforeach
                                    @else
                                    <option value="{{$itinerary->account->id}}">{{$itinerary->account->account_name}} {{$itinerary->account->account_type}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Purpose</strong>
                                <input type='text' name="purpose" value="{{$itinerary->purpose}}" class="form-control" placholder="Coop/Associtae">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Product</strong> <a href="{{url('/nsmnl/productedit',$itinerary->id)}}">Edit</a></strong>
                                <select class='form-control' name='product_id'>
                                    @if ($itinerary->status === 'product edited')
                                        @foreach ($products as $product)
                                        <option value="{{$product->id}}">{{$product->product_name}} {{$product->product_type}}</option>
                                        @endforeach
                                    @else
                                        <option value="{{$itinerary->product->id}}">{{$itinerary->product->product_name}} {{$itinerary->product->product_type}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
        
                        <div class="container d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-primary" style="width: 200px;">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
