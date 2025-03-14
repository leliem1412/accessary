<?php

namespace App\Http\Controllers;

use App\Exports\AccessaryExport;
use App\Models\Accessary;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AccessaryController extends Controller
{
    public function index()
    {
        return view('accessary/show');
    }

    public function getMembers()
    {
        $accessaries = Accessary::with('supplier')->orderBy('id', 'desc')->get();

        return view('accessary/accessaryList', compact('accessaries'));
    }

    public function getDetail(Request $request)
    {
        $accessary = Accessary::find($request->id);
        $supplier = Supplier::get();
        return response([
            'accessary' => $accessary,
            'supplier' => $supplier,
        ]);
    }

    public function save(Request $request)
    {
        if ($request->ajax()) {
            // Create New Accessary
            $accessary = new Accessary;
            $accessary->name = $request->input('name');
            $accessary->price = $request->input('price');
            $accessary->quantityImport = $request->input('quantityImport');
            $accessary->quantityMin = $request->input('quantityMin');
            $accessary->quantityStock = $request->input('quantityImport');
            $accessary->supplier_id =  $request->input('supplierId');
            // Save Member
            $accessary->save();

            return response($accessary);
        }
    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {
            $accessary = Accessary::find($request->id);
            $accessary->delete();
        }
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $accessary = Accessary::find($request->id);
            if ($accessary) {
                $accessary->name = $request->input('name');
                $accessary->price = $request->input('price');
                $accessary->quantityMin = $request->input('quantityMin');
                $accessary->supplier_id =  $request->input('supplierId');

                $accessary->save();
            }

            return response($accessary);
        }
    }

    /* Update quantityExport */
    public function updateQuantityExport(Request $request)
    {
        if ($request->ajax()) {
            $validated = Validator::make($request->all(), [
                "id" => "required",
                "quantityExport" => "required",
            ]);
            if ($validated->failed()) {
                return response()->json([
                    "status" => false,
                    "data" => null,
                    "msg" => $validated
                ]);
            }
            $accessary = Accessary::find($request->id);
            if ($accessary) {
                // Tính số lượng tồn = Số lượng nhập - số lượng xuất
                $quantityExport = $accessary->quantityExport + (+$request->quantityExport);
                $quantityStock =  $accessary->quantityImport - $quantityExport;
                if ($quantityStock < 0) {
                    return response()->json([
                        "status" => false,
                        "data" => $accessary,
                        "msg" => "Số lượng xuất không hợp lệ"
                    ]);
                }
                // Lưu dữ liệu
                $accessary->quantityExport = $quantityExport;
                $accessary->quantityStock = $quantityStock;
                $accessary->save();
                return response()->json([
                    "status" => true,
                    "data" => $accessary,
                    "msg" => "Xuất kho thành công"
                ]);
            }
            return response($accessary);
        }
    }

    /* Update quantityExport */
    public function updateQuantityImport(Request $request)
    {
        if ($request->ajax()) {
            $validated = Validator::make($request->all(), [
                "id" => "required",
                "quantityImport" => "required",
            ]);
            if ($validated->failed()) {
                return response()->json([
                    "status" => false,
                    "data" => null,
                    "msg" => $validated
                ]);
            }
            $accessary = Accessary::find($request->id);
            if ($accessary) {
                // Tính số lượng tồn = Số lượng nhập - số lượng xuất
                $quantityImport = $accessary->quantityImport + (+$request->quantityImport);
                $quantityStock =  $quantityImport - $request->quantityExport;
                if ($quantityStock < 0) {
                    return response()->json([
                        "status" => false,
                        "data" => $accessary,
                        "msg" => "Số lượng nhập không hợp lệ"
                    ]);
                }
                // Lưu dữ liệu
                $accessary->quantityImport = $quantityImport;
                $accessary->quantityStock = $quantityStock;
                $accessary->save();
                return response()->json([
                    "status" => true,
                    "data" => $accessary,
                    "msg" => "Nhập kho thành công"
                ]);
            }
            return response($accessary);
        }
    }

    public function exportExcelAccessary() {
        return Excel::download(new AccessaryExport, 'accessary.xlsx');
    }
}
