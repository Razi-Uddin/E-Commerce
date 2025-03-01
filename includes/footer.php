<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .main-footer {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            border: none;
        }
        .main-footer .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .main-footer .contact-details {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 20px;
        }
        .main-footer .contact-details li {
            margin: 20px 0;
            display: flex;
            align-items: center;
        }
        .main-footer .contact-details li i {
            margin-right: 10px;
        }
        .main-footer .pull-right {
            margin-left: auto;
        }
        @media (max-width: 768px) {
            .main-footer .container {
                flex-direction: column;
                text-align: center;
            }
            .main-footer .pull-right {
                margin-left: 0;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

<!-- Your existing footer content -->
<footer class="main-footer">
    <div class="container">
        <ul class="contact-details">
            <li><i class="fas fa-phone-alt"></i> +92 309 1256320</li>
            <li><i class="fas fa-envelope"></i> noorfabrics09@gmail.com</li>
        </ul>
        <div class="pull-right hidden-xs">
            <b>All rights reserved</b>
        </div>
        <strong>Copyright &copy; 2024 Brought to You By <a href="#">Techenters</a></strong>
    </div>
</footer>

</body>
</html>
