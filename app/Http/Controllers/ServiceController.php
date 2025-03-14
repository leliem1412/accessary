<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ServiceController extends Controller {

    public function list(Request $request) {
        $entryData = Service::select();

        if ($request->has('service_code')) {
            $entryData->where('service_code', 'like', '%' . $request->input('service_code') . '%');
        }

        if ($request->has('service_name')) {
            $entryData->where('service_name', 'like', '%' . $request->input('service_name') . '%');
        }

        if ($request->has('price')) {
            $entryData->where('price', 'like', '%' . $request->input('price') . '%');
        }

        if ($request->has('service_category')) {
            $entryData->where('service_category', 'like', '%' . $request->input('service_category') . '%');
        }

        $entryData = $entryData->orderBy('updated_at', 'desc')->paginate(10);
        $data = ['entry_data' => $entryData];

        return view('service.list', $data);
    }

    public function create() {
        return view('service.create');
    }

    public function store(Request $request) {
        if (!$request->ajax()) {
            return response()->json(['message' => 'Bad Request'], 400);
        }

        $request->validate([
            'service_name' => 'required',
            'price' => 'required',
            'duration' => 'required',
            'duration_type' => 'required',
            'service_image' => 'required|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

       // Save service image to storage
        $serviceImage = $request->file('service_image');
        $serviceImagePath = $serviceImage->store('uploads', 'public');
        $duration = implode(' |##| ', [$request['duration'], $request['duration_type']]);

        // Create new service
        $service = new Service();
        $service->service_code = $this->getCode(Service::class, Service::$codePrefix);
        $service->service_name = $request->input('service_name');
        $service->price = $request->input('price');
        $service->status = 1;
        $service->image = $serviceImagePath;
        $service->service_category = $request->input('service_category');
        $service->duration = $duration;
        $service->save();
        $service = $service->toArray();
        $service['id'] = Crypt::encrypt($service['id']);

        return response()->json(['message' => 'Create customer success', 'data' => $service], 200);
    }

    public function edit($id) {
        $idDecode = Crypt::decrypt($id);
        $record = Service::find($idDecode);
        $record = $record->toArray();
        $record['id'] = Crypt::encrypt($record['id']);

        return view('service.edit', ['record' => $record]);
    }

    public function detail($id) {
        $idDecode = Crypt::decrypt($id);
        $service = Service::where('id', $idDecode)->first();
        $service = $service->toArray();
        $service['id'] = Crypt::encrypt($service['id']);
        
        return view('service.detail', ['entry_data' => $service]);
    }

    public function update($id, Request $request) {
        $request->validate([
            'service_image' => 'required',
            'service_name' => 'required',
            'service_category' => 'required',
            'duration' => 'required',
            'duration_type' => 'required',
            'price' => 'required',
        ]);

        $idDecode = Crypt::decrypt($id);
        $serviceModel = Service::find($idDecode);
        $serviceModel->service_name = $request->input('service_name');
        $serviceModel->service_category = $request->input('service_category');
        $serviceModel->price = $request->input('price');
        $duration = implode(' |##| ', [$request['duration'], $request['duration_type']]);
        $serviceModel->duration = $duration;

        if ($request->hasFile('service_image')) {
           $serviceImage = $request->file('service_image');
           $serviceImagePath = $serviceImage->store('uploads', 'public');
           $serviceModel->image = $serviceImagePath;
        }

        $serviceModel->save();
        $serviceModel = $serviceModel->toArray();
        $serviceModel['id'] = Crypt::encrypt($serviceModel['id']);
        
        return response()->json(['message' => 'Update success', 'data' => $serviceModel], 200);
    }
}