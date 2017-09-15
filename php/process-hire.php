<?php
require_once('./includes/config.php');
require_once('./includes/db.php');

$message = "Kindly fill the form appropriately and submit.";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gradeLevelCount = (int)$_POST['grade-level-count'];
    $gradeLevelForms = array();

    $costs = array(
        'intern' => array(
            'full' => 50000,
            'part' => 500
        ),
        'eng1' => array(
            'full' => 70000,
            'part' => 1000
        ),
        'eng2' => array(
            'full' => 100000,
            'part' => 1800
        ),
        'sd1' => array(
            'full' => 130000,
            'part' => 3000
        ),
        'sd2' => array(
            'full' => 150000,
            'part' => 5000
        ),
        'arch' => array(
            'full' => 190000,
            'part' => 7000
        ),
        'pe' => array(
            'full' => 220000,
            'part' => 14000
        ),
        'se' => array(
            'full' => 250000,
            'part' => 20000
        )
    );

    $totalCost = array(
        'full' => 0,
        'part' => 0
    );

    for ($i = 0; $i < $gradeLevelCount; $i++) {
        $modeOfWork = strtolower($_POST['mode-of-work-' . $i]);
        $gradeLevel = strtolower($_POST['grade-level-' . $i]);
        $skillLevel = $_POST['skill-level-' . $i];
        $numberOfTeam = (int)$_POST['number-of-team-' . $i];

        $cost = (double)$costs[$gradeLevel][$modeOfWork] * (double)$numberOfTeam;
        $totalCost[$modeOfWork] += (double)$cost;

        $gradeLevelForms[] = array(
            'modeOfWork' => $modeOfWork,
            'gradeLevel' => $gradeLevel,
            'skillLevel' => $skillLevel,
            'numberOfTeam' => $numberOfTeam,
            'cost' => (double)$cost
        );
    }

    $database = new Database();

    try {
        // Start database transaction
        $database->beginTransaction();

        // Insert into hires table
        $database->query('insert into hires (name, email, total_full_cost, total_part_cost) values (:name, :email, :total_full_cost, :total_part_cost)');
        $database->bind(':name', $name);
        $database->bind(':email', $email);
        $database->bind(':total_full_cost', $totalCost['full']);
        $database->bind(':total_part_cost', $totalCost['part']);

        // Execute the above query
        $database->execute();

        // Get the last insert id which is the hire_id
        $hireId = $database->lastInsertId();

        foreach ($gradeLevelForms as $key => $gradeLevelForm) {
            // Insert each grade level entries into the hire_grade_levels table
            $database->query('insert into hire_grade_levels (hire_id, mode_of_work, grade_level, skill_level, number_of_team, cost) values (:hire_id, :mode_of_work, :grade_level, :skill_level, :number_of_team, :cost)');
            $database->bind(':hire_id', $hireId);
            $database->bind(':mode_of_work', $gradeLevelForm['modeOfWork']);
            $database->bind(':grade_level', $gradeLevelForm['gradeLevel']);
            $database->bind(':skill_level', $gradeLevelForm['skillLevel']);
            $database->bind(':number_of_team', $gradeLevelForm['numberOfTeam']);
            $database->bind(':cost', $cost);

            // Excute the above query
            $database->execute();
        }

        // All successful  then end transaction
        $database->endTransaction();

        $message = 'Thank you, your request has been saved and will be processed shorly. We will get back to you soon.';
    }
    catch (Exception $e) {
        // If there's any error then cancel transaction so as to revert all above queries
        $database->cancelTransaction();
        $message = "Sorry, an error occured and we're unable to complete your request. Please go back to the form and try again.";
    }
}

die($message);
