<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title></title>
        <style>
            body {
                font-family: Arial, sans-serif;
            }

            h1 {
                color: #333;
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 20px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                border: 1px solid #ccc;
            }

            tr {
                background-color: #f5f5f5;
                border-bottom: 1px solid #ccc;
                padding: 10px;
                text-align: left;
            }

            td {
                border-bottom: 1px solid #ccc;
                padding: 10px;
            }
        </style>
    </head>

    <body>
        <h1>Your reservation is confirmed!</h1>
        <p>
            Dear {{ $reservation->user->name }}, your car reservation is now confirmed. You can check the details below.
        </p>
        <table>
            <tr>
                <td>Name </td>
                <td>{{ $reservation->user->name }}</td>
            </tr>
            <tr>
                <td>Vehicle </td>
                <td>{{ $reservation->vehicle->brand->name." ".$reservation->vehicle->vehicle_model->name }}</td>
            </tr>
            <tr>
                <td>Year </td>
                <td>{{ $reservation->vehicle->year }}</td>
            </tr>
            <tr>
                <td>Price per day </td>
                <td>{{ $reservation->vehicle->price }}</td>
            </tr>
            <tr>
                <td>Start date </td>
                <td>{{ $reservation->start_date }}</td>
            </tr>
            <tr>
                <td>End date </td>
                <td>{{ $reservation->end_date }}</td>
            </tr>
        </table>
        <p>
            Have a nice ride!
        </p>
        <p>
            WSC Rent a Car.
        </p>
    </body>
</html>
