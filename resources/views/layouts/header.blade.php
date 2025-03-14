<style>
    .header-nav-custom {
        background-image: linear-gradient(282deg,#00b0ff 5.54%,#3e98eb)!important;
        padding-bottom: unset;
    }

    .header-nav-custom .navbar-brand {
        font-weight: 600;
        color: #fff;
        font-size: 1.5rem;
        text-transform: uppercase;
        font-style: italic;
    }

    .header-nav-custom .header-container {
        display: flex;
        flex-wrap: inherit;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 10px 40px;
        border-bottom: 1.5px solid #ccc;
    }

    .header-nav-custom .nav-link {
        color: #fff !important;
    }
</style>

<nav class="navbar header-nav-custom navbar-expand-lg bg-body-tertiary">
    <div class="header-container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                Accessary
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> 

            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu" style="right: 0; left: unset;">
                    <li><a class="dropdown-item" href="{{ route('user.info') }}">Thông tin tài khoản</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.change_password') }}">Đổi mật khẩu</a></li>
                    <li id="logoutBtn"><a class="dropdown-item" href="#">Đăng xuất</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
