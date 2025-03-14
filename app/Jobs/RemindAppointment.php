<?php

namespace App\Jobs;

use App\Mail\RemindAppointment as MailRemindAppointment;
use App\Mail\RemindAppointmentEmployee;
use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RemindAppointment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $appointment;

    /**
     * Create a new job instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $appointment = $this->appointment;
        $appointment->load('employee', 'service', 'customer');
        $customerEmail = $appointment['customer']['email'];
        $employeeEmail = $appointment['employee']['email'];
        Mail::to($customerEmail)->send(new MailRemindAppointment($appointment));
        Mail::to($employeeEmail)->send(new RemindAppointmentEmployee($appointment));

        $appointment->update(['notified' => 1]);
        Log::info("Đã gửi nhắc hẹn cho khách hàng: " . $customerEmail);
        Log::info("Đã gửi nhắc hẹn cho nhân viên: " . $employeeEmail);
    }
}
