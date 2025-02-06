<table>

        <tbody>


            <table>
                <thead>
                    <tr>
                        <th style="width: 200%;">Product</th>
                        <th style="width: 200%;">{{__('Stock')}}</th>
                        <th style="width: 200%;">{{__('Enum')}}</th>
                        <!-- Add other Product attributes here -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td style="width: 200%;" >{{ $product->name }}</td>


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
                        

                        <td style="width: 200%;"> {{$stock}} </td>

                        <td style="width: 200%;"> {{$product->enum}}</td>
                        <!-- Add other Product attributes here -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </tbody>
        
    
</table>