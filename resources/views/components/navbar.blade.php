<nav id="navbar" class="nav-menu navbar">
    <ul>
        <li>
            <a href="/" class="{{ request()->is('/') ? 'nav-link scrollto active' : 'nav-link scrollto' }} py-2">
                <i class="bi bi-house-door" style="font-size: 1.50em;"></i> <span>Home</span>
            </a>
        </li>
        <li>
            <a href="/#about" class="nav-link scrollto py-1">
                <i class="bi bi-person" style="font-size: 1.50em;"></i> <span>About</span>
            </a>
        </li>
        <li>
            <a href="/#resume" class="nav-link scrollto py-1">
                <i class="bi bi-file-earmark-text" style="font-size: 1.50em;"></i> <span>Resume</span>
            </a>
        </li>
        <li>
            <a href="/#portfolio" class="nav-link scrollto py-1">
                <i class="bi bi-award" style="font-size: 1.50em;"></i> <span>Certificate</span>
            </a>
        </li>
        <li>
            <a href="/#project" class="nav-link scrollto py-1">
                <i class="bi bi-hdd-stack" style="font-size: 1.50em;"></i> <span>Project</span>
            </a>
        </li>
        <li>
            <a href="/#contact" class="nav-link scrollto py-1">
                <i class="bi bi-envelope" style="font-size: 1.50em;"></i> <span>Contact</span>
            </a>
        </li>
        <li>
            <a href="/forum" class="nav-link scrollto py-1 {{ request()->is('forum') ? 'active' : '' }}">
                <i class="bi bi-chat-dots" style="font-size: 1.50em;"></i> <span>Forum</span>
            </a>
        </li>

        <li>
            <a href="/tools" class="nav-link scrollto py-1 {{ request()->is('tools') ? 'active' : '' }}">
                <i class="bi bi-gear" style="font-size: 1.50em;"></i> <span>Tools</span>
            </a>
        </li>
        <li class="dropdown">
            <a href="#" class="nav-link scrollto dropdown-toggle py-1" data-bs-toggle="dropdown" role="button"
                aria-expanded="false">
                <i class="bi bi-pencil-square" style="font-size: 1.50em;"></i> <span>Discover</span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="/blog"
                        class="{{ request()->is('blog') ? 'dropdown-item active' : 'dropdown-item' }} text-dark bg-transparent"><i
                            class="bi bi-pencil-square"></i> My Blog</a></li>
                <li><a href="/event"
                        class="{{ request()->is('event') ? 'dropdown-item active' : 'dropdown-item' }} text-dark bg-transparent"><i
                            class="bi bi-calendar-event"></i> Event</a></li>
            </ul>
        </li>

        @auth
            <li class="dropdown">
                <a href="#" class="nav-link scrollto dropdown-toggle py-1" data-bs-toggle="dropdown" role="button"
                    aria-expanded="false">
                    <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="/dashboard" class="dropdown-item text-dark bg-transparent"><i
                                class="bi bi-speedometer2"></i> Dashboard</a></li>
                    <li>
                        <form action="/logout" method="POST" class="dropdown-item text-dark bg-transparent ps-3 pb-3">
                            @csrf
                            <button class="btn p-0 text-start" type="submit"><i class="bi bi-box-arrow-right fs-5"></i>
                                Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        @else
            <li>
                <a href="/login" class="nav-link scrollto py-1">
                    <i class="bi bi-box-arrow-in-right" style="font-size: 1.50em;"></i>
                    <span>Login</span>
                </a>
            </li>
        @endauth
    </ul>
</nav>
