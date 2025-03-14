<?php

namespace App\Http\Controllers;

use App\Jobs\SaveAppointment;
use App\Mail\SaveAppointment as MailSaveAppointment;
use App\Mail\SaveAppointmentEmployee;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function list()
    {
        $customers = Customer::all();
        $customers = $customers->map(function ($customer) {
            return [
                'id' => Crypt::encrypt($customer['id']),
                'name' => implode(' - ', [$customer['customer_code'], $customer['name']])
            ];
        });

        $services = Service::all();
        $services = $services->map(function ($service) {
            return [
                'id' => Crypt::encrypt($service['id']),
                'name' => implode(' - ', [$service['service_code'], $service['service_name']])
            ];
        });

        $employees = Employee::all();
        $employees = $employees->map(function ($employee) {
            return [
                'id' => Crypt::encrypt($employee['id']),
                'name' => implode(' - ', [$employee['employee_code'], $employee['name']]),
            ];
        });

        $appointments = Appointment::all();
        $appointments = $appointments->map(function ($appointment) {
            $appointment['id'] = Crypt::encrypt($appointment['id']);
            $appointment['service_id'] = Crypt::encrypt($appointment['service_id']);
            $appointment['customer_id'] = Crypt::encrypt($appointment['customer_id']);
            $appointment['created_by_id'] = Crypt::encrypt($appointment['created_by_id']);
            return $appointment;
        });

        $status = [
            'confirmed' => 'Đã xác nhận',
            'inprocess' => 'Đang tiến hành',
            'completed' => 'Đã xong',
        ];

        $data = [
            'customers' => $customers,
            'services' => $services,
            'employees' => $employees,
            'appointments' => $appointments,
            'status' => $status,
        ];

        return view('appointment.list', $data);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'customer_id' => 'required',
            'service_id' => 'required',
            'start_date' => 'required',
            'status' => 'required',
            'created_by_id' => 'required',
        ]);

        $customerId = Crypt::decrypt($request->input('customer_id'));
        $serviceId = Crypt::decrypt($request->input('service_id'));
        $startDate = $request->input('start_date');
        $status = $request->input('status');
        $assignedEmployeeId = Crypt::decrypt($request->input('created_by_id'));
        $service = Service::find($serviceId);
        $endDate = $startDate;
        $serviceDurations = explode(' |##| ', $service['duration']);

        if (count($serviceDurations) > 0) {
            $serviceDurationNum = $serviceDurations[0];
            $serviceDurationType = $serviceDurations[1];
            $time = new Carbon($startDate);

            switch ($serviceDurationType) {
                case 'hour':
                    $time = $time->addHours($serviceDurationNum);
                    break;

                case 'minute':
                    $time = $time->addMinutes($serviceDurationNum);
                    break;
                
                case 'day':
                    $time = $time->addDays($serviceDurationNum);
                    break;
            }

            $endDate = $time->format('Y-m-d H:i:s');
        }
       
        if ($startDate == $endDate) {
            return response()->json([
                'message' => 'service duration invalid',
                'data' => null
            ], 400);
        }

        $appointment = new Appointment();
        $appointment['title'] = $request->input('title');
        $appointment['customer_id'] = $customerId;
        $appointment['service_id'] = $serviceId;
        $appointment['start_date'] = $startDate;
        $appointment['end_date'] = $endDate;
        $appointment['status'] = $status;
        $appointment['created_by_id'] = $assignedEmployeeId;
        $appointment['note'] = $request->input('note', '');
        $appointment->save();
        dispatch(new SaveAppointment($appointment));
        $appointment = $appointment->toArray();
        $appointment['id'] = Crypt::encrypt($appointment['id']);
        $appointment['customer_id'] = Crypt::encrypt($appointment['customer_id']);
        $appointment['service_id'] = Crypt::encrypt($appointment['service_id']);
        $appointment['created_by_id'] = Crypt::encrypt($appointment['created_by_id']);

        return response()->json([
            'message' => 'Create appointment successfully',
            'data' => $appointment
        ], 200);
    }
}
