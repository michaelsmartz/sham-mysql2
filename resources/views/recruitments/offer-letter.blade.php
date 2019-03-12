<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
  </head>
  <body>
    <p>
        {{date('d/m/Y')}}
        <br><br>
        <strong>{{$candidate->name}}</strong>
        <br><br>Dear candidate,
        <br><br>
        <strong>Confirmation of offer of employment</strong>
    </p>
    <p>
        I am pleased to confirm your offer of employment by (company name) in the position of {{$recruitment->job_title}} in the {{$recruitment->department->description}} department.
    </p>
    <p>
        If accepted, your employment will commence on {{$candidate->date_available}} and will continue.
    </p>
    <p>
        In the capacity of {{$recruitment->job_title}}, you will report directly to the (position of the direct report). You will be located at, (office location’s physical address).
    </p>
    <p>
        Once your acceptance is confirmed you will be provided with a full letter of appointment and employment contract detailing all related conditions.
    </p>
    <p>
        Kindly indicate your acceptance of the above by signing below and returning it on or before, <strong>{{date('d-m-Y', strtotime($recruitment->end_date))}}</strong>. Please contact me if you require any further clarity.
    </p>
    <p>
        Yours faithfully,
        <br>Lai Choi Filou
    </p>
    <p>
        Signed and accepted: ………………………………………………………………………………<br>(candidate name) <br><br>Date: ……../……../…….
                                  	
    </p>
  </body>
</html>