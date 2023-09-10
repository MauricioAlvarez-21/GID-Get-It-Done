<?php
require_once "pdo.php";
require_once "is_email.php";
require_once "utilities.php";
session_start();

SecurityValidation();

if (isset($_POST['Cancel'])) {
    header("Location: index.php");
    return;
}

if (isset($_POST['title']) && isset($_POST['headline']) && isset($_POST['date']) && isset($_POST['description']) && isset($_POST['location'])) {
    $message = ValidateTask();
    if (is_string($message)) {
        $_SESSION['error'] = $message;
        header("Location: add.php");
        return;
    }
    if (InputTask($pdo)) {
        header("Location: index.php");
        return;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "bootstrap.php"; ?>
    <title>GID: Adding Task</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        h1 {
            font-size: 24px;
            color: #333;
        }

        h2 {
            font-size: 20px;
            color: #333;
        }

        p {
            font-size: 16px;
            color: #555;
        }

        form {
            margin-top: 20px;
        }

        input[type="text"],
        input[type="password"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
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
<div class="container">
    <h1>GID: Get It Done!</h1>
    <h2>Keep in mind you want to have MAD goals: measurable, achievable, and able to be done by a set deadline. Keep this in mind when adding tasks, and most importantly, trust yourself!</h2>
    <h2>Adding a task for <?= $_SESSION['name'] ?></h2>
    <?php
    FlashMessage();
    ?>
    <form method="POST">
        <p>Task title:
            <input type="text" name="title">
        </p>
        <p>
            Headline:
            <input type="text" name="headline">
        </p>
        <p>
            Location:
            <input type="text" name="location">
        </p>
        <p>
            Due Date:
            <input type="text" name="date" value="mm/dd/yy">
        </p>
        <p>
            Description:
        </p>
        <textarea name="description" rows="8" cols="80"></textarea>
        <p>
            <input type="submit" name="Add" value="Add">
        </p>
        <p>
            <input type="submit" name="Cancel" value="Cancel">
        </p>
    </form>
</div>
</body>
</html>
