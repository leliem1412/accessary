<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Accessary</title>
    <link rel="icon" type="image/png" href="{{ Storage::url('/custom/logo.png') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.3/datatables.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        tfoot input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }
        .select2-selection {
            height: 38px !important;
            border: 1px solid #ccc !important;
        }
        a {
            text-decoration: none;
        }
        .breakcrumb-container {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            margin-block: 10px;
            border-radius: 10px;
            background: linear-gradient(282deg, #00b0ff 5.54%, #3e98eb) !important;
        }
        .breakcrumb-container .breadcrumb {
            margin-bottom: unset;
        }
        .breakcrumb-container .breadcrumb-item,
        .breakcrumb-container .breadcrumb-item a {
            font-size: 1rem;
            font-weight: 500;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
        }
        .breadcrumb-item+.breadcrumb-item::before {
            float: left;
            padding-right: .5rem;
            color: #fff;
            font-size: 1rem;
            content: var(--bs-breadcrumb-divider, "/");
        }
        .breakcrumb-container .btn-breakcrumb-box .btn {
            border-radius: 10px;
            padding-left: 20px;
            padding-right: 20px;
            border: 1px solid #ccc;
        }
        .breakcrumb-container .btn-breakcrumb-box .btn-primary {
            background: linear-gradient(45deg, #ffe000, #fffc00);
            color: #000;
        }

        .breakcrumb-container .btn-breakcrumb-box .btn-primary:hover {
            opacity: 0.8;
        }

        .loading-container {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #f4f4f4a3;
            z-index: 100;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 70px;
        }
        .loading-container .loading {
            position: relative;
            width: 200px;
            height: 200px;
        }
        .loading-container .loading .logo {
            width: 100%;
            animation: fadeIn 2s ease-in-out;
        }
        .loading-container .loading .water-drop {
            position: absolute;
            top: 30px;
            left: 50%;
            width: 30px;
            height: 40px;
            background: #00b0ff;
            border-radius: 50% 50% 50% 50%;
            transform: translateX(-50%);
            animation: dropBounce 2s infinite ease-in-out;
        }
        .loading-container .loading .waves {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 20px;
            background: linear-gradient(to right, #00b0ff, transparent);
            animation: waveMove 3s infinite linear;
        }
        @keyframes dropBounce {
            0%, 100% {
                transform: translateX(-50%) translateY(0);
            }
            50% {
                transform: translateX(-50%) translateY(15px);
            }
        }
        @keyframes waveMove {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(100%);
            }
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>

    @yield('css')
</head>

<body>
    @include('layouts/header')
    <div class="template-content-layout" style="position: relative;">
        <div class="loading-container d-none">
            <div class="loading">
                <img src="{{ Storage::url('/custom/logo.png') }}" alt="Loading Logo" class="logo">
                <div class="water-drop"></div>
                <div class="waves"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                @include('layouts/sidebar')
            </div>

            <div class="col-md-10">
               <div class="container">
                    @yield('content')
               </div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.3/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js" integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('li#logoutBtn').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ URL::to('/logout') }}",
                dataType: 'json',
                success: function() {
                    window.location.href = '/login';
                }
            });
        });

        $(document).ready(function() {
            // Init select2
            $('.select2').select2();

            // Init tooltip
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
    @yield('script')
</body>

</html>
