<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class StocktakingExport implements FromView
{

    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */

    private $products;


    public function __construct($stocktaking_id)
    {
        $products = DB::table('product_stocktakings')
        ->select(
            'products.id as id',
            'products.name as name',
            'products.enum as enum',
            'products.weightable as weightable',
            'products.packing_weight as packing_weight',
            'products.packing_size as packing_size',
            'products.storage as storage',
            DB::raw('SUM(product_stocktakings.weight) as weight'),
            DB::raw('SUM(product_stocktakings.quantity) as quantity'),
            DB::raw('SUM(product_stocktakings.liters) as liters')
        )
        ->join('products', 'products.id', '=', 'product_stocktakings.product_id')
        ->where('product_stocktakings.stocktaking_id', $stocktaking_id)
        ->groupBy('products.id','product_stocktakings.product_id', 'products.name', 'products.enum', 'products.weightable', 'products.packing_weight', 'products.storage','products.packing_size')
        ->get();

        $this->products = $products;
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        return view('exports.stocktaking', [
            'products' => $this->products,
        ]);
    }
}
