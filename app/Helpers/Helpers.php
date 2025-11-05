<?php

use App\Models\SettingModel;
use Illuminate\Support\Facades\DB;
use MaxMind\Db\Reader;
use DeviceDetector\ClientHints;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;

function _________getCompanyImage($type = 'url', $user_id = Null)
{
    $userId =  $user_id ?? Auth::id();

    if (empty($userId) ||  !$userId || is_null($userId)) {
        throw new \Exception("Setting not found for user: " . $userId);
    }

    // Try to find the company settings by user ID
    $setting = SettingModel::where('user_id', $userId)->first();



    // Check if the setting and image exist
    if ($setting && !empty($setting->logo_path)) {
        return asset($setting->logo_path);
    }


    if ($type == 'path') {
        return $setting->logo_path;
    }
    // Return default image path
    return asset('logo.png');
}
function parseDateRange($dateTimeRange)
{
    // Split the range into start and end parts
    [$start, $end] = explode(" - ", $dateTimeRange);
    // Return the separated values as an array or JSON response
    return [
        'start_date' => $start,
        'end_date' => $end,
    ];
}

function parseDateTimeRange($dateTimeRange)
{
    // Split the range into start and end parts
    [$start, $end] = explode(" - ", $dateTimeRange);

    // Parse start date and time
    $startDateTime = explode(" ", $start);
    $startDate = $startDateTime[0]; // Start Date
    $startTime = $startDateTime[1]; // Start Time

    // Parse end date and time
    $endDateTime = explode(" ", $end);
    $endDate = $endDateTime[0]; // End Date
    $endTime = $endDateTime[1]; // End Time

    // Return the separated values as an array or JSON response
    return [
        'start_date' => $startDate,
        'start_time' => $startTime,
        'end_date' => $endDate,
        'end_time' => $endTime,
        'start_date_time' => $startDate . " " .  $startTime,
        'end_date_time' => $endDate . " " .  $endTime,
    ];
}

function convertToUTC($dateTime, $timezone = 'Asia/Kolkata')
{

    return Carbon::createFromFormat('Y-m-d', $dateTime, $timezone)

        ->setTimezone('UTC')

        ->toDateTimeString();
}

function convertToUTCDateOnly($dateTime, $timezone = 'Asia/Kolkata')
{

    return Carbon::createFromFormat('Y-m-d', $dateTime, $timezone)

        ->setTimezone('UTC')

        ->toDateString();
}

if (!function_exists('setting')) {
    function setting($key = null, $user_id = NULL, $default = null)
    {
        $userId =  $user_id ?? Auth::id(); // Optional: adjust if needed (e.g., for multi-tenant)

        $settings = SettingModel::where('user_id', $userId)->first();

        if (!$settings) {
            return $default;
        }

        if (is_null($key)) {
            return $settings;
        }

        return $settings->{$key} ?? $default;
    }
}

if (!function_exists('paymentKeys')) {
    function paymentKeys()
    {
        $keys = [];
        $payment_method = DB::table('payment_methods')->where('payment_method_id', 1)->first();

        if ($payment_method->mode == 'live') {
            $payment_key = json_decode($payment_method->live_config, false);
            $keys['public_key'] =  $payment_key->public_key;
            $keys['secret_key'] =  $payment_key->secret_key;
        } else {
            $payment_key = json_decode($payment_method->test_config, false);
            $keys['public_key'] =  $payment_key->public_key;
            $keys['secret_key'] =  $payment_key->secret_key;
        }

        return $keys;
    }
}


