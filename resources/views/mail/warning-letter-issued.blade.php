<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  body { font-family: Arial, sans-serif; background: #f4f6f8; margin: 0; padding: 0; }
  .wrapper { max-width: 560px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
  .header { padding: 32px 40px; background: #b45309; color: #fff; }
  .header h1 { margin: 0; font-size: 22px; }
  .header p { margin: 6px 0 0; opacity: .85; font-size: 14px; }
  .body { padding: 32px 40px; }
  .body p { color: #374151; line-height: 1.6; font-size: 15px; margin: 0 0 16px; }
  .info-box { background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 20px 24px; margin: 20px 0; }
  .info-row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #fef3c7; font-size: 14px; }
  .info-row:last-child { border: none; }
  .info-row span:first-child { color: #92400e; }
  .info-row span:last-child { font-weight: 600; color: #78350f; }
  .letter-box { background: #f9fafb; border-left: 4px solid #f59e0b; padding: 20px 24px; border-radius: 0 8px 8px 0; margin: 20px 0; white-space: pre-wrap; font-size: 14px; color: #374151; line-height: 1.7; }
  .footer { padding: 20px 40px; background: #f9fafb; text-align: center; color: #9ca3af; font-size: 12px; border-top: 1px solid #e5e7eb; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <h1>Warning Letter Issued</h1>
    <p>{{ \App\Models\Setting::get('company_name', 'HR System') }}</p>
  </div>
  <div class="body">
    <p>Dear <strong>{{ $letter->employee?->full_name }}</strong>,</p>
    <p>A formal warning letter has been issued to you. Please review the details below.</p>

    <div class="info-box">
      <div class="info-row">
        <span>Subject</span>
        <span>{{ $letter->subject }}</span>
      </div>
      <div class="info-row">
        <span>Type</span>
        <span>{{ ucfirst($letter->type) }}</span>
      </div>
      <div class="info-row">
        <span>Severity</span>
        <span>{{ ucfirst($letter->severity) }}</span>
      </div>
      <div class="info-row">
        <span>Date Issued</span>
        <span>{{ $letter->issued_date?->format('d M Y') }}</span>
      </div>
    </div>

    <div class="letter-box">{{ $letter->body }}</div>

    <p style="color:#6b7280; font-size:14px;">
      Please log in to the employee portal to acknowledge this letter.
    </p>
  </div>
  <div class="footer">
    &copy; {{ date('Y') }} {{ \App\Models\Setting::get('company_name', 'HR System') }} &mdash; This is an automated email.
  </div>
</div>
</body>
</html>
