<?php
  // Validate the form data
  if (empty($_POST['user_id']) || empty($_POST['total_price'])) {
    // Redirect back to the form page with an error message
    header("Location: form.php?error=Please fill all required fields");
    exit();
  }

  // Get the form data
  $user_id = $_POST['user_id'];
  $total_price = $_POST['total_price'];
  $notes = $_POST['notes'];

  // Insert the new order into the orders table
  $insert_query = "INSERT INTO orders (user_id, status, total_price, notes) VALUES ('$user_id', 'processing', '$total_price', '$notes')";
  mysqli_query($conn, $insert_query);

  // Redirect to the order details page
  $order_id = mysqli_insert_id($conn); // Get the ID of the newly inserted order
  header("Location: order_details.php?id=$order_id");
  exit();
