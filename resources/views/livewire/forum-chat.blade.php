<div class="d-flex flex-column w-100" style="height: 100vh;" wire:poll.30s>
    <style>
        /* Hide Layout Footer and Crisp globally for this view */
        #footer {
            display: none !important;
        }

        .crisp-client {
            display: none !important;
        }

        div[id^="crisp-"] {
            display: none !important;
        }

        .chat-bg-custom {
            background-color: #040b14;
        }

        .card-custom {
            background-color: #040b14;
            border: none;
        }

        .chat-container::-webkit-scrollbar {
            width: 6px;
        }

        .chat-container::-webkit-scrollbar-track {
            background: #040b14;
        }

        .chat-container::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 10px;
        }

        .chat-container::-webkit-scrollbar-thumb:hover {
            background: #334155;
        }

        .message-bubble-self {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
            border-radius: 18px 18px 0 18px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .message-bubble-other {
            background-color: #1e293b;
            color: #f1f5f9;
            border-radius: 18px 18px 18px 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .input-dark {
            background-color: #1e293b !important;
            border: 1px solid #334155 !important;
            color: #f8fafc !important;
        }

        .input-dark::placeholder {
            color: #94a3b8 !important;
        }

        .input-dark:focus {
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.5) !important;
            border-color: #6366f1 !important;
        }

        .avatar-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #040b14;
        }

        .card .card-body p {
            color: #ffffff;
        }

        .card-custom:hover,
        .card-custom:active,
        .card-custom:focus,
        .card-custom:focus-within {
            transform: none !important;
            transition: none !important;
            border: none !important;
            box-shadow: none !important;
            outline: none !important;
        }

        .hover-opacity-100:hover {
            opacity: 1 !important;
        }
    </style>

    <script>
        document.addEventListener('livewire:initialized', () => {
            if (window.$crisp) {
                window.$crisp.push(["do", "chat:hide"]);
            }
            const style = document.createElement('style');
            style.innerHTML = '.crisp-client { display: none !important; }';
            document.head.appendChild(style);
        });
    </script>

    <div class="card card-custom shadow-none h-100 rounded-0">
        <div class="card-header border-bottom border-secondary border-opacity-25 py-3" style="background-color: #040b14;">
            <div class="d-flex align-items-center justify-content-between px-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-gradient rounded-circle p-2 d-flex align-items-center justify-content-center"
                        style="width: 45px; height: 45px;">
                        <i class="bi bi-chat-dots-fill fs-4 text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-white">Community Chat</h5>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success bg-opacity-25 text-white rounded-pill px-2 py-1"
                                style="font-size: 0.65rem;">
                                <span class="d-inline-block rounded-circle bg-success me-1"
                                    style="width: 6px; height: 6px;"></span>
                                Live
                            </span>
                            <small class="text-secondary">Auto updates every 30s</small>
                        </div>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="btn btn-icon btn-outline-secondary border-0 rounded-circle" type="button">
                        <iconify-icon icon="solar:menu-dots-bold" class="fs-4"></iconify-icon>
                    </button>
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="card-body overflow-auto chat-container p-4 d-flex flex-column" id="chat-container"
            style="background-image: radial-gradient(#1e293b 1px, transparent 1px); background-size: 20px 20px; background-color: #040b14;">
            <div class="d-flex flex-column gap-4 mt-auto">
                @forelse($messages as $msg)
                    <div
                        class="d-flex w-100 {{ $msg->user_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }} animate__animated animate__fadeInUp animate__faster gap-2">
                        @if ($msg->user_id !== auth()->id())
                            <div class="flex-shrink-0 align-self-end mb-1">
                                @if ($msg->user->avatar)
                                    <img src="{{ asset('public/' . $msg->user->avatar) }}" alt="{{ $msg->user->name }}"
                                        class="avatar-img lazyload">
                                @elseif($msg->user->google_avatar)
                                    <img src="{{ $msg->user->google_avatar }}" alt="{{ $msg->user->name }}"
                                        class="avatar-img lazyload">
                                @else
                                    <img src="https://img.icons8.com/color/500/user-male-circle--v1.png"
                                        alt="{{ $msg->user->name }}" class="avatar-img lazyload">
                                @endif
                            </div>
                        @endif

                        <div class="d-flex flex-column {{ $msg->user_id === auth()->id() ? 'align-items-end' : 'align-items-start' }}"
                            style="max-width: 75%;">

                            @if ($msg->user_id !== auth()->id())
                                <small class="text-secondary ms-1 mb-1"
                                    style="font-size: 0.75rem;">{{ $msg->user->name }}</small>
                            @endif

                            <div
                                class="p-3 {{ $msg->user_id === auth()->id() ? 'message-bubble-self' : 'message-bubble-other' }}">
                                <p class="mb-0" style="line-height: 1.5; font-size: 0.95rem;">
                                    {{ $msg->message }}
                                </p>
                            </div>

                            <div
                                class="d-flex align-items-center gap-2 mt-1 {{ $msg->user_id === auth()->id() ? 'me-1' : 'ms-1' }}">
                                @if ($msg->user_id === auth()->id())
                                    <button wire:click="deleteMessage({{ $msg->id }})"
                                        wire:confirm="Are you sure you want to delete this message?"
                                        class="btn btn-link p-0 text-danger opacity-50 hover-opacity-100"
                                        style="font-size: 0.85rem; text-decoration: none; transition: opacity 0.2s;"
                                        title="Delete message">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endif
                                <small class="text-secondary" style="font-size: 0.7rem;">
                                    {{ $msg->created_at->format('H:i') }}
                                </small>
                            </div>
                        </div>

                        <!-- Self User Avatar -->
                        @if ($msg->user_id === auth()->id())
                            <div class="flex-shrink-0 align-self-end mb-1">
                                @if (auth()->user()->avatar)
                                    <img src="{{ asset('public/' . auth()->user()->avatar) }}"
                                        alt="{{ auth()->user()->name }}" class="avatar-img lazyload">
                                @elseif(auth()->user()->google_avatar)
                                    <img src="{{ auth()->user()->google_avatar }}" alt="{{ auth()->user()->name }}"
                                        class="avatar-img lazyload">
                                @else
                                    <img src="https://img.icons8.com/color/500/user-male-circle--v1.png"
                                        alt="{{ auth()->user()->name }}" class="avatar-img lazyload">
                                @endif
                            </div>
                        @endif

                    </div>
                @empty
                    <div class="text-center my-auto">
                        <div class="bg-dark bg-opacity-50 rounded-circle p-4 d-inline-block mb-3">
                            <iconify-icon icon="solar:chat-square-like-bold-duotone"
                                class="fs-1 text-secondary opacity-50"></iconify-icon>
                        </div>
                        <h6 class="text-secondary mb-1">It's quiet here...</h6>
                        <p class="text-secondary opacity-75 small">Start the conversation by sending a message!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="card-footer p-3 border-top border-secondary border-opacity-25" style="background-color: #040b14;">
            <form wire:submit.prevent="sendMessage">
                <div class="input-group">
                    <input type="text" wire:model="message"
                        class="form-control rounded-start-4 input-dark py-3 ps-4 shadow-none"
                        placeholder="Type a message..." autofocus>
                    <button class="btn btn-primary rounded-end-4 px-4 fw-bold" type="submit"
                        wire:loading.attr="disabled"
                        style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border: none;">
                        <span wire:loading.remove class="d-flex align-items-center gap-2">
                            Send <iconify-icon icon="solar:plain-bold-duotone" class="fs-5"></iconify-icon>
                        </span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            const container = document.getElementById('chat-container');
            container.scrollTop = container.scrollHeight;

            Livewire.hook('morph.updated', ({
                el,
                component
            }) => {
                const container = document.getElementById('chat-container');
                if (container.scrollHeight - container.scrollTop <= container.clientHeight + 150) {
                    container.scrollTo({
                        top: container.scrollHeight,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</div>
