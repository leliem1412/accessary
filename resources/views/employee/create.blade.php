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
                <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
            </ol>
        </nav>

        <div class="btn-breakcrumb-box">
            <button class="btn btn-primary btn_create">Thêm mới</button>
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
                    <input type="name" class="form-control" id="name" name="name">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="phone" class="form-control" id="phone" name="phone">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="role" class="form-label">Vai trò</label>
                    {!! App\Enums\Picklist::getPicklistView('employee', 'Vui lòng nhập vai trò', 'role') !!}
                </div>
            </div>
         </div>
        <!-- Ended thông tin cơ bản -->
    </form>

    @include('sweetalert::alert')
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // just for the demos, avoids form submit
        jQuery.validator.setDefaults({
            debug: true,
            success: "valid"
        });

        const formElm = $('form[name=employeeForm]');

        formElm.validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                phone: {
                    required: true,
                },
                role: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Vui lòng nhập tên nhân viên",
                },
                email: {
                    required: "Vui lòng nhập email",
                },
                phone: {
                    required: "Vui lòng nhập số điện thoại",
                },
                role: {
                    required: "Vui lòng chọn vai trò",
                }
            }
        })

        $('.btn_create').on('click', (e) => {
            event.preventDefault();
            if (!$(formElm).valid()) return false;

            var form = $(formElm).serialize();
            var url = $(formElm).attr('action');
            $.ajax({
                type: 'POST',
                url: url,
                data: form,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    const { data, message } = response;

                    window.location.href = '/employee/detail/' + data['id'];
                },
                error: function({ responseJSON }) {
                    alert(responseJSON['message']);
                }
            });
        });
    });
</script>
@endsection
