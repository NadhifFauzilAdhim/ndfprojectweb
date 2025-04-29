<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tracking;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TrackingIndex extends Component
{
    use WithPagination;

    public $showAddModal = false;
    public $title;
    public $target_url;
    public $slug;
    public $selectedTracking;

    protected $listeners = ['refreshTrackings' => '$refresh'];

    protected $rules = [
        'title' => 'required|max:255',
        'target_url' => 'required|url',
        'slug' => 'nullable|regex:/^[\S]+$/|unique:trackings,slug',
    ];

    public function openAddModal()
    {
        $this->resetForm();
        $this->showAddModal = true;
    }

    public function save()
    {
        $this->validate();

        if (empty($this->slug)) {
            do {
                $slug = Str::random(5);
            } while (Tracking::where('slug', $slug)->exists());
            $this->slug = $slug;
        }

        Tracking::create([
            'title' => $this->title,
            'target_url' => filter_var($this->target_url, FILTER_SANITIZE_URL),
            'slug' => $this->slug,
            'user_id' => Auth::id(),
        ]);

        $this->showAddModal = false;
        $this->dispatch('notify', type: 'success', message: 'Tracking created successfully');
        $this->resetForm();
    }

    public function delete($id)
    {
        $tracking = Tracking::findOrFail($id);
        $tracking->delete();
        $this->dispatch('notify', type: 'success', message: 'Tracking deleted successfully');
    }

    public function copySlug($slug)
    {
        $this->dispatch('copy-to-clipboard', text: url('t/' . $slug));
        $this->dispatch('notify', type: 'info', message: 'Link copied to clipboard');
    }

    private function resetForm()
    {
        $this->reset(['title', 'target_url', 'slug']);
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.tracking-index', [
            'trackings' => Tracking::with(['trackingHistories' => fn($q) => $q->latest()->limit(3)])
                ->withCount(['trackingHistories as unique_visits' => fn($q) => $q->where('is_unique', true)])
                ->latest()
                ->paginate(20)
        ])
        ->layout('components.dashlayout', [ // Tambahkan ini
            'title' => 'Tracking Links' // Kirim title ke layout
        ]);
    }
}
