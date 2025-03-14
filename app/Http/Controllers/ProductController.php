<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProductController extends Controller {

    public function list(Request $request) {
        
        $product = Product::select();

        if ($request->has('product_code')) {
            $product->where('product_code', 'like', '%' . $request->input('product_code') . '%');
        }

        if ($request->has('product_name')) {
            $product->where('product_name', 'like', '%' . $request->input('product_name') . '%');
        }

        if ($request->has('price')) {
            $product->where('price', 'like', '%' . $request->input('price') . '%');
        }

        if ($request->has('product_category')) {
            $product->where('product_category', 'like', '%' . $request->input('product_category') . '%');
        }

        $product = $product->orderBy('updated_at', 'desc')->paginate(10);
        $data = ['entry_data' => $product];

        return view('product.list', $data);
    }

    public function create() {
        return view('product.create');
    }

    public function store(Request $request) {
        if (!$request->ajax()) {
            return response()->json(['message' => 'Bad Request'], 400);
        }

        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'product_image' => 'required|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

       // Save product image to storage
        $productImage = $request->file('product_image');
        $productImagePath = $productImage->store('uploads', 'public');

        // Create new product
        $product = new Product();
        $product->image = $productImagePath;
        $product->product_code = $this->getCode(Product::class, Product::$codePrefix);
        $product->product_name = $request->input('product_name');
        $product->price = $request->input('price');
        $product->status = 1;
        $product->product_category = $request->input('product_category');
        $product->save();
        $product = $product->toArray();
        $product['id'] = Crypt::encrypt($product['id']);

        return response()->json(['message' => 'Create customer success', 'data' => $product], 200);
    }

    public function detail($id) {
        $idDecode = Crypt::decrypt($id);
        $product = Product::where('id', $idDecode)->first();
        $product = $product->toArray();
        $product['id'] = Crypt::encrypt($product['id']);
        
        return view('product.detail', ['entry_data' => $product]);
    }

    public function edit($id) {
        $idDecode = Crypt::decrypt($id);
        $product = Product::where('id', $idDecode)->first();
        $product = $product->toArray();
        $product['id'] = Crypt::encrypt($product['id']);
        
        return view('product.edit', ['entry_data' => $product]);
    }

    public function update($id, Request $request) {
        if (!$request->ajax()) {
            return response()->json(['message' => 'Bad Request'], 400);
        }

        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
        ]);

        $idDecode = Crypt::decrypt($id);
        $product = Product::where('id', $idDecode)->first();

        if ($request->hasFile('product_image')) {
             // Save product image to storage
            $productImage = $request->file('product_image');
            $productImagePath = $productImage->store('uploads', 'public');
            $product->image = $productImagePath;
        }

        $product->product_name = $request->input('product_name');
        $product->price = $request->input('price');
        $product->status = 1;
        $product->product_category = $request->input('product_category');
        $product->save();
        $product = $product->toArray();
        $product['id'] = Crypt::encrypt($product['id']);
        
        return response()->json(['message' => 'Update success', 'data' => $product], 200);
    }
}
