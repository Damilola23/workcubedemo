<?php

require_once('./includes/config.php');
require_once('./includes/db.php');

$message = "Kindly fill the form appropriately and submit.";

if (isset($_POST['submit'])) {
    $companyName = $_POST['company-name'];
    $contactName = $_POST['contact-name'];
    $phoneNumber = $_POST['phone-number'];
    $companyEmail = $_POST['company-email'];
    $describeYourself = $_POST['describe-yourself'];
    $country = $_POST['country'];
    $trainingNeeds = $_POST['training-needs'];
    $priority = $_POST['priority'];

    $database = new Database();

    try {
        $database->beginTransaction();

        $database->query('insert into trainings (company_name, contact_name, phone_number, company_email, describe_yourself, country, training_needs, priority) values (:company_name, :contact_name, :phone_number, :company_email, :describe_yourself, :country, :training_needs, :priority)');
        $database->bind(':company_name', $contactName);
        $database->bind(':contact_name', $contactName);
        $database->bind(':phone_number', $phoneNumber);
        $database->bind(':company_email', $companyEmail);
        $database->bind(':describe_yourself', $describeYourself);
        $database->bind(':country', $country);
        $database->bind(':training_needs', $trainingNeeds);
        $database->bind(':priority', $priority);

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
