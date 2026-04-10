<?php

namespace App\Livewire\Performance;

use App\Models\PerformanceReview;
use App\Models\ReviewCriteria;
use App\Models\Employee;
use Livewire\Component;

class PerformanceCreate extends Component
{
    public ?int    $editId             = null;
    public ?int    $employee_id        = null;
    public string  $period_type        = 'quarterly';
    public string  $cycle              = '';
    public int     $year;
    public string  $strengths          = '';
    public string  $improvements       = '';
    public string  $goals_next_period  = '';
    public string  $status             = 'draft';

    // Dynamic criteria rows
    public array $criteriaRows = [];

    // Default criteria templates
    public array $defaultCriteria = [
        'Work Quality',
        'Productivity',
        'Communication',
        'Teamwork',
        'Punctuality',
    ];

    public function mount(?PerformanceReview $review = null): void
{
    $this->year = now()->year;

    // Load default criteria rows
    foreach ($this->defaultCriteria as $c) {
        $this->criteriaRows[] = [
            'criteria' => $c,
            'rating'   => 3,
            'comment'  => '',
        ];
    }

    if ($review && $review->exists) {
        $this->editId            = $review->id;
        $this->employee_id       = $review->employee_id;
        $this->period_type       = $review->period_type;
        $this->cycle             = $review->cycle;
        $this->year              = $review->year;
        $this->strengths         = $review->strengths ?? '';
        $this->improvements      = $review->improvements ?? '';
        $this->goals_next_period = $review->goals_next_period ?? '';
        $this->status            = $review->status;

        // Replace default criteria with saved ones
        $this->criteriaRows = $review->criteria->map(fn($c) => [
            'criteria' => $c->criteria,
            'rating'   => $c->rating,
            'comment'  => $c->comment ?? '',
        ])->toArray();
    }

    $this->generateCycle();
}

    public function updatedPeriodType(): void
    {
        $this->generateCycle();
    }

    public function updatedYear(): void
    {
        $this->generateCycle();
    }

    private function generateCycle(): void
    {
        $this->cycle = match($this->period_type) {
            'quarterly'    => 'Q' . ceil(now()->month / 3) . '-' . $this->year,
            'half_yearly'  => (now()->month <= 6 ? 'H1' : 'H2') . '-' . $this->year,
            'annual'       => 'Annual-' . $this->year,
            default        => $this->year,
        };
    }

    public function addCriteria(): void
    {
        $this->criteriaRows[] = ['criteria' => '', 'rating' => 3, 'comment' => ''];
    }

    public function removeCriteria(int $index): void
    {
        unset($this->criteriaRows[$index]);
        $this->criteriaRows = array_values($this->criteriaRows);
    }

    public function save(string $submitStatus = 'draft'): void
    {
        $this->validate([
            'employee_id' => 'required|exists:employees,id',
            'period_type' => 'required|in:quarterly,half_yearly,annual',
            'year'        => 'required|integer|min:2020|max:2030',
        ]);

        // Calculate overall score
        $totalRating = collect($this->criteriaRows)->sum('rating');
        $avgScore    = count($this->criteriaRows) > 0
            ? round($totalRating / count($this->criteriaRows), 2)
            : null;

        $data = [
            'employee_id'       => $this->employee_id,
            'reviewer_id'       => auth()->id(),
            'cycle'             => $this->cycle,
            'period_type'       => $this->period_type,
            'year'              => $this->year,
            'overall_score'     => $avgScore,
            'strengths'         => $this->strengths,
            'improvements'      => $this->improvements,
            'goals_next_period' => $this->goals_next_period,
            'status'            => $submitStatus,
            'submitted_at'      => $submitStatus === 'submitted' ? now() : null,
        ];

        if ($this->editId) {
            $review = PerformanceReview::findOrFail($this->editId);
            $review->update($data);
            $review->criteria()->delete();
        } else {
            $review = PerformanceReview::create($data);
        }

        // Save criteria
        foreach ($this->criteriaRows as $row) {
            if (!empty($row['criteria'])) {
                ReviewCriteria::create([
                    'performance_review_id' => $review->id,
                    'criteria'              => $row['criteria'],
                    'rating'                => $row['rating'],
                    'comment'               => $row['comment'] ?? '',
                ]);
            }
        }

        session()->flash('success', $submitStatus === 'submitted' ? 'Review submitted!' : 'Review saved as draft.');
        $this->redirect(route('performance.index'));
    }

    public function render()
    {
        return view('livewire.performance.performance-create', [
            'employees' => Employee::where('status', 'active')->get(),
        ])->layout('layouts.app', ['title' => $this->editId ? 'Edit Review' : 'New Performance Review']);
    }
}
