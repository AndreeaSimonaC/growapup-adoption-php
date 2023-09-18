<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request-adoption'])) {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $contact = $_POST["contact"];
    $comments = $_POST["comments"];

    // Email subject
    $subject = "Adoption Request from $name";

    // Email message
    $message = "Name: $name\n";
    $message .= "Email: $email\n";
    $message .= "Contact Details: $contact\n";
    $message .= "Comments:\n$comments";

    // Recipient email address
    $to = "andreeasimciobanu1@gmail.com"; // Replace with the actual recipient's email address

    // Additional headers
    $headers = "From: $email" . "\r\n" .
               "Reply-To: $email" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        // Email sent successfully
        echo "Adoption request sent successfully. We will contact you soon.";
    } else {
        // Email sending failed
        echo "Failed to send adoption request. Please try again later.";
    }
    // Send a confirmation email to the user
$userSubject = "Adoption Request Confirmation";
$userMessage = "Thank you for submitting your adoption request, $name.\n\n";
$userMessage .= "We have received your request and will contact you soon.\n";
$userHeaders = "From: andreeasimciobanu1@gmail.com"; // Replace with your organization's email address

if (mail($email, $userSubject, $userMessage, $userHeaders)) {
    // Confirmation email sent successfully to the user
    echo "Adoption request sent successfully. We will contact you soon.";
} else {
    // Confirmation email sending failed
    echo "Failed to send adoption request. Please try again later.";
}

}
?>
