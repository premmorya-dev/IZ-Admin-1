<!-- Recurring options wrapper -->
<div id="recurringOptions" style="display: none;" class="row">

    <!-- Frequency -->
    <div class="col-md-4 mt-3">
        <label for="frequency" class="form-label">
            <span class="icon-badge icon-badge--purple">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 1l4 4-4 4" />
                    <path d="M3 11V9a4 4 0 0 1 4-4h14" />
                    <path d="M7 23l-4-4 4-4" />
                    <path d="M21 13v2a4 4 0 0 1-4 4H3" />
                </svg>
            </span>
            Frequency
        </label>
        <select name="frequency" id="frequency" class="form-select">
            <option value="monthly" {{ old('frequency', $data['recurring']->frequency ?? '') == 'monthly' ? 'selected' : '' }}>Monthly</option>
            <option value="weekly" {{ old('frequency', $data['recurring']->frequency ?? '') == 'weekly' ? 'selected' : '' }}>Weekly</option>
            <option value="yearly" {{ old('frequency', $data['recurring']->frequency ?? '') == 'yearly' ? 'selected' : '' }}>Yearly</option>
        </select>
    </div>

    <!-- Monthly Day -->
    <div class="col-md-4 mt-3" id="monthlyDay">
        <label for="day_of_month" class="form-label">
            <span class="icon-badge icon-badge--blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="3" />
                    <path d="M16 2v4M8 2v4M3 10h18" />
                </svg>
            </span>
            Day of Month (1–31)
        </label>
        <select name="day_of_month" class="form-select">
            @for ($i = 1; $i <= 31; $i++)
                <option value="{{ $i }}"
                {{ old('day_of_month', $data['recurring']->day_of_month ?? '') == $i ? 'selected' : '' }}>
                {{ $i }}
                </option>
                @endfor
        </select>
    </div>

    <!-- Weekly Day -->
    <div class="col-md-4 mt-3" id="weeklyDay" style="display: none;">
        <label for="day_of_week" class="form-label">
            <span class="icon-badge icon-badge--green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="3" />
                    <path d="M16 2v4M8 2v4M3 10h18" />
                    <path d="M8 15h2M14 15h2" />
                </svg>
            </span>
            Day of Week
        </label>
        <select name="day_of_week" class="form-select">
            @foreach(['sunday','monday','tuesday','wednesday','thursday','friday','saturday'] as $day)
            <option value="{{ $day }}"
                {{ old('day_of_week', $data['recurring']->day_of_week ?? '') == $day ? 'selected' : '' }}>
                {{ ucfirst($day) }}
            </option>
            @endforeach
        </select>
    </div>

    <!-- Yearly Month + Day -->
    <div id="yearlySection" class="row" style="display: none;">
        <!-- Month -->
        <div class="col-md-4 mt-3">
            <label for="month_of_year" class="form-label">
                <span class="icon-badge icon-badge--pink">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="3" />
                        <path d="M16 2v4M8 2v4M3 10h18" />
                        <path d="M8 15h8" />
                    </svg>
                </span>
                Month of Year
            </label>
            <select name="month_of_year" class="form-select">
                @foreach([
                1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                ] as $num => $month)
                <option value="{{ $num }}"
                    {{ old('month_of_year', $data['recurring']->month_of_year ?? '') == $num ? 'selected' : '' }}>
                    {{ $month }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Day -->
        <div class="col-md-4 mt-3">
            <label for="yearly_day_of_month" class="form-label">
                <span class="icon-badge icon-badge--blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="3" />
                        <path d="M16 2v4M8 2v4M3 10h18" />
                    </svg>
                </span>
                Day of Month
            </label>
            <select name="yearly_day_of_month" class="form-select">
                @for ($i = 1; $i <= 31; $i++)
                    <option value="{{ $i }}"
                    {{ old('yearly_day_of_month', $data['recurring']->day_of_month ?? '') == $i ? 'selected' : '' }}>
                    {{ $i }}
                    </option>
                    @endfor
            </select>
        </div>
    </div>

    <!-- Time Picker -->
    <div class="col-md-4 mt-3">
        <label for="time_of_day" class="form-label">
            <span class="icon-badge icon-badge--orange">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="9" />
                    <path d="M12 7v5l3 3" />
                </svg>
            </span>
            Time to Generate
        </label>
        @php
        $time = old('time_of_day', isset($data['recurring']->time_of_day)
        ? \Carbon\Carbon::parse($data['recurring']->time_of_day)->setTimezone('Asia/Kolkata')->format('H:i')
        : '09:00');
        @endphp
        <input type="time" name="time_of_day" class="form-control" value="{{ $time }}">
    </div>

</div>