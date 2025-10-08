<?php 

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cat";
$connection = mysqli_connect($servername,$username,$password,$dbname);
if(!$connection){
    die("connection field: ".mysqli_connect_error());
}else{
    if (isset($_POST['pname']) && isset($_POST['price']) && isset($_POST['date'])){
        $pname = $_POST['pname'];
        $price = $_POST['price'];
        $date = $_POST['date'];
        $sql = "INSERT INTO product (product_name,price,date) VALUES ('$pname','$price','$date')";
        
        if (mysqli_query($connection,$sql)){
            echo "Product registration successful!!";
        }
        else{
            echo "Error: ".mysqli_error($connection);
        }
    }
}

?>
<html>
    <head>
        <title>PRODUCT REGISTRATION</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Product Registration</h1>
        <form action="" method="POST" id="productform">
        <p>Product Name :<input type="text" name="pname" id="pname" placeholder="enter the product name"></p>
        <p>Price: <input type="number" name="price" id="price" placeholder="Enter the price"></p>
        <p>Date: <input type="date" name="date" id="date" placeholder="date"></p>
             <button id="btn">Submit</button>
        <div id="message" class="message"></div>
        </form>
    </body>
    <script>
    document.getElementById("productform").addEventListener("submit",function(event){
        event.preventDefault(); 
        
        const pname = document.getElementById("pname").value.trim();
        const price = parseFloat(document.getElementById("price").value);
        const date = document.getElementById("date").value;
        const messageDiv = document.getElementById("message");
        

        messageDiv.innerHTML = "";
        messageDiv.className = "message";
        
        let isValid = true;
        let errorMessages = [];
        
    
        if (pname === "") {
            errorMessages.push("Product name cannot be empty");
            isValid = false;
        }
        
       
        if (isNaN(price) || price <= 0) {
            errorMessages.push("Price must be a number greater than 0");
            isValid = false;
        }
        
        
        if (date === "") {
            errorMessages.push("Expiration date cannot be empty");
            isValid = false;
        } else {
            const selectedDate = new Date(date);
            const today = new Date();
            today.setHours(0, 0, 0, 0); 
            
            if (selectedDate <= today) {
                errorMessages.push("Expiration date must be a future date");
                isValid = false;
            }
        }
        
        if (isValid) {
            messageDiv.innerHTML = "Form validation successful!";
            messageDiv.className = "message success";
           
            setTimeout(() => {
                document.getElementById("productform").submit();
            }, 1500);
        } else {
            messageDiv.innerHTML = errorMessages.join("<br>");
            messageDiv.className = "message error";
        }
    });
    </script>
</html>