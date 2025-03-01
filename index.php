<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>

        <div class="content-wrapper">
            <div class="container-fluid ">

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-sm-9">
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo "
                                <div class='alert alert-danger'>
                                    " . $_SESSION['error'] . "
                                </div>
                            ";
                                unset($_SESSION['error']);
                            }
                            ?>
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="width: 100%; height: 53vh;">
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                <div class="item active">
                                        <img src="images/welcome.png" alt="Third slide" style="width: 100%; height: 53vh;">
                                    </div>
                                    <div class="item">
                                        <img src="images/caros2.png" alt="First slide" style="width: 100%; height: 53vh;">
                                    </div>
                                    <div class="item">
                                        <img src="images/carouse1.jpg" alt="Second slide" style="width: 100%; height: 53vh;">
                                    </div>

                                </div>
                                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                    <span class="fa fa-angle-left"></span>
                                </a>
                                <a class="right carousel-control !active" href="#carousel-example-generic" data-slide="next">
                                    <span class="fa fa-angle-right"></span>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-3 sidebar">
                            <?php include 'includes/sidebar.php'; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            // Connect to database
                            $conn = $pdo->open();

                            $categories = ['Hijab/Scarf', 'Dupatta', 'Bundle', 'Shawls'];

                            foreach ($categories as $category) {
                                // Get category ID
                                $stmt = $conn->prepare("SELECT * FROM category WHERE name = :name");
                                $stmt->execute(['name' => $category]);
                                $cat = $stmt->fetch();
                                $catid = $cat['id'];

                                // Get products
                                $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = :catid");
                                $stmt->execute(['catid' => $catid]);
                                $products = $stmt->fetchAll();

                                echo "<hr><h2 class='cathead'>{$category}</h2><hr>";

                                if ($stmt->rowCount() > 0) {
                                    echo "<div class='custom-carousel-wrapper'>";
                                    echo "<button class='custom-prev '><i class='fa fa-angle-left'></i></button>";
                                    echo "<div class='owl-carousel owl-theme'>";
                                    foreach ($products as $product) {
                                        $image = (!empty($product['photo'])) ? 'images/' . $product['photo'] : 'images/noimage.jpg';
                                        echo "
                                        <a href='product.php?product={$product['slug']}'>
                                        <div class='item'>
                                            <div class='box box-solid boxes' >
                                                <div class='box-body prod-body'>
                                                    <img src='{$image}' class='thumbnail'>
                                                    <h5 style='color:black; font-weight:bold;'>{$product['name']}</h5>
                                                </div><br>
                                                <div class='box-footer' style='margin-top:5%; background-color:black;border:none;'>
                                                    <b style='color:red'>&#36; " . number_format($product['price'], 2) . "</b>
                                                </div>
                                            </div>
                                        </div>
                                        </a>
                                    ";
                                    }
                                    echo "</div>";
                                    echo "<button class='custom-next '><i class='fa fa-angle-right'></i></button>";
                                    echo "</div>";
                                } else {
                                    echo "<p>No products found in this category.</p>";
                                }
                            }

                            $pdo->close();
                            ?>
                        </div>
                    </div>
                </section>

            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/scripts.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
    <link rel="stylesheet" href="owl.theme.default.min.css">

    <style>
        .content-wrapper{
            background-color: palevioletred;
            background-image: linear-gradient(to right, palevioletred, Pink );
        }
        .cathead{
            color: white;
            font-weight: bold;
        }
        .custom-carousel-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .owl-carousel {
            width: 80%;
        }
        .boxes{
            background: rgb(148,187,233);
            background: radial-gradient(circle, rgba(148,187,233,1) 0%, rgba(238,174,202,1) 84%);
        }

        .custom-prev,
        .custom-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: transparent;
            border: none;
            font-size: 1em;
            cursor: pointer;
            z-index: 10;
        }

        .custom-prev {
            left: -20px; /* Adjust as needed */
        }

        .custom-next {
            right: -20px; /* Adjust as needed */
        }

        .custom-prev i,
        .custom-next i {
            font-size: 2em;
            color: white;
        }

        .item {
            margin: 0 10px;
        }

        .prod-body img {
            width: 100%;
            height: 90%;
        }
        @media (max-width: 767px) {
            .sidebar {
                display: none;
            }
        }
    </style>

    <script>
        $(document).ready(function() {
            $(".owl-carousel").each(function(index, element) {
                var carousel = $(element).owlCarousel({
                    items: 3,
                    loop: true,
                    margin: 10,
                    autoplay: true,
                    autoplayTimeout: 3000,
                    autoplayHoverPause: true,
                    nav: false, // Disable default navigation
                    dots: false
                });

                // Custom navigation
                $(element).closest('.custom-carousel-wrapper').find('.custom-prev').click(function() {
                    carousel.trigger('owl.prev');
                });

                $(element).closest('.custom-carousel-wrapper').find('.custom-next').click(function() {
                    carousel.trigger('owl.next');
                });
            });
        });
    </script>

</body>

</html>
