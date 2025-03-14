<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CustomerController extends Controller
{

    public function getList(Request $request)
    {
        $customers = Customer::select();

        if ($request->has('customer_code')) {
            $customers = $customers->where('customer_code', 'like', '%' . $request->input('customer_code') . '%');
        }
        if ($request->has('name')) {
            $customers = $customers->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->has('email')) {
            $customers = $customers->where('email', 'like', '%' . $request->input('email') . '%');
        }
        if ($request->has('phone')) {
            $customers = $customers->where('phone', 'like', '%' . $request->input('phone') . '%');
        }

        $customers = $customers->orderBy('updated_at', 'desc')->paginate(10);
        return view('customer.list', ['customers' => $customers]);
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['message' => 'Bad Request'], 400);
        }

        $customer = new Customer();
        $customer->customer_code = $this->getCode(Customer::class, Customer::$codePrefix);
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->save();
        $customer = $customer->toArray();
        $customer['id'] = Crypt::encrypt($customer['id']);

        return response()->json(['message' => 'Create customer success', 'data' => $customer], 200);
    }

    public function edit($id)
    {
        $idDecode = Crypt::decrypt($id);
        $customer = Customer::find($idDecode);

        return view('customer.edit', ['entry_data' => $customer]);
    }

    public function getCustomerList(Request $request) 
    {
        if (!$request->ajax()) {
            return response()->json(['message' => 'Bad Request'], 400);
        }

        $keyword = '%' . $request->keyword . '%';
        $customers = Customer::where('customer_code', 'like', $keyword)
            ->orWhere('name', 'like', $keyword)
            ->get(['customer_code', 'name', 'phone', 'email']);

        return response()->json($customers, 200);
    }

    public function detail($id) {
        $idDecode = Crypt::decrypt($id);
        $customer = Customer::where('id', $idDecode)->first();
        
        return view('customer.detail', ['entry_data' => $customer]);
    }

    public function update($id, Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $idDecode = Crypt::decrypt($id);
        $customer = Customer::where('id', $idDecode)->first();

        if (!$customer instanceof Customer) {
            return response()->json(['message' => 'Bad request'], 400);
        }

        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->save();
        $customer = $customer->toArray();
        $customer['id'] = Crypt::encrypt($customer['id']);
    
        return response()->json(['message' => 'Update success', 'data' => $customer], 200);
    }

    public function delete(Request $request) {
        $recordId = $request->input('entry_id');
        $recordIdDecode = Crypt::decrypt($recordId);
        $customer = Customer::where('id', $recordIdDecode)->first();

        if (!$customer instanceof Customer) {
            return response()->json(['message' => 'Bad request'], 400);
        }

        // Delete all Order by customer id
        SalesOrder::where('customer_id', $recordIdDecode)->delete();

        // Delete customer
        $customer->delete();
        $customer = $customer->toArray();
        $customer['id'] = Crypt::encrypt($customer['id']);
        
        return response()->json(['message' => 'Delete success', 'data' => $customer], 200);
    }
}