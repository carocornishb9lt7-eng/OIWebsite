<?php
if (isset($_POST['Email'])) {

    $email_to = "odysseysrp@gmail.com";
    $email_subject = "New form submissions";

    function problem($error)
    {
        echo "We're sorry, but there was a problem with your submission. Please try again later.";
        die();
    }

    // validation expected data exists
    if (
        !isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['qc'])
    ) {
        problem('We're sorry, but there was a problem with your submission. Please try again later.');
    }

    $name = $_POST['name']; // required
    $email = $_POST['email']; // required
    $message = $_POST['qc']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email)) {
        $error_message .= 'The Email you have entered does not appear to be in the correct format.<br>';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $name)) {
        $error_message .= 'The name you have entered does not appear to be in the correct format.<br>';
    }

    if (strlen($message) < 2) {
        $error_message .= 'The question or comment you have entered does not appear to be in the correct format.<br>';
    }

    if (strlen($error_message) > 0) {
        problem($error_message);
    }

    $email_message = "Form details below.\n\n";

    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $email_message .= "Name: " . clean_string($name) . "\n";
    $email_message .= "Email: " . clean_string($email) . "\n";
    $email_message .= "Message: " . clean_string($message) . "\n";

    // create email headers
    $headers = 'From: ' . $email . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);
?>

Thanks for you interest in Odysseys Interactive. We'll get back to you as soon as possible.

<?php
}
?>