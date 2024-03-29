<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image:url("1677693807803.jpeg");
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-top: 50px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.8);
        }

        .container {
            margin-top: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"],
        input[type="tel"] { 
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 12px 20px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        @media screen and (max-width: 600px) {
            form {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <h2 style="color:white ;">Registration</h2>

    <form action="register.php" method="post" onsubmit="return validateForm()">
        <div class="container">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter your username">

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" placeholder="Enter your email">

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" placeholder="Enter your phone number">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password">
            
            <button type="submit">Register</button>
        </div>
    </form>
    <script>
      function validateForm() {
            // Get form inputs
            var username = document.getElementById('username').value;
            var email = document.getElementById('email').value;
            var phone = document.getElementById('phone').value;
            var password = document.getElementById('password').value;

            
            var usernameRegex = /^[a-zA-Z0-9_]{3,20}$/; 
            var emailRegex = /^\S+@\S+\.\S+$/;
            var phoneRegex = /^\d{10}$/; 
            var passwordRegex = /^(?=.*\d)(?=.*[a-zA-Z]).{8,}$/;

            
            if (!usernameRegex.test(username)) {
                alert('Username must be alphanumeric and underscore, 3 to 20 characters long.');
                return false;
            }

          
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address.');
                return false;
            }

           
            if (!phoneRegex.test(phone)) {
                alert('Please enter a valid 10-digit phone number.');
                return false;
            }

            
            if (!passwordRegex.test(password)) {
                alert('Password must be at least 8 characters long and contain at least one digit and one letter.');
                return false;
            }

            
            return true;
        }
    </script>

</body>
</html>
