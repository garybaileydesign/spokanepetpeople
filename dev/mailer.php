<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Get the form fields and remove whitespace.
        $service = trim($_POST["Service"]);
        $from = trim($_POST["From"]);
        $to = trim($_POST["To"]);
        $name = strip_tags(trim($_POST["Name"]));
		  $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["Email"]), FILTER_SANITIZE_EMAIL);
        $phone = trim($_POST["Phone-number"]);
        $type = trim($_POST["Type"]);
        $number = trim($_POST["Number-of-pets"]);
        $pname = trim($_POST["Pet-name"]);
        $breed = trim($_POST["Breed"]);

        // Check that data was sent to the mailer.
        if ( empty($service) OR empty($from) OR empty($to) OR empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($phone) OR empty($type) OR empty($number) OR empty($pname) OR empty($breed)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "*Please complete fields before submitting";
            exit;
        }

        // Set the recipient email address.
        $recipient = "Info@SpokanePetPeople.com";

        // Set the email subject.
        $subject = "You have a booking request from $name";

        // Build the email content.
        $email_content = "Service: $service\n\n";
        $email_content .= "From: $from\n";
        $email_content .= "To: $to\n\n";
        $email_content .= "Name: $name\n";
        $email_content .= "Email: $email\n";
        $email_content .= "Phone: $phone\n\n";
        $email_content .= "Pet type: $type\n";
        $email_content .= "Number of pets: $number\n";
        $email_content .= "Pet names: $pname\n";
        $email_content .= "Pet breeds: $breed\n";

        // Build the email headers.
        $email_headers = "From: $name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! We will confirm your appointment shortly.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>