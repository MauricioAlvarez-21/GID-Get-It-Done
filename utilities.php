<?php
require_once "pdo.php";
require_once "is_email.php";

function SecurityValidation(){
    if ( !isset($_SESSION['name']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    return;
  }
}


function SignInValidation(){
  if(strlen($_POST['email'])==0 || strlen($_POST['pass'])==0){
    return "Email and Password are required!";
  }
  elseif(!is_email($_POST['email'])){
    return "Make sure you are typing your email correctly";
  }
  else{
    return True;
  }
}


function SignUpValidation(){
  if(strlen($_POST['name'])==0 || $_POST['email']==0 || strlen($_POST['pass'])==0){
    return "Name, Email and Password are required!";
  }
  elseif(!is_email($_POST['email'])){
    return "Make sure you are typing your email correctly";
  }
  else{
    return True;
  }
}



function SearchAccount($pdo){
  $stmt = $pdo->prepare("SELECT user_id, name, email, password FROM users WHERE email = :email");
  $stmt->bindParam(':email', $_POST['email']);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$row) {
      return "We could not find your account! Make sure to type your email correctly or sign up.";
  }

  // Verify the password securely using password_verify(). do in the future
  //$passwordCorrect = password_verify($_POST['password'], $row['password']);

  if ($_POST['pass']!= $row['password']) {
      return "Incorrect password! Try again";
  }

  // Set session variables
  $_SESSION['user_id'] = $row['user_id'];
  $_SESSION['name'] = $row['name'];
  $_SESSION['email'] = $row['email'];
  
  return true;

}



function VerifyEmail($pdo){
  // for faster development rethink this 
  $stmt = $pdo->prepare("SELECT email FROM users");
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach($rows as $rou){
    if ($rou['email']==$_POST['email']){
      return "Looks like you already have an account with this email";
    }
  }

  $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
  $stmt->execute(array(
    ':name' => $_POST['name'],
    ':email' => $_POST['email'],
    ':password' => $_POST['pass'])
    );
    $user_id = $pdo->lastInsertId();


  // Set session variables
  $_SESSION['user_id'] = $user_id;
  $_SESSION['name'] = $_POST['name'];
  $_SESSION['email'] = $_POST['email'];
  
  return true;

}



function FlashMessage(){
  if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
  }
  if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
  }
}

function ValidateTask(){
  if(strlen($_POST['title'])==0 || strlen($_POST['headline'])==0 || strlen($_POST['description'])==0 || strlen($_POST['date'])==0 || strlen($_POST['location'])==0){
    return "All fields are required!";
  }
  $date=$_POST['date'];
  if(strlen($date)!=8){
    return "Please enter the date using the indicated format";
  }
  $dd = intval(substr($date,3,2));
  $mm = intval(substr($date,0,2));
  $yy = intval(substr($date,6,2));

  if (!checkdate($mm,$dd,$yy)){
    return "Please enter the date using the indicated format";
  }
  return True;

}

function InputTask($pdo){
  $stmt = $pdo->prepare("SELECT location_id FROM  locations WHERE location_name = :name");
  $stmt->execute( array(
    ':name' => $_POST['location']
  ));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$row){
    $stmt = $pdo->prepare("INSERT INTO locations (location_name) VALUES (:name)");
    $stmt->execute(array(
      ':name' => $_POST['location'])
    );
    $location_id = $pdo->lastInsertId();
  } else{
    $location_id=$row['location_id'];
  }


  $olddate=$_POST['date'];
  $dd = intval(substr($olddate,3,2));
  $mm = intval(substr($olddate,0,2));
  $yy = intval(substr($olddate,6,2));
  $newDate='20'.$yy.'-'.$mm.'-'.$dd;

  $stmt = $pdo->prepare("INSERT INTO tasks (location_id, user_id, title, headline, due_date, description) VALUES (:location_id, :user_id, :title, :headline, :due_date, :description)");
  $stmt->execute(array(
    ':location_id' => $location_id,
    ':user_id' => $_SESSION['user_id'],
    ':title' => $_POST['title'],
    ':headline' => $_POST['headline'],
    ':due_date' => $newDate,
    ':description' => $_POST['description'])
    );
  return True;

}
