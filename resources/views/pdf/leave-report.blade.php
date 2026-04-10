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
        .badge-approved { background: #dcfce7; color: #16a34a; }
        .badge-pending  { background: #fef9c3; color: #ca8a04; }
        .badge-rejected { background: #fee2e2; color: #dc2626; }
        .green { color: #16a34a; }
        .red   { color: #dc2626; }
        .yellow { color: #ca8a04; }
    </style>
</head>
<body>

<div class="header clearfix">
    <h1>HR<span>Flow</span> — Leave Report</h1>
    <div class="info">
        {{ \Carbon\Carbon::parse($from_date)->format('d M Y') }} to {{ \Carbon\Carbon::parse($to_date)->format('d M Y') }}<br/>
        Generated: {{ now()->format('d M Y H:i') }}
    </div>
</div>

<div class="summary">
    <table class="summary-grid">
        <tr>
            <td><div class="stat-val">{{ $summary['total'] }}</div><div class="stat-lbl">Total Requests</div></td>
            <td><div class="stat-val green">{{ $summary['approved'] }}</div><div class="stat-lbl">Approved</div></td>
            <td><div class="stat-val yellow">{{ $summary['pending'] }}</div><div class="stat-lbl">Pending</div></td>
            <td><div class="stat-val red">{{ $summary['rejected'] }}</div><div class="stat-lbl">Rejected</div></td>
            <td><div class="stat-val">{{ $summary['days'] }}</div><div class="stat-lbl">Total Days</div></td>
        </tr>
    </table>
</div>

<table class="report">
    <thead>
        <tr>
            <th>#</th>
            <th>Employee</th>
            <th>Department</th>
            <th>Leave Type</th>
            <th>From</th>
            <th>To</th>
            <th>Days</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($records as $i => $rec)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><strong>{{ $rec->employee->full_name }}</strong></td>
                <td>{{ $rec->employee->department?->name ?? '—' }}</td>
                <td>{{ $rec->leaveType->name }}</td>
                <td>{{ $rec->from_date->format('d M Y') }}</td>
                <td>{{ $rec->to_date->format('d M Y') }}</td>
                <td><strong>{{ $rec->days }}</strong></td>
                <td>
                    <span class="badge badge-{{ $rec->status }}">{{ ucfirst($rec->status) }}</span>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" style="text-align:center;padding:20px;color:#9ca3af">No records found</td></tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
