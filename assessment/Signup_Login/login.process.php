<?php
$firstNameErr = $lastNameErr = $emailErr = $contactErr = $passErr = $websiteErr = "";
$firstName = $lastName = $email = $contact = $pass = $website = "";

$fixedPass = "admin1234";
$fixedEmail = "admin@gmail.com";

function cleanInput($data)
{
  return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = cleanInput($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    } else if ($email !== $fixedEmail) {
      $emailErr = "Incorrect email";
    }
  }

  if (empty($_POST["password"])) {
    $passErr = "Password is required";
  } else {
    $pass = cleanInput($_POST["password"]);
    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).{8,}$/", $pass)) {
      $passErr = "At least 8 characters containing letters and numbers required";
    } else if ($pass !== $fixedPass) {
      $passErr = "Incorrect password";
    }
  }

  $website = cleanInput($_POST["website"] ?? "");
  if (!empty($website) && !filter_var($website, FILTER_VALIDATE_URL)) {
    $websiteErr = "Invalid URL";
  }
}
