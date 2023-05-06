<?php
  // Validate the form data
  if (empty($_GET['start_date']) || empty($_GET['end_date'])) {
    // Redirect back to the form page with an error message
    header("Location: view_orders_form.php?error=Please select a date range");
    exit();
  }

  // Get the form data
  $start_date = $_GET['start_date'];
  $end_date = $_GET['end_date'];

  // Create a PDO instance
  $dsn = 'mysql:host=localhost;dbname=mydatabase';
  $username = 'myusername';
  $password = 'mypassword';
  $pdo = new PDO($dsn, $username, $password);

  // Prepare and execute the query to retrieve the orders for the user within the selected date range
  $user_id = $_SESSION['user_id']; // Assuming the user ID is stored in a session variable
  $orders_query = "SELECT id, status, total_price, created_at FROM orders WHERE user_id = ? AND created_at BETWEEN ? AND ? AND status IN ('processing', 'out for delivery', 'done')";
  $stmt = $pdo->prepare($orders_query);
  $stmt->execute([$user_id, $start_date, $end_date]);
  $orders = $stmt->fetchAll();

  // Display the orders in a table
  echo "<table>";
  echo "<tr><th>Order ID</th><th>Status</th><th>Total Price</th><th>Created Date</th></tr>";
  foreach ($orders as $order) {
    echo "<tr>";
    echo "<td><a href='order_details.php?id=" . $order['id'] . "'>" . $order['id'] . "</a></td>";
    echo "<td>" . $order['status'] . "</td>";
    echo "<td>" . $order['total_price'] . "</td>";
    echo "<td>" . $order['created_at'] . "</td>";
    echo "</tr>";
  }
  echo "</table>";
