<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {
    margin:0;
    font-family:Arial;
            background-size: cover;
            background-position: center; 
            background-repeat: no-repeat; 
            background-attachment: fixed;
}

.topnav {
  overflow: hidden;
  background-color:rgb(151, 198, 226); 
   
}

.topnav a {
  float: left;
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.active {
  background-color: #04AA6D;
  color: white;
}

.topnav .icon {
  display: none;
}

.dropdown {
  float: right;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 17px;    
  border: none;
  outline: none;
  color: black;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
  padding-top: 10px;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.topnav a:hover, .dropdown:hover .dropbtn {
  background-color:whitesmoke;
  color: black;
}

.dropdown-content a:hover {
  background-color: #ddd;
  color: black;
}

.dropdown:hover .dropdown-content {
  display: block;
}

@media screen and (max-width: 600px) {
  .topnav a:not(:first-child), .dropdown .dropbtn {
    display: none;
  }
  .topnav a.icon {
    float: right;
    display: block;
  }
}

@media screen and (max-width: 600px) {
  .topnav.responsive {position: relative;}
  .topnav.responsive .icon {
    position: absolute;
    right: 0;
    top: 0;
  }
  .topnav.responsive a {
    float: none;
    display: block;
    text-align: left;
  }
  .topnav.responsive .dropdown {float: none;}
  .topnav.responsive .dropdown-content {position: relative;}
  .topnav.responsive .dropdown .dropbtn {
    display: block;
    width: 100%;
    text-align: left;
  }
}
.topnav a:first-child:hover {
  background-color: white; 
}
.topnav a:hover {
  background-color: #ddd;
  color: black;
  transition: background-color 0.3s, color 0.3s; 
}

.topnav a:first-child:hover {
  background-color: rgb(151, 198, 226); 
}


#products-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  
  gap: 10px;
  padding: 10px;
}

.product-card {
  background-color: #fff;
  border-radius: 8px;
  padding: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  text-align: center;
  width: 300px;
  height: auto;
}

.product-card img {
  max-width: 100%;
  height: auto;
}

.product-card:hover {
    cursor: pointer;
  
}

.profile {
  float: right;
  margin-right: 20px;
  font-size: 17px;
}

@media screen and (max-width: 600px) {
  .profile {
    float: none;
    margin: 10px auto; 
    text-align: center;
  }
}


</style>
</head>
<body>

<div class="topnav" id="myTopnav">
    <a href="adding.php" id="cart-icon"><img src="shop.png" width="70px" height="70px" alt="logo" style="padding-bottom:15%;" ></a>
  <a href="#home">Home</a>

  <!-- Check if user is logged in, display profile  -->
  <?php
    session_start();
    
    if(isset($_SESSION['username'])) {
        echo '<div class="profile">Welcome, ' . $_SESSION['username'] . ' !! <a href="logout.php">Logout</a></div>';

        
    if(isset($_GET['logout'])) {
      session_destroy();
      header('Location: index.php');
      exit();
  }

    }
    ?>
    
    
  <div class="dropdown">
    <button class="dropbtn">User 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="index.php">Register</a>
      <a href="login.php">Login</a>
      
    </div>
    
  </div> 

  
  <a href="#about" style="float:right ; "><img src="cart.png" alt="cart" width="20px" height="20px"></a>
  <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>
<div id="products-container"></div>


<script>




function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}

// Function to fetch and display products
function fetchProducts() {
    fetch('https://fakestoreapi.com/products')
    .then(response => response.json())
    .then(data => {
        const productsContainer = document.getElementById('products-container');
       
        productsContainer.innerHTML = '';
      
        data.forEach(product => {
            const productCard = document.createElement('div');
            productCard.classList.add('product-card');

            
            productCard.innerHTML = `
                <h3>${product.title}</h3>
                <p>${product.price}</p>
                <p>${product.description}</p>
                <img src="${product.image}" alt="${product.title}" style="width:100%">
            `;

            productCard.addEventListener('click', () => {
              window.location.href = 'product details.php?id=' + product.id;
            });


            productsContainer.appendChild(productCard);
        });
    })
    .catch(error => {
        console.error('Error fetching products:', error);
        
    });
}


window.onload = fetchProducts;


document.getElementById('cart-icon').addEventListener('click', function() {
    console.log('Cart icon clicked');
    window.location.href = 'adding.php';
});

</script>

</body>
</html>
