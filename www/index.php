<?php
//List all our products
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../classes/Products.php');
$product=new Products(new PDO('mysql:dbname=inventory;host=127.0.0.1','dev','password'));

?><html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="navbar navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Inventory</a>
            </div>
        </nav>
        <div class="container">
            <?php
            if(array_key_exists('alert',$_REQUEST)){
                ?>
                <div class="alert alert-success" role="alert">
                   <?php echo $_REQUEST['alert']?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
            }
            ?>
            <div class="row">
                <div class="col">
                    <h4>Create a product:</h4>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <form method="post" action="/createProduct.php">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-default">Product Name</span>
                            <input type="text" name="name" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-primary" type="submit" value="Create">Button</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4>Product:</h4>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Add To Quantity</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $i=0;
                foreach($product->getProducts() as $product){
                    ?>
                    <tr>
                        <td><?php echo Products::name($product) ?></td>
                        <td><?php echo Products::quantity($product) ?></td>
                        <td>
                            <form method="post" action="updateQuantity.php">
                                <input type="hidden" name="id" value="<?php echo Products::id($product);?>">
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" value="0" name="quantity" aria-describedby="<?php echo "subButton".$i;?>">
                                    <button class="btn btn-primary" type="submit" id="<?php echo "subButton".$i;?>">Add</button>
                                </div>
                            </form>
                        </td><?php
                        $i++;
                }?>
                </tbody>
            </table>
        </div>
    </body>
</html>