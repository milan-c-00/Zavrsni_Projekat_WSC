<table>
    <thead>
    @php($style1 = 'background-color: #57b9a8; border: 1px solid black; text-align: center; font-weight: bold;')
    <tr>
        <td style="{{$style1}}">Reservation ID</td>
        <td style="{{$style1}}">Vehicle</td>
        <td style="{{$style1}}">Price</td>
        <td style="{{$style1}}">User</td>
        <td style="{{$style1}}">Start date</td>
        <td style="{{$style1}}">End date</td>

    </tr>
    </thead>
    <tbody>
    @php($style2 = 'background-color: #b4dce9; border: 1px solid black')
    @foreach($reservations as $reservation)
        <tr>
            <td style="{{$style2}}">{{ $reservation->id }}</td>
            <td style="{{$style2}}">{{ $reservation->vehicle->brand->name.' '.$reservation->vehicle->vehicle_model->name}}</td>
            <td style="{{$style2}}">{{ $reservation->vehicle->price }}</td>
            <td style="{{$style2}}">{{ $reservation->user->name }}</td>
            <td style="{{$style2}}">{{ $reservation->start_date }}</td>
            <td style="{{$style2}}">{{ $reservation->end_date }}</td>

        </tr>
    @endforeach
    </tbody>
</table>
