<?php
  $order_id = $_GET['id'];

  // Create a PDO instance
  $dsn = 'mysql:host=localhost;dbname=mydatabase';
  $username = 'myusername';
  $password = 'mypassword';
  $pdo = new PDO($dsn, $username, $password);

  // Query the orders table to check if the order can be cancelled
  $order_query = "SELECT status FROM orders WHERE id = ? AND user_id = ?";
  $stmt = $pdo->prepare($order_query);
  $stmt->execute([$order_id, $user_id]);
  $order = $stmt->fetch();

  if ($order['status'] == 'processing') {
    // Update the status of the order to "cancelled"
    $update_query = "UPDATE orders SET status = 'cancelled' WHERE id = ?";
    $stmt = $pdo->prepare($update_query);
    $stmt->execute([$order_id]);

    // Redirect back to the order details page with a success message
    header("Location: order_details.php?id=$order_id&success=Order has been cancelled");
    exit();
  } else {
    // Redirect back to the order details page with an error message
    header("Location: order_details.php?id=$order_id&error=Order cannot be cancelled");
    exit();
  }