if (!function_exists('getShortcode')) {
    function getShortcode($type, $code, $userId = null)
    {
        $service = match ($type) {
            'invoice' => new \App\Services\InvoiceService(),
            'estimate' => new \App\Services\EstimateService(),
            default => null,
        };

        if (!$service) return [];

        $doc = $service->getDocumentData($code, $userId);


        if (!$doc) return [];

        $items = json_decode($doc->item_json, false) ?? [];
        $dynamicItemRow = $service->generateDynamicItemRows($items, $doc->currency_symbol);



        if (app()->runningInConsole()) {
            $qr_code_image = $doc->qr_base64;
            $signature_image = $doc->signature_base64;
            $logo_image = $doc->logo_base64;
            $userId =   $userId;
        } else {
            // Only execute this for web requests, not cron jobs          
            $qr_code_image = $doc->qr_base64;
            $signature_image = $doc->signature_base64;
            $logo_image =  $doc->logo_base64;
            $userId =   Auth::id();
        }
        

        $return_array =  [
            // Common placeholders
            '{{' . $type . '_id}}' => $doc->{$service->getAttribute('idField')},
            '{{' . $type . '_code}}' => $doc->{$service->getAttribute('codeField')},
            '{{' . $type . '_number}}' => $doc->{$service->getAttribute('numberField')},
            '{{' . $type . '_date}}' => Carbon::parse($doc->{$service->getAttribute('dateField')})->format(setting('date_format', $userId )),
            '{{' . $type . '_due_date}}' => Carbon::parse($doc->{$service->getAttribute('dueField')})->format(setting('date_format', $userId )),
            '{{' . $type . '_status}}' => $doc->status,
            '{{' . $type . '_template_id}}' => $doc->template_id,
            '{{' . $type . '_sub_total}}' => $doc->sub_total,
            '{{' . $type . '_total_tax}}' => $doc->total_tax,
            '{{' . $type . '_total_discount}}' => $doc->total_discount,
            '{{' . $type . '_grand_total}}' => $doc->grand_total,
             '{{' . $type . '_round_off}}' => $doc->round_off,
            '{{invoice_advance_payment}}' => $doc->advance_payment ?? 0,

            '{{' . $type . '_total_due}}' => $doc->total_due ?? 0,
            '{{' . $type . '_notes}}' => $doc->notes,
            '{{' . $type . '_terms}}' => $doc->terms,
            '{{' . $type . '_currency_code}}' => $doc->currency_code,
            '{{' . $type . '_currency_symbol}}' => $doc->currency_symbol,
            '{{' . $type . '_item_json}}' => $doc->item_json,
            '{{' . $type . '_dynamic_item_row}}' => $dynamicItemRow,
            '{{' . $type . '_download}}' => route("{$type}.download", [$service->getAttribute('codeField') => $doc->{$service->getAttribute('codeField')}]),
            '{{' . $type . '_accept_url}}' => url("/") . "/estimate/acceptance/" . $doc->{$service->getAttribute('codeField')} . "?acceptance=true",
            '{{' . $type . '_reject_url}}' => url("/") . "/estimate/acceptance/" . $doc->{$service->getAttribute('codeField')} . "?acceptance=false",

            // Client
            '{{client_name}}' => $doc->client_name,
            '{{client_company_name}}' => $doc->client_company_name ?? $doc->client_name ?? '',
            '{{client_email}}' => $doc->client_email ?? '',
            '{{client_phone}}' => $doc->phone ?? '',
            '{{client_address_1}}' => $doc->client_address_1 ?? '',
            '{{client_address_2}}' => $doc->client_address_2 ?? '',
            '{{client_city}}' => $doc->city ?? '',
            '{{client_state}}' => $doc->client_state,
            '{{client_country}}' => $doc->client_country,
            '{{client_zip}}' => $doc->zip ?? '',
            '{{client_gst_number}}' => $doc->client_gst_number ?? '',
            '{{show_client_gst_number}}' => !empty($doc->client_gst_number) ? 'Gstin:' . $doc->client_gst_number : '',


            // User
            '{{user_id}}' => $doc->user_id,
            '{{user_logo_path}}' => $doc->logo_path,
            '{{user_logo_path_base64_pdf}}' => $doc->logo_base64,
            '{{user_mobile_no}}' => !empty($doc->mobile_no) ? $doc->country_code . " " . $doc->mobile_no : '',
            '{{user_email}}' => $doc->email ?? '',
            '{{user_company_name}}' => ucfirst($doc->user_company_name) ?? '',
            '{{user_address_1}}' => $doc->user_address_1 ?? '',
            '{{user_address_2}}' => $doc->user_address_2 ?? '',
            '{{user_state}}' => $doc->user_state,
            '{{user_country}}' => $doc->user_country,
            '{{user_qrcode_image}}' => $qr_code_image ?? '',
            '{{user_signature_image}}' => $signature_image,
            '{{user_gst_number}}' => $doc->user_gst_number ?? '',
            '{{show_user_gst_number}}' => !empty($doc->user_gst_number) ? 'Gstin:' . $doc->user_gst_number : '',

            '{{user_pincode}}' =>  $doc->pincode ?? '',
            '{{user_logo_image}}' => $logo_image
        ];



        return $return_array;
    }
}

