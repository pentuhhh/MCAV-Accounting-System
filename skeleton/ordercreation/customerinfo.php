<?php
    require 'addcustomer.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Information</title>
</head>
<body>
    <h2>Enter Customer Information</h2>
    <form action="payment_plan.php" method="post">
        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="CustomerFname" required><br><br>
        
        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="CustomerLname" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="CustomerEmail" required><br><br>
        
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="CustomerPhone" required><br><br>
        
        <input type="submit" value="Next">
    </form>
</body>
</html>
