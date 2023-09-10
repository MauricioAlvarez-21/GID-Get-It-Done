<?php
require_once "utilities.php";
session_start();
if (isset($_POST['Cancel'])) {
    header("Location: login.php");
    return;
}
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['pass'])) {
    $message = SignUpValidation();
    if (is_string($message)) {
        $_SESSION['error'] = $message;
        header("Location: login.php");
        return;
    }
    $message = VerifyEmail($pdo);
    if (is_string($message)) {
        $_SESSION['error'] = $message;
        header("Location: login.php");
        return;
    }
    header("Location: index.php");
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "bootstrap.php"; ?>
    <title>Sign Up Page</title>
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
        input[type="submit"] {
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
    <h1>Welcome to GID: Get It Done!</h1>
    <h2>This will be some text about what this application does and how we can help you become better. For now, all this text is actually a placeholder, but remember to include some data and some motivational quotes.</h2>
    <h2>Sign Up</h2>
    <?php
    FlashMessage();
    ?>
    <form method="POST">
        <p>Name:
            <input type="text" name="name">
        </p>
        <p>Email:
            <input type="text" name="email">
        </p>
        <p>Password:
            <input type="password" name="pass">
        </p>
        <p>
            <input type="submit" value="Create Account">
        </p>
        <p>Don't Have an account?</p>
        <p>
            <input type="submit" name="Cancel" value="Cancel">
        </p>
    </form>
</div>
</body>
</html>
