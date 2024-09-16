<?php
session_start();
include 'config.php';  // Database connection

// Check if the user is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    echo "Access denied. You must be an admin to access this page.";
    exit();
}

// Fetch all discount codes from the database
$sql = "SELECT * FROM discount_codes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Discount Codes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .admin-container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        form {
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="number"], input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .edit, .delete {
            color: white;
            padding: 5px 10px;
            border-radius: 3px;
            text-decoration: none;
            margin-right: 10px;
        }

        .edit {
            background-color: #28a745;
        }

        .delete {
            background-color: #dc3545;
        }

        .edit:hover {
            background-color: #218838;
        }

        .delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Manage Discount Codes</h1>

        <!-- Form to Add New Discount Code -->
        <form action="add_discount_code.php" method="POST">
            <label for="code">Discount Code</label>
            <input type="text" name="code" required>

            <label for="discount_percentage">Discount Percentage (%)</label>
            <input type="number" name="discount_percentage" step="0.01" required>

            <input type="submit" value="Add Discount Code">
        </form>

        <!-- Display List of Discount Codes -->
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Discount Percentage (%)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['code']); ?></td>
                            <td><?php echo (float)$row['discount_percentage'] * 100; ?>%</td>
                            <td>
                                <a href="edit_discount_code.php?id=<?php echo $row['id']; ?>" class="edit">Edit</a>
                                <a href="delete_discount_code.php?id=<?php echo $row['id']; ?>" class="delete">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="3">No discount codes found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
