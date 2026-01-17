<?php

namespace App\Livewire;

use App\Models\Link;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Throttle; // 1. Import Throttle
use Livewire\Component;

class InstantShortlink extends Component
{
    use LivewireAlert;

    public $target_url;

    public $custom_slug;

    public $title;

    public $generated_link;

    public function rules()
    {
        return [
            'target_url' => [
                'required',
                'url',
                'starts_with:http,https',
                function ($attribute, $value, $fail) {
                    $host = parse_url($value, PHP_URL_HOST);
                    $appHost = parse_url(config('app.url'), PHP_URL_HOST);

                    if ($host === $appHost) {
                        $fail('You cannot create a short link for this domain.');
                    }
                },
            ],
            'custom_slug' => 'nullable|alpha_dash|unique:links,slug|min:3|max:50',
            'title' => 'nullable|string|max:255',
        ];
    }

    public function generateSlug()
    {
        $this->custom_slug = Str::random(6);
    }

    #[Throttle(5, 1)]
    public function save()
    {
        $this->validate();

        if ($this->custom_slug) {
            $slug = $this->custom_slug;
        } else {
            $slug = $this->generateUniqueSlug();
        }

        try {
            Link::create([
                'user_id' => Auth::id() ?? null,
                'target_url' => $this->target_url,
                'slug' => $slug,
                'title' => $this->title ? strip_tags($this->title) : 'Instant Link',
                'active' => true,
            ]);

            $this->generated_link = config('app.shorting_url.base_url').'/'.$slug;

            $this->reset(['target_url', 'custom_slug', 'title']);

            $this->dispatch('linkCreated', link: $this->generated_link);

        } catch (\Exception $e) {
            $this->alert('error', 'An error occurred or the slug is already taken. Please try again.');
        }
    }

    /**
     * Recursive function or loop to find a truly unique random slug
     */
    protected function generateUniqueSlug()
    {
        $maxAttempts = 5;
        $attempt = 0;

        do {
            $slug = Str::random(6);
            $exists = Link::where('slug', $slug)->exists();
            $attempt++;
        } while ($exists && $attempt < $maxAttempts);

        if ($exists) {
            abort(503, 'Unable to generate unique link. Please try again.');
        }

        return $slug;
    }

    #[Layout('components.layout')]
    public function render()
    {
        return view('livewire.instant-shortlink');
    }
}
