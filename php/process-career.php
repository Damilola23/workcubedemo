<?php

require_once('./includes/config.php');
require_once('./includes/db.php');

$message = "Kindly fill the form appropriately and submit.";

if (isset($_POST['submit'])) {
    $fullName = $_POST['full-name'];
    $phoneNumber = $_POST['phone-number'];
    $email = $_POST['email'];
    $aboutYourself = $_POST['about-yourself'];
    $acquiredSkills = $_POST['acquired-skills'];
    $hobbies = $_POST['hobbies'];
    $reasonToJoin = $_POST['reason-to-join'];
    $nigeriaTechnology = $_POST['nigeria-technology'];

    $database = new Database();

    try {
        $database->beginTransaction();

        $database->query('insert into careers (full_name, phone_number, email, about_yourself, acquired_skills, hobbies, reason_to_join, nigeria_technology) values (:full_name, :phone_number, :email, :about_yourself, :acquired_skills, :hobbies, :reason_to_join, :nigeria_technology)');
        $database->bind(':full_name', $fullName);
        $database->bind(':phone_number', $phoneNumber);
        $database->bind(':email', $email);
        $database->bind(':about_yourself', $aboutYourself);
        $database->bind(':acquired_skills', $acquiredSkills);
        $database->bind(':hobbies', $hobbies);
        $database->bind(':reason_to_join', $reasonToJoin);
        $database->bind(':nigeria_technology', $nigeriaTechnology);

        $database->execute();
        $database->endTransaction();

        $message = 'Thank you, your request has been saved and will be processed shorly. We will get back to you soon.';
    }
    catch (Exception $e) {
        $database->cancelTransaction();
        $message = "Sorry, an error occured and we're unable to complete your request. Please go back to the form and try again.";
    }
}

?>
