<?php

namespace App\Console\Commands;

use App\Jobs\RemindAppointment;
use App\Models\Appointment;
use Illuminate\Console\Command;

class SendReminderNotifications extends Command
{
    protected $signature = 'reminder:send';
    protected $description = 'Gửi thông báo nhắc nhở lịch hẹn trước 1 tiếng';

    public function handle()
    {
        $startDate = date('Y-m-d H:i:s');
        $endDate = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $appointments = Appointment::whereBetween('start_date', [$startDate, $endDate])
            ->where('notified', 0)
            ->get();

        foreach ($appointments as $appointment) {
           dispatch(new RemindAppointment($appointment));
        }

        $this->info("Hoàn thành gửi thông báo.");
    }
}
