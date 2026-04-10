<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; }
        .header { background: #0f4c81; color: white; padding: 15px 25px; margin-bottom: 15px; }
        .header h1 { font-size: 18px; font-weight: bold; float: left; }
        .header h1 span { color: #ff6b35; }
        .header .info { float: right; text-align: right; font-size: 11px; color: #93c5fd; }
        .clearfix::after { content: ''; display: table; clear: both; }
        .summary { padding: 10px 25px; margin-bottom: 15px; background: #f9fafb; }
        .summary-grid { width: 100%; }
        .summary-grid td { text-align: center; padding: 8px; }
        .stat-val { font-size: 18px; font-weight: bold; }
        .stat-lbl { font-size: 10px; color: #6b7280; }
        table.report { width: 100%; border-collapse: collapse; margin: 0 25px; width: calc(100% - 50px); }
        table.report th { background: #f3f4f6; text-align: left; padding: 8px 10px; font-size: 10px; text-transform: uppercase; color: #6b7280; border-bottom: 2px solid #e5e7eb; }
        table.report td { padding: 7px 10px; border-bottom: 1px solid #f3f4f6; }
        .badge { padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: bold; }
        .badge-paid      { background: #dcfce7; color: #16a34a; }
        .badge-processed { background: #dbeafe; color: #2563eb; }
        .badge-draft     { background: #fef9c3; color: #ca8a04; }
        .green { color: #16a34a; }
        .red   { color: #dc2626; }
        .total-row td { font-weight: bold; background: #f3f4f6; border-top: 2px solid #e5e7eb; }
    </style>
</head>
<body>

<div class="header clearfix">
    <h1>HR<span>Flow</span> — Payroll Report</h1>
    <div class="info">
        {{ $monthName }}<br/>
        Generated: {{ now()->format('d M Y H:i') }}
    </div>
</div>

<div class="summary">
    <table class="summary-grid">
        <tr>
            <td><div class="stat-val">{{ $summary['total_employees'] }}</div><div class="stat-lbl">Employees</div></td>
            <td><div class="stat-val">{{ currency($summary['total_basic']) }}</div><div class="stat-lbl">Total Basic</div></td>
            <td><div class="stat-val green">{{ currency($summary['total_earnings']) }}</div><div class="stat-lbl">Total Earnings</div></td>
            <td><div class="stat-val red">{{ currency($summary['total_deductions']) }}</div><div class="stat-lbl">Total Deductions</div></td>
            <td><div class="stat-val">{{ currency($summary['total_net']) }}</div><div class="stat-lbl">Net Payable</div></td>
        </tr>
    </table>
</div>

<table class="report">
    <thead>
        <tr>
            <th>#</th>
            <th>Employee</th>
            <th>Department</th>
            <th>Basic</th>
            <th>Earnings</th>
            <th>Deductions</th>
            <th>Net Salary</th>
            <th>Attendance</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($records as $i => $rec)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><strong>{{ $rec->employee->full_name }}</strong><br/><span style="color:#9ca3af;font-size:10px">{{ $rec->employee->emp_code }}</span></td>
                <td>{{ $rec->employee->department?->name ?? '—' }}</td>
                <td>{{ currency($rec->basic_salary) }}</td>
                <td class="green">+{{ currency($rec->total_earnings) }}</td>
                <td class="red">-{{ currency($rec->total_deductions) }}</td>
                <td><strong>{{ currency($rec->net_salary) }}</strong></td>
                <td><span class="green">{{ $rec->present_days }}P</span> / <span class="red">{{ $rec->absent_days }}A</span></td>
                <td><span class="badge badge-{{ $rec->status }}">{{ ucfirst($rec->status) }}</span></td>
            </tr>
        @empty
            <tr><td colspan="9" style="text-align:center;padding:20px;color:#9ca3af">No records found</td></tr>
        @endforelse
        @if($records->count() > 0)
            <tr class="total-row">
                <td colspan="3">Total</td>
                <td>{{ currency($summary['total_basic']) }}</td>
                <td class="green">+{{ currency($summary['total_earnings']) }}</td>
                <td class="red">-{{ currency($summary['total_deductions']) }}</td>
                <td><strong>{{ currency($summary['total_net']) }}</strong></td>
                <td colspan="2"></td>
            </tr>
        @endif
    </tbody>
</table>

</body>
</html>
