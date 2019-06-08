<html lang="en"><head></head><body>


    
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Service Unavailable</title>
		
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
		<link href="{{ asset('/public/css/flipclock.css').'?t='.time() }}" rel="stylesheet">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 36px;
                padding: 20px;
            }
        </style>
    
    
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title">
                    MAINTENANCE         </div>
					<h1>Will Back In </h1>
						<?php $s=App\Setting::find(1);?>
					<span id="2" class="timerendin flip-clock-wrapper" time="
					{{$s->downtill??'Dec 10, 2018 14:30:25'}}">

            </div>
        </div>
    


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://momentjs.com/downloads/moment.min.js"></script>
	<script src="https://momentjs.com/downloads/moment-timezone-with-data-2012-2022.min.js"></script>
	<script src="{{ asset('/public/js/flipclock.min.js') }}" defer></script>
	<script src="{{ asset('/public/js/counter.js').'?t='.time() }}" defer></script>
</body></html>