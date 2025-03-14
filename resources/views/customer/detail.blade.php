@extends('app')

@section('css')
    <style>
        .breakcrumb {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
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
                <li class="breadcrumb-item active" aria-current="page">Chi tiết</li>
            </ol>
        </nav>

        <div class="btn-breakcrumb-box">
            <a href="{{ route('customer.edit', ['id' => Illuminate\Support\Facades\Crypt::encrypt($entry_data['id'])]) }}" class="btn btn-primary pull-right">Cập nhật</a>
            <button href="{{ route('customer.delete', ['id' => $entry_data['id']]) }}" class="btn btn-danger pull-right btn-remove">Xoá</button>
        </div>
   </div>

    <form id="customerForm" action="{{ route('customer.store') }}" method="POST" name="customerForm">
        @csrf
        <!-- Thông tin cơ bản -->
         <div class="block-container">
            <div class="block-title">Thông tin cơ bản</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Tên khách hàng</label>
                    <input type="name" class="form-control" value="{{ $entry_data['name'] }}" readonly id="name" name="name">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ $entry_data['email'] }}" readonly id="email" name="email">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" value="{{ $entry_data['phone'] }}" readonly id="phone" name="phone">
                </div>
            </div>
         </div>
        <!-- Ended thông tin cơ bản -->
    </form>

    <input type="hidden" name="entry_id" value="{{ Illuminate\Support\Facades\Crypt::encrypt($entry_data['id']) }}">

    @include('sweetalert::alert')
@endsection

@section('script')
<script>
    
const Customer_DetailViewJs = new class {

    constructor() {
        this.handleClickToRemoveBtnEvent();
    }

    handleClickToRemoveBtnEvent() {
        $('.btn-remove').on('click', function(e) {
            e.preventDefault();
            if (!confirm('Bạn có chắc chắn muốn xoá?')) return

            const entryId = $('[name=entry_id]').val();

            $.ajax({
                type: 'POST',
                url: '/customer/delete',
                data: { entry_id: entryId },
                dataType: 'json',
                success: function(response) {
                    console.log('success!');
                    window.location.href = '/customer';
                },
                error: function({ responseJSON }) {
                    alert(responseJSON['message']);
                }
            });
        });
    }
}

</script>
@endsection
