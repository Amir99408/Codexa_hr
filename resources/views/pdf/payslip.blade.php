<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
        .header { background: #0f4c81; color: white; padding: 20px 30px; }
        .header h1 { font-size: 24px; font-weight: bold; }
        .header h1 span { color: #ff6b35; }
        .header p { font-size: 12px; color: #93c5fd; margin-top: 2px; }
        .header-right { float: right; text-align: right; }
        .header-right .month { font-size: 16px; font-weight: bold; }
        .header-right .status { background: #22c55e; color: white; padding: 3px 10px; border-radius: 20px; font-size: 11px; display: inline-block; margin-top: 4px; }
        .clearfix::after { content: ''; display: table; clear: both; }
        .section { padding: 20px 30px; border-bottom: 1px solid #e5e7eb; }
        .section-title { font-size: 10px; font-weight: bold; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px; }
        .grid-2 { width: 100%; }
        .grid-2 td { width: 50%; vertical-align: top; padding-right: 20px; }
        .info-row { margin-bottom: 8px; }
        .info-label { color: #6b7280; font-size: 10px; }
        .info-value { font-weight: bold; font-size: 12px; color: #111827; }
        .stats-table { width: 100%; text-align: center; }
        .stats-table td { padding: 8px; }
        .stat-value { font-size: 20px; font-weight: bold; }
        .stat-label { font-size: 10px; color: #6b7280; }
        .earnings-table { width: 100%; }
        .earnings-table td { padding: 5px 0; border-bottom: 1px solid #f3f4f6; }
        .earnings-table .total-row td { font-weight: bold; border-top: 2px solid #e5e7eb; border-bottom: none; padding-top: 8px; }
        .green { color: #16a34a; }
        .red { color: #dc2626; }
        .net-section { background: #0f4c81; color: white; padding: 20px 30px; }
        .net-section .label { font-size: 14px; font-weight: bold; float: left; line-height: 36px; }
        .net-section .amount { font-size: 28px; font-weight: bold; float: right; }
        .bg-gray { background: #f9fafb; }
    </style>
</head>
<body>

{{-- Header --}}
<div class="header clearfix">
    <div style="float:left">
        <h1>HR<span>Flow</span></h1>
        <p>Employee Payslip</p>
    </div>
    <div class="header-right">
        <div class="month">{{ $payroll->month_name }}</div>
        <div class="status">{{ ucfirst($payroll->status) }}</div>
    </div>
</div>

{{-- Employee Info --}}
<div class="section">
    <div class="section-title">Employee Information</div>
    <table class="grid-2">
        <tr>
            <td>
                <div class="info-row">
                    <div class="info-label">Employee Name</div>
                    <div class="info-value">{{ $payroll->employee->full_name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Employee Code</div>
                    <div class="info-value">{{ $payroll->employee->emp_code }}</div>
                </div>
            </td>
            <td>
                <div class="info-row">
                    <div class="info-label">Department</div>
                    <div class="info-value">{{ $payroll->employee->department?->name ?? '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Designation</div>
                    <div class="info-value">{{ $payroll->employee->designation ?? '—' }}</div>
                </div>
            </td>
        </tr>
    </table>
</div>

{{-- Attendance Summary --}}
<div class="section bg-gray">
    <div class="section-title">Attendance Summary</div>
    <table class="stats-table">
        <tr>
            <td>
                <div class="stat-value">{{ $payroll->working_days }}</div>
                <div class="stat-label">Working Days</div>
            </td>
            <td>
                <div class="stat-value green">{{ $payroll->present_days }}</div>
                <div class="stat-label">Present Days</div>
            </td>
            <td>
                <div class="stat-value red">{{ $payroll->absent_days }}</div>
                <div class="stat-label">Absent Days</div>
            </td>
        </tr>
    </table>
</div>

{{-- Earnings & Deductions --}}
<div class="section">
    <table class="grid-2">
        <tr>
            <td>
                <div class="section-title">Earnings</div>
                <table class="earnings-table" width="100%">
                    <tr>
                        <td>Basic Salary</td>
                        <td align="right">{{ currency($payroll->basic_salary) }}</td>
                    </tr>
                    @foreach($payroll->items->where('type','earning') as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td align="right" class="green">+{{ currency($item->amount) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td>Gross Salary</td>
                        <td align="right" class="green">{{ currency($payroll->gross_salary) }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <div class="section-title">Deductions</div>
                <table class="earnings-table" width="100%">
                    @forelse($payroll->items->where('type','deduction') as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td align="right" class="red">-{{ currency($item->amount) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" style="color:#9ca3af">No deductions</td></tr>
                    @endforelse
                    <tr class="total-row">
                        <td>Total Deductions</td>
                        <td align="right" class="red">{{ currency($payroll->total_deductions) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

{{-- Net Salary --}}
<div class="net-section clearfix">
    <div class="label">Net Salary</div>
    <div class="amount">{{ currency($payroll->net_salary) }}</div>
</div>

</body>
</html>