if (!function_exists('shortcode')) {
    function shortcode($type, $code, $message, $userId = null)
    {
        $replace = getShortcode($type, $code, $userId);
        $message = replaceTagWithValue($message, $replace);

        // Clean up message
        $message = mb_convert_encoding($message, 'UTF-8', 'auto');
        $message = preg_replace('/\xA0/u', ' ', $message);
        $message = str_replace("\xc2\xa0", ' ', $message);
        $message = trim($message, "\xC2\xA0");
        $message = preg_replace(["/\s\s+/", "/\r\r+/", "/\n\n+/"], '', $message);
        $message = str_replace(["\r\n", "\r", "\n"], '', $message);

        return $message;
    }
}


function replaceTagWithValue($template, $data)
{
    foreach ($data as $key => $value) {
        $template = str_replace($key, $value, $template);
    }
    return $template;
}

function filterAmount($amount)
{
    return preg_replace('/^[^\d]+/', '', $amount);
}


if (!function_exists('getGeo')) {
    function getGeo($ip)
    {
        try {
            $reader = new Reader(base_path('vendor/databases/GeoLite2-City.mmdb'));
            $record = $reader->get($ip);

            $continent = isset($record['continent']['names']['en']) ? trim($record['continent']['names']['en']) : 'Others';
            $country = isset($record['country']['names']['en']) ? trim($record['country']['names']['en']) : 'Others';
            $state = isset($record['subdivisions'][0]['names']['en']) ? trim($record['subdivisions'][0]['names']['en']) : 'Others';
            $country = isset($record['country']['names']['en']) ? trim($record['country']['names']['en']) : 'Others';
            $city = isset($record['city']['names']['en']) ? trim($record['city']['names']['en']) : 'Others';
            $location = (isset($record['location']) && !empty($record['location'])) ? $record['location'] : [];

            $geo = array(
                'ip_address' => $ip,
                'continent' => $continent,
                'country' => $country,
                'state' => $state,
                'city' => $city,
                'location' => $location

            );
        } catch (Exception $ex) {

            $geo = array(
                'ip_address' => $ip,
                'continent' => 'Others',
                'country' => 'Others',
                'state' => 'Others',
                'city' => 'Others',
                'location' => 'Others',
                'timezone' => 'Others'
            );
        }

        return $geo;
    }
}


if (!function_exists('getDevice')) {
    function getDevice($request)
    {
        $userAgent = $request->header('User-Agent');

        // OPTIONAL: Set version truncation to none, so full versions will be returned
        // By default only minor versions will be returned (e.g. X.Y)
        // for other options see VERSION_TRUNCATION_* constants in DeviceParserAbstract class
        AbstractDeviceParser::setVersionTruncation(AbstractDeviceParser::VERSION_TRUNCATION_NONE);

        $userAgent = $_SERVER['HTTP_USER_AGENT']; // change this to the useragent you want to parse
        $clientHints = ClientHints::factory($_SERVER); // client hints are optional

        $dd = new DeviceDetector($userAgent, $clientHints);

        $dd->parse();

        // print_r($dd);die;

        if ($dd->isBot()) {
            // handle bots,spiders,crawlers,...
            $botInfo = $dd->getBot();
        } else {

            $device = [
                "browser" => $dd->getClient()['name'] . ", " . $dd->getClient()['version'],
                "platform" => $dd->getOs()['name'] . ", " . $dd->getOs()['platform'],
                "device_type" => $dd->getDevice(),
                "device_name" => $dd->getDeviceName(),
                "device_brand" => $dd->getBrandName(),
                "is_mobile" => $dd->isMobile(),
                "is_tablet" => $dd->isTablet(),
                "model" => $dd->getModel(),

            ];
        }

        return $device;
    }
}



