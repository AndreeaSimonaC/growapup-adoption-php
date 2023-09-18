<!-- Up_for_adoption_admin_edits.php 
What it does:
  - Update dogs -->


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
  <div class="logo"><a href="/growapup/index.php">
    <img src="/growapup/images/logo.png" alt="logo" /></a>
  </div>
  <div class="header-content">
    <h1> Welcome to Grow A Pup</h1>
      <h3> Adoption Edition </h3>
  </div>
</header>

<body>
  <nav>
    <ul class="menu">
      <!-- <li><a href="nutrition.php" id="nutrition">Nutrition</a></li>
      <li><a href="wellness.php" id="wellness">Wellness</a></li>
      <li><a href="calendar.php" id="calendar">Calendar</a></li>
      <li><a href="training.php" id="training">Training</a></li>
      <li><a href="health.php" id="health">Health</a></li> -->

      <!-- Login/Logout Button if user is loggedin or not -->
      <?php
      if (isset($_SESSION['adminLoggedIn'])) : ?>
          <li><a href="up_for_adoption_admin.php">Admin Edit Dogs</a></li>

        <li>

          <form method="POST" action="login.php">
            <input type="submit" name="logout-submit" value="logout admin">
          </form>
        </li>
      <?php else : ?>
        <li><a href="up_for_adoption.php" id="adoption">Adopt</a></li>
        <li><a href="login.php">Login</a></li>
      <?php endif; ?>


    </ul>
  </nav>


  <?php
include_once 'dbconnection.php';
session_start();


$dogName = $dogDescription = $dogBreed = $dogImage = '';
  $dogId = null;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET['dog_id'])) {
      // Edit existing dog
      $dogId = $_GET['dog_id'];
      $dogName = isset($_POST['dog_name']) ? $_POST['dog_name'] : '';
      $dogDescription = isset($_POST['dog_description']) ? $_POST['dog_description'] : '';
      $dogBreed = isset($_POST['dog_breed']) ? $_POST['dog_breed'] : '';
      $dogImage = isset($_POST['dog_image']) ? $_POST['dog_image'] : '';

      // Update dog in database
      $sql = "UPDATE dogs SET dog_name=?, dog_description=?, dog_breed=?, dog_image=? WHERE dog_id=?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$dogName, $dogDescription, $dogBreed, $dogImage, $dogId]);

      echo "Dog updated";
    } else {
      //add new dog
    //   $dogId = $_GET['dog_id'];
      $dogName = isset($_POST['dog_name']) ? $_POST['dog_name'] : '';
      $dogDescription = isset($_POST['dog_description']) ? $_POST['dog_description'] : '';
      $dogBreed = isset($_POST['dog_breed']) ? $_POST['dog_breed'] : '';
      $dogImage = isset($_POST['dog_image']) ? $_POST['dog_image'] : '';

      // Insert new product into database
      $sql = "INSERT INTO dogs (dog_name, dog_description, dog_breed, dog_image) 
            VALUES (?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$dogName, $dogDescription, $dogBreed, $dogImage, $dogId]);

      echo "Dog added";
    }
  } elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['dog_id'])) {
      // Fetch product data for editing
      $dogId = $_GET['dog_id'];
      $sql = "SELECT * FROM dogs WHERE dog_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->execute([$dogId]);
      $dogData = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($dogData) {
        $dogName = $dogData['dog_name'];
        $dogDescription = $dogData['dog_description'];
        $dogBreed = $dogData['dog_breed'];
        $dogImage = $dogData['dog_image'];
      }
    }
  } 

?>
  <form action="up_for_adoption_admin_edit.php<?php if (isset($dogId)) echo '?dog_id=' . $dogId; ?>" method="POST" enctype="multipart/form-data">
    <div class="add-products-container">
      <div class="add-product-details">
        <label for="dog_name">Name:</label><br>
        <input type="text" name="dog_name" value="<?php echo $dogName ?? ''; ?>" required><br>

        <label for="dog_description">Description:</label><br>
        <textarea name="dog_description" required><?php echo $dogDescription ?? ''; ?></textarea><br>

        <label for="dog_breed">Breed:</label><br>
        <input type="text" name="dog_breed"  value="<?php echo $dogBreed ?? ''; ?>" required><br>

        <label for="dog_image">Image:</label><br>
        <input type="file" name="dog_image" accept="image/*" value="<?php echo $dogImage ?? ''; ?>" required><br>
      </div>
    </div>
    <input type="submit" value="<?php echo isset($dogId) ? 'Update Dog' : 'Add New Dog'; ?>" class="save-product" name="submit-edit-add-product">
  </form>

</body>

</html>
