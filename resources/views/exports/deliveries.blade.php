<table>

    <thead>
        <tr>
            <th style="width: 200%;">{{__('Product')}}</th>
            <th style="width: 200%;">{{__('Value')}}</th>
            <th style="width: 300%;">{{__('Enum')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($deliveries as $delivery)
        <tr>
            <td style="width: 200%;" >{{ $delivery->name }}</td>
            <td style="width: 200%;">
                @if($delivery->quantity != null) {{$delivery->quantity}} @endif
                @if($delivery->weight != null) {{$delivery->weight}} @endif
                @if($delivery->liters != null) {{$delivery->liters}} @endif
            </td>
            <td style="width: 200%;">
                @if($delivery->quantity != null) {{__('Pieces')}} @endif
                @if($delivery->weight != null) g @endif
                @if($delivery->liters != null) l @endif
            </td>
        </tr>
        @endforeach
    </tbody>

</table>