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
        .badge-present { background: #dcfce7; color: #16a34a; }
        .badge-absent  { background: #fee2e2; color: #dc2626; }
        .badge-late    { background: #ffedd5; color: #ea580c; }
        .badge-half    { background: #fef9c3; color: #ca8a04; }
        .badge-wfh     { background: #dbeafe; color: #2563eb; }
        .green { color: #16a34a; }
        .red   { color: #dc2626; }
        .orange { color: #ea580c; }
    </style>
</head>
<body>

<div class="header clearfix">
    <h1>HR<span>Flow</span> — Attendance Report</h1>
    <div class="info">
        {{ \Carbon\Carbon::parse($from_date)->format('d M Y') }} to {{ \Carbon\Carbon::parse($to_date)->format('d M Y') }}<br/>
        Generated: {{ now()->format('d M Y H:i') }}
    </div>
</div>
<a href="{{ route('pdf.attendance', ['from_date' => $from_date, 'to_date' => $to_date, 'status' => $filterStatus, 'dept' => $filterDept]) }}"
   class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-600 flex items-center gap-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    Export PDF
</a>

<div class="summary">
    <table class="summary-grid">
        <tr>
            <td><div class="stat-val">{{ $summary['total'] }}</div><div class="stat-lbl">Total Records</div></td>
            <td><div class="stat-val green">{{ $summary['present'] }}</div><div class="stat-lbl">Present</div></td>
            <td><div class="stat-val red">{{ $summary['absent'] }}</div><div class="stat-lbl">Absent</div></td>
            <td><div class="stat-val orange">{{ $summary['late'] }}</div><div class="stat-lbl">Late</div></td>
            <td><div class="stat-val">{{ $summary['half_day'] }}</div><div class="stat-lbl">Half Day</div></td>
            <td><div class="stat-val">{{ $summary['wfh'] }}</div><div class="stat-lbl">WFH</div></td>
        </tr>
    </table>
</div>

<table class="report">
    <thead>
        <tr>
            <th>#</th>
            <th>Employee</th>
            <th>Department</th>
            <th>Date</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($records as $i => $rec)
            @php
                $badges = ['present'=>'badge-present','absent'=>'badge-absent','late'=>'badge-late','half_day'=>'badge-half','work_from_home'=>'badge-wfh'];
                $labels = ['present'=>'Present','absent'=>'Absent','late'=>'Late','half_day'=>'Half Day','work_from_home'=>'WFH'];
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><strong>{{ $rec->employee->full_name }}</strong></td>
                <td>{{ $rec->employee->department?->name ?? '—' }}</td>
                <td>{{ $rec->date->format('d M Y') }}</td>
                <td>{{ $rec->check_in ?? '—' }}</td>
                <td>{{ $rec->check_out ?? '—' }}</td>
                <td>
                    <span class="badge {{ $badges[$rec->status] ?? '' }}">
                        {{ $labels[$rec->status] ?? $rec->status }}
                    </span>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" style="text-align:center;padding:20px;color:#9ca3af">No records found</td></tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
