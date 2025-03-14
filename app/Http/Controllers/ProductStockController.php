<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;

class ProductStockController extends Controller {
    
    public function list(Request $request) {
        $productStock = ProductStock::select();

        if ($request->has('product_name')) {
            $productStock->whereHas('product', function ($query) use ($request) {
                $query->where('product_name', 'like', '%' . $request->product_name . '%');
            });
        }
        if ($request->has('quantity')) {
            $productStock->where('quantity', 'like', '%' . $request->quantity . '%');
        }
        if ($request->has('stock_type')) {
            $productStock->where('stock_type', 'like', '%' . $request->stock_type . '%');
        }
        if ($request->has('description')) {
            $productStock->where('description', 'like', '%' . $request->description . '%');
        }
        if ($request->has('created_at') && $request->get('created_at') != '') {
            $productStock->whereDate('created_at', $request->created_at);
        }
        if ($request->has('user_name')) {
            $productStock->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        $productStock = $productStock->orderBy('updated_at', 'desc')->paginate(10);
        $productList = Product::get(['id', 'product_code', 'product_name']);

        $data = [
            'entry_data' => $productStock,
            'product_list' => $productList,
        ];

        return view('productStock.list', $data);
    }

    public function store(Request $request) {
        if (!$request->ajax()) {
            return response()->json(['message' => 'Bad Request'], 400);
        }

        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
            'stock_type' => 'required',
        ]);

        $userId =  auth()->user()->id;

        $productStock = new ProductStock();
        $productStock->product_id = $request->product_id;
        $productStock->quantity = $request->quantity;
        $productStock->stock_type = $request->stock_type;
        $productStock->created_by_id = $userId;
        $productStock->description = 'User_generated_content';
        $productStock->save();

        return response()->json(['message' => 'Lưu thành công', 'data' => $productStock], 200);
    }

    public function getProductInfo(Request $request) {
        if (!$request->ajax()) {
            return response()->json(['message' => 'Bad Request'], 400);
        }

        $request->validate([
            'product_id' => 'required',
        ]);

        $product = Product::find($request->product_id);
        $quantity = $product->getQuantityAttribute();
        $data = [
            'product_code' => $product->product_code,
            'product_name' => $product->product_name,
            'quantity' => $quantity,
            'quantity_format' => number_format($quantity),
        ];

        return response()->json(['message' => 'Lấy thông tin sản phẩm thành công', 'data' => $data], 200);

    }
}
