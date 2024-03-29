<?php
session_start();

// Check if the user is logged in or not
if (!isset($_SESSION['username'])) {
    
    header("Location: login.php");
    exit();
}


include 'connection.php';

// Function to remove item from cart
function removeFromCart($conn, $product_id) {
   
    $user_id = $_SESSION['user_id'];
    $sql_delete_product = "DELETE FROM products WHERE user_id = ? AND id = ?";
    $stmt = $conn->prepare($sql_delete_product);
    $stmt->bind_param("ii", $user_id, $product_id);
    if ($stmt->execute()) {
        echo "Product removed from cart successfully!";
    } else {
        echo "Error removing product from cart: " . $conn->error;
    }
}

// Function to add item to cart
function addToCart($conn, $product_id) {
    // Check if the product is already in the cart for the current user
    $user_id = $_SESSION['user_id'];
    $sql_check_cart = "SELECT * FROM products WHERE user_id = ? AND id = ?";
    $stmt_check_cart = $conn->prepare($sql_check_cart);
    $stmt_check_cart->bind_param("ii", $user_id, $product_id);
    $stmt_check_cart->execute();
    $result_check_cart = $stmt_check_cart->get_result();

    if ($result_check_cart->num_rows == 0) { // If the product is not already in the cart
       
        $api_url = "https://fakestoreapi.com/products/$product_id";
        $product_json = file_get_contents($api_url);
        $product_details = json_decode($product_json, true);

        if ($product_details) {
           
            $title = $conn->real_escape_string($product_details['title']);
            $description = $conn->real_escape_string($product_details['description']);
            $price = $product_details['price'];
            $image = $product_details['image']; 
          
            $sql_insert = "INSERT INTO products (user_id, id, title, description, price, image, quantity) 
                           VALUES (?, ?, ?, ?, ?, ?, 1)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("iissis", $user_id, $product_id, $title, $description, $price, $image);
            if ($stmt_insert->execute()) {
                echo "Product added to cart successfully!";
            } else {
                echo "Error adding product to cart: " . $conn->error;
            }
        } else {
            echo "Failed to fetch product details from the API";
        }
    } else {
       
        $row = $result_check_cart->fetch_assoc();
        $current_quantity = $row['quantity'];
        $new_quantity = $current_quantity + 1;

        $sql_update_quantity = "UPDATE products SET quantity = ? WHERE user_id = ? AND id = ?";
        $stmt_update_quantity = $conn->prepare($sql_update_quantity);
        $stmt_update_quantity->bind_param("iii", $new_quantity, $user_id, $product_id);
        if ($stmt_update_quantity->execute()) {
            echo "Product quantity updated in cart!";
        } else {
            echo "Error updating product quantity: " . $conn->error;
        }
    }
    
    header("Location: ".$_SERVER['REQUEST_URI']);
    exit();
}

//Function to calculate total price of items in cart
function calculateTotalPrice($conn, $user_id) {
    $sql_total_price = "SELECT SUM(price * quantity) AS total_price FROM products WHERE user_id = ?";
    $stmt_total_price = $conn->prepare($sql_total_price);
    $stmt_total_price->bind_param("i", $user_id);
    $stmt_total_price->execute();
    $result_total_price = $stmt_total_price->get_result();
    $row_total_price = $result_total_price->fetch_assoc();
    return $row_total_price['total_price'];
}


if(isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id']; 
    removeFromCart($conn, $product_id);
}


if(isset($_POST['add_to_cart'])) {
    // Get the product ID from the form submission
    $product_id = $_POST['product_id'];
    addToCart($conn, $product_id);
}

// Retrieve product details from the products table for the current user
$user_id = $_SESSION['user_id'];
$sql_products = "SELECT * FROM products WHERE user_id = $user_id";
$result_products = $conn->query($sql_products);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .product {
            border: 1px solid #ccc;
            margin-bottom: 10px;
            padding: 10px;
        }
        .product img {
            max-width: 100px;
            max-height: 100px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Shopping Cart</h2>
        <div class="cart-items">
                <?php if ($result_products->num_rows > 0) : ?>
                    <?php while($row_product = $result_products->fetch_assoc()) : ?>
                        <div class="product">
                            <img src="<?php echo $row_product["image"]; ?>" alt="Product Image">
                            <div>
                                <p><strong>Title:</strong> <?php echo $row_product["title"]; ?></p>
                                <p><strong>Description:</strong> <?php echo $row_product["description"]; ?></p>
                                <p><strong>Price:</strong> <?php echo $row_product["price"]; ?></p>
                                <p><strong>Quantity:</strong> <?php echo $row_product["quantity"]; ?></p>
                            </div>
                            <form method="post" action="">
                                <input type="hidden" name="product_id" value="<?php echo $row_product["id"]; ?>">
                                <button type="submit" name="remove_from_cart">Remove from Cart</button>
                            </form>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p>No items in the cart.</p>
                <?php endif; ?>
                
                
                <?php
                $total_price = calculateTotalPrice($conn, $user_id);
                ?>
                <p><strong>Total Price:</strong> <?php echo $total_price; ?></p>
                
                </div>
                </body>
                </html>
