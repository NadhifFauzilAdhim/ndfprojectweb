<div class="d-flex flex-column justify-content-center align-items-center min-vh-100 position-relative sticky-header-offset"
    style="background-color: #0f172a; overflow: hidden;">

    <!-- Ambient Background Effects -->
    <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="z-index: 0; pointer-events: none;">
        <div class="position-absolute rounded-circle"
            style="width: 600px; height: 600px; background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(15, 23, 42, 0) 70%); top: -10%; left: -10%; filter: blur(60px);">
        </div>
        <div class="position-absolute rounded-circle"
            style="width: 500px; height: 500px; background: radial-gradient(circle, rgba(236, 72, 153, 0.1) 0%, rgba(15, 23, 42, 0) 70%); bottom: -10%; right: -10%; filter: blur(60px);">
        </div>
    </div>

    <!-- Main Content -->
    <div class="container position-relative z-1">

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <!-- Header -->
                <div class="text-center mb-5">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle"
                        style="width: 60px; height: 60px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);">
                        <i class="bi bi-link-45deg fs-2 text-white fs-7"></i>
                    </div>
                    <h1 class="fw-bold text-white display-6 mb-2" style="letter-spacing: -0.5px;">Shorten URL</h1>
                    <p class="text-secondary small text-uppercase fw-semibold ls-2">Instant & Secure</p>
                </div>

                <!-- Result Card (Shows on Success) -->
                @if ($generated_link)
                    <div class="glass-card p-4 rounded-4 mb-5 border-success-subtle position-relative overflow-hidden"
                        style="border: 1px solid rgba(34, 197, 94, 0.3);">
                        <div class="position-absolute top-0 start-0 w-100 h-100"
                            style="background: radial-gradient(circle at top right, rgba(34, 197, 94, 0.1), transparent); pointer-events: none;">
                        </div>

                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10 text-success mb-3"
                                style="width: 50px; height: 50px;">
                                <i class="bi bi-check-lg fs-3"></i>
                            </div>
                            <h4 class="text-white fw-bold mb-1">Link Created!</h4>
                            <p class="text-secondary small">Your secure shortlink is ready to use.</p>
                        </div>

                        <div
                            class="input-group bg-dark bg-opacity-50 rounded-3 p-1 border border-secondary border-opacity-25 align-items-center">
                            <input type="text"
                                class="form-control bg-transparent border-0 text-white shadow-none px-3"
                                value="{{ $generated_link }}" readonly
                                style="font-family: 'Courier New', monospace; font-size: 0.95rem;">
                            <button class="btn btn-primary rounded-3 fw-semibold px-4 py-2"
                                onclick="navigator.clipboard.writeText('{{ $generated_link }}'); this.innerHTML = '<i class=\'bi bi-check2 me-1\'></i>Copied!'; setTimeout(() => this.innerHTML = 'Copy', 2000);">
                                Copy
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <button wire:click="$set('generated_link', null)"
                                class="btn btn-link text-secondary text-decoration-none btn-sm hover-text-white transition-all">
                                <i class="bi bi-plus-lg me-1"></i>Shorten another link
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Form Card -->
                @if (!$generated_link)
                    <div class="glass-card p-4 p-md-5 rounded-4">
                        <form wire:submit.prevent="save">

                            <div class="mb-4">
                                <label for="target_url"
                                    class="form-label text-white-50 small fw-bold text-uppercase ls-1 mb-2">Target
                                    URL</label>
                                <div class="position-relative">
                                    <input type="url" class="form-control form-control-lg dark-input ps-3"
                                        id="target_url" wire:model="target_url"
                                        placeholder="Paste your long URL here..." required>
                                    <div class="position-absolute top-50 end-0 translate-middle-y me-3 text-secondary">
                                        <i class="bi bi-globe2"></i>
                                    </div>
                                </div>
                                @error('target_url')
                                    <span class="text-danger small mt-1 d-block"><i
                                            class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="title"
                                        class="form-label text-white-50 small fw-bold text-uppercase ls-1 mb-2">Title
                                        <span class="text-secondary opacity-50 fw-normal ms-1">(Optional)</span></label>
                                    <input type="text" class="form-control dark-input" id="title"
                                        wire:model="title" placeholder="e.g. My Portfolio">
                                    @error('title')
                                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="custom_slug"
                                        class="form-label text-white-50 small fw-bold text-uppercase ls-1 mb-2">Custom
                                        Alias</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control dark-input border-end-0"
                                            id="custom_slug" wire:model="custom_slug" placeholder="alias">
                                        <button class="btn btn-outline-secondary border-start-0 border-opacity-10"
                                            type="button" wire:click="generateSlug" data-bs-toggle="tooltip"
                                            title="Generate Random">
                                            <i class="bi bi-magic"></i>
                                        </button>
                                    </div>
                                    @error('custom_slug')
                                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit"
                                class="btn btn-primary w-100 py-3 rounded-3 fw-bold text-uppercase ls-1 gradient-btn shadow-lg position-relative overflow-hidden">
                                <span wire:loading.remove wire:target="save">Shorten Link</span>
                                <span wire:loading wire:target="save">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"
                                        aria-hidden="true"></span>
                                    Processing...
                                </span>
                            </button>

                        </form>
                    </div>
                @endif

                <div class="text-center mt-4">
                    <p class="text-white-50 small mb-0">Powered by <span class="text-white fw-bold">Linksy</span>. <a
                            href="/dashboard" class="text-white-50 text-decoration-underline">Dashboard</a></p>
                </div>

            </div>
        </div>
    </div>

    <!-- Styles -->
    <style>
        .ls-1 {
            letter-spacing: 1px;
        }

        .ls-2 {
            letter-spacing: 2px;
        }

        .sticky-header-offset {
            /* Fix for sticky headers usually taking up space */
            padding-top: 80px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .dark-input {
            background-color: rgba(0, 0, 0, 0.3) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            transition: all 0.3s ease;
        }

        .dark-input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .dark-input:focus {
            background-color: rgba(0, 0, 0, 0.5) !important;
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
        }

        .gradient-btn {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border: none;
            transition: transform 0.2s;
        }

        .gradient-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(124, 58, 237, 0.5) !important;
        }

        .gradient-btn:active {
            transform: translateY(0);
        }

        .hover-text-white:hover {
            color: #fff !important;
        }

        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
</div>