if (!function_exists('getCountryCode')) {
    function getCountryCode()
    {
        $countries =   DB::table('mobile_country_list')->get()->toArray();

        foreach ($countries as $key => $country) {
            $country->country_code = str_replace('+', '', $country->country_code);
        }

        return $countries;
    }
}

if (!function_exists('paymentGateway')) {
    function paymentGateway()
    {
        $payment_gateway =   DB::table('payment_gateway_config')->get();
        return $payment_gateway;
    }
}




if (!function_exists('getAllTimeZones')) {
    function getAllTimeZones()
    {
        $timezones = DB::table('time_zone')
            ->get();

        return $timezones;
    }
}

if (!function_exists('getCountry')) {
    function getCountry()
    {
        $country = DB::table('country')
            ->get();

        return $country;
    }
}
if (!function_exists('getState')) {
    function getState()
    {
        $country = DB::table('country_to_state_code')
            ->get();

        return $country;
    }
}

if (!function_exists('getCurrency')) {
    function getCurrency()
    {
        $currency = DB::table('currency_settings')
            ->get();

        return $currency;
    }
}


if (!function_exists('appendUTM')) {
    function appendUTM($html, $utm_parameters)
    {
        // Load HTML into DOMDocument
        $dom = new DOMDocument();
        libxml_use_internal_errors(true); // To suppress warnings for invalid HTML
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        // Get all anchor tags
        $anchors = $dom->getElementsByTagName('a');

        // Iterate through each anchor tag and append UTM parameters
        foreach ($anchors as $anchor) {
            $href = $anchor->getAttribute('href');

            // Append UTM parameters to the URL
            $parsed_url = parse_url($href);
            $separator = isset($parsed_url['query']) ? '&' : '?';
            $new_href = $href . $separator . $utm_parameters;

            // Update the href attribute
            $anchor->setAttribute('href', $new_href);
        }

        // Output the modified HTML
        return html_entity_decode($dom->saveHTML());
    }
}





if (!function_exists('convertUtcToTimeZone')) {
    function convertUtcToTimeZone($utcDateTime, $targetTimeZone = 'Asia/Kolkata')
    {
        $date = new DateTime($utcDateTime, new DateTimeZone('UTC'));
        $date->setTimezone(new DateTimeZone($targetTimeZone));
        return $date->format('Y-m-d H:i:s');
    }
}




if (!function_exists('getEmailAlias')) {
    function getEmailAlias($email, $program_id)
    {
        $alias = explode('@', $email);
        $alias_email = '';
        if (!empty($alias)) {
            $alias_email = $alias[0]  . "+" . $program_id . "@" . $alias[1];
        }
        return $alias_email;
    }
}



// if (!function_exists('convertToUTC')) {
//     function convertToUTC($dateTime, $timezone = 'Asia/Kolkata')
//     {
//         return Carbon::createFromFormat('Y-m-d H:i:s', $dateTime, $timezone)
//             ->setTimezone('UTC')
//             ->toDateTimeString();
//     }
// }

if (!function_exists('getTimeDateDisplay')) {
    function getTimeDateDisplay($time_zone_id, $date_time, $view_format, $recieve_format = 'Y-m-d')
    {
        $timezone = DB::table('time_zone')
            ->where('time_zone_id', $time_zone_id)
            ->first();

        // dd($date_time);

        // Create a Carbon instance from the given UTC time
        $utc_date_time = Carbon::createFromFormat($recieve_format, $date_time, 'UTC');
        // Convert to Asia/Kolkata timezone
        $kolkata_date_time = $utc_date_time->setTimezone($timezone->timezone);
        // Format the datetime as needed
        $registered_program_end_dates_month_txt = $kolkata_date_time->format($view_format);

        return $registered_program_end_dates_month_txt;
    }
}

