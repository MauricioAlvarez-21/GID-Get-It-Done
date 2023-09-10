<?php
require_once "pdo.php";
require_once "is_email.php";
require_once "utilities.php";
session_start();

SecurityValidation();

if (isset($_POST['Return'])) {
    header("Location: index.php");
    return;
}

if (isset($_POST['Delete'])) {
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE task_id = :task_id");
    $stmt->bindParam(':task_id', $_GET['task_id']);
    $stmt->execute();

    $_SESSION['success'] = "Record deleted";
    header("Location: index.php");
    return;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GID: Delete</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
        }

        p {
            font-size: 16px;
            color: #555;
            text-align: center;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<form method="POST">
    <h1>GID: Delete</h1>
    <p>Please confirm you would like to delete the task:</p>
    <p>
        <input type="submit" name="Delete" value="Delete">
    </p>
    <p>
        <input type="submit" name="Return" value="Return">
    </p>
</form>
</body>
</html>
