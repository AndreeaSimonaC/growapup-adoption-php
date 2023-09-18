<!-- up_for_adoption.php : 
What it does:
  - Displays the dogs up for adoption from the db
  - Allows user to “Choose this dog” -> will add the dog and lead to adoption_process where user will be able to request the adoption -->


<?php
include_once 'dbconnection.php';
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['logout-submit'])) {
        session_destroy();
        var_dump($_SESSION);
    }
}

if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET['dog_id'])) {
        if(!isset($_SESSION['adoption'])) {
            $_SESSION['adoption'] = array();
        }
        $dogId = $_GET['dog_id'];
        $_SESSION['adoption'][] = $dogId;
        var_dump($_SESSION['adoption']);
    }
}

$sql = "SELECT * FROM dogs";
$stmt = $conn->prepare($sql);
$stmt->execute();
$dogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Grow A Pup</title>
  <link rel="icon" type="image/x-icon" href="/images/logo.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="/growapup/style.css" />
</head>
<header>
  <div class="logo"><a href="/growapup/index.php">
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
      <li><a href="adoption_process.php">Continue with Adoption</a></li>

      <li><a href="up_for_adoption.php" id="adoption">Adopt</a></li>
      <!-- Login/Logout Button if user is loggedin or not -->
      <?php
      if (isset($_SESSION['loggedIn'])) : ?>
        <li>
          <form method="POST" action="/growapup/login.php">
            <input type="submit" name="logout-submit" value="logout">
          </form>
        </li>
      <?php else : ?>
        <li><a href="/growapup/login.php">Login</a></li>
      <?php endif ; ?>


    </ul>
  </nav>
  <h1>Choose your furry friend!</h1>

  <?php
  //get the dogs

  if (!empty($dogs)) {
    foreach ($dogs as $row) {
      $dogId = $row['dog_id'];
      $dogImage = $row['dog_image'];
      $dogName = $row['dog_name'];
      $dogDescription = $row['dog_description'];
      $dogBreed = $row['dog_breed'];

  ?>
<div class="dogs-container">
  <div class="dog-wrapper">
    <div class="dog-image">
      <img class="dog-image" src="/growapup/images/dogs/<?php echo $dogImage; ?>" width="300px" height="300px" alt="dog">
    </div>
    <div class="dog-details">
      <!-- display the values in the variables -->
      <h3><?php echo $dogName; ?></h3>
      <p><?php echo $dogDescription; ?></p>
      <p><?php echo $dogBreed; ?></p>
    </div>
  </div>
  <form method="post" action="adoption_process.php">
    <input type="hidden" name="dog_id" value="<?php echo $row['dog_id']; ?>">
    <input type="submit" name="choose-this-dog" value="Choose this dog" class="adminedits editdog">
  </form>
</div>

  <?php
    }
  } else {
    echo "No dogs found.";
  }
  ?>
</body>
<!-- <footer>
  <div class="contact-information">
    <address>
      Branded by: *me*<br />
      Visit us at:<br />
      www.growapup.com<br />
      Launching Soon<br />
    </address>
  </div>
</footer> -->

</html>