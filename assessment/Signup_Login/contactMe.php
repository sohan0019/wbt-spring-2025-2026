<?php require_once "contact_process.php"; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/contactMeStyle.css">
  <title>Contact Me</title>
</head>

<body>

  <br><br>

  <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <fieldset>
      <table>
        <tr>
          <td>First Name <span class="required">*</span></td>
          <td>
            <input
              type="text"
              id="firstname"
              name="firstName"
              placeholder="Enter first name"
              value="<?= $firstName ?>" />
            <span class="error"><?= $firstNameErr ?></span>
          </td>
        </tr>

        <tr>
          <td>Last Name <span class="required">*</span></td>
          <td>
            <input
              type="text"
              id="lastname"
              name="lastName"
              placeholder="Enter last name"
              value="<?= $lastName ?>" />
            <span class="error"><?= $lastNameErr ?></span>
          </td>
        </tr>

        <tr>
          <td>Contact Number</td>
          <td>
            <input type="text" type="number" name="contact" placeholder="Enter Contact Number" value="<?= $contact ?>">
            <span class="error"><?= $contactErr ?></span>
          </td>
        </tr>

        <tr>
          <td>Email <span class="required">*</span></td>
          <td>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="Enter email"
              value="<?= $email ?>">
            <span class="error"><?= $emailErr ?></span>
          </td>
        </tr>

        <tr>
          <td>Password <span class="required">*</span></td>
          <td>
            <input type="password" name="password" id="password" placeholder="Enter Password" value="<?= $pass ?>">
            <span class="error"><?= $passErr ?></span>
          </td>
        </tr>

        <tr>
          <td></td>
          <td>
            <input type="submit" value="Submit" />
            <input type="reset" />
          </td>
        </tr>
      </table>
    </fieldset>
  </form>

  <br><br>
</body>

</html>