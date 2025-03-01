<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

    <?php include 'includes/navbar.php'; ?>
     
    <div class="content-wrapper">
        <div class="container">

          <!-- Main content -->
          <section class="content">
            <div class="row">
                <div class="col-sm-9">
                    <h1 class="page-header" style="color: white; font-weight: bold;">YOUR CART</h1>
                    <div class="box box-solid">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <th></th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Color</th>
                                        <th>Price</th>
                                        <th width="20%">Quantity</th>
                                        <th>Subtotal</th>
                                    </thead>
                                    <tbody id="tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <button id='checkoutButton' class='btn btn-primary'>Checkout</button>
                    <div id="checkoutFormContainer" style="display: none;">
                        <form action="https://api.web3forms.com/submit" method="POST">
                            <input type="hidden" name="access_key" value="51c11192-8554-45a0-9145-a92b04ea4512">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="number">Mobile Number</label>
                                <input type="tel" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Complete Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="form-group" style="display:none">
                                <label for="message">Cart Items</label>
                                <textarea class="form-control" id="message" name="message" required readonly></textarea>
                                
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
                <br>
                <div class="col-sm-3">
                    <?php include 'includes/sidebar.php'; ?>
                </div>
            </div>
          </section>
         
        </div>
      </div>
    <?php $pdo->close(); ?>
    <?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
<script>

$(function(){
    $(document).on('click', '.cart_delete', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: 'cart_delete.php',
            data: {id:id},
            dataType: 'json',
            success: function(response){
                if(!response.error){
                    getDetails();
                    getCart();
                }
            }
        });
    });

    $(document).on('click', '.minus', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var qty = parseInt($('#qty_'+id).val());
        if(qty > 1){
            qty--;
        }
        $('#qty_'+id).val(qty);
        $.ajax({
            type: 'POST',
            url: 'cart_update.php',
            data: {
                id: id,
                qty: qty,
            },
            dataType: 'json',
            success: function(response){
                if(!response.error){
                    getDetails();
                    getCart();
                }
            }
        });
    });

    $(document).on('click', '.add', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var qty = parseInt($('#qty_'+id).val());
        qty++;
        $('#qty_'+id).val(qty);
        $.ajax({
            type: 'POST',
            url: 'cart_update.php',
            data: {
                id: id,
                qty: qty,
            },
            dataType: 'json',
            success: function(response){
                if(!response.error){
                    getDetails();
                    getCart();
                }
            }
        });
    });

    $(document).on('change', '.color-select', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var color = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'cart_update.php',
            data: {
                id: id,
                color: color,
            },
            dataType: 'json',
            success: function(response){
                if(!response.error){
                    getDetails();
                    getCart();
                }
            }
        });
    });

    getDetails();

    $('#checkoutButton').on('click', function() {
        $('#checkoutFormContainer').toggle();
    });
});

function getDetails(){
    $.ajax({
        type: 'POST',
        url: 'cart_details.php',
        dataType: 'json',
        success: function(response){
            $('#tbody').html(response.cartTable);
            $('#message').val(getMessageFromCartItems(response.cartItems));
            $('#cartItemsContainer').html(response.cartTable); // display for user in form
            getCart();
        }
    });
}

function getMessageFromCartItems(cartItems){
    if(cartItems && cartItems.length > 0){
        let keys = Object.keys(cartItems[0]);
        let message =keys.join(",");
        message += "\r\n";
        message += "\r\n";

        cartItems.forEach(row => {
            let rowLine = "";
            keys.forEach(key => {
                rowLine += row[key]+",";
            });
            message += rowLine;
            message += "\r\n";
        });

        return message;
    }
}

function getCart(){
    $.ajax({
        type: 'POST',
        url: 'cart_total.php',
        dataType: 'json',
        success:function(response){
            // Assuming you update the cart total somewhere
        }
    });
}
</script>


<style>
    .content-wrapper{
        background-color: palevioletred;
        background-image: linear-gradient(to right, palevioletred, Pink );
    }
</style>
</body>
</html>
