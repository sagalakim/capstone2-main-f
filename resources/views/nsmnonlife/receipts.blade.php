<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Receipts</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-20">
            <div class="card border-primary" style="border-width:2px; margin-top:50px; height: 500px;">
                <div class="card-header">{{$user->firstname}}'s Receipts for this liquidation</div>

                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Date Uploaded</th>
                            <th>view</th>
                        </thead>
                        <tbody>
                            @if($receipts->count() > 0)
                                @foreach($receipts as $receipt)
                                <tr>
                                    <td><img src="{{$receipt->location}}" name="{{$receipt->name}}"></td>
                                    <td>{{$receipt->name}}</td>
                                    <td>
                                        @if($receipt->size < 1000)
                                            {{number_format($receipt->size,2)}} bytes
                                         @elseif($receipt->size >= 1000000)
                                            {{number_format($receipt->size/1000000,2)}} mb
                                        @else  
                                            {{number_format($receipt->size/1000,2)}} kb
                                        @endif
                                    </td>
                                    <td>{{date('M d, Y h:i A', strtotime($receipt->created_at))}}</td>
                                    <td><a href="{{ asset($receipt->location) }}" target="_blank">{{$receipt->location}}</a></td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No table</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>