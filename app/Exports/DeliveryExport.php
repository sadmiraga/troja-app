<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class DeliveryExport implements FromView
{

    private $deliveries;

    public function __construct($delivery_id){
        
        $deliveries = DB::table('products')
        ->select(
            'products.id as product_id',
            'products.name as name',
            'products.enum as enum',
            'products.packing_size as packing_size',
            'delivery_products.quantity as quantity',
            'delivery_products.weight as weight',
            'delivery_products.liters as liters',
        )
        ->join('delivery_products', 'delivery_products.product_id', '=', 'products.id')
        ->where('delivery_products.delivery_id',$delivery_id)
        ->get();

        $this->deliveries = $deliveries;
        
    }


    public function view(): \Illuminate\Contracts\View\View
    {
        return view('exports.deliveries', [
            'deliveries' => $this->deliveries,
        ]);
    }
}
