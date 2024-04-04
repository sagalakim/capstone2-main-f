<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Accomplishment Details Preview</title>

    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: sans-serif;
        }
        h1,h2,h3,h4,h5,h6,p,span,label {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px !important;
        }
        table thead th {
            height: 28px;
            text-align: left;
            font-size: 14px;
            font-family: sans-serif;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
        }

        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: sans-serif;
        }
        .small-heading {
            font-size: 18px;
            font-family: sans-serif;
        }
        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: sans-serif;
        }
        .order-details tbody tr td:nth-child(1) {
            width: 20%;
        }
        .order-details tbody tr td:nth-child(3) {
            width: 20%;
        }

        .text-start {
            text-align: left;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 400;
        }
        .no-border {
            border: 1px solid #fff !important;
        }
        .bg-blue {
            background-color: #414ab1;
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="row">
    <h3 class="col">WEEKLY ACCOMPLISHMENT and ITINERARY REPORT</h3>
        <!--<img class="col"src="{{asset('company/climbs-logo.jpg')}}" alt="img" style="height:150px; width:150px; margin-left:1100px; margin-top:-60px;"> -->
    </div>
    <br>
    
    <div style="margin-top:-20px;">
    <span>Date of Submission: {{date('M d, Y', strtotime($date))}}</span><br>
    <span>Inclusive Dates: {{date('M d, Y', strtotime($accomplishment->date_from))}} - {{date('M d, Y', strtotime($accomplishment->date_to))}}</span><br><br>
    
    <span >To: Mr. Renan P. Diaz</span><br>
    <span style="margin-left:26px;">VP Sales</span><br><br>
    </div>
    <table style="margin-left:-10px;">
        <thead>
            <tr>
            </tr>
            <tr class="bg-blue">
                <th class="text-center" style="width:70px;">DATE</th>
                <th class="text-center" style="width:150px;">NAME OF COOP/ASSOCIATES</th>
                <th class="text-center" style="width:200px;">PURPOSE</th>
                <th class="text-center" style="width:250px;">REMARKS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @if($data->count()>0)
                    @foreach($data as $data)
                        <tr>
                            <td>{{date('M d, Y', strtotime($data->date))}}</td>
                            <td>{{$data->name_of_coop}}</td>
                            <td >{{$data->purpose}}</td>
                            <td >{{$data->remarks}}</td>
                        </tr>
                    @endforeach
                @endif
            </tr>
        </tbody>
    </table>
        <br>
    <h3>ITINERARY (For the next 5 days)</h3>
    <table style="margin-left:-10px;">
        <thead>
            <tr class="bg-blue">
            <th class="text-center" style="width:70px;">DATE</th>
                <th class="text-center" style="width:150px;">ACTIVITIES</th>
                <th class="text-center" style="width:200px;">PURPOSE</th>
                <th class="text-center" style="width:250px;">REMARKS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th></th>
                <th>(Name of Coops/Non Coops)</th><th></th><th></th>
            </tr>
            @if($fornext5days)
                    @foreach($fornext5days as $data)
            <tr>
                
                        <td>{{date('M d, Y', strtotime($data->date))}}</td>
                        <td>{{$data->name_of_coop}}</td>
                        <td>{{$data->purpose}}</td>
                        <td>Not Applicable</td>
                    
            </tr>
                    @endforeach
            @else
            <tr>
                <td colspan="4" class="text-center">No Itineraries Yet</td>
            </tr>
            @endif
        </tbody>
    </table><br><br>

    <span style="font-size:18px;">A. Top Accomplishment of the Week: </span>
    <p style="margin-bottom:-5px;">_________________________________________________________________________________</p>
    <p style="margin-bottom:-5px;">_________________________________________________________________________________</p>
    <p style="margin-bottom:-5px;">_________________________________________________________________________________</p>
    <p>________________________________________________________________</p>
    <br><br>

    <span style="font-size:18px;">B. Concerns and Immediate Action: </span>
    <p style="margin-bottom:-5px;">_________________________________________________________________________________</p>
    <p style="margin-bottom:-5px;">_________________________________________________________________________________</p>

    <div class="row">
    <div class="col">
    <p>Prepared by:</p>
    <p style="text-decoration: underline; margin-top:-5px;">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</p>
    @if (Auth::user()->role == 'agents')
    <p style="margin-top:-16px; font-size:13px;">Sales Agent</p>
    @elseif(Auth::user()->role == 'nsm_nl')
    <p style="margin-top:-16px; font-size:13px;">National Non-life</p>
    @endif
    </div>

    <div class="col" style="margin-left:500px; margin-top:-237px;">
    <p>Approved by:</p>
    @if ($accomplishment->approved_by !== null)
    <p style="text-decoration: underline; margin-top:-5px;">{{$accomplishment->approver->firstname}}</p>
    @else
        <p style="text-decoration: underline; margin-top:30px;">______________</p>
    @endif
    @if($accomplishment->approver->role == 'nsm_nl')
    <p style="margin-top:-16px; font-size:13px;">NSM Non-life</p>
    @elseif($accomplishment->approver->role == 'general_admin')
    <p style="margin-top:-16px; font-size:13px;">General Admin</p>
    @endif
    </div>
    </div>
</body>
</html>