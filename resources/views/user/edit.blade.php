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
                <li class="breadcrumb-item active" aria-current="page">Cập nhật</li>
            </ol>
        </nav>

        <div class="btn-breakcrumb-box">
        <button type="submit" class="btn btn-primary btn_edit">Lưu</button>
        </div>
   </div>

    <form id="customerForm" action="{{ route('user.update', ['id' => $entry_data['id']]) }}" method="POST" name="customerForm">
        @csrf
        <!-- Thông tin cơ bản -->
         <div class="block-container">
            <div class="block-title">Thông tin cơ bản</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Tên người dùng</label>
                    <input type="name" class="form-control" id="name" name="name" value="{{ $entry_data['name'] }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="role" class="form-label">Vai trò</label>
                    {!! App\Enums\Picklist::getPicklistView('user', 'Vui lòng nhập vai trò', 'role', $entry_data['role']) !!}
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
                    <input type="email" class="form-control" id="email" name="email" value="{{ $entry_data['email'] }}">
                </div>
            </div>
         </div>
        <!-- Ended thông tin đăng nhập -->
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

        const formElm = $('form[name=customerForm]');

        formElm.validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                role: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Please enter your name",
                },
                email: {
                    required: "We need your email address to contact you",
                },
                role: {
                    required: "We need your role",
                }
            }
        })

        $('.btn_edit').on('click', (event) => {
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

                    window.location.href = '/user/detail/' + data['id'];
                },
                error: function({ responseJSON }) {
                    alert(responseJSON['message']);
                }
            });
        });
    });
</script>
@endsection
