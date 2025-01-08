<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Console\Command;

class CreateInvoiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create invoice for bookings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating invoice for bookings started');

        $bookings = Booking::where('created_at', '<', now()->subDays(30))->chunkById(100, function ($bookings) {
            foreach ($bookings as $booking) {
                $invoice = Invoice::firstOrCreate([
                    'booking_id' => $booking->id,
                ], [
                    'amount' => $booking->total_amount,
                    'status' => 'not payed'
                ]);
            }
        });

        $this->warn('some danger message here');
        $this->info('Invoice creating finished');
    }
}
