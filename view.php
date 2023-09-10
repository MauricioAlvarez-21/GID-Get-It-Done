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

$stmt = $pdo->prepare("SELECT * FROM tasks JOIN locations ON tasks.location_id=locations.location_id WHERE task_id = :task_id");
$stmt->bindParam(':task_id', $_GET['task_id']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GID: View</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
        }

        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
        }

        h2 {
            font-size: 20px;
            color: #333;
        }

        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        form {
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
    <h1>Task details</h1>
    <h2>Title: <?= $row['title'] ?></h2>
    <h2>Headline: <?= $row['headline'] ?></h2>
    <h2>Due date: <?= $row['due_date'] ?></h2>
    <h2>Location: <?= $row['location_name'] ?></h2>
    <h2>Description:</h2>
    <textarea rows="8" cols="80"><?= $row['description'] ?></textarea>
    <h2>User: <?= $_SESSION['name'] ?></h2>
    <form method="POST">
        <p>
            <input type="submit" name="Return" value="Return">
        </p>
    </form>
</body>
</html>
