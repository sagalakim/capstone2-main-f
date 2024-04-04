<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Invoice #6</title>

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

    <table class="order-details">
        <thead>
            <tr>
                <th width="50%" colspan="2" class="company-data">
                    <span style="font-size:15px;">Activity : {{$liquidation->activity}}</span> <br>
                    <span style="font-size:15px;">Employee name : {{$liquidation->owner->firstname}} {{$liquidation->owner->lastname}}</span> <br>
                    <span style="font-size:15px;">Position : {{$liquidation->owner->role}}</span> <br>
                </th>
                <th width="50%" colspan="2" class="text-start company-data">
                     <br><br>
                    <span style="font-size:15px;">Date filed : {{$liquidation->date_filed}}</span> <br>
                    <span style="font-size:15px;">Inclusive date : {{$liquidation->inclusive_date}}</span> <br>
                </th>
            </tr>
    </table>

    <table >
        <thead>
            <tr>
            </tr>
            <tr class="bg-blue">
                <th>Date</th>
                <th colspan="2">Travel Itinerary</th>
                <th style="width:50px;">Reference</th>
                <th>Particulars</th>
                <th>Transpo</th>
                <th>Hotel</th>
                <th>Meals</th>
                <th>Sundry</th>
                <th>Amount</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>{{$year}}</th>
                <th>From</th>
                <th>To</th>
                <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
            </tr>
            
            @if($data->count()>0)
                @foreach($data as $data)
                    <tr>
                        <td>{{$data->date}}</td>
                        <td>{{$data->travel_itinerary_from}}</td>
                        <td>{{$data->travel_itinerary_to}}</td>
                        <td>{{$data->reference}}</td>
                        <td>{{$data->particulars}}</td>
                        <td>{{$data->transpo}}</td>
                        <td>{{$data->hotel}}</td>
                        <td>{{$data->meals}}</td>
                        <td>{{$data->sundry}}</td>
                        <td>{{$data->amount}}</td>
                        <td>{{$data->row_total}}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <br>
    <p style="margin-right:30px; font-size:16px; font-weight:bold;" class="text-end">
        <i style="margin-right:20px;">TOTAL : </i> {{$data->total}}
    </p>

    <p style="margin-right:30px; font-size:16px; font-weight:bold; text-decoration: underline;" class="text-end">
        <i style="margin-right:20px;"> Cash Advance : </i> {{$data->cash_advance}}
    </p>

    <p style="margin-right:30px; font-size:16px; font-weight:bold; text-decoration: underline;" class="text-end">
        <i style="margin-right:20px;"> For OR : </i> {{$data->for_or}}
    </p>

    <br>

    <div style="margin-top:180px; margin-left:25px;">
    <p>Liquidated by:</p>
    <p style="text-decoration: underline; margin-top:30px;">{{$liquidation->owner->firstname}} {{$liquidation->owner->lastname}}</p>
    <p style="margin-top:-13px;">Name of Employee</p>
    </div>

    <div style="margin-left:500px; margin-top:-127px;">
    <p>Checked by:</p>
    @if ($liquidation->checked_by !== null)
    <p style="text-decoration: underline; margin-top:30px;">{{$liquidation->checked_by}}</p>
    @else
        <p>______________</p>
    @endif
    <p style="margin-top:-13px;">BOOKEEPER</p>
    </div>

    <div style="margin-top:100px; margin-left:25px;">
    <p>Recommending approval:</p>
    @if ($liquidation->Recommending_approval !== null)
    <p style="text-decoration: underline; margin-top:30px;">{{$liquidation->Recommending_approval}}</p>
    @else
        <p>__________________</p>
    @endif
    <p style="margin-top:-13px;">VP/CFO</p>
    </div>

    <div style="margin-left:500px; margin-top:-117px;">
    <p>Approved by:</p>
    @if ($liquidation->approved_by !== null)
    <p style="text-decoration: underline; margin-top:30px;">{{$liquidation->approved_by}}</p>
    @else
        <p>______________</p>
    @endif
    <p style="margin-top:-13px;">PRES/CEO</p>
    </div>
            

</body>
</html>