if (!function_exists('short_login_code')) {
    function short_login_code()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $charactersLength = strlen($characters);
        $short_login_code = '';
        for ($i = 0; $i < 6; $i++) {
            $short_login_code .= $characters[rand(0, $charactersLength - 1)];
        }
        return $short_login_code;
    }
}

if (!function_exists('dbPrefix')) {
    function dbPrefix()
    {
        return DB::getTablePrefix();
    }
}

if (!function_exists('generateUniqueCode')) {
    function generateUniqueCode($length = 4)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789123456789123456789';
        $charactersLength = strlen($characters);
        $uniqueCode = '';
        for ($i = 0; $i < $length; $i++) {
            $uniqueCode .= $characters[rand(0, $charactersLength - 1)];
        }
        return $uniqueCode;
    }
}





if (!function_exists('theme')) {
    function theme()
    {
        return app(App\Core\Theme::class);
    }
}


if (!function_exists('getName')) {
    /**
     * Get product name
     *
     * @return void
     */
    function getName()
    {
        return config('settings.KT_THEME');
    }
}


if (!function_exists('addHtmlAttribute')) {
    /**
     * Add HTML attributes by scope
     *
     * @param $scope
     * @param $name
     * @param $value
     *
     * @return void
     */
    function addHtmlAttribute($scope, $name, $value)
    {
        theme()->addHtmlAttribute($scope, $name, $value);
    }
}


if (!function_exists('addHtmlAttributes')) {
    /**
     * Add multiple HTML attributes by scope
     *
     * @param $scope
     * @param $attributes
     *
     * @return void
     */
    function addHtmlAttributes($scope, $attributes)
    {
        theme()->addHtmlAttributes($scope, $attributes);
    }
}


if (!function_exists('addHtmlClass')) {
    /**
     * Add HTML class by scope
     *
     * @param $scope
     * @param $value
     *
     * @return void
     */
    function addHtmlClass($scope, $value)
    {
        theme()->addHtmlClass($scope, $value);
    }
}


if (!function_exists('printHtmlAttributes')) {
    /**
     * Print HTML attributes for the HTML template
     *
     * @param $scope
     *
     * @return string
     */
    function printHtmlAttributes($scope)
    {
        return theme()->printHtmlAttributes($scope);
    }
}


if (!function_exists('printHtmlClasses')) {
    /**
     * Print HTML classes for the HTML template
     *
     * @param $scope
     * @param $full
     *
     * @return string
     */
    function printHtmlClasses($scope, $full = true)
    {
        return theme()->printHtmlClasses($scope, $full);
    }
}


if (!function_exists('getSvgIcon')) {
    /**
     * Get SVG icon content
     *
     * @param $path
     * @param $classNames
     * @param $folder
     *
     * @return string
     */
    function getSvgIcon($path, $classNames = 'svg-icon', $folder = 'assets/media/icons/')
    {
        return theme()->getSvgIcon($path, $classNames, $folder);
    }
}


if (!function_exists('setModeSwitch')) {
    /**
     * Set dark mode enabled status
     *
     * @param $flag
     *
     * @return void
     */
    function setModeSwitch($flag)
    {
        theme()->setModeSwitch($flag);
    }
}


if (!function_exists('isModeSwitchEnabled')) {
    /**
     * Check dark mode status
     *
     * @return void
     */
    function isModeSwitchEnabled()
    {
        return theme()->isModeSwitchEnabled();
    }
}


if (!function_exists('setModeDefault')) {
    /**
     * Set the mode to dark or light
     *
     * @param $mode
     *
     * @return void
     */
    function setModeDefault($mode)
    {
        theme()->setModeDefault($mode);
    }
}


if (!function_exists('getModeDefault')) {
    /**
     * Get current mode
     *
     * @return void
     */
    function getModeDefault()
    {
        return theme()->getModeDefault();
    }
}


