<div class="invoice-address-row mt-2">

    <!-- From Address Card -->
    <div class="addr-card bg-blue">
        <input type="hidden" name="user_state_id" id="user_state_id" value="{{ setting('state_id') }}">

        <div class="addr-card-header">
            <span class="addr-label">From</span>

            <a href="{{ route('settings.edit') }}" target="_blank" class="addr-action-link">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </div>

        <div class="addr-body">
            @if(!empty($setting->company_name ?? '' ))
                <strong>{{ $setting->company_name ?? '' }}</strong><br>
            @endif

            @if(!empty($setting->address_1 ?? '' ))
                {{ $setting->address_1 ?? '' }}<br>
            @endif

            @if(!empty($setting->address_2 ?? '' ))
                {{ $setting->address_2 ?? '' }}<br>
            @endif

            @if(!empty($setting->state->state_name ?? ''))
                {{ $setting->state->state_name ?? ''  }}
            @endif

            @if(!empty($setting->country->country_name ?? ''))
                {{ $setting->country->country_name ?? ''  }}
            @endif

            @if(!empty($setting->pincode ?? '' ))
                {{ $setting->pincode ?? '' }}
            @endif
        </div>
    </div>

    <!-- Client -->
    <div class="addr-card bg-blue">

        <div class="addr-card-header">

            <span class="addr-label required">To</span>

            <div>

                <a href="{{ route('client.add') }}"
                   target="_blank"
                   class="addr-action-link clientActionBtn new-client"
                   id="new-client-btn"
                   style="display:none;">

                    <i class="bi bi-plus-lg"></i>
                    New Client

                </a>

                <a href="#"
                   onclick="event.preventDefault()"
                   class="addr-action-link clientActionBtn change-client">

                    <i class="bi bi-arrow-repeat"></i>
                    Change

                </a>

            </div>

        </div>

        <div id="clientSearchBox">

            <input
                type="text"
                class="form-control"
                id="client"
                name="client_name"
                placeholder="Search client by name, email or phone"
                autocomplete="off">

            <input type="hidden" id="client_id" name="client_id">
            <input type="hidden" id="client_state_id" name="client_state_id">

            <div
                id="clientList"
                class="list-group w-100 z-3"
                style="display:none;max-height:220px;overflow:auto;">
            </div>

        </div>

        <div id="clientAddress" style="display:none;"></div>

    </div>

</div>