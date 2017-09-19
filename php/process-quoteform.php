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

        $message = 'Thank you, your request has been saved and will be processed shortly. We will get back to you soon.';
    }
    catch (Exception $e) {
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
      <li><a href="../skills.html">Skills</a></li>
      <li><a href="../fees.html">Fees</a></li>      
      <li><a href="../developer.html">Featured Developers</a></li>
      <li><a href="../career.html">Career</a></li>
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