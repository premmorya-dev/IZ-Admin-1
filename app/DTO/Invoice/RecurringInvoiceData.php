<?php

namespace App\DTO\Invoice;

use Carbon\Carbon;
use Illuminate\Http\Request;

class RecurringInvoiceData
{
    public $frequency;
    public $dayOfMonth;
    public $dayOfWeek;
    public $monthOfYear;
    public $yearlyDayOfMonth;
    public $timeOfDay;

    public static function fromRequest(Request $request): ?self
    {
        if (! $request->boolean('is_recurring')) {
            return null;
        }

        $dto = new self();
        $dto->frequency = $request->input('frequency');
        $dto->dayOfMonth = $request->input('day_of_month');
        $dto->dayOfWeek = $request->input('day_of_week');
        $dto->monthOfYear = $request->input('month_of_year');
        $dto->yearlyDayOfMonth = $request->input('yearly_day_of_month');
        $dto->timeOfDay = $request->input('time_of_day');

        return $dto;
    }

    public function toDatabaseAttributes(int $invoiceId, int $userId, bool $includeTimestamps = true): array
    {
        $attributes = [
            'invoice_id' => $invoiceId,
            'user_id' => $userId,
            'frequency' => $this->frequency,
            'day_of_month' => null,
            'day_of_week' => null,
            'month_of_year' => null,
            'time_of_day' => null,
            'status' => 'active',
        ];

        if ($this->frequency === 'monthly') {
            $attributes['day_of_month'] = $this->dayOfMonth;
        } elseif ($this->frequency === 'weekly') {
            $attributes['day_of_week'] = $this->dayOfWeek;
        } elseif ($this->frequency === 'yearly') {
            $attributes['month_of_year'] = $this->monthOfYear;
            $attributes['day_of_month'] = $this->yearlyDayOfMonth;
        }

        if (!empty($this->timeOfDay)) {
            $attributes['time_of_day'] = Carbon::createFromFormat('H:i', $this->timeOfDay, 'Asia/Kolkata')
                ->setTimezone('UTC')
                ->toDateTimeString();
        }

        if ($includeTimestamps) {
            $attributes['created_at'] = Carbon::now('UTC')->format('Y-m-d H:i:s');
        }

        $attributes['updated_at'] = Carbon::now('UTC')->format('Y-m-d H:i:s');

        return $attributes;
    }
}
