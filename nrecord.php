<?php
// Initialize variables for success and error messages
$success_message = "";
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $itemId = $_POST['item_id'];
    $itemName = $_POST['item_name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $supplierName = $_POST['supplier_name'];
    $date = $_POST['date'];
    $price = $_POST['price'];
    $details = $_POST['details'];

    // Basic validation
    if (empty($itemId) || empty($itemName) || empty($category) || empty($quantity) || empty($supplierName) || empty($date) || empty($price) || empty($details)) {
        $error_message = "Please fill in all fields.";
    } else {
        // Database connection
        $servername = "localhost"; // Change this to your server name
        $username = "root"; // Change this to your database username
        $password = ""; // Change this to your database password
        $dbname = "inventory_db"; // Change this to your database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert data into the inventory table
        $sql = "INSERT INTO inventory (item_id, item_name, category, quantity, supplier_name, date, price, details) 
                VALUES ('$itemId', '$itemName', '$category', '$quantity', '$supplierName', '$date', '$price', '$details')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "New inventory item added successfully.";

            // Update stock management (assuming there's a stocks table)
            $update_sql = "INSERT INTO stocks (item_id, quantity) VALUES ('$itemId', '$quantity') 
                           ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";

            if ($conn->query($update_sql) !== TRUE) {
                $error_message = "Error updating stock: " . $conn->error;
            }
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the connection
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Inventory Item</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: #f4f4f4;
        }
        /* Sidebar style */
        .sidebar {
            height: 100vh;
            width: 250px;
            background-color: #333;
            padding-top: 20px;
            position: fixed;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        /* Main content */
        .main-content {
            margin-left: 260px; /* Same as sidebar width + padding */
            padding: 20px;
            flex-grow: 1;
        }
        .form-container {
            width: 60%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px #0000001a;
        }
        .form-container h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-group button:hover {
            background-color: #575757;
        }
        .message {
            text-align: center;
            color: green;
        }
        .error {
            text-align: center;
            color: red;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

    <div class="main-content">
        <div class="form-container">
            <h2>Add Inventory Item</h2>

            <!-- Display success or error messages -->
            <?php if (!empty($success_message)): ?>
                <p class="message"><?php echo $success_message; ?></p>
            <?php elseif (!empty($error_message)): ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <!-- Inventory form -->
            <form action="" method="POST">
                <div class="form-group">
                    <label for="item_id">Item ID:</label>
                    <input type="text" id="item_id" name="item_id" required>
                </div>
                <div class="form-group">
                    <label for="item_name">Item Name:</label>
                    <input type="text" id="item_name" name="item_name" required>
                </div>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select id="category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="Heavy Machinery">Heavy Machinery</option>
                        <option value="Tools">Tools</option>
                        <option value="Building Materials">Building Materials</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" required>
                </div>
                <div class="form-group">
                    <label for="supplier_name">Supplier Name:</label>
                    <input type="text" id="supplier_name" name="supplier_name" required>
                </div>
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" min="0" step="0.01" required>
                </div>
                <div class="form-group">
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
