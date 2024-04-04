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

    <!-- Scripts -->
    <style>
        :root {
            --main-bg-color:  #9999ff;
            --main-text-color:  #0000cc;
            --second-text-color: #8080ff;
            --second-bg-color: #4d4dff;
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
            cursor:pointer;
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

        <!-- Sidebar starts here -->
            <div class="bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
                    <img src="{{asset('company/climbs-logo.jpg')}}" style="height:50px; width:50px; margin-left:10px;"> CLIMBS
                </div>

                <div class="list-group list-group-flush my-3">
                    <a href="{{ url('/home') }}" class="list-group-item list-group-item-action bg-transparent second-text active">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>

                    <div class="nav-link dropdown">
                    <a data-toggle="dropdown" href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                        <i class="fas fa-book me-2"></i>My Reports
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item second-text fw-bold" href="{{ url('/sa/itineraries') }}"> <i class="fas fa-map me-2"></i>Itinerary</a>
                        <a class="dropdown-item second-text fw-bold" href="{{ url('/sa/accomplishments') }}"> <i class="fas fa-project-diagram me-2"></i> Accomplishment</a>
                    </div>
                    </div>

                    <div class="nav-link dropdown">
                    <a data-toggle="dropdown" href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                        <i class="fas fa-paperclip me-2"></i>Create Report
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item second-text fw-bold" href="{{ url('/accomplishments') }}"> <i class="fas fa-clipboard-check me-2"></i> Accomplishment</a>
                        <a class="dropdown-item second-text fw-bold" href="{{ url('/itineraries') }}"><i class="fas fa-window-restore me-2"></i>Itinerary</a>
                    </div>
                    </div>

                    <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                        <i class="fas fa-history me-2"></i>History
                    </a>
                </div>
            </div>
        <!-- Sidebar ends here -->

        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4 border-bottom" style="margin-bottom:20px;">
                

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

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
        </div>



        <!--
        <main class="py-4">
            @yield('content')
        </main>
        s-->
    </div>

        
  

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
    /*
    var el= document.getElementById('wrapper')
    var toggleButton = document.getElementById('menu-toggle')

    toggleButton.onclick = function(){
        el.classList.toggle('toggled')
    }
    */
</script>

</body>
</html>
