@extends('app')

@section('css')
    <style>
        .upload-img-container {
            max-width: 300px;
            width: 100%;
            background: #fff;
            padding: 30px;
            border-radius: 30px;
            border: 1px solid #ccc
        }
        .upload-img-container .img-area {
            position: relative;
            width: 100%;
            height: 140px;
            background: var(--grey);
            margin-bottom: 30px;
            border-radius: 15px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .upload-img-container .img-area .icon {
            font-size: 100px;
        }
        .upload-img-container .img-area h3 {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .upload-img-container .img-area p {
            font-size: 13px;
            color: #999;
        }

        .img-area p span {
            font-weight: 600;
        }

        .upload-img-container .select-image {
            display: block;
            width: 100%;
            padding: 16px 0;
            border-radius: 15px;
            background: #0071FF;
            color: #fff;
            font-weight: 500;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-img-container .select-image:hover {
            background: #005DD1;
        }

        .upload-img-container .img-area img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            z-index: 100;
        }

        .upload-img-container .img-area::before {
            content: attr(data-img);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            font-weight: 500;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            pointer-events: none;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 200;
        }
        .upload-img-container .img-area:hover::before {
            opacity: 1;
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
        .input-duration-group {
            display: flex;
            flex-direction: row;
            gap: 10px;
        }
        .input-duration-group input[type="number"] {
            width: 40%;
        }
        .input-duration-group select.select2 {
            width: 20%;
        }
    </style>
@endsection

@section('content')
    <div class="breakcrumb-container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('service.list') }}">Dịch vụ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết</li>
            </ol>
        </nav>

        <div class="btn-breakcrumb-box">
            <a href="{{ route('service.edit', ['id' => $entry_data['id']]) }}" class="btn btn-primary pull-right">Cập nhật</a>
        </div>
    </div>

    <form id="serviceForm" action="{{ route('service.store') }}" method="POST" name="serviceForm">
        @csrf
      
        <!-- Thông tin cơ bản -->
        <div class="block-container">
            <div class="row">
                <!-- Upload Image -->
                <div class="col-md-12 mb-3">
                    <div class="upload-img-container">
                        <input type="file" name="service_image" id="service_image" accept="image/*" hidden>
                        <div class="img-area active" data-img="{{ Storage::url($entry_data['image']) }}">
                            <box-icon class="icon" name='cloud-upload'></box-icon>
                            <h3>Tải ảnh lên</h3>
                            <p>Kích thước hình ảnh không vượt quá <span>2MB</span></p>
                            <img src="{{ Storage::url($entry_data['image']) }}" alt="">
                        </div>
                    </div>
                </div>
                <!-- End upload Image -->

                <div class="col-md-6 mb-3">
                    <label for="service_name" class="form-label">Tên dịch vụ</label>
                    <input type="text" class="form-control" id="service_name" value="{{ $entry_data['service_name'] }}" readonly name="service_name" placeholder="Nhập tên dịch vụ">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="service_category" class="form-label">Loại dịch vụ</label>
                    {!! App\Enums\Picklist::getPicklistView('service', 'Vui lòng chọn loại dịch vụ', 'service_category', $entry_data['service_category'], true) !!}
                </div>

                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Giá</label>
                    <input type="text" class="form-control" value="{{ $entry_data['price'] }}" readonly id="price" name="price" placeholder="Nhập giá">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="duration" class="form-label">Thời lượng</label>
                    <div class="input-duration-group">
                        <input type="number" name="duration" id="duration" disabled value="{{ explode(' |##| ', $entry_data['duration'])[0] }}">
                        <select class="form-select select2" name="duration_type" id="duration_type" disabled>
                            @foreach (['hour', 'minute', 'day'] as $value)
                                <option value="{{ $value }}" {{ explode(' |##| ', $entry_data['duration'])[1] == $value ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- <div class="col-md-12 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="status" name="status">
                        <label for="status" class="form-label">Tình trạng</label>
                    </div>
                </div> -->
            </div>
        </div>
        <!-- Ended thông tin cơ bản -->
    </form>

    @include('sweetalert::alert')
@endsection
