@extends('app')

@section('css')
    <style>
        .block-container {
            padding: 20px;
            border: 1px solid #ccc;
            display: flex;
            flex-direction: column;
            gap: 20px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .block-container .block-title {
            font-size: 18px;
            font-weight: 600;
            padding: 10px;
            position: relative;
        }

        .block-container .block-title::before {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(45deg, #1FA2FF, #12D8FA, #A6FF);
        }
    </style>
@endsection

@section('content')
    <div class="breakcrumb-container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.list') }}">Người dùng</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết</li>
            </ol>
        </nav>

        <div class="btn-breakcrumb-box">
            <a href="{{ route('user.edit', ['id' => $entry_data['id']]) }}" class="btn btn-primary">Cập nhật</a>

            @if (auth()->user()->role == 'admin' && auth()->user()->id != Illuminate\Support\Facades\Crypt::decrypt($entry_data['id']))
                <a href="{{ route('user.active', ['id' => $entry_data['id']]) }}" onclick="return confirm('Bạn chắc chắn muốn thực hiện <?= $entry_data['active'] == 1 ? 'khoá tài khoản' : 'Kích hoạt tài khoản' ?> không?')" class="btn btn-danger pull-right btn-remove">{{ $entry_data['active'] == 1 ? 'khoá tài khoản' : 'Kích hoạt tài khoản'  }}</a>
            @endif
        </div>
   </div>

    <form id="customerForm" action="{{ route('user.store') }}" method="POST" name="customerForm">
        @csrf
        <!-- Thông tin cơ bản -->
         <div class="block-container">
            <div class="block-title">Thông tin cơ bản</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Tên người dùng</label>
                    <input type="name" class="form-control" id="name" name="name" value="{{ $entry_data['name'] }}" disabled>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="role" class="form-label">Vai trò</label>
                    {!! App\Enums\Picklist::getPicklistView('user', 'Vui lòng nhập vai trò', 'role', $entry_data['role'], true) !!}
                </div>
            </div>
         </div>
        <!-- Ended thông tin cơ bản -->

        <!-- Thông tin đăng nhập -->
         <div class="block-container">
            <div class="block-title">Thông tin đăng nhập</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $entry_data['email'] }}" disabled>
                </div>
            </div>
         </div>
        <!-- Ended thông tin đăng nhập -->
    </form>

    @include('sweetalert::alert')
@endsection
