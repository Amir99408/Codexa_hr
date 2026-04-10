<?php

use Illuminate\Support\Facades\Route;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Payroll;
use App\Models\Department;
use App\Livewire\Employees\EmployeeIndex;
use App\Livewire\Employees\EmployeeCreate;
use App\Livewire\Employees\EmployeeEdit;
use App\Livewire\Departments\DepartmentIndex;
use App\Livewire\Attendance\AttendanceIndex;
use App\Livewire\Leave\LeaveIndex;
use App\Livewire\Leave\LeaveCreate;
use App\Livewire\Leave\LeaveTypes;
use App\Livewire\Payroll\PayrollIndex;
use App\Livewire\Payroll\PayrollComponents;
use App\Livewire\Payroll\PayrollSlip;
use App\Livewire\Settings\CompanySettings;
use App\Livewire\Settings\ProfileSettings;
use App\Livewire\Holidays\HolidayIndex;
use App\Livewire\Reports\AttendanceReport;
use App\Livewire\Reports\LeaveReport;
use App\Livewire\Reports\PayrollReport;
use App\Livewire\Portal\EmployeeDashboard;
use App\Livewire\Portal\EmployeeLeaveApply;
use App\Livewire\Portal\EmployeeAttendance;
use App\Livewire\Portal\EmployeePayslips;
use App\Http\Controllers\PdfController;
use App\Livewire\AuditLog\AuditLogIndex;
use App\Livewire\Notifications\NotificationIndex;

use App\Livewire\Recruitment\JobIndex;
use App\Livewire\Recruitment\JobCreate;
use App\Livewire\Recruitment\ApplicantIndex;
use App\Livewire\Performance\PerformanceIndex;
use App\Livewire\Performance\PerformanceCreate;
use App\Livewire\Expenses\ExpenseIndex;
use App\Livewire\Portal\EmployeeExpenses;
use App\Livewire\Shifts\ShiftIndex;
use App\Livewire\Shifts\ShiftRoster;
use App\Livewire\Portal\EmployeeShifts;
use App\Http\Controllers\LanguageController;

// -----------------------------------------------
// ADMIN ROUTES
// -----------------------------------------------
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', function () {
        $stats = [
            'total_employees'       => Employee::where('status', 'active')->count(),
            'present_today'         => Attendance::whereDate('date', today())
                                            ->whereIn('status', ['present', 'late', 'work_from_home'])->count(),
            'on_leave_today'        => Leave::where('status', 'approved')
                                            ->whereDate('from_date', '<=', today())
                                            ->whereDate('to_date', '>=', today())->count(),
            'pending_leaves'        => Leave::where('status', 'pending')->count(),
            'total_employees_count' => Employee::count(),
        ];
        $recentEmployees  = Employee::with('department')->latest()->take(5)->get();
        $payrollThisMonth = Payroll::where('month', now()->month)->where('year', now()->year)->sum('net_salary');
        $totalDepartments = Department::count();

        return view('dashboard', compact(
            'stats', 'recentEmployees', 'payrollThisMonth', 'totalDepartments'
        ));
    })->name('dashboard');

    // Employees
    Route::get('/employees',                 EmployeeIndex::class)->name('employees.index');
    Route::get('/employees/create',          EmployeeCreate::class)->name('employees.create');
    Route::get('/employees/{employee}/edit', EmployeeEdit::class)->name('employees.edit');

    // Departments
    Route::get('/departments', DepartmentIndex::class)->name('departments.index');

    // Attendance
    Route::get('/attendance', AttendanceIndex::class)->name('attendance.index');

    // Holidays
    Route::get('/holidays', HolidayIndex::class)->name('holidays.index');

    // Leave
    Route::get('/leave',        LeaveIndex::class)->name('leave.index');
    Route::get('/leave/create', LeaveCreate::class)->name('leave.create');
    Route::get('/leave/types',  LeaveTypes::class)->name('leave.types');

    // Payroll
    Route::get('/payroll',                 PayrollIndex::class)->name('payroll.index');
    Route::get('/payroll/components',      PayrollComponents::class)->name('payroll.components');
    Route::get('/payroll/{payroll}/slip',  PayrollSlip::class)->name('payroll.slip');

    // Reports
    Route::get('/reports/attendance', AttendanceReport::class)->name('reports.attendance');
    Route::get('/reports/leave',      LeaveReport::class)->name('reports.leave');
    Route::get('/reports/payroll',    PayrollReport::class)->name('reports.payroll');

    // Settings
    Route::get('/settings/company', CompanySettings::class)->name('settings.company');
    Route::get('/settings/profile', ProfileSettings::class)->name('settings.profile');


    // PDF Exports
Route::get('/pdf/payslip/{payroll}', [PdfController::class, 'payslip'])->name('pdf.payslip');
Route::get('/pdf/attendance-report', [PdfController::class, 'attendanceReport'])->name('pdf.attendance');
Route::get('/pdf/leave-report',      [PdfController::class, 'leaveReport'])->name('pdf.leave');
Route::get('/pdf/payroll-report',    [PdfController::class, 'payrollReport'])->name('pdf.payroll');

Route::get('/audit-log', AuditLogIndex::class)->name('audit.index');

Route::get('/notifications', NotificationIndex::class)->name('notifications.index');

// Recruitment
Route::get('/recruitment',                  JobIndex::class)->name('recruitment.jobs');
Route::get('/recruitment/create',           JobCreate::class)->name('recruitment.jobs.create');
Route::get('/recruitment/{job}/edit',       JobCreate::class)->name('recruitment.jobs.edit');
Route::get('/recruitment/{job}/applicants', ApplicantIndex::class)->name('recruitment.applicants');

// Performance Reviews
Route::get('/performance',              PerformanceIndex::class)->name('performance.index');
Route::get('/performance/create',       PerformanceCreate::class)->name('performance.create');
Route::get('/performance/{review}/edit', PerformanceCreate::class)->name('performance.edit');
// Expense Claims
Route::get('/expenses', ExpenseIndex::class)->name('expenses.index');

// Shifts
Route::get('/shifts',        ShiftIndex::class)->name('shifts.index');
Route::get('/shifts/roster', ShiftRoster::class)->name('shifts.roster');

});

// -----------------------------------------------
// EMPLOYEE PORTAL ROUTES
// -----------------------------------------------
Route::middleware(['auth', 'employee'])->prefix('portal')->group(function () {

    Route::get('/dashboard',   EmployeeDashboard::class)->name('employee.dashboard');
    Route::get('/leave/apply', EmployeeLeaveApply::class)->name('employee.leave.apply');
    Route::get('/attendance',  EmployeeAttendance::class)->name('employee.attendance');
    Route::get('/payslips',    EmployeePayslips::class)->name('employee.payslips');
    Route::get('/notifications', NotificationIndex::class)->name('employee.notifications');
    Route::get('/expenses', EmployeeExpenses::class)->name('employee.expenses');
    Route::get('/shifts', EmployeeShifts::class)->name('employee.shifts');


});

// -----------------------------------------------
// REDIRECT ROOT
// -----------------------------------------------

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->hasRole('admin')
            ? redirect()->route('dashboard')
            : redirect()->route('employee.dashboard');
    }
    return redirect()->route('login');
});
Route::get('/language/{locale}', [LanguageController::class, 'switch'])
    ->middleware('auth')
    ->name('language.switch');
require __DIR__.'/auth.php';