<!-- index.php : 
What it does:
 - Landing page: no menu, only a login button
 - If user already loggedIn:
   - Logout Button
   - Menu with: Adopt, Continue with Adoption
   - Button with Find Your Best Friend -> leads to up_for_adoption page -> shows all the dogs
 - If admin already loggedIn:
   - Logout Button
   - Menu with Admin Dog Edit -->


<?php
session_start();
var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="EN">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Grow A Pup</title>
  <link rel="icon" type="image/x-icon" href="/images/logo.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<header>
  <div class="logo"><a href="index.php">
      <img src="/growapup/images/logo.png" alt="logo" /></a>
  </div>
  <div class="header-content">
    <h1> Welcome to Grow A Pup</h5>
      <h3> Adoption Edition </h3>
  </div>
</header>

<body>
  <nav>
    <ul class="menu">
      <!-- <li><a href="up_for_adoption_admin.php">Admin Edit Dogs</a></li> -->

      <!-- 
      <li><a href="nutrition.php" id="nutrition">Nutrition</a></li>
      <li><a href="wellness.php" id="wellness">Wellness</a></li>
      <li><a href="calendar.php" id="calendar">Calendar</a></li>
      <li><a href="training.php" id="training">Training</a></li>
      <li><a href="health.php" id="health">Health</a></li> -->

      <!-- <li><a href="up_for_adoption.php" id="adoption">Adopt</a></li>
      <li><a href="adoption_process.php">Continue with Adoption</a></li> -->
      <!-- Login/Logout Button if user is loggedin or not -->

        <?php if (isset($_SESSION['adminLoggedIn'])) : ?>
            <!-- Admin is logged in -->
            <li><a href="up_for_adoption_admin.php">Admin Edit Dogs</a></li>
            <li>
                <form method="POST" action="login.php">
                    <input type="submit" name="logout-submit" value="Logout">
                </form>
            </li>
        <?php elseif (isset($_SESSION['loggedIn'])) : ?>
            <!-- Regular user is logged in -->
            <li><a href="up_for_adoption.php" id="adoption">Adopt</a></li>
            <li><a href="adoption_process.php">Continue with Adoption</a></li>
            <li>
                <form method="POST" action="login.php">
                    <input type="submit" name="logout-submit" value="Logout">
                </form>
            </li>
        <?php else : ?>
            <!-- Neither user nor admin is logged in -->
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>


  <div class="about-us index-content">
    <h1>About Us</h1><br>
    <p>You will learn about dog nutrition, training, health and wellness,
      and track your furry friend's progress as they grow and develop.</p><br>
    <p>You don't have a dog? See our dogs up for adoption!</p>

    <?php
      if (isset($_SESSION['loggedIn'])) : ?>
<a href="up_for_adoption.php" class="indexbutton">Find Your Best Friend</a>
      <?php else : ?>
        <li><a href="login.php">Find Your Best Friend - Login</a></li>
      <?php endif; ?>

    <!-- <a href="up_for_adoption.php" class="indexbutton">Find Your Best Friend</a> -->

  </div>
</body>

<footer>
  <div class="contact-information">
    <address>
      Branded by: *me*<br />
      Visit us at:<br />
      www.growapup.com<br />
      Launching Soon<br />
    </address>
  </div>
</footer>
</html>