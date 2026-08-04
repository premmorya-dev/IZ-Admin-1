<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome to InvoiceZy</title>
</head>
<body style="margin:0;padding:0;background-color:#F3F4F6;font-family:Arial,Helvetica,sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F3F4F6;padding:32px 0;">
<tr><td align="center">
<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:10px;overflow:hidden;max-width:600px;width:100%;box-shadow:0 1px 3px rgba(0,0,0,0.08);">

<!-- Header with logo -->
<tr>
<td style="background-color:#0A0E1A;padding:32px;text-align:center;">
<img src="{{ config('app.url') }}/logo.png" alt="InvoiceZy" width="140" style="display:block;margin:0 auto;border:0;">
</td>
</tr>

<!-- Accent bar -->
<tr>
<td style="height:3px;background:linear-gradient(90deg,#4338CA,#7C3AED);font-size:0;line-height:0;">&nbsp;</td>
</tr>

<!-- Hero -->
<tr>
<td style="padding:40px 40px 8px 40px;">
<p style="margin:0 0 8px 0;font-size:13px;font-weight:bold;color:#4338CA;letter-spacing:0.5px;text-transform:uppercase;">Welcome to InvoiceZy</p>
<h1 style="margin:0 0 18px 0;font-size:26px;line-height:34px;color:#111827;">Hi {{ $user->first_name }} {{ $user->last_name }}, glad to have you on board 👋</h1>
<p style="margin:0 0 28px 0;font-size:15px;line-height:24px;color:#4B5563;">
Your InvoiceZy account is ready. You can now create GST-compliant invoices, manage clients, and get paid faster — all from one dashboard.
</p>

<!-- CTA -->
<table role="presentation" cellpadding="0" cellspacing="0">
<tr>
<td style="background-color:#4338CA;border-radius:8px;">
<a href="{{ config('app.url') }}/invoices/create" style="display:inline-block;padding:14px 32px;font-size:15px;color:#ffffff;text-decoration:none;font-weight:bold;">Create Your First Invoice →</a>
</td>
</tr>
</table>
</td>
</tr>

<!-- Feature strip -->
<tr>
<td style="padding:36px 40px 8px 40px;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
<tr>
<td width="33%" valign="top" style="padding:0 8px 0 0;">
<div style="background-color:#F9FAFB;border:1px solid #EEF2FF;border-radius:8px;padding:18px 14px;">
<div style="font-size:22px;margin-bottom:8px;">🧾</div>
<p style="margin:0 0 4px 0;font-size:13px;font-weight:bold;color:#111827;">GST-Ready</p>
<p style="margin:0;font-size:12px;line-height:18px;color:#6B7280;">Auto tax calculation on every invoice</p>
</div>
</td>
<td width="33%" valign="top" style="padding:0 4px;">
<div style="background-color:#F9FAFB;border:1px solid #EEF2FF;border-radius:8px;padding:18px 14px;">
<div style="font-size:22px;margin-bottom:8px;">⚡</div>
<p style="margin:0 0 4px 0;font-size:13px;font-weight:bold;color:#111827;">2-Minute Setup</p>
<p style="margin:0;font-size:12px;line-height:18px;color:#6B7280;">Send your first invoice today</p>
</div>
</td>
<td width="33%" valign="top" style="padding:0 0 0 8px;">
<div style="background-color:#F9FAFB;border:1px solid #EEF2FF;border-radius:8px;padding:18px 14px;">
<div style="font-size:22px;margin-bottom:8px;">🔒</div>
<p style="margin:0 0 4px 0;font-size:13px;font-weight:bold;color:#111827;">Secure & Reliable</p>
<p style="margin:0;font-size:12px;line-height:18px;color:#6B7280;">Your data, always protected</p>
</div>
</td>
</tr>
</table>
</td>
</tr>

<!-- Help note -->
<tr>
<td style="padding:32px 40px 40px 40px;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#EEF2FF;border-radius:8px;">
<tr>
<td style="padding:16px 20px;">
<p style="margin:0;font-size:13px;line-height:20px;color:#3730A3;">💬 Need a hand getting started? Just reply to this email — a real person from our team will help you out.</p>
</td>
</tr>
</table>
</td>
</tr>

<!-- Footer -->
<tr>
<td style="padding:28px 40px;border-top:1px solid #E5E7EB;background-color:#FAFAFA;">
<p style="margin:0 0 6px 0;font-size:12px;color:#9CA3AF;">You're receiving this because you created an account on InvoiceZy.</p>

</td>
</tr>

</table>
</td></tr>
</table>
</body>
</html>