if (!function_exists('setDirection')) {
    /**
     * Set style direction
     *
     * @param $direction
     *
     * @return void
     */
    function setDirection($direction)
    {
        theme()->setDirection($direction);
    }
}


if (!function_exists('getDirection')) {
    /**
     * Get style direction
     *
     * @return void
     */
    function getDirection()
    {
        return theme()->getDirection();
    }
}


if (!function_exists('isRtlDirection')) {
    /**
     * Check if style direction is RTL
     *
     * @return void
     */
    function isRtlDirection()
    {
        return theme()->isRtlDirection();
    }
}


if (!function_exists('extendCssFilename')) {
    /**
     * Extend CSS file name with RTL or dark mode
     *
     * @param $path
     *
     * @return void
     */
    function extendCssFilename($path)
    {
        return theme()->extendCssFilename($path);
    }
}


if (!function_exists('includeFavicon')) {
    /**
     * Include favicon from settings
     *
     * @return string
     */
    function includeFavicon()
    {
        return theme()->includeFavicon();
    }
}


if (!function_exists('includeFonts')) {
    /**
     * Include the fonts from settings
     *
     * @return string
     */
    function includeFonts()
    {
        return theme()->includeFonts();
    }
}


if (!function_exists('getGlobalAssets')) {
    /**
     * Get the global assets
     *
     * @param $type
     *
     * @return array
     */
    function getGlobalAssets($type = 'js')
    {
        return theme()->getGlobalAssets($type);
    }
}


if (!function_exists('addVendors')) {
    /**
     * Add multiple vendors to the page by name. Refer to settings KT_THEME_VENDORS
     *
     * @param $vendors
     *
     * @return void
     */
    function addVendors($vendors)
    {
        theme()->addVendors($vendors);
    }
}


if (!function_exists('addVendor')) {
    /**
     * Add single vendor to the page by name. Refer to settings KT_THEME_VENDORS
     *
     * @param $vendor
     *
     * @return void
     */
    function addVendor($vendor)
    {
        theme()->addVendor($vendor);
    }
}


if (!function_exists('addJavascriptFile')) {
    /**
     * Add custom javascript file to the page
     *
     * @param $file
     *
     * @return void
     */
    function addJavascriptFile($file)
    {
        theme()->addJavascriptFile($file);
    }
}


if (!function_exists('addCssFile')) {
    /**
     * Add custom CSS file to the page
     *
     * @param $file
     *
     * @return void
     */
    function addCssFile($file)
    {
        theme()->addCssFile($file);
    }
}


if (!function_exists('getVendors')) {
    /**
     * Get vendor files from settings. Refer to settings KT_THEME_VENDORS
     *
     * @param $type
     *
     * @return array
     */
    function getVendors($type)
    {
        return theme()->getVendors($type);
    }
}


if (!function_exists('getCustomJs')) {
    /**
     * Get custom js files from the settings
     *
     * @return array
     */
    function getCustomJs()
    {
        return theme()->getCustomJs();
    }
}


if (!function_exists('getCustomCss')) {
    /**
     * Get custom css files from the settings
     *
     * @return array
     */
    function getCustomCss()
    {
        return theme()->getCustomCss();
    }
}


if (!function_exists('getHtmlAttribute')) {
    /**
     * Get HTML attribute based on the scope
     *
     * @param $scope
     * @param $attribute
     *
     * @return array
     */
    function getHtmlAttribute($scope, $attribute)
    {
        return theme()->getHtmlAttribute($scope, $attribute);
    }
}


if (!function_exists('isUrl')) {
    /**
     * Get HTML attribute based on the scope
     *
     * @param $url
     *
     * @return mixed
     */
    function isUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}


if (!function_exists('image')) {
    /**
     * Get image url by path
     *
     * @param $path
     *
     * @return string
     */
    function image($path)
    {
        return asset('assets/media/' . $path);
    }
}


if (!function_exists('getIcon')) {
    /**
     * Get icon
     *
     * @param $path
     *
     * @return string
     */
    function getIcon($name, $class = '', $type = '', $tag = 'span')
    {
        return theme()->getIcon($name, $class, $type, $tag);
    }
}
