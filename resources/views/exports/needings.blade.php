<table>

    <thead>
        <tr>
            <th style="width: 200%;">{{__('Product')}}</th>
            <th style="width: 200%;">{{__('Value')}}</th>
            <th style="width: 300%;">{{__('Enum')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($needings as $needing)
        <tr>
            <td style="width: 200%;" >{{ $needing->name }}</td>
            <td style="width: 200%;">
                @if($needing->quantity != null) {{$needing->quantity}} @endif
                @if($needing->weight != null) {{$needing->weight}} @endif
                @if($needing->liters != null) {{$needing->liters}} @endif
            </td>
            <td style="width: 200%;">
                @if($needing->quantity != null) {{__('Pieces')}} @endif
                @if($needing->weight != null) g @endif
                @if($needing->liters != null) l @endif
            </td>
        </tr>
        @endforeach
    </tbody>

</table>