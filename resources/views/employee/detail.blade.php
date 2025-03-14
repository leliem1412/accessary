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
                <li class="breadcrumb-item"><a href="{{ route('employee.list') }}">Nhân viên</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết</li>
            </ol>
        </nav>

        <div class="btn-breakcrumb-box">
        <a href="{{ route('employee.edit', ['id' => $entry_data['id']]) }}" class="btn btn-primary pull-right">Cập nhật</a>
        </div>
   </div>

    <form id="employeeForm" action="{{ route('employee.store') }}" method="POST" name="employeeForm">
        @csrf
        <!-- Thông tin cơ bản -->
         <div class="block-container">
            <div class="block-title">Thông tin cơ bản</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Tên nhân viên</label>
                    <input type="name" class="form-control" id="name" value="{{ $entry_data['name'] }}" disabled name="name">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" value="{{ $entry_data['email'] }}" disabled name="email">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="phone" class="form-control" id="phone" value="{{ $entry_data['phone'] }}" disabled name="phone">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="role" class="form-label">Vai trò</label>
                    {!! App\Enums\Picklist::getPicklistView('employee', 'Vui lòng nhập vai trò', 'role', $entry_data['role'], true) !!}
                </div>
            </div>
         </div>
        <!-- Ended thông tin cơ bản -->
    </form>

    @include('sweetalert::alert')
@endsection
