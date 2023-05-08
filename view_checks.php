<?php
  // Validate the form data
  if (empty($_GET['start_date']) || empty($_GET['end_date'])) {
    // Redirect back to the form page with an error message
    header("Location: view_checks_form.php?error=Please select a date range");
    exit();
  }

  // Get the form data
  $start_date = $_GET['start_date'];
  $end_date = $_GET['end_date'];
  $user_id = $_GET['user_id'];

  // Query the checks table to retrieve the checks within the selected date range for the specified user (if any)
  $checks_query = "SELECT id, user_id, created_at FROM checks WHERE created_at BETWEEN ? AND ?";
  $params = [$start_date, $end_date];
  if (!empty($user_id)) {
    $checks_query .= " AND user_id = ?";
    $params[] = $user_id;
  }
  $stmt = $pdo->prepare($checks_query);
  $stmt->execute($params);
  $checks = $stmt->fetchAll();

  // Display the checks in a table
  echo "<table>";
  echo "<tr><th>Check ID</th><th>User ID</th><th>User Name</th><th>Created Date</th><th>View Orders</th></tr>";
  foreach ($checks as $check) {
    // Query the users table to retrieve the user name
    $user_query = "SELECT name FROM users WHERE id = ?";
    $stmt = $pdo->prepare($user_query);
    $stmt->execute([$check['user_id']]);
    $user = $stmt->fetch();

    echo "<tr>";
    echo "<td>" . $check['id'] . "</td>";
    echo "<td>" . $check['user_id'] . "</td>";
    echo "<td>" . $user['name'] . "</td>";
    echo "<td>" . $check['created_at'] . "</td>";
    echo "<td><a href='view_orders.php?user_id=" . $check['user_id'] . "&start_date=" . $start_date . "&end_date=" . $end_date . "'>View Orders</a></td>";
    echo "</tr>";
  }
  echo "</table>";
