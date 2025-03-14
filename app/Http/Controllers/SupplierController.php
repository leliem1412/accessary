<?php

namespace App\Http\Controllers;

use App\Models\Accessary;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        return view('supplier/show');
    }

    public function getMembers()
    {
        $suppliers = Supplier::orderBy('id', 'desc')->get();

        return view('supplier/supplierList', compact('suppliers'));
    }

    public function getList()
    {
        $suppliers = Supplier::orderBy('id', 'desc')->get();

        return response($suppliers);
    }

    public function getDetail(Request $request)
    {
        $supplier = Supplier::find($request->id);
        return response($supplier);
    }

    public function save(Request $request)
    {
        if ($request->ajax()) {
            // Create New Accessary
            $supplier = new Supplier;
            $supplier->name = $request->input('name');
            $supplier->description = $request->input('description');
            // Save Member
            $supplier->save();

            return response($supplier);
        }
    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {
            $supplier = Supplier::find($request->id);
            $supplier->delete();
        }
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $supplier = Supplier::find($request->id);
            $supplier->name = $request->input('name');
            $supplier->description = $request->input('description');
            $supplier->update();
            return response($supplier);
        }
    }
}
