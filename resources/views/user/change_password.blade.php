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
                <li class="breadcrumb-item"><a href="{{ route('user.info') }}">Thông tin tài khoản</a></li>
                <li class="breadcrumb-item active" aria-current="page">Đổi mật khẩu</li>
            </ol>
        </nav>

        <div class="btn-breakcrumb-box">
        </div>
   </div>

    <form id="customerForm" action="{{ route('user.update_password') }}" method="POST" name="customerForm">
            @csrf
            <!-- Thông tin đăng nhập -->
            <div class="block-container">
                <div class="block-title">Thông tin đăng nhập</div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="current_password">Mật khẩu hiện tại</label>
                        <input type="password" name="current_password" class="form-control" placeholder="Nhập mật khẩu hiện tại"
                            required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="new_password">Mật khẩu mới</label>
                        <input type="password" name="new_password" class="form-control" placeholder="Nhập mật khẩu mới"
                            required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="new_password_confirmation">Nhập lại mật khẩu mới</label>
                        <input type="password" name="new_password_confirmation" class="form-control" placeholder="Nhập mật khẩu mới" required>
                    </div>
                </div>
            </div>
            <!-- Ended thông tin đăng nhập -->

            <button type="submit" class="btn btn-primary">Lưu</button>
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
                phone: {
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
                phone: {
                    required: "We need your phone to contact you",
                }
            }
        })

        formElm.on('submit', function(e) {
            e.preventDefault();

            if (!$(this).valid()) {
                return false;
            }

            var form = $(this).serialize();
            var url = $(this).attr('action');
            $.ajax({
                type: 'POST',
                url: url,
                data: form,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    const { data, message } = response;
                    window.location.href = "/user/info";
                },
                error: function({ responseJSON }) {
                    alert(responseJSON['message']);
                }
            });
        });
    });
</script>
@endsection
