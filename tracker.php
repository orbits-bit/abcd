<?php
// Simulated database connection
$equipmentData = [
    ['id' => '001', 'name' => 'Excavator', 'status' => 'Available', 'location' => 'Warehouse A', 'last_checked' => '2024-10-07'],
    ['id' => '002', 'name' => 'Bulldozer', 'status' => 'In Use', 'location' => 'Site B', 'last_checked' => '2024-10-05'],
    ['id' => '003', 'name' => 'Crane', 'status' => 'Under Maintenance', 'location' => 'Workshop', 'last_checked' => '2024-09-30'],
];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Here, you can handle the form data, e.g., save to the database
    header("Location: addform.php");
    exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <title>Tracker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
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

        .navbar {
            background-color: #333;
            padding: 15px;
            color: white;
            text-align: center;
        }

        .navbar h1 {
            margin: 0;
        }

        .container {
            margin: 20px;
        }

        .search-container {
            margin-bottom: 20px;
            width: 400px;
        }

        .search-container input {
            padding: 10px;
            width: 80%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .green-button {
            background-color: green; /* Green background */
            color: white; /* White text */
            border: none; /* No border */
            padding: 8px 15px; /* Smaller padding for smaller button */
            text-align: center; /* Center the text */
            text-decoration: none; /* No underline */
            display: inline-block; /* Make it behave like a button */
            font-size: 14px; /* Smaller font size */
            cursor: pointer; /* Pointer cursor on hover */
            border-radius: 5px; /* Rounded corners */
            margin-top: 10px; /* Margin for spacing */
        }

        .green-button:hover {
            background-color: darkgreen; /* Darker green on hover */
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
        <div class="navbar">
            <h1>Equipment Tracker</h1>
        </div>

        <div class="container">
            <div class="search-container">
                <input type="text" id="search" placeholder="Search for equipment..." onkeyup="filterTable()">
            </div>

            <!-- Green Button for Adding New Record -->
            <form method="post" action="">
                <button type="submit" name="myButton" class="green-button">Add New Record</button>
            </form>

            <table id="trackerTable">
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th>Last Checked</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($equipmentData as $equipment): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($equipment['id']); ?></td>
                            <td><?php echo htmlspecialchars($equipment['name']); ?></td>
                            <td><?php echo htmlspecialchars($equipment['status']); ?></td>
                            <td><?php echo htmlspecialchars($equipment['location']); ?></td>
                            <td><?php echo htmlspecialchars($equipment['last_checked']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function filterTable() {
            const input = document.getElementById("search").value.toUpperCase();
            const table = document.getElementById("trackerTable");
            const tr = table.getElementsByTagName("tr");
            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName("td");
                let showRow = false;

                for (let j = 0; j < td.length; j++) {
                    if (td[j] && td[j].innerHTML.toUpperCase().indexOf(input) > -1) {
                        showRow = true;
                    }
                }

                tr[i].style.display = showRow ? "" : "none";
            }
        }
    </script>

</body>
</html>
