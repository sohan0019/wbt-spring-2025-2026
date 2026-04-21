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
            <td>First Name <span class="required">*</span></td>
            <td>
              <input
                type="text"
                id="firstname"
                name="firstName"
                placeholder="Enter first name"
                value="<?= $firstName ?>"
              />
              <span class="error"><?= $firstNameErr ?></span>
            </td>
          </tr>

          <tr>
            <td>Last Name <span class="required">*</span></td>
            <td>
              <input
                type="text"
                id="lastname"
                name="lastNaame"
                placeholder="Enter last name"
                value="<?= $lastName ?>"
              />
              <span class="error"><?= $lastNameErr ?></span>
            </td>
          </tr>

          <tr>
            <td>Gender <span class="required">*</span></td>
            <td>
              <input type="radio" name="gender" value="male" <?= ($gender == "male") ? "checked" : "" ?>/> Male
              <input type="radio" name="gender" value="female" <?= ($gender == "female") ? "checked" : "" ?>/> Female
              <span class="error"><?= $genderErr ?></span>
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
                value="<?= $email ?>"
              >
              <span class="error"><?= $emailErr ?></span>
            </td>
          </tr>

          <tr>
            <td>Company</td>
            <td>
              <input
                type="text"
                name="company"
                id="company"
                placeholder="Enter company"
                value="<?= $company ?>"
              />
            </td>
          </tr>

          <tr>
            <td>Reason of Contact <span class="required">*</span></td>
            <td>
              <input type="radio" name="reason" value="project" <?= ($reason == "project") ? "checked" : "" ?> />Project 
              <input type="radio" name="reason" value="thesis" <?= ($reason == "thesis") ? "checked" : "" ?> /> Thesis
              <input type="radio" name="reason" value="job" <?= ($reason == "job") ? "checked" : "" ?> /> Job
              <span class="error"><?= $reasonErr ?></span>
            </td>
          </tr>
          <tr>
            <td>Topics <span class="required">*</span></td>
            <td>
              <input type="checkbox" name="chkbox[]" value="web" <?= ($chkbox == "web") ? "checked" : "" ?> /> Web Development
              <input type="checkbox" name="chkbox[]" value="mobile" <?= ($chkbox == "mobile") ? "checked" : "" ?> /> Mobile Development
              <input type="checkbox" name="chkbox[]" value="ai_ml" <?= ($chkbox == "ai_ml") ? "checked" : "" ?> /> AI/ML Development
              <span class="error"><?= $chkboxErr ?></span>
            </td>
          </tr>

          <tr>
            <td>Date <span class="required">*</span></td>
            <td>
              <input type="date" name="date" id="date" value="<?= $date ?>" />
              <span class="error"><?= $dateErr ?></span>
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

    <footer>
      <h3 class="title">Social Media Links</h3>
      <a href="https://github.com/sohan0019?tab=repositories" target="_blank">
        <img src="https://img.icons8.com/?size=100&id=12599&format=png&color=000000" alt="">
      </a>
      <a href="https://www.linkedin.com/in/mohammad-sohanur-rahman-871659319/" target="_blank">
        <img src="https://img.icons8.com/?size=100&id=13930&format=png&color=000000" alt="">
        </a
      >
    </footer>
  </body>
</html>
