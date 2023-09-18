<!-- adoption_process.php : 
What it does:
    - Once the user chooses a dog, this page will display its details
    - Form to be completed and submitted to Request Adoption -->


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

<!-- 
            <li><a href="nutrition.php" id="nutrition">Nutrition</a></li>
            <li><a href="wellness.php" id="wellness">Wellness</a></li>
            <li><a href="calendar.php" id="calendar">Calendar</a></li>
            <li><a href="training.php" id="training">Training</a></li>
            <li><a href="health.php" id="health">Health</a></li> -->
            <li><a href="up_for_adoption.php" id="adoption">Adopt</a></li>
            <li><a href="adoption_process.php">Continue with Adoption</a></li>
            <!-- Login/Logout Button if user is loggedin or not -->
            <?php
            if (isset($_SESSION['userLoggedIn'])) : ?>
                <li>
                    <form method="POST" action="/growapup/login.php">
                        <input type="submit" name="logout-submit" value="logout">
                    </form>
                </li>
            <?php else : ?>
                <li><a href="/growapup/login.php">Login</a></li>
            <?php endif; ?>


        </ul>
    </nav>


    <?php
    include_once 'dbconnection.php';
    session_start();

    // Add the product to the cart
    //check if form was submitted with method post and the name is add-product-cart
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['choose-this-dog'])) {
        //get the id from the product added
        $dogId = $_POST['dog_id'];
        //check if cart session exists and if the 
        //element with $productId key doesnt exist in cart
        if (!isset($_SESSION['adoption'][$dogId])) {

            $_SESSION['adoption'][$dogId] = 1;
        } else {
            array_push($_SESSION['adoption'], $dogId);
        }
    }
    // Remove the product from the cart
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_dog_id'])) {
        $dogId = $_POST['dog_id'];
        if (isset($_SESSION['adoption'][$dogId])) {
            unset($_SESSION['adoption'][$dogId]);
        }
    }



    ?>

    <!-- Display cart contents -->
    <h1>This is what you chose!</h1>
    <table>

        <?php
        foreach ($_SESSION['adoption'] as $dogId => $quantity) {
            // Retrieve product details from the database using PDO
            $stmt = $conn->prepare("SELECT dog_image, dog_name, dog_description, dog_breed FROM dogs WHERE dog_id = :dogId");
            $stmt->bindParam(':dogId', $dogId);
            $stmt->execute();
            $dogData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($dogData) {
                foreach ($dogData as $row) {

                    //variables - are assigned the values from the current row in the result set

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
                            <input type="hidden" name="dog_id" value="<?php echo $dogId; ?>">

                            <input type="submit" value="Remove Dog" class="remove-dog" name="remove_dog_id">
                        </form>
                    </div>
        <?php
                }
            }
        }
        ?>
    </table>

    <div class="checkout-form">
        <form method="post" action="finalize_adoption.php"> <!-- for now -->
            <br>
            <label for="name">Name:</label><br>
            <input type="text" name="name" required><br>

            <label for="name">Email:</label><br>
            <input type="email" name="email" required><br>

            <label for="contact">Contact Details:</label><br>
            <input type="text" name="contact" required><br>

            <label for="comments">Comments:</label><br>
            <textarea name="comments" rows="5" required></textarea><br>
            <br>
            <input type="submit" name="request-adoption" value="Request Adoption">
        </form>
    </div>


</body>

</html>