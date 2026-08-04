<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Annual Discount — InvoiceZy</title>
</head>
<body style="margin:0;padding:0;background-color:#F3F4F6;font-family:Arial,Helvetica,sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F3F4F6;padding:32px 0;">
<tr><td align="center">
<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:8px;overflow:hidden;max-width:600px;width:100%;">
<tr>
<td style="background-color:#0A0E1A;padding:28px 32px;">
<span style="color:#ffffff;font-size:20px;font-weight:bold;letter-spacing:0.5px;">InvoiceZy</span>
</td>
</tr>
<tr>
<td style="padding:36px 32px 8px 32px;">
<span style="display:inline-block;background-color:#FEF3C7;color:#92400E;font-size:12px;font-weight:bold;padding:4px 10px;border-radius:4px;margin-bottom:14px;">LIMITED TIME</span>
<h1 style="margin:0 0 16px 0;font-size:22px;color:#111827;">A month in, {{ $user->first_name }} {{ $user->last_name }} — here's a thank you</h1>
<p style="margin:0 0 16px 0;font-size:15px;line-height:24px;color:#4B5563;">
Switch to our Annual plan and lock in a discounted rate for the next 12 months, plus everything in Premium.
</p>
<table role="presentation" cellpadding="0" cellspacing="0">
<tr>
<td style="background-color:#4338CA;border-radius:6px;">
<a href="{{ config('app.url') }}/billing/upgrade?plan=annual" style="display:inline-block;padding:12px 28px;font-size:15px;color:#ffffff;text-decoration:none;font-weight:bold;">Claim Annual Discount</a>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td style="padding:32px;border-top:1px solid #E5E7EB;">
<p style="margin:0;font-size:12px;color:#9CA3AF;">— Team InvoiceZy</p>
</td>
</tr>
</table>
</td></tr>
</table>
</body>
</html>
