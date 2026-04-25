<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  body { font-family: Arial, sans-serif; background: #f4f6f8; margin: 0; padding: 0; }
  .wrapper { max-width: 560px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
  .header { padding: 32px 40px; background: #0f4c81; color: #fff; }
  .header h1 { margin: 0; font-size: 22px; }
  .header p { margin: 6px 0 0; opacity: .85; font-size: 14px; }
  .body { padding: 32px 40px; }
  .body p { color: #374151; line-height: 1.6; font-size: 15px; margin: 0 0 16px; }
  .amount-box { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 24px; text-align: center; margin: 24px 0; }
  .amount-box .label { font-size: 12px; text-transform: uppercase; letter-spacing: .08em; color: #3b82f6; font-weight: 700; margin-bottom: 6px; }
  .amount-box .amount { font-size: 36px; font-weight: 800; color: #1e3a5f; }
  .info-box { background: #f9fafb; border-radius: 8px; padding: 20px 24px; margin: 20px 0; }
  .info-row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
  .info-row:last-child { border: none; }
  .info-row span:first-child { color: #6b7280; }
  .info-row span:last-child { font-weight: 600; color: #111827; }
  .footer { padding: 20px 40px; background: #f9fafb; text-align: center; color: #9ca3af; font-size: 12px; border-top: 1px solid #e5e7eb; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <h1>Salary Credited</h1>
    <p>{{ \App\Models\Setting::get('company_name', 'HR System') }}</p>
  </div>
  <div class="body">
    <p>Dear <strong>{{ $payroll->employee?->full_name }}</strong>,</p>
    <p>Your salary for <strong>{{ $payroll->month_name }}</strong> has been processed and credited to your account.</p>

    <div class="amount-box">
      <div class="label">Net Salary</div>
      <div class="amount">{{ currency($payroll->net_salary) }}</div>
    </div>

    <div class="info-box">
      <div class="info-row">
        <span>Basic Salary</span>
        <span>{{ currency($payroll->basic_salary) }}</span>
      </div>
      <div class="info-row">
        <span>Total Earnings</span>
        <span>+ {{ currency($payroll->total_earnings) }}</span>
      </div>
      <div class="info-row">
        <span>Total Deductions</span>
        <span>- {{ currency($payroll->total_deductions) }}</span>
      </div>
      @if($payroll->advance_deduction > 0)
      <div class="info-row">
        <span>Advance Deduction</span>
        <span>- {{ currency($payroll->advance_deduction) }}</span>
      </div>
      @endif
      <div class="info-row">
        <span>Present Days</span>
        <span>{{ $payroll->present_days }} / {{ $payroll->working_days }}</span>
      </div>
    </div>

    <p style="color:#6b7280; font-size:14px;">
      You can download your full payslip from the employee portal.
    </p>
  </div>
  <div class="footer">
    &copy; {{ date('Y') }} {{ \App\Models\Setting::get('company_name', 'HR System') }} &mdash; This is an automated email.
  </div>
</div>
</body>
</html>
