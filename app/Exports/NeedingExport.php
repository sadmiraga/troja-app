<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;


class NeedingExport implements FromView
{

    private $needings;


    //constructor.
    public function __construct($needing_id){

        $needings = DB::table('products')
        ->select(
            'products.id as product_id',
            'products.name as name',
            'products.enum as enum',
            'products.packing_size as packing_size',
            'product_needings.quantity as quantity',
            'product_needings.weight as weight',
            'product_needings.liters as liters',
            'product_needings.id as product_needing_id',
            'product_needings.needing_id as needing_id',
        )
        ->join('product_needings', 'product_needings.product_id', '=', 'products.id')
        ->where('product_needings.needing_id',$needing_id)
        ->get();

        $this->needings = $needings;
    }


    public function view(): \Illuminate\Contracts\View\View
    {
        return view('exports.needings', [
            'needings' => $this->needings,
        ]);
    }
}
