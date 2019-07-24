<?php
session_start();
error_log("Login Failure: User name and password are required");
$salt = 'XyZzy12*_';
$stored_hash = hash('md5', 'XyZzy12*_php123');//'a8609e8d62c043243c4e201cbb342862';  // Pw is meow123

$failure = false;  // If we have no POST data
$NeedAt = false;

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) )
{
  if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 )
  {
    error_log("login failed");
    $_SESSION['error'] = "User name and password are required";
    header("Location: login.php");
    return;
  }
  else if(strpos($_POST['email'], '@') === false)
  {
    $_SESSION['error'] = "Email must have an at-sign (@)";
    header("Location: login.php");
    return;
    //error_log("login.php Login Failure", 3, "/var/www/html/phpErrors.log");
  }
  else
  {
    $check = hash('md5', $salt.$_POST['pass']);
    if ( $check == $stored_hash )
    {
      $_SESSION['name'] = $_POST['email'];
      header("Location: index.php");
      return;
    }
    else
    {
      //error_log("login.php Login Failure",  3, "/var/www/html/phpErrors.log");
      $_SESSION['error'] = "Incorrect password";
      header("Location: login.php");
      return;
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>

<title>Kody Rogers Login Page</title>
</head>
<body>

<h1>Please Log In</h1>
<?php

if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}

 ?>
<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="email" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="password" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>


</body>
</html>
