<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ trans("Inventura") }} - {{ $location->name }}</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
    </style>
</head>
<body>
                

                        

                        <table>
                            @foreach($products as $product)
                    


                            @php
                                if($product->enum == 'g'){
                                    $stock = round($product->weight, 2);
                                }
    
                                if($product->enum == 'pcs'){
                                    $stock = round($product->quantity, 2);
                                }
    
                                if($product->enum == 'l'){
                                    
                                    $stock = 0.0;
    
                                    //QUANTITY
                                    if (isset($product->quantity) && $product->quantity !== null) {
                                        $chunk = floatval($product->quantity) * floatval($product->packing_size);
                                        $stock += $chunk;
                                    }
    
                                    //LITERS
                                    if (isset($product->liters) && $product->liters !== null) {
                                        $stock += $product->liters;
                                    }
    
                                    //WEIGHT
                                    if (isset($product->weight) && $product->weight !== null) {
    
                                        $density = 930; 
                                        $weight = floatval($product->weight);
                                        $liters = $weight / $density;
    
                                        $stock += $liters;
                                    }
    
                                    $stock = round($stock, 2);
                                }
                            @endphp
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{$stock}} {{$product->enum}}</td>
                            </tr>
                            @endforeach
                        </table>

                    
                    
                    
            
            
        </tbody>
        
    
</table>
</body>
</html> 