<?php
require_once "pdo.php";
require_once "is_email.php";
require_once "utilities.php";
session_start();

SecurityValidation();

if (isset($_POST['AddNew'])) {
    header("Location: add.php");
    return;
}

if (isset($_POST['SignOut'])) {
    header("Location: logout.php");
    return;
}
?>
<!DOCTYPE html>
<html>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>GID: Index</title>
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

        h3 {
            font-size: 18px;
            color: #555;
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }

        th, td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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

        p {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Showing Tasks for <?= $_SESSION['name'] ?></h1>
    <h3>Today is <?= date("l m-d-Y") ?></h3>
    <?php FlashMessage(); ?>
    <?php
    $stmt = $pdo->prepare("SELECT * FROM tasks JOIN locations ON tasks.location_id=locations.location_id WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $currDate = date("Y-m-d");

    $overdue = 0;

    foreach ($rows as $row) {
        if (strtotime($row['due_date']) < strtotime($currDate)) {
            $overdue++;
        }
    }
    if ($overdue > 0) {
        echo("<h2>You have " . $overdue . " overdue tasks</h2>");
        echo("<table>");
        echo("<tr> <th> Title </th>");
        echo("<th> Headline </th>");
        echo("<th> Due Date </th>");
        echo("<th> Location </th>");
        echo("<th> Action </th> </tr>");
        foreach ($rows as $row) {
            if (strtotime($row['due_date']) < strtotime($currDate)) {
                echo("<tr>");
                echo("<td><a href=view.php?task_id=" . $row['task_id'] . ">" . $row['title'] . "</a></td>");
                echo("<td>");
                echo($row['headline']);
                echo("</td>");
                echo("<td>");
                echo($row['due_date']);
                echo("</td>");
                echo("<td>");
                echo($row['location_name']);
                echo("</td>");
                echo("<td>");
                echo("<a href=edit.php?task_id=" . $row['task_id'] . ">Edit</a> /");
                echo("<a href=delete.php?task_id=" . $row['task_id'] . ">Delete</a>");
                echo("</td>");
            }
        }
        echo("</table>");
    }

    $dueToday = 0;

    foreach ($rows as $row) {
        if (strtotime($row['due_date']) == strtotime($currDate)) {
            $dueToday++;
        }
    }
    if ($dueToday > 0) {
        echo("<h2>You have " . $dueToday . " tasks due today</h2>");
        echo("<table>");
        echo("<tr> <th> Title </th>");
        echo("<th> Headline </th>");
        echo("<th> Due Date </th>");
        echo("<th> Location </th>");
        echo("<th> Action </th> </tr>");
        foreach ($rows as $row) {
            if (strtotime($row['due_date']) == strtotime($currDate)) {
                echo("<tr>");
                echo("<td><a href=view.php?task_id=" . $row['task_id'] . ">" . $row['title'] . "</a></td>");
                echo("<td>");
                echo($row['headline']);
                echo("</td>");
                echo("<td>");
                echo($row['due_date']);
                echo("</td>");
                echo("<td>");
                echo($row['location_name']);
                echo("</td>");
                echo("<td>");
                echo("<a href=edit.php?task_id=" . $row['task_id'] . ">Edit</a> /");
                echo("<a href=delete.php?task_id=" . $row['task_id'] . ">Delete</a>");
                echo("</td>");
            }
        }
        echo("</table>");
    }

    $dueFuture = 0;

    foreach ($rows as $row) {
        if (strtotime($row['due_date']) > strtotime($currDate)) {
            $dueFuture++;
        }
    }
    if ($dueFuture > 0) {
        echo("<h2>You have " . $dueFuture . " tasks due in the future. Start getting ahead!</h2>");
        echo("<table>");
        echo("<tr> <th> Title </th>");
        echo("<th> Headline </th>");
        echo("<th> Due Date </th>");
        echo("<th> Location </th>");
        echo("<th> Action </th> </tr>");
        foreach ($rows as $row) {
            if (strtotime($row['due_date']) > strtotime($currDate)) {
                echo("<tr>");
                echo("<td><a href=view.php?task_id=" . $row['task_id'] . ">" . $row['title'] . "</a></td>");
                echo("<td>");
                echo($row['headline']);
                echo("</td>");
                echo("<td>");
                echo($row['due_date']);
                echo("</td>");
                echo("<td>");
                echo($row['location_name']);
                echo("</td>");
                echo("<td>");
                echo("<a href=edit.php?task_id=" . $row['task_id'] . ">Edit</a> /");
                echo("<a href=delete.php?task_id=" . $row['task_id'] . ">Delete</a>");
                echo("</td>");
            }
        }
        echo("</table>");
    }
    ?>
    <form method="POST">
        <p>
            <input type="submit" name="AddNew" value="Add New Task">
        </p>
        <p>
            <input type="submit" name="SignOut" value="Sign Out">
        </p>
    </form>
</body>
</html>
