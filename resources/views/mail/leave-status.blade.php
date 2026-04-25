<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  body { font-family: Arial, sans-serif; background: #f4f6f8; margin: 0; padding: 0; }
  .wrapper { max-width: 560px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
  .header { padding: 32px 40px; background: {{ $leave->status === 'approved' ? '#059669' : '#dc2626' }}; color: #fff; }
  .header h1 { margin: 0; font-size: 22px; }
  .header p { margin: 6px 0 0; opacity: .85; font-size: 14px; }
  .body { padding: 32px 40px; }
  .body p { color: #374151; line-height: 1.6; font-size: 15px; margin: 0 0 16px; }
  .info-box { background: #f9fafb; border-radius: 8px; padding: 20px 24px; margin: 20px 0; }
  .info-row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
  .info-row:last-child { border: none; }
  .info-row span:first-child { color: #6b7280; }
  .info-row span:last-child { font-weight: 600; color: #111827; }
  .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 13px; font-weight: 700; }
  .badge-approved { background: #d1fae5; color: #065f46; }
  .badge-rejected { background: #fee2e2; color: #991b1b; }
  .footer { padding: 20px 40px; background: #f9fafb; text-align: center; color: #9ca3af; font-size: 12px; border-top: 1px solid #e5e7eb; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <h1>Leave Request {{ ucfirst($leave->status) }}</h1>
    <p>{{ \App\Models\Setting::get('company_name', 'HR System') }}</p>
  </div>
  <div class="body">
    <p>Dear <strong>{{ $leave->employee?->full_name }}</strong>,</p>
    <p>
      Your leave request has been
      <span class="badge {{ $leave->status === 'approved' ? 'badge-approved' : 'badge-rejected' }}">
        {{ strtoupper($leave->status) }}
      </span>.
    </p>

    <div class="info-box">
      <div class="info-row">
        <span>Leave Type</span>
        <span>{{ $leave->leaveType?->name }}</span>
      </div>
      <div class="info-row">
        <span>From</span>
        <span>{{ $leave->from_date?->format('d M Y') }}</span>
      </div>
      <div class="info-row">
        <span>To</span>
        <span>{{ $leave->to_date?->format('d M Y') }}</span>
      </div>
      <div class="info-row">
        <span>Days</span>
        <span>{{ $leave->days }} working day(s)</span>
      </div>
      @if($leave->status === 'rejected' && $leave->rejection_reason)
      <div class="info-row">
        <span>Reason</span>
        <span>{{ $leave->rejection_reason }}</span>
      </div>
      @endif
    </div>

    <p style="color:#6b7280; font-size:14px;">
      You can view all your leave requests in the employee portal.
    </p>
  </div>
  <div class="footer">
    &copy; {{ date('Y') }} {{ \App\Models\Setting::get('company_name', 'HR System') }} &mdash; This is an automated email.
  </div>
</div>
</body>
</html>
