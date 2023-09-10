<?php
require_once "utilities.php";
require_once "pdo.php";
session_start();

if (isset($_POST['SignUp'])) {
    header("Location: SignUp.php");
    return;
}

if (isset($_POST['email']) && isset($_POST['pass'])) {
    $message = SignInValidation();
    if (is_string($message)) {
        $_SESSION['error'] = $message;
        header("Location: login.php");
        return;
    }
    $message = SearchAccount($pdo);
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
    <title>GID: Sign in</title>
    <style>
        body {
            font-family: "Arial", sans-serif;
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

        p {
            font-size: 16px;
            color: #555;
        }

        h2 {
            font-size: 20px;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        input[type="text"],
        input[type="password"] {
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
    <p>
        Procrastination is a real problem. It's when we put things off, and it keeps us from reaching our goals. Studies show that around 50% of college students procrastinate in a consistent and chronic manner. But remember, you are not alone! We are here to help you stay organized and become a better you! Let's Get it Done!
    </p>
    <h2>Sign In</h2>
    <?php
    FlashMessage();
    ?>
    <form method="POST">
        <p>Email:
            <input type="text" name="email">
        </p>
        <p>Password:
            <input type="password" name="pass">
        </p>
        <p>
            <input type="submit" name="SignIn" value="Sign In">
        </p>
        <p>Don't Have an account?
            <input type="submit" name="SignUp" value="Sign up">
        </p>
    </form>
</div>
</body>
</html>
