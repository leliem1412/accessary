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
    </style>
@endsection

@section('content')
   <div class="breakcrumb-container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('product.list') }}">Sản phẩm</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết</li>
            </ol>
        </nav>

        <div class="btn-breakcrumb-box">
            <!-- <a class="btn btn-primary">Cập nhật</a> -->
            <a href="{{ route('product.edit', ['id' => $entry_data['id']]) }}" class="btn btn-primary pull-right">Cập nhật</a>
        </div>
   </div>

    <form id="productForm" action="{{ route('product.store') }}" method="POST" name="productForm" enctype="multipart/form-data">
        @csrf
    
        <!-- Thông tin sản phẩm cơ bản -->
        <div class="block-container">
            <div class="block-title">Thông tin cơ bản</div>

            <div class="row">
                <!-- Upload Image -->
                <div class="col-md-12 mb-3">
                    <div class="upload-img-container">
                        <input type="file" name="product_image" id="product_image" accept="image/*" hidden>
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
                    <label for="product_name" class="form-label">Tên sản phẩm</label>
                    <input type="text" class="form-control" value="{{ $entry_data['product_name'] }}" readonly id="product_name" name="product_name">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="product_category" class="form-label">Loại sản phẩm</label>
                    {!! App\Enums\Picklist::getPicklistView('product', 'Vui lòng chọn sản phẩm', 'product_category', $entry_data['product_category'], true) !!}
                </div>

                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Giá</label>
                    <input type="text" class="form-control" id="price" value="{{ number_format($entry_data['price']) }}" readonly name="price">
                </div>

                <!-- <div class="col-md-12 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" readonly role="switch" id="status" name="status">
                        <label for="status" class="form-label">Tình trạng</label>
                    </div>
                </div> -->
            </div>
        </div>
        <!-- Ended Thông tin sản phẩm cơ bản -->

       <input type="hidden" name="entry_data" value="{{ json_encode($entry_data) }}">
    </form>

    @include('sweetalert::alert')
@endsection

@section('script')
<script>
    const Customer_CreateView_Js = new class {
        constructor() {
            // this.loadProductData();
            // this.handleSelectImageEvent();
        }

        loadProductData() {
            const productDataJson = $('#productForm input[name="entry_data"]').val();
            const productData = JSON.parse(productDataJson);

            $('form#productForm input[name="product_name"]').val(productData.product_name);
            $('form#productForm input[name="price"]').val(productData.price);
            $('form#productForm select[name="product_category"]').val(productData.product_category);
        }

        handleSelectImageEvent() {
            const selectImage = $('.upload-img-container .select-image');
            const inputFile = $('.upload-img-container input[type=file]');
            const imgArea = $('.upload-img-container .img-area');

            selectImage.on('click', (event) => {
                event.preventDefault();
                inputFile.click();
            });

            inputFile.on('change', (event) => {
                event.preventDefault();
                const imageFile = event.target.files[0];

                if (imageFile.size < 2000000) {
                    const reader = new FileReader();
                 
                    reader.onload = (readerEvent) => {
                        // Resize image
                        let image = new Image();
                        image.onload = function () {
                            let canvas = document.createElement('canvas');
                            let ctx = canvas.getContext('2d');
                            
                            canvas.width = 238;
                            canvas.height = 140;
                            ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
                            
                            canvas.toBlob(function (blob) {
                                let resizedFile = new File([blob], 'resized_image.jpg', { type: 'image/jpeg' });
                                let url = URL.createObjectURL(resizedFile);
                                $('#preview').attr('src', url);
                            }, 'image/jpeg', 0.9);
                        };

                        // Remove old image
                        imgArea.find('img').length > 0 && imgArea.find('img').remove();

                        // Append new image from UI
                        const imgUrl = readerEvent.target.result;
                        console.log(imgUrl)
                        const img = document.createElement('img');
                        img.src = imgUrl;
                        imgArea.append(img).addClass('active').attr('data-img', imageFile.name);                        
                    };

                    reader.readAsDataURL(imageFile);   
                }
                else {
                    alert('Image size must be lest than 2MB');
                }
            });
        }
    }
</script>
@endsection
