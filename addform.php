<?php
include 'db.php'; // Include your database connection file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Record Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMcD+5rW5Z8N5X7ySg8VoGokxGSSiZQi13n7/f" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            background-color: #333;
            padding-top: 20px;
            position: fixed;
        }

        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 16px;
            color: white;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .main-content {
            margin-left: 260px;
            padding: 20px;
            flex-grow: 1;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .submit-btn {
            background-color: #5cb85c;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: #4cae4c;
        }

        .message {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="User Profile.php"><i class="fa-solid fa-cog"></i> User Profile</a>
        <a href="dashboard.php"><i class="fa-solid fa-tachometer-alt"></i> Dashboard</a>
        <a href="inventory.php"><i class="fa-solid fa-warehouse"></i> Inventory</a>
        <a href="nrecord.php"><i class="fa-solid fa-file-alt"></i> New Record</a>
        <a href="stocks.php"><i class="fa-solid fa-boxes"></i> Stocks</a>    
        <a href="tracker.php"><i class="fa-solid fa-map-marker-alt"></i> Tracker</a>
        <a href="return.php"><i class="fa-solid fa-undo-alt"></i> Return Record</a>
    </div>
    
    <!-- Main content -->
    <div class="main-content">
        <div class="container">
            <h1>New Record</h1>
            <form action="nrecord.php" method="POST">
                <label for="item_name">Item Name:</label>
                <input type="text" id="item_name" name="item_name" required>

                <label for="item_id">Item ID:</label>
                <input type="text" id="item_id" name="item_id" required>

                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Item Returned">Item Returned</option>
                    <option value="Pending">Pending</option>
                    <option value="Lost">Lost</option>
                </select>

                <label for="date_of_borrowing">Date of Borrowing:</label>
                <input type="date" id="date_of_borrowing" name="date_of_borrowing" required>

                <label for="returned_date">Returned Date:</label>
                <input type="date" id="returned_date" name="returned_date" required>

                <button type="submit" class="submit-btn">Submit</button>
            </form>

            <?php
            // Process the form submission
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Collect form data
                $itemName = $_POST['item_name'];
                $itemId = $_POST['item_id'];
                $status = $_POST['status'];
                $dateOfBorrowing = $_POST['date_of_borrowing'];
                $returnedDate = $_POST['returned_date'];

                // Prepare SQL statement to insert the record
                $stmt = $conn->prepare("INSERT INTO records (item_name, item_id, status, date_of_borrowing, returned_date) VALUES (?, ?, ?, ?, ?)");
                if ($stmt) { // Check if preparation was successful
                    $stmt->bind_param("sssss", $itemName, $itemId, $status, $dateOfBorrowing, $returnedDate);

                    // Execute the statement and check for success
                    if ($stmt->execute()) {
                        echo "<p class='message' style='color: green;'>New record created successfully!</p>";
                    } else {
                        echo "<p class='message' style='color: red;'>Error: " . $stmt->error . "</p>";
                    }

                    // Close the statement
                    $stmt->close();
                } else {
                    echo "<p class='message' style='color: red;'>Error preparing statement: " . $conn->error . "</p>";
                }
            }

            // Close the database connection
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
