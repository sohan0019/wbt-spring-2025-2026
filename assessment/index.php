<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Basics</title>
</head>
<body>
  <h1>PHP Task</h1>
  <?php
  echo '1.';
    $length = 10;
    $width = 5;

    $area = $length * $width;
    $perimeter = 2 * ($length + $width);

    echo '<p>The area of the rectangle is : ' .$area. '</p>';
    echo '<p>The perimeter of the rectangle is : ' .$perimeter. '</p>';

  echo '2.';
    $amount = 5000;
    $vat = $amount * (15/100);

    echo '<p>The VAT on the amount ' .$amount. ' is : ' .$vat. '</p>';

  echo '3.';
    $num = 27;

    if ($num % 2 == 0) {
      echo '<p>The number is even.</p>';
    } else {
      echo '<p>The number ' .$num. ' is odd.</p>';
    }

  echo '4.';
    $a = 46;
    $b = 64;
    $c = 19;

    if ($a > $b && $a > $c) {
      echo '<p>' .$a. ' is the largest.</p>';
    } else if ($b > $a && $b >$c) {
      echo '<p>' .$b. ' is the largest.</p>';
    } else {
      echo '<p>' .$c. ' is the largest.</p>';
    }

  echo '5. <br>';
    echo '<p>The odd numbers from 10 to 100 are :</p>';

    for ($i = 10; $i<=100; $i++) {
      if ($i % 2 != 0) {
        echo $i . ' ';
      }
    }

  echo '6.';
    $arr = [10, 2, 89, 14, 26, 55, 100, 98, 40, 53, 54, 81];
    $search = 98;
    $found = FALSE;

    for ($i = 0; $i < count($arr); $i++) {
      if ($arr[$i] == $search) {
        echo '<p>It is found at index : ' .$i. '</p>';
        $found = TRUE;
        break;
      }
    }

    if ($found == FALSE) {
      echo '<p>Not Found.</p>';
    }

  echo '7. <br>';
    for ($i = 1; $i <= 3; $i++) {
      for ($j = 1; $j <= $i; $j++) {
          echo '* ';
      }
      echo '<br>';
    }
    echo '<br>';

    for ($i = 3; $i >= 1; $i--) {
      for ($j = 1; $j <= $i; $j++) {
          echo $j . ' ';
      }
      echo '<br>';
    }
    echo '<br>';

    $char = 'A';
    for ($i = 1; $i <= 3; $i++) {
        for ($j = 1; $j <= $i; $j++) {
            echo $char . ' ';
            $char++;
        }
        echo '<br>';
    }


  ?>
</body>
</html>