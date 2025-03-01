
<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue layout-top-nav">

<div class="wrapper">

        <?php include 'includes/navbar.php'; ?>

        <div class="content-wrapper">
            <div class="container-fluid">

                <!-- Main content -->
                <section class="content">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-sm-12">
                            <div class="contact-info text-center">
                                <h2>Contact Us</h2>
                                <div class="contact-item">
                                    <i class="fa fa-phone contact-icon" style="color:green"></i>
                                    <a href="https://wa.me/923091256320" target="_blank">+923091256320 (WhatsApp & Call)</a>
                                </div>
                                <div class="contact-item">
                                    <i class="fa fa-envelope contact-icon"></i>
                                    <a href="mailto:noorfabrics09@gmail.com">noorfabrics09@gmail.com</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/scripts.php'; ?>

    <style>
        .content-wrapper {
            background-color: palevioletred;
            background-image: linear-gradient(to right, palevioletred, pink);
        }

        .contact-info {
            text-align: center;
            padding: 50px;
            background: radial-gradient(circle, rgba(148, 187, 233, 1) 0%, rgba(238, 174, 202, 1) 84%);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }

        .contact-info h2 {
            margin-bottom: 20px;
            color: white;
            font-weight: bold;
        }

        .contact-item {
            margin: 20px 0;
            font-size: 18px;
            color: white;
        }

        .contact-item a {
            color: white;
            text-decoration: none;
            margin-left: 10px;
        }

        .contact-icon {
            font-size: 24px;
            vertical-align: middle;
        }

        .fa-whatsapp {
            color: #25D366; /* WhatsApp green */
        }

        .fa-envelope {
            color: #D44638; /* Gmail red */
        }

        @media (max-width: 767px) {
            .contact-info {
                padding: 30px;
                margin: 10px;
            }

            .contact-item {
                font-size: 16px;
            }

            .contact-icon {
                font-size: 20px;
            }
        }
    </style>
</body>

</html>
