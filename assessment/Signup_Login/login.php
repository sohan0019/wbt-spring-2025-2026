<?php require_once "login.process.php"; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/contactMeStyle.css">
  <title>Contact Me</title>
</head>

<body>
  <header>
    <ul>
      <li><a href="../index.html">Home</a></li>
      <li><a href="./project.html">Project</a></li>
      <li><a href="./education.html">Education</a></li>
      <li><a href="./experience.html">Experience</a></li>
    </ul>
  </header>

  <br><br>

  <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <fieldset>
      <table>
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

</body>

</html>