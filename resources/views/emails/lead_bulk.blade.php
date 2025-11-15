<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>InvoiceZy – Thanks for your enquiry</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    /* Basic responsive email styles */
    body { margin:0; padding:0; background-color:#f4f6f8; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; color:#2b2b2b; }
    .email-wrap { width:100%; background:#f4f6f8; padding:20px 0; }
    .email-container { max-width:680px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 18px rgba(0,0,0,0.06); }
    .header { padding:24px; text-align:left; border-bottom:1px solid #eef1f4; }
    .logo { font-weight:700; font-size:20px; color:#0b63d6; text-decoration:none; }
    .content { padding:24px; line-height:1.55; font-size:15px; color:#334155; }
    .greeting { font-size:16px; margin-bottom:12px; }
    .features { margin:16px 0; padding:0; list-style:none; }
    .features li { margin:8px 0; display:flex; gap:10px; align-items:center; }
    .feature-icon { width:34px; height:34px; background:#eef6ff; color:#0b63d6; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; font-weight:600; }
    .cta { padding:24px; text-align:center; }
    .btn { display:inline-block; text-decoration:none; padding:12px 20px; border-radius:8px; font-weight:600; }
    .btn-primary { background:#0b63d6; color:#ffffff; }
    .btn-outline { background:transparent; border:1px solid #0b63d6; color:#0b63d6; }
    .footer { padding:20px 24px; background:#fbfdff; border-top:1px solid #eef1f4; font-size:13px; color:#6b7280; }
    .small { font-size:13px; color:#6b7280; }
    @media only screen and (max-width:480px) {
      .email-container { margin:12px; }
      .header, .content, .cta, .footer { padding:16px; }
      .feature-icon { width:30px; height:30px; font-size:12px; }
    }
  </style>
</head>
<body>
  <div class="email-wrap">
    <div class="email-container" role="article" aria-roledescription="email">
    <div class="header">
  <a href="https://invoicezy.com/" target="_blank">
    <img src="https://invoicezy.com/logo.png" 
         alt="InvoiceZy" 
         style="height:50px; display:block; margin:0 auto;">
  </a>
</div>


      <div class="content">
        <p class="greeting">Hello {{ $lead->customer_name }}, 👋</p>

        <p>This is <strong>Prem from InvoiceZy</strong>.</p>

        <p>We received your enquiry via <strong>Techjockey</strong> regarding our billing &amp; invoicing software. To suggest the best plan, could you please share your <strong>business type</strong> and the <strong>billing challenges</strong> you’re facing right now? 🙂</p>

        <hr style="border:none;border-top:1px solid #eef1f4;margin:18px 0;">

        <p style="margin-bottom:8px;font-weight:600;">🚀 Meanwhile, here’s how InvoiceZy can help your business:</p>

        <ul class="features" aria-hidden="true">
          <li>
            <span class="feature-icon">🧾</span>
            <span>Create <strong>GST invoices</strong> in seconds</span>
          </li>
          <li>
            <span class="feature-icon">💰</span>
            <span>Track <strong>expenses &amp; payments</strong></span>
          </li>
          <li>
            <span class="feature-icon">📧</span>
            <span>Send invoices on <strong>Email</strong></span>
          </li>
          <li>
            <span class="feature-icon">👥</span>
            <span>Manage <strong>clients, taxes &amp; inventory</strong></span>
          </li>
          <li>
            <span class="feature-icon">📊</span>
            <span>Get detailed <strong>reports &amp; statements</strong></span>
          </li>
          <li>
            <span class="feature-icon">⏰</span>
            <span><strong>Automatic payment reminders</strong></span>
          </li>
          <li>
            <span class="feature-icon">🎨</span>
            <span>Multiple professional <strong>invoice templates</strong></span>
          </li>
        </ul>

        <div class="cta">
          <a href="https://invoicezy.com/" class="btn btn-outline" target="_blank" rel="noopener">Explore InvoiceZy</a>
          <span style="display:inline-block;width:12px;"></span>
          <a href="https://invoicezy.com/register" class="btn btn-outline" target="_blank" rel="noopener">Register (Free)</a>
        </div>

        <p style="margin-top:8px;" class="small">(Check features &amp; pricing instantly)</p>

        <hr style="border:none;border-top:1px solid #eef1f4;margin:18px 0;">

        <p>If you want, I can schedule a quick <strong>call</strong> or <strong>live demo</strong> to show you how everything works.</p>

        <p style="margin:8px 0;">
          <strong>📞 Call</strong> or <strong>💻 Demo</strong> — which do you prefer?<br>
          Please share a convenient time slot and I’ll confirm.
        </p>

        <p style="margin-top:16px;">
          <strong>InvoiceZy Dashboard</strong><br>
          <a href="https://invoicezy.com/register" target="_blank" rel="noopener">Register</a> •
          <a href="https://pro.invoicezy.com/" target="_blank" rel="noopener">Login</a>
        </p>

        <p style="margin-top:8px;font-weight:600;color:#0b63d6;">
          ✨ Lifetime Free Plan — Create up to <strong>5 invoices</strong> every month at no cost!
        </p>

        <div style="margin-top:20px;">
          <p style="margin:0;">Warm regards,</p>
          <p style="margin:6px 0 0;"><strong>Prem Morya</strong><br>InvoiceZy</p>
          <p class="small" style="margin-top:6px;">
            📧 <a href="mailto:support@invoicezy.com">support@invoicezy.com</a> · 📞 +91-8750101087 · 🌐 <a href="https://invoicezy.com/">invoicezy.com</a>
          </p>
        </div>
      </div>

      <div class="footer">
        <p style="margin:0 0 8px;" class="small">You received this email because you enquired about InvoiceZy via Techjockey. If you prefer not to receive these emails, reply with <strong>UNSUBSCRIBE</strong> and we will remove you.</p>
      
      </div>
    </div>
  </div>
</body>
</html>
