<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Models\Product;
use App\Models\SaleDetail;
use Illuminate\Http\Request;

class SaleDetailController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('custom.auth');
    }
    
    public function obtenerProducto($id)
    {
        $product = Product::where('id', $id)->first();
        return response()->json(['product' => $product]);
    }

    public function actualizarSaleDetail(Request $request)
    {
        if ($request->input('id')) {
            $sale_detail_db = SaleDetail::where('id', $request->input('id'))->first();

            $sale_detail_db->product_id = $request->input('product_id');
            $sale_detail_db->product_name = $request->input('product_name');
            $sale_detail_db->detail_quantity = $request->input('detail_quantity');
            $sale_detail_db->detail_unit_price_sell = $request->input('detail_unit_price_sell');
            $sale_detail_db->detail_unit_price_buy = $request->input('detail_unit_price_buy');

            $sale_detail_db->save();
        } else {
            $saleDetail = new SaleDetail([
                "sale_id" => $request->input('sales_id'),
                "product_id" => $request->input('product_id'),
                "product_name" => $request->input('product_name'),
                "detail_quantity" => $request->input('detail_quantity'),
                "detail_unit_price_sell" => $request->input('detail_unit_price_sell'),
                "detail_unit_price_buy" => $request->input('detail_unit_price_buy'),
            ]);

            $saleDetail->save();
        }
    }

    public function borrarSaleDetail(Request $request) {
        $sale_detail = SaleDetail::where('id', $request->input('id'))->first();

        $sale_detail->delete();
    }

}
