<?php
$firstNameErr = $lastNameErr = $emailErr = $reasonErr = $chkboxErr = $dateErr = $websiteErr = $genderErr = "";
$firstName = $lastName = $email = $company = $reason = $chkbox = $date = $website = $gender = "";

function cleanInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["firstName"])) {
        $firstNameErr = "First Name is required";
    } else {
        $firstName = cleanInput($_POST["firstName"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $firstName)) {
            $firstNameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["lastName"])) {
        $lastNameErr = "Last Name is required";
    } else {
        $lastName = cleanInput($_POST["lastName"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $lastName)) {
            $lastNameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = cleanInput($_POST["gender"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = cleanInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    $company = cleanInput($_POST["company"] ?? "");

    if (empty($_POST["reason"])) {
        $reasonErr = "Reason is required";
    } else {
        $reason = cleanInput($_POST["reason"]);
    }

    if (empty($_POST["chkbox"])) {
        $chkboxErr = "Topics is required";
    } else {
        $chkbox = cleanInput($_POST["chkbox"]);
    }

    if (empty($_POST["date"])) {
        $dateErr = "Date is required";
    } else {
        $date = cleanInput($_POST["date"]);
    }

    $website = cleanInput($_POST["website"] ?? "");
    if (!empty($website) && !filter_var($website, FILTER_VALIDATE_URL)) {
        $websiteErr = "Invalid URL";
    }
}
