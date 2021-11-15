<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
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

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <h1> 
                    <a href="affiliate">Affiliates within 100km of Office</a>
                </h1>
                    <table style="width:100%">
                        <tr>
                            <th>Name</th>
                            <th>Affiliate ID</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                        </tr>  
                        @foreach ($affiliates as $affiliate)
                            <tr>
                                <th>{{ $affiliate->name }}</th>
                                <th>{{ $affiliate->affiliate_id }}</th>
                                <th>{{ $affiliate->latitude }}</th>
                                <th>{{ $affiliate->longitude }}</th>
                            </tr>    
                        @endforeach
                    </table>
            </div>
        </div>
    </body>
</html>
