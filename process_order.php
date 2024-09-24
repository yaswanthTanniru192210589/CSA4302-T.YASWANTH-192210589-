<?php
// Connect to the database
$servername = "localhost";
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$dbname = "cakeordering";

// Create connection
$conn = new mysqli('localhost', 'root', "",'cakeordering');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$purpose = $_POST['purpose'];
$delivery_date = $_POST['delivery-date'];
$delivery_time = $_POST['delivery-time'];
$instructions = $_POST['instructions'];
$payment_method = $_POST['payment-method'];

// Retrieve cart items from localStorage via POST request
$cart_items = json_decode($_POST['cart-items'], true);
$total_amount = $_POST['total-amount']; // Pass total amount from JS

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO cart (name, email, address, phone, purpose, delivery_date, delivery_time, instructions, payment_method, cart_items, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssd", $name, $email, $address, $phone, $purpose, $delivery_date, $delivery_time, $instructions, $payment_method, json_encode($cart_items), $total_amount);

// Execute the statement
if ($stmt->execute()) {
    echo "Order placed successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Redirect to a confirmation page
header("Location: confirmation.php");
exit();
?>
