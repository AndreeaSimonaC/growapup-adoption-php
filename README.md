# growapup-adoption-php
Adoption System in PHP

FILES:

dbconnection.php:
What it does:
Establish database connection using PDO

index.php : 
What it does:
Landing page: no menu, only a login button
If user already loggedIn:
Logout Button
Menu with: Adopt, Continue with Adoption
Button with Find Your Best Friend -> leads to up_for_adoption page -> shows all the dogs
If admin already loggedIn:
Logout Button
Menu with Admin Dog Edit

login.php : 
What it does:
Logs in users -> allowed to access up_for_adoption and adoption_process
Logs in admin -> allowed to go to Up_for_adoption_admin and up_for_adoption_admin_edit

up_for_adoption.php : 
What it does:
Displays the dogs up for adoption from the db
Allows user to “Choose this dog” -> will add the dog and lead to adoption_process where user will be able to request the adoption

adoption_process.php : 
What it does:
Once the user chooses a dog, this page will display its details
Form to be completed and submitted to Request Adoption

finalize_adoption.php: 
TD:
Add functionality to Request Adoption -> send confirmation email to user

Up_for_adoption_admin.php - 
What it does:
Admin page for:
Editing Dogs
Adding New Dogs
Deleting Dogs
Edit/Add lead to up_for_adoption_admin_edits -> where admin can make changes/add new dogs to db


Up_for_adoption_admin_edits.php 
What it does:
Update dogs
