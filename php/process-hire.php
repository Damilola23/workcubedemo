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

        $message = 'Thank you, your request has been saved and will be processed shortly. We will get back to you soon.';
    }
    catch (Exception $e) {
        // If there's any error then cancel transaction so as to revert all above queries
        $database->cancelTransaction();
        $message = "Sorry, an error occured and we're unable to complete your request. Please go back to the form and try again.";
    }
}

?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="description" content="Responsive Bootstrap Landing Page Template">
  <meta name="keywords" content="Bootstrap, Landing page, Template, Registration, Landing">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="author" content="Grayrids">

  <title>WorkCube</title>

  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="fonts/font-awesome.min.css" type="text/css" media="screen">
  <!-- Include roboto.css to use the Roboto web font, material.css to include the theme and ripples.css to style the ripple effect -->
  <link href="../css/material.min.css" rel="stylesheet">
  <link href="../css/ripples.min.css" rel="stylesheet">
  <link href="../css/main.css" rel="stylesheet">
  <link href="../css/responsive.css" rel="stylesheet">
  <link href="../css/animate.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="../img/WorkCube-Logo.png" type="image/x-icon">
  <link rel="stylesheet" href="../css/style.css">
  <!-- <link rel="stylesheet" href="css/mdb.min.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

  <div class="navbar navbar-invers menu-wrap">
    <div class="navbar-header text-center">
      <a class="navbar-brand logo-right" href="javascript:void(0)"><img src="../img/WorkCube-Logo.png" width="30" height="30" style="margin-right:5px;">Workcube</a>
    </div>
    <ul class="nav navbar-nav main-navigation">
      <li><a href="../index.html">Home</a></li>
      <li><a href="../developer.html">Featured Devs</a></li>
      <li><a href="../career.html">Careers</a></li>
    </ul>
    <button class="close-button" id="close-button">Close Menu</button>
  </div>
  <div class="content-wrap about">

    <header class="about-area" id="about">
      <div class="container">
        <div class="col-md-12">

          <div class="navbar navbar-inverse sticky-navigation navbar-fixed-top about" role="navigation" data-spy="affix" data-offset-top="200">
            <div class="container">
              <div class="navbar-header">
                <a class="logo-left " href="../index.html"><img src="../img/WorkCube-Logo.png" width="30" height="30" style="margin-right:5px;padding-bottom: 3px;">WorkCube</a>
              </div>
              <div class="navbar-right">
                <button class="menu-icon" id="open-button">
                    <i class="mdi-navigation-menu"></i>
                  </button>
                </div>
            </div>
          </div>

          <div class="row contents text-right" id="about-title">
            <h1 class="wow fadeInRight" data-wow-duration="1000ms" data-wow-delay="300ms">Thank You
            </h1>
          </div>

        </div>
      </div>
    </header>


    <section id="thanks">
      <div class="container">
        <div class="row">
          <div class="well">
            <h2 class="text-center">
             <?php echo $message; ?>
            </h2>
          </div>
        </div>
      </div>
    </section>









    
    <section id="footer">
      <div class="container">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <h3>Hire WorkCube</h3>
              <ul>
                <li><a href="../skills.html">Skills</a>
                </li>
                <li><a href="../fees.html">Fees</a>
                </li>
              </ul>
            </div>
            <!-- <div class="col-md-4 col-sm-6 col-xs-6">
              <h3>FAQs</h3>
              <ul>
                <li><a href="#">Why choose us?</a>
                </li>
                <li><a href="#">Where we are?</a>
                </li>
                <li><a href="#">Fees</a>
                </li>
                <li><a href="#">Guarantee</a>
                </li>
                <li><a href="#">Discount</a>
                </li>
              </ul>
            </div> -->

            <div class="col-md-6 col-sm-6 col-xs-12">
              <h3>Company</h3>
              <ul>
                <li><a href="../about.html">About Us</a>
                </li>
                <li><a href="../developer.html">Featured developers</a>
                </li>
                <li><a href="#contact">Contact</a>
                </li>
                <li><a href="../career.html">Careers</a>
                </li>
              </ul>
            </div>
            <!-- <div class="col-md-4 col-sm-6 col-xs-12">
              <h3>Find us on</h3>
              <a class="social" href="#" target="_blank"><i class="fa fa-facebook"></i></a>
              <a class="social" href="#" target="_blank"><i class="fa fa-twitter"></i></a>
              <a class="social" href="#" target="_blank"><i class="fa fa-google-plus"></i></a>
            </div> -->
          </div>
        </div>
      </div>
      <!-- Go to Top Link -->
      
    </section>

    <section id="copyright">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <p class="copyright-text">
                © WorkCube 2017 All right reserved.
                <!-- Designed and Developed by
                <a rel="nofollow" href="http://graygrids.com/">
                  GrayGrids
                </a> -->
              </p>
            </div>
          </div>
        </div>
      </section>

  <!-- script Tags -->

    <!-- <script src="js/jquery-2.1.4.min.js"></script> -->
    <script src="../js/ripples.min.js"></script>
    <script src="../js/material.min.js"></script>
    <script src="../js/wow.js"></script>
    <script src="../js/jquery.mmenu.min.all.js"></script>
    <script src="../js/count-to.js"></script>
    <script src="../js/jquery.inview.min.js"></script>
    <script src="../js/classie.js"></script>
    <script src="../js/jquery.nav.js"></script>
    <script src="../js/jquery.nav.js"></script>
    <!-- <script src="js/smooth-on-scroll.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scroll/12.1.4/js/smooth-scroll.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/mdb.min.js"></script>



    <script>
      $(document).ready(function () {
        // This command is used to initialize some elements and make them work properly
        $.material.init();
      });
    </script>
</body>

</html>