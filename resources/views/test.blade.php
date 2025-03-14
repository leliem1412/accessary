<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            margin: 60px auto;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #fff;
        }

        .crumbs {
            text-align: center;
        }

        .crumbs h1 {
            padding: 0 0 30px;
            text-transform: uppercase;
            font-size: 1.9rem;
            font-weight: 600;
            letter-spacing: .0.01rem;
            color: #8093A7;
        }
        .crumbs ul {
            list-style: none;
            display: inline-table;
        }
        .crumbs ul li {
            display: inline;
        }
        .crumbs ul li a {
            display: block;
            float: left;
            height: 50px;
            background: #f3f5fa;
            text-align: center;
            padding: 30px 20px 0 60px;
            position: relative;
            margin: 0 10px 0 0;
            font-size: 20px;
            text-decoration: none;
            color: #8093A7;
        }
        .crumbs ul li a::after {
            content: '';
            border-top: 40px solid transparent;
            border-bottom: 40px solid transparent;
            border-left: 40px solid #f3f5fa;
            position: absolute;
            right: -40px;
            top: 0;
            z-index: 1;
        }
        .crumbs ul li a::before {
            content: '';
            border-top: 40px solid transparent;
            border-bottom: 40px solid transparent;
            border-left: 40px solid #fff;
            position: absolute;
            left: 0;
            top: 0;
        }

        .crumbs ul li:first-child a {
            padding-left: 40px;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .crumbs ul li:first-child a::before {
            display: none;
        }

        .crumbs ul li:last-child a {
            padding-right: 40px;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .crumbs ul li:last-child a::after {
            display: none;
        }

        .crumbs ul li a:hover {
            background: #932e3e;
            color: #fff;
        }
        .crumbs ul li a:hover::after {
            border-left-color: #932e3e;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="crumbs">
        <h1>Breadcrumbs</h1>

        <ul>
            <li><a href="#"><i class="fa fa-home"></i></a></li>
            <li><a href="#"><i class="fa shopping-bag">Shop</i></a></li>
            <li><a href="#"><i class="fa fa-card-plus">Card</i></a></li>
            <li><a href="#"><i class="fa fa-credit-card">Checkout</i></a></li>
        </ul>
    </div>
</body>
</html>