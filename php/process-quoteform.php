<?php

require_once('./includes/config.php');
require_once('./includes/db.php');

$message = "Kindly fill the form appropriately and submit.";

if (isset($_POST['submit'])) {
    $fullName = $_POST['full-name'];
    $phoneNumber = $_POST['phone-number'];
    $email = $_POST['email'];
    $briefDetails = $_POST['brief-details'];
    $skillset = $_POST['skillset'];
    $talent = $_POST['talent'];
    $modeOfWork = $_POST['mode-of-work'];

    $database = new Database();

    try {
        $database->beginTransaction();

        $database->query('insert into quote_forms (full_name, phone_number, email, brief_details, skillset, talent, mode_of_work) values (:full_name, :phone_number, :email, :brief_details, :skillset, :talent, :mode_of_work)');
        $database->bind(':full_name', $fullName);
        $database->bind(':phone_number', $phoneNumber);
        $database->bind(':email', $email);
        $database->bind(':brief_details', $briefDetails);
        $database->bind(':skillset', $skillset);
        $database->bind(':talent', $talent);
        $database->bind(':mode_of_work', $modeOfWork);

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
