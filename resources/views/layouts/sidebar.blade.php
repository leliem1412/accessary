<style>
    .sidebar {
        width: 250px;
        min-height: calc(100vh - 75.5px);
        background-color: #fff;
        top: 0;
        left: 0;
        border-bottom: 1px solid #ccc;
        border-right: 1px solid #ccc;
        overflow: hidden;
        overflow-y: auto;
        padding-block: 20px;
    }
    .sidebar ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    .sidebar ul li {
        text-align: left;
        text-align: left;
        padding-left: 10px;
        padding-right: 10px;
        padding-bottom: 5px;
    }
    .sidebar ul li a {
        display: block;
        color: #000 !important;
        text-decoration: none;
        padding: 15px 20px;
        transition: 0.3s;
        border-radius: 10px;
    }
    .sidebar ul li a:hover,
    .sidebar ul li a.active {
        background: linear-gradient(282deg, #00b0ff 5.54%, #3e98eb) !important;;
        color: #fff !important;
    }
    .navbar-nav-custom .nav-item .nav-link {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 10px;
    }
    .content {
        margin-left: 250px;
        padding: 20px;
        flex-grow: 1;
    }
</style>

@php
    $isDashboardRoute = Route::is('dashboard');
    $isCustomerRoute = Route::is('customer.list') 
        || Route::is('customer.detail') 
        || Route::is('customer.create') 
        || Route::is('customer.edit');

    $isProductRoute = Route::is('product.list')
        || Route::is('product.detail')
        || Route::is('product.create')
        || Route::is('product.edit');

    $isServiceRoute = Route::is('service.list')
        || Route::is('service.detail')
        || Route::is('service.create')
        || Route::is('service.edit');

    $isSalesOrderRoute = Route::is('salesorder.list')
        || Route::is('salesorder.detail')
        || Route::is('salesorder.create')
        || Route::is('salesorder.edit');

    $isProductStockRoute = Route::is('product_stock.list');
    $isUserRoute = Route::is('user.list')
        || Route::is('user.detail')
        || Route::is('user.create')
        || Route::is('user.edit');

    $isEmployeeRoute = Route::is('employee.list')
        || Route::is('employee.detail')
        || Route::is('employee.create')
        || Route::is('employee.edit');

    $isAppointmentRoute = Route::is('appointment.list')
                    || Route::is('appointment.detail')
                    || Route::is('appointment.create')
                    || Route::is('appointment.edit');
@endphp

<nav class="sidebar">
    <ul class="navbar-nav-custom">
        <li class="nav-item">
            <a class="nav-link {{ $isDashboardRoute ? 'active' : '' }}" aria-current="page" href="/">
                <i class="fa-solid fa-house"></i>
                <span>Trang chủ</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $isCustomerRoute ? 'active' : '' }}" href="{{ route('customer.list') }}">
                <i class="fa-solid fa-user"></i>
                <span>Khách hàng</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $isProductRoute ? 'active' : '' }}" href="{{ route('product.list') }}">
                <i class="fa-solid fa-radio"></i>
                <span>Sản phẩm</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $isServiceRoute ? 'active' : '' }}" href="{{ route('service.list') }}">
                <i class="fa-solid fa-soap"></i>
                <span>Dịch vụ</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $isSalesOrderRoute ? 'active' : '' }}" href="{{ route('salesorder.list') }}">
                <i class="fa-solid fa-bag-shopping"></i>
                <span>Đơn hàng</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $isAppointmentRoute ? 'active' : '' }}" href="{{ route('appointment.list') }}">
                <i class="fa-solid fa-calendar"></i>
                <span>Đặt hẹn</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $isProductStockRoute ? 'active' : '' }}" href="{{ route('product_stock.list') }}">
                <i class="fa-solid fa-store"></i>
                <span> Nhập / xuất kho</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $isEmployeeRoute ? 'active' : '' }}" href="{{ route('employee.list') }}">
                <i class="fa-solid fa-address-card"></i>
                <span> Nhân viên</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $isUserRoute ? 'active' : '' }}" href="{{ route('user.list') }}">
                <i class="fa-solid fa-users"></i>
                <span>Người dùng</span>
            </a>
        </li>
    </ul>
</nav>