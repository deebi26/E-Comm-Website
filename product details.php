<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-height: 700px; 
            display: flex;
            flex-direction: column;
            align-items: center;
    
        }

        .product-details {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        h2 {
            color: #333;
            margin-bottom: 10px;
        }

        p {
            color: #666;
            margin-bottom: 5px;
        }

        img {
            max-width: 100%;
            height: 300px;
            margin-top: 20px;
            border-radius: 8px;
        }

        button {
            padding: 10px 20px;
            background-color: rgb(151, 198, 226);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: rgb(151, 198, 226);
        }

        @media screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<div class="container">

<?php
session_start();

if(isset($_SESSION['user_id'])) {
    echo '<p>User ID: ' . $_SESSION['user_id'] . '</p>';
}


// Check if the product ID is provided 
if(isset($_GET['id'])) {
    
    $product_id = $_GET['id'];

    $api_url = 'https://fakestoreapi.com/products/' . $product_id;
    $product_details_json = file_get_contents($api_url);
    $product_details = json_decode($product_details_json, true);

    // Display the product details
    if($product_details) {
        echo '<div class="product-details">';
        echo '<h2>' . $product_details['title'] . '</h2>';
        echo '<p>Description: ' . $product_details['description'] . '</p>';
        echo '<p>Price: ' . $product_details['price'] . '</p>';
        echo '<img src="' . $product_details['image'] . '" alt="' . $product_details['title'] . '">';
        
        // Display the Add to Cart button
        if(isset($_SESSION['username'])) {
            echo '<form action="adding.php" method="post">';
            
            echo '<input type="hidden" name="product_id" value="' . $product_id . '">';
            
            
            echo '<button type="submit" name="add_to_cart">Add to Cart</button>';
            echo '</form>';
        } else {
            echo '<button onclick="window.location.href=\'login.php\'">Login to Add to Cart</button>';
        }

        echo '</div>';
    } else {
        echo '<p>Product details not found.</p>';
    }
} else {
    echo '<p>No product ID provided.</p>';
}
?>

</div>

</body>
</html>