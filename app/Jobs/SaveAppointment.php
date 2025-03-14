<?php

namespace App\Jobs;

use App\Mail\SaveAppointment as MailSaveAppointment;
use App\Mail\SaveAppointmentEmployee;
use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SaveAppointment implements ShouldQueue
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
        $appointment->load('service', 'employee', 'customer');
        $customerEmail = $appointment['customer']['email'];
        $employeeEmail = $appointment['employee']['email'];
        Mail::to($customerEmail)->send(new MailSaveAppointment($appointment));
        Mail::to($employeeEmail)->send(new SaveAppointmentEmployee($appointment));
    }
}
