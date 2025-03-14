<?php

namespace App\Http\Controllers;

use App\Enums\Picklist;
use App\Jobs\SendOrderEmail;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\OrderPaymentHistory;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\SalesOrder;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SalesOrderController extends Controller 
{
    
    public function list(Request $request) 
    {
        $entryData = SalesOrder::select();

        if ($request->has('order_code')) {
            $entryData->where('order_code', 'like', '%' . $request->get('order_code') . '%');
        }
        if ($request->has('netTotal')) {
            $entryData->where('netTotal', 'like', '%' . $request->get('netTotal') . '%');
        }
        if ($request->has('customer_name')) {
            $entryData->whereHas('customer', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('customer_name') . '%');
            });
        }
        if ($request->has('status')) {
            $entryData->where('status', 'like', '%' . $request->get('status') . '%');
        }
        if ($request->has('created_at') && $request->get('created_at') != '') {
            $entryData->whereDate('created_at', $request->get('created_at'));
        }
        if ($request->has('updated_at') && $request->get('updated_at') != '') {
            $entryData->whereDate('updated_at', $request->get('updated_at'));
        }

        $entryData = $entryData->orderBy('updated_at', 'desc')->paginate(10);
        $data = ['entry_data' => $entryData];

        return view('salesorder.list', $data);
    }

    public function create() 
    {
        $data = [
            'services' => Service::all(),
            'products' => Product::all(),
        ];

        return view('salesorder.create', $data);
    }

    public function store(Request $request) 
    {
        if (!$request->ajax()) {
            throw new Exception('Bad Request', 400);
        }

        DB::beginTransaction();
        $customerInfo = $request->input('customer_info');
        $inventories = $request->input('entry_list');
        $totalPrice = $request->input('total_price');
        $orderPayment =  $request->input('order_payment');
        $userId = auth()->user()->id;

        $customer = Customer::where('email', $customerInfo['email'])
                    ->orWhere('name', $customerInfo['customer_name'])
                    ->where('phone', $customerInfo['phone'])
                    ->first();

        if (!$customer instanceof Customer) {
            $customer = new Customer();
            $customer->customer_code = $this->getCode(Customer::class, Customer::$codePrefix);
            $customer->name = $customerInfo['customer_name'];
            $customer->phone = $customerInfo['phone'];
            $customer->email = $customerInfo['email'];
            $customer->save();
        }

        // Save Order
        $paymentStatus = $this->getPaymentStatus($totalPrice['total_order'], $orderPayment['paymentMoney']);
        $salesOrder = new SalesOrder();
        $salesOrder->order_code = $this->getCode(SalesOrder::class, SalesOrder::$codePrefix);
        $salesOrder->customer_id = $customer->id;
        $salesOrder->netTotal = $totalPrice['total_order'];
        $salesOrder->discount = $totalPrice['order_discount'];
        $salesOrder->tax = $totalPrice['order_tax'];
        $salesOrder->payment_status = $paymentStatus;
        $salesOrder->created_by_id = $userId;
        $salesOrder->save();

        // Save Order Payment
        $orderPaymentHistory = new OrderPaymentHistory();
        $orderPaymentHistory->salesorder_id = $salesOrder->id;
        $orderPaymentHistory->customer_id = $customer->id;
        $orderPaymentHistory->amount = $orderPayment['paymentMoney'];
        $orderPaymentHistory->netTotal = $totalPrice['total_order'];
        $orderPaymentHistory->payment_method = $orderPayment['paymentMethod'];
        $orderPaymentHistory->created_by_id = $userId;
        $orderPaymentHistory->save();

        // Save inventory
        foreach ($inventories as $item) {
            $inventory = new Inventory();
            $inventory->module = 'SalesOrder';
            $inventory->module_id = $salesOrder->id;
            $inventory->lineitem_id = $item['id'];
            $inventory->lineitem_type = $item['entry_type'];
            $inventory->price = $item['order_price'];;
            $inventory->quantity = $item['quantity'];
            $inventory->save();
        }

        foreach ($inventories as $value) {
            if ($value['entry_type'] == 'service') continue;
            $productStock = new ProductStock();
            $productStock->product_id = $value['id'];
            $productStock->quantity = $value['quantity'];
            $productStock->stock_type = 'export';
            $productStock->created_by_id = $userId;
            $productStock->description = 'Export_order';
            $productStock->save();
        }

        DB::commit();
        dispatch(new SendOrderEmail($salesOrder));
        $salesOrder = $salesOrder->toArray();
        $salesOrder['id'] = Crypt::encrypt($salesOrder['id']);

        return response()->json(['message' => 'Create salesorder success', 'data' => $salesOrder], 200);     
    }

    public function detail($id) 
    {
        $idDecode = Crypt::decrypt($id);
        $entryData = SalesOrder::where(['id' => $idDecode])->first();
        $entryData->hash_id = Crypt::encrypt($entryData->id);
        $data = [
            'services' => Service::all(),
            'products' => Product::all(),
            'entry_data' => $entryData
        ];

        return view('salesorder.detail', $data);
    }

    public function getCustomerInfo(Request $request) 
    {
        if (!$request->ajax()) {
            return response()->json(['message' => 'Bad Request'], 400);
        }

        $customer = Customer::where('id', $request->customer_id)->first(['name', 'phone', 'email']);

        return response()->json($customer, 200);
    }

    public function getInventoryList(Request $request) 
    {
        if (!$request->ajax()) {
            return response()->json(['message' => 'Bad Request'], 400);
        }

        $productInventory = Inventory::join('products', 'products.id', '=', 'inventory.lineitem_id')
            ->where('inventory.module', 'SalesOrder')
            ->where('inventory.module_id', $request->sales_order_id)
            ->where('inventory.lineitem_type', 'product')
            ->get(['inventory.id', 'products.product_name', 'inventory.quantity', 'inventory.price as order_price', 'products.price', 'inventory.lineitem_type as entry_type'])
            ->toArray();
        
        $serviceInventory = Inventory::join('services', 'services.id', '=', 'inventory.lineitem_id')
            ->where('inventory.module', 'SalesOrder')
            ->where('inventory.module_id', $request->sales_order_id)
            ->where('inventory.lineitem_type', 'service')
            ->get(['inventory.id', 'services.service_name', 'inventory.quantity', 'inventory.price as order_price', 'services.price', 'inventory.lineitem_type as entry_type'])
            ->toArray();

        $inventory = array_merge($productInventory, $serviceInventory);

        return response()->json($inventory, 200);
    }

    private function getPaymentStatus($netTotal, $paymentMoney) 
    {
        $paymentStatus = 'Unpaid';

        if ($netTotal == $paymentMoney) {
            $paymentStatus = 'Paid';
        }
        if ($netTotal > $paymentMoney) {
            $paymentStatus = 'Partially Paid';
        }

        return $paymentStatus;
    }

    public function info($id) 
    {
        $idDecode = Crypt::decrypt($id);
        $entryData = SalesOrder::where(['id' => $idDecode])->first();
        $entryData->load('customer', 'user');
        $entryData->setAttribute('inventory', $entryData->getInventoyAttribute());
        $entryData->setAttribute('payment_amount', $entryData->getTotalPaymentAmountAttribute());

        $data = [
            'services' => Service::all(),
            'products' => Product::all(),
            'entry_data' => $entryData
        ];

        return view('salesorder.info', $data);
    }

    public function getPaymentHistory($id) 
    {
        $idDecode = Crypt::decrypt($id);
        $entryData = SalesOrder::where(['id' => $idDecode])->first();
        $entryData->load('paymentHistory');
        $paymentHistory = $entryData->paymentHistory;
        $paymentHistory = $paymentHistory->map(function($item) {
            return [
                'id' => Crypt::encrypt($item['id']),
                'amount' => number_format($item['amount']),
                'payment_method' => Picklist::getPicklistValue('salesorder', 'payment_method',  $item['payment_method']),
                'created_at' => date('d/m/Y H:i', strtotime($item['created_at'])),
            ];
        });

       return response()->json(['message' => 'Get payment history success', 'data' => $paymentHistory], 200);
    }
}
