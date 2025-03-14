@extends('app')

@section('css')
    <style>
        .breakcrumb {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            /* background: linear-gradient(45deg, #1FA2FF, #12D8FA, #A6FF); */
            margin-block: 10px;
            border-radius: 10px;
        }

        .breakcrumb .title {
            font-size: 20px;
            font-weight: 500;
            color: #000;
        }

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
                <li class="breadcrumb-item"><a href="{{ route('customer.list') }}">Khách hàng</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cập nhật</li>
            </ol>
        </nav>

        <div class="btn-breakcrumb-box">
            <button type="submit" class="btn btn-primary btn_edit">Lưu</button>
        </div>
   </div>

    <form id="customerForm" action="{{ route('customer.update', ['id' => Illuminate\Support\Facades\Crypt::encrypt($entry_data['id'])]) }}" method="POST" name="customerForm">
        @csrf
        <!-- Thông tin cơ bản -->
         <div class="block-container">
            <div class="block-title">Thông tin cơ bản</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Tên khách hàng</label>
                    <input type="name" class="form-control" id="name" name="name" value="{{ $entry_data['name'] }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $entry_data['email'] }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $entry_data['phone'] }}">
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

        $('.btn_edit').on('click', function(event) {
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
                    const { data, message } = response;
                    console.log(data)
                    window.location.href = '/customer/detail/' + data['id'];
                },
                error: function({ responseJSON }) {
                    alert(responseJSON['message']);
                }
            });
        });
    });
</script>
@endsection
