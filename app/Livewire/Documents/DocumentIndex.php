<?php

namespace App\Livewire\Documents;

use App\Models\Employee;
use App\Models\EmployeeDocument;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class DocumentIndex extends Component
{
    use WithFileUploads, WithPagination;

    public string $search   = '';
    public string $category = '';
    public string $message  = '';

    // Upload form
    public bool    $showUploadModal = false;
    public ?int    $uploadEmployeeId = null;
    public string  $title    = '';
    public string  $docCategory = 'general';
    public ?string $expiryDate  = null;
    public         $file = null;

    public function updatingSearch(): void { $this->resetPage(); }

    public function openUpload(int $employeeId): void
    {
        $this->uploadEmployeeId = $employeeId;
        $this->reset(['title', 'docCategory', 'expiryDate', 'file']);
        $this->docCategory   = 'general';
        $this->showUploadModal = true;
    }

    public function upload(): void
    {
        $this->validate([
            'title'       => 'required|string|max:150',
            'docCategory' => 'required|in:id,contract,certificate,general',
            'expiryDate'  => 'nullable|date',
            'file'        => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
        ]);

        $path     = $this->file->store("documents/{$this->uploadEmployeeId}", 'local');
        $fileName = $this->file->getClientOriginalName();

        EmployeeDocument::create([
            'employee_id' => $this->uploadEmployeeId,
            'title'       => $this->title,
            'category'    => $this->docCategory,
            'file_path'   => $path,
            'file_name'   => $fileName,
            'expiry_date' => $this->expiryDate ?: null,
        ]);

        $this->reset(['showUploadModal', 'uploadEmployeeId', 'title', 'docCategory', 'expiryDate', 'file']);
        $this->message = 'Document uploaded successfully.';
    }

    public function verify(int $docId): void
    {
        EmployeeDocument::findOrFail($docId)->update(['is_verified' => true]);
        $this->message = 'Document verified.';
    }

    public function delete(int $docId): void
    {
        $doc = EmployeeDocument::findOrFail($docId);
        Storage::disk('local')->delete($doc->file_path);
        $doc->delete();
        $this->message = 'Document deleted.';
    }

    public function download(int $docId)
    {
        $doc = EmployeeDocument::findOrFail($docId);
        return Storage::disk('local')->download($doc->file_path, $doc->file_name);
    }

    public function render()
    {
        $employees = Employee::query()
            ->with(['documents' => function ($q) {
                if ($this->category) {
                    $q->where('category', $this->category);
                }
                $q->orderBy('created_at', 'desc');
            }])
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('first_name', 'like', "%{$this->search}%")
                  ->orWhere('last_name',  'like', "%{$this->search}%")
                  ->orWhere('emp_code',   'like', "%{$this->search}%");
            }))
            ->where('status', 'active')
            ->orderBy('first_name')
            ->paginate(10);

        // Expiring within 30 days
        $expiringSoon = EmployeeDocument::with('employee')
            ->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '>=', today())
            ->whereDate('expiry_date', '<=', today()->addDays(30))
            ->orderBy('expiry_date')
            ->get();

        return view('livewire.documents.document-index', [
            'employees'    => $employees,
            'expiringSoon' => $expiringSoon,
        ])->layout('layouts.app', ['title' => 'Documents']);
    }
}
