<!-- Up_for_adoption_admin.php - 
What it does:
  - Admin page for:
  - Editing Dogs
  - Adding New Dogs
  - Deleting Dogs
    -Edit/Add lead to up_for_adoption_admin_edits -> where admin can make changes/add new dogs to db -->



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

    <?php if (isset($_SESSION['adminLoggedIn'])) : ?>
      <!-- Admin is logged in -->
      <li><a href="up_for_adoption_admin.php">Admin Edit Dogs</a></li>
      <li>
        <form method="POST" action="login.php">
          <input type="submit" name="logout-submit" value="Logout admin">
        </form>
      </li>
    <?php endif; ?>
  </ul>
</nav>



    </ul>
  </nav>
  <a class="adminedits adddog" href="up_for_adoption_admin_edit.php">Add New Dog</a>


  <?php
include_once 'dbconnection.php';
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete-dog'])) {
  $dogIdToDelete = $_PSOT['dog_id'];

  //delete dog from db
  $sqlDeleteDog = "DELETE FROM dogs WHERE dog_id = ?";
  $stmtDeleteDog = $conn->prepare($sqlDeleteDog);
  $stmtDeleteDog-> execute([$dogIdToDelete]);
  header("Location: up_for_adoption_admin.php");
  exit;
}
//fetch dogs from db
$sqlGetDogs = "SELECT * FROM dogs";
$stmtGetDogs = $conn->prepare($sqlGetDogs);
$stmtGetDogs->execute();
$dogs = $stmtGetDogs->fetchAll(PDO::FETCH_ASSOC);

if(!empty($dogs)) {

  foreach ($dogs as $row) {
    $dogId = $row['dog_id'];
    $dogName = $row['dog_name'];
    $dogDescription = $row['dog_description'];
    $dogBreed = $row['dog_breed'];
    $dogImage = $row['dog_image'];
    ?>
            <div class="dogs-container">
                <div class="dog-image">
                    <img class="dog-image" src="/growapup/images/dogs/<?php echo $dogImage; ?>" width="300px" height="300px">
                </div>
                <div class="dog-details">
                    <h3><?php echo $dogName; ?></h3>
                    <p><?php echo $dogDescription; ?></p>
                    <p><?php echo $dogBreed; ?></p>
                </div>
                <!--same as shop to display products - above-->


                <!-- Form for Editing my products -->
                <form method="get" action="up_for_adoption_admin_edit.php">

                    <input type="hidden" name="dog_id" value="<?php echo $row['dog_id']; ?>">
                    <input type="submit" name="edit-dog" value="Edit Dog" class="adminedits editproduct">
                </form>


                <!-- Form for Deleting my products -->
                <form method="post" action="up_for_adoption_admin_edit.php">
                    
                    <input type="hidden" name="dog_id" value="<?php echo $row['dog_id']; ?>">
                    <input type="submit" name="delete-dog" value="Delete Dog" class="adminedits deleteproduct">
                </form>
                

            </div>

            <?php
        }
    } else {
        echo "No dogs found.";
    }
  ?>



</body>

</html>
