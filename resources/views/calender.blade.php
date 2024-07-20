<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Calender</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </head>
    <body>
        <p>This is Calender App</p>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col"></th>
                    @foreach($meetings as $date => $meeting )
                    <th scope="col">
                        {{date('n月d日',strtotime($date))}}
                        ({{$week[date("w", strtotime($date))]}})
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @for($i=$start_hour; $i<=$end_hour; $i++)
                <tr>
                    <th scope="row">{{$i}}:00</th>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endfor
            </tbody>
        </table>

    </body>
</html>

