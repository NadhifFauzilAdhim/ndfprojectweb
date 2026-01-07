<div class="d-flex flex-column w-100 position-relative overflow-hidden" style="height: 100vh; background-color: #020617;"
    wire:poll.30s>
    <style>
        /* Global Overrides */
        #footer,
        .crisp-client,
        div[id^="crisp-"] {
            display: none !important;
        }

        /* Animations */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Glassmorphism Utilities */
        .glass-panel {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .glass-input {
            background: rgba(30, 41, 59, 0.7) !important;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #f1f5f9 !important;
            transition: all 0.3s ease;
        }

        .glass-input:focus {
            background: rgba(30, 41, 59, 0.9) !important;
            border-color: #6366f1 !important;
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.2) !important;
        }

        /* Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.2);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Message Bubbles */
        .bubble-self {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            border-radius: 20px 20px 4px 20px;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .bubble-other {
            background: rgba(30, 41, 59, 0.8);
            color: #f1f5f9;
            border-radius: 20px 20px 20px 4px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* User Avatar */
        .avatar-glow {
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.2);
            transition: transform 0.2s ease;
            width: 40px;
            height: 40px;
            border-radius: 20px;
            object-fit: cover;
        }

        .avatar-glow:hover {
            transform: scale(1.05);
        }

        /* Background Effects */
        .bg-gradient-mesh {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 15% 50%, rgba(79, 70, 229, 0.08) 0%, transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(124, 58, 237, 0.08) 0%, transparent 25%);
            z-index: 0;
            pointer-events: none;
        }
    </style>

    <script>
        document.addEventListener('livewire:initialized', () => {
            // Hide Crisp logic
            if (window.$crisp) window.$crisp.push(["do", "chat:hide"]);
            const style = document.createElement('style');
            style.innerHTML = '.crisp-client { display: none !important; }';
            document.head.appendChild(style);

            // Scroll Logic
            const container = document.getElementById('chat-container');
            const scrollBottom = () => {
                const targetScroll = container.scrollHeight;
                container.scrollTo({
                    top: targetScroll,
                    behavior: 'smooth'
                });
            };

            // Initial scroll
            container.scrollTop = container.scrollHeight;

            Livewire.hook('morph.updated', () => {
                if (container.scrollHeight - container.scrollTop <= container.clientHeight + 250) {
                    scrollBottom();
                }
            });
        });
    </script>

    <!-- Mesh Background -->
    <div class="bg-gradient-mesh"></div>

    <!-- Header -->
    <div class="glass-panel position-absolute top-0 w-100 px-4 py-3 d-flex align-items-center justify-content-between z-3"
        style="height: 80px;">
        <div class="d-flex align-items-center gap-3">
            <div class="position-relative">
                <div class="d-flex align-items-center justify-content-center rounded-circle bg-indigo-500 bg-opacity-20"
                    style="width: 48px; height: 48px; background: rgba(99, 102, 241, 0.1);">
                    <i class="bi bi-chat-dots-fill text-white"></i>
                </div>
                <div class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-dark"
                    style="width: 12px; height: 12px;"></div>
            </div>
            <div>
                <h5 class="fw-bold text-white mb-0" style="letter-spacing: -0.5px;">Community Forum</h5>
                <div class="d-flex align-items-center gap-2 text-secondary" style="font-size: 0.8rem;">
                    <span class="pulse-dot bg-success d-inline-block rounded-circle"
                        style="width: 6px; height: 6px;"></span>
                    <span>Live Discussion</span>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-icon text-white opacity-50 hover-opacity-100 transition-all">
                <iconify-icon icon="solar:menu-dots-bold" class="fs-4"></iconify-icon>
            </button>
        </div>
    </div>

    <!-- Chat Body -->
    <div class="flex-grow-1 overflow-auto custom-scrollbar p-4 position-relative z-1 d-flex flex-column"
        id="chat-container" style="padding-top: 100px !important; padding-bottom: 100px !important;">

        <!-- Welcome/Empty State -->
        @if ($messages->isEmpty())
            <div class="m-auto text-center" style="animation: fadeInScale 0.5s ease-out;">
                <div class="d-inline-flex p-4 rounded-circle mb-3" style="background: rgba(99, 102, 241, 0.05);">
                    <iconify-icon icon="solar:chat-square-like-bold-duotone"
                        class="fs-1 text-white opacity-50"></iconify-icon>
                </div>
                <h4 class="text-white fw-bold mb-2">It's quiet here...</h4>
                <p class="text-secondary mb-0">Be the first to spark a conversation!</p>
            </div>
        @else
            <div class="mt-auto d-flex flex-column gap-3">
                <!-- Notice -->
                <div class="align-self-center my-4 px-4 py-2 rounded-pill mt-5"
                    style="background: rgba(234, 179, 8, 0.1); border: 1px solid rgba(234, 179, 8, 0.2); max-width: 90%;">
                    <p class="mb-0 text-center" style="color: #fde047; font-size: 0.85rem;">
                        <iconify-icon icon="solar:shield-warning-bold" class="me-1 position-relative"
                            style="top: 2px;"></iconify-icon>
                        Reminder: This acts as a public forum. Please keep conversations respectful.
                    </p>
                </div>

                @foreach ($messages as $msg)
                    @php
                        $isSelf = $msg->user_id === auth()->id();
                        $isAdmin = auth()->user()->is_admin ?? false;
                    @endphp

                    <div
                        class="d-flex {{ $isSelf ? 'justify-content-end' : 'justify-content-start' }} w-100 animate__animated animate__fadeInUp animate__faster gap-3">

                        @if (!$isSelf)
                            <div class="d-flex flex-column justify-content-end pb-1">
                                <img src="{{ $msg->user->avatar ? asset('public/' . $msg->user->avatar) : $msg->user->google_avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($msg->user->name) }}"
                                    alt="{{ $msg->user->name }}" class="avatar-glow">
                            </div>
                        @endif

                        <div class="d-flex flex-column {{ $isSelf ? 'align-items-end' : 'align-items-start' }}"
                            style="max-width: 75%;">
                            @if (!$isSelf)
                                <span class="text-secondary ms-2 mb-1 fw-medium" style="font-size: 0.75rem;">
                                    {{ $msg->user->name }}
                                </span>
                            @endif

                            <div class="px-3 py-2 position-relative {{ $isSelf ? 'bubble-self' : 'bubble-other' }}"
                                style="width: fit-content;">
                                <p class="mb-0" style="font-size: 0.95rem; line-height: 1.5; word-break: break-word;">
                                    {{ $msg->message }}</p>
                            </div>

                            <div class="d-flex align-items-center gap-2 mt-1 px-1">
                                <span class="text-secondary opacity-75" style="font-size: 0.7rem;">
                                    {{ $msg->created_at->format('H:i') }}
                                </span>
                                @if ($isSelf || $isAdmin)
                                    <button wire:click="deleteMessage({{ $msg->id }})"
                                        wire:confirm="Are you sure you want to delete this message?"
                                        class="btn p-0 text-danger opacity-50 hover-opacity-100 transition-all"
                                        title="Delete Message">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </div>

                        @if ($isSelf)
                            <div class="d-flex flex-column justify-content-end pb-1">
                                <img src="{{ auth()->user()->avatar ? asset('public/' . auth()->user()->avatar) : auth()->user()->google_avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                                    alt="Me" class="avatar-glow">
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Floating Input Footer -->
    <div class="position-absolute bottom-0 w-100 p-4 z-3">
        <div class="container-fluid px-0" style="max-width: 900px; margin: 0 auto;">
            <form wire:submit.prevent="sendMessage" class="position-relative">
                <div class="position-relative">
                    <input type="text" wire:model="message"
                        class="form-control glass-input rounded-pill py-3 px-4 shadow-lg w-100"
                        placeholder="Write your thought..." style="padding-right: 120px;" autofocus>

                    <button type="submit"
                        class="btn position-absolute top-50 translate-middle-y rounded-circle d-flex align-items-center justify-content-center p-0"
                        style="right: 8px; width: 42px; height: 42px; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border: none; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);"
                        wire:loading.attr="disabled">

                        <span wire:loading.remove>
                            <i class="bi bi-send text-white"></i>
                        </span>

                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm text-white" role="status"
                                aria-hidden="true"></span>
                        </span>
                    </button>
                </div>
                @error('message')
                    <div class="text-danger small mt-2 ms-3 animate__animated animate__fadeIn">{{ $message }}</div>
                @enderror
            </form>
        </div>
    </div>
</div>
