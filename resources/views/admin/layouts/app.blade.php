<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CLIMBS</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https:://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!-- Scripts -->
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <style>
        :root {
            --main-bg-color: #9999ff;
            --main-text-color: #0000cc;
            --second-text-color: #8080ff;
            --second-bg-color: #4d4dff;
        }

        .modal-dialog-wide {
            max-width: 80% !important;
        }

        .scrollable-menu {
            height: auto;
            max-height: 400px;
            overflow-x: hidden;
        }

        .modal-dialog-wide-enough {
            max-width: 65% !important;
        }

        .scrollable-table {
            overflow-x: auto;
            display: block;
            max-height: 400px; /* you can set this value to your preferred height */
            overflow-y: auto;
            max-width:1200px;
        }

        th#data{
            font-weight: normal;
        }

        .locked {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            padding: 5px;
            pointer-events: none;
        }
        .primary-text{
            color: var(--main-text-color);
        }
        .second-text{
            color: var(--second-text-color);
        }
        .primary-bg{
            background-color: var(--main-bg-color);
        }
        .secondary-bg{
            background-color: var(--second-bg-color);
        }
        .rounded-full{
            border-radius: 100%;
        }
        #wrapper{
            overflow-x: hidden;
            background-image: linear-gradient(
                to right,
                #baf3d7,
                #c2f5de,
                #cbf7e4,
                #d4f8ea,
                #ddfaef,
            );
        }
        #sidebar-wrapper{
            min-height:100vh;
            margin-left:-15rem;
            transition: margin 0.25s ease-out;
            
            
        }
        #sidebar-wrapper .sidebar-heading{
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
        }
        #sidebar-wrapper .list-group{
            width: 15rem;
        }
        #page-content-wrapper{
            min-width:100vh;
        }
        #wrapper .toggled #sidebar-wrapper{
            margin-left:0;
        }
        #menu-toggle{
            
        }
        .list-group-item{
            border:none;
            padding:20px 30px;
        }
        .list-group-item.active{
            background-color: transparent;
            color: var(--main-text-color);
            font-weight: bold;
            border:none;
        }

        .loader-wrapper {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background-color: #330099;
            display:flex;
            justify-content: center;
            align-items: center;
        }
        .loader {
            display: inline-block;
            width: 30px;
            height: 30px;
            position: relative;
            border: 4px solid #Fff;
            animation: loader 2s infinite ease;
        }
        .loader-inner {
            vertical-align: top;
            display: inline-block;
            width: 100%;
            background-color: #fff;
            animation: loader-inner 2s infinite ease-in;
        }

        .bg-blue {
            background-color: #414ab1;
            color: #fff;
        }

        @keyframes loader {
            0% { transform: rotate(0deg);}
            25% { transform: rotate(180deg);}
            50% { transform: rotate(180deg);}
            75% { transform: rotate(360deg);}
            100% { transform: rotate(360deg);}
        }

        @keyframes loader-inner {
            0% { height: 0%;}
            25% { height: 0%;}
            50% { height: 100%;}
            75% { height: 100%;}
            100% { height: 0%;}
        }

        @media (min-width: 768px){
            #sidebar-wrapper{
                margin-left:0;
            }
            #page-content-wrapper {
                min-width: 0;
                width:100%;
            }
            #wrapper .toggled #sidebar-wrapper{
                margin-left:15rem;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
  </symbol>
  <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
  </symbol>
  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>
        <!-- Sidebar starts here -->
            <div class="bg-white border border-right-0" id="sidebar-wrapper">
                <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
                    <img src="{{asset('company/climbs-logo.jpg')}}" style="height:50px; width:50px; margin-left:10px;"> CLIMBS
                </div>

                <div class="list-group list-group-flush my-3">
                    <a href="{{ url('/general_admin/home') }}" class="list-group-item list-group-item-action bg-transparent primary-text fw-bold">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>

                    <div class="nav-link dropdown">
                    <a data-toggle="dropdown" href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                        <i class="fas fa-user me-2"></i>Agent Reports
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item second-text fw-bold" href="{{ url('/admin/agent/itinerary/reports') }}"> <i class="fas fa-map me-2"></i>Itinerary</a>
                        <a class="dropdown-item second-text fw-bold" href="{{ url('/admin/agent/accomplishment/reports') }}"> <i class="fas fa-project-diagram me-2"></i> Accomplishment</a>
                        <a class="dropdown-item second-text fw-bold" href="{{ url('/admin/agent/liquidation/reports') }}"> <i class="fas fa-list me-2"></i> Liquidation</a>
                    </div>
                    </div>

                    <div class="nav-link dropdown">
                    <a data-toggle="dropdown" href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                        <i class="fas fa-book me-2"></i>My Reports
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item second-text fw-bold" href="{{ url('/admin/itineraries') }}"> <i class="fas fa-map me-2"></i>Itinerary</a>
                        <a class="dropdown-item second-text fw-bold" href="{{ url('/admin-accomplishments') }}"> <i class="fas fa-project-diagram me-2"></i> Accomplishment</a>
                        <a class="dropdown-item second-text fw-bold" href="{{ url('/admin/liquidations') }}"> <i class="fas fa-folder me-2"></i> Liquidation</a>
                    </div>
                    </div>

                    <div class="nav-link dropdown">
                    <a data-toggle="dropdown" href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                        <i class="fas fa-paperclip me-2"></i>Create Report
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item second-text fw-bold" href="{{ url('/admin/create/liquidation') }}"> <i class="fas fa-clipboard-check me-2"></i> Liquidation</a>
                    </div>
                    </div>

                    <a href="{{ url('/admin/register') }}" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                        <i style="font-size:10px;margin-right:-20px;"class="fa fa-plus me-2"></i><i class="fas fa-user me-2"></i>Add User
                    </a>

                    <!--
                    <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                        <i class="fas fa-history me-2"></i>History
                    </a>
                    -->
                </div>
            </div>
        <!-- Sidebar ends here -->

        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4 border-bottom" style="margin-bottom:20px;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left:720px;">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0"> 
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle second-text fw-bold" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Notifications <i class="fas fa-bell"></i>
                            </a>
                            <ul class="dropdown-menu scrollable-menu" aria-labelledby="navbarDropdown" style="width:400px;margin-left:-200px; max-height: 400px; overflow-y: auto;">
                                <li > <div style="width:380px;margin-left:5px;" class="alert alert-primary d-flex align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="20" height="20" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                                    <div>
                                        An example alert with an icon <a href="hehe" style="margin-left:60px;">View</a>
                                    </div>
                                    </div>
                                </li>
                                <li ><div style="width:380px;margin-left:5px;" class="alert alert-primary d-flex align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="20" height="20" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                                    <div>
                                        An example alert with an icon <a href="hehe" style="margin-left:60px;">View</a>
                                    </div>
                                    </div></a>
                                </li>
                                <li>
                                    <div style="width:380px;margin-left:5px;" class="alert alert-success d-flex align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="20" height="20" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                                    <div>
                                        An example success alert with an icon
                                    </div>
                                    </div>
                                </li>
                                <li>
                                    <div style="width:380px;margin-left:5px;" class="alert alert-success d-flex align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="20" height="20" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                                    <div>
                                        An example success alert with an icon
                                    </div>
                                    </div>
                                </li>
                                
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle second-text fw-bold" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>{{Auth::user()->firstname}}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a href="#" class="dropdown-item">Profile</a></li>
                                <li><a href="#" class="dropdown-item">Settings</a></li>
                                <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </nav>

            <div class="container-fluid px-4">
                @yield('content')
            </div>
            
            <div class="loader-wrapper">
                <span class="loader"><span class="loader-inner"></span></span>
            </div>
        </div>
    </div>

        
  
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

<script>
        $(window).on("load",function(){
          $(".loader-wrapper").fadeOut("slow");
        });
</script>

</body>
</html>