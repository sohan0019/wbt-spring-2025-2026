<?php
$firstNameErr = $lastNameErr = $emailErr = $contactErr = $passErr = $websiteErr = $contactErr = "";
$firstName = $lastName = $email = $contact = $pass = $website = $contact = "";

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

    if (!empty($_POST["contact"])) {
        $contact = cleanInput($_POST["contact"]);
        if (!preg_match("/^\d+$/", $contact)) {
            $contactErr = "Only numbers allowed";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = cleanInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["password"])) {
        $passErr = "Password is required";
    } else {
        $pass = cleanInput($_POST["password"]);
        if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d).{8,}$/", $pass)) {
            $passErr = "Atleast 8 characters containing letter, numbers allowed";
        }
    }

    $website = cleanInput($_POST["website"] ?? "");
    if (!empty($website) && !filter_var($website, FILTER_VALIDATE_URL)) {
        $websiteErr = "Invalid URL";
    }
}
//assesment e joma deya lagbe
