<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="​Radiation effects testing​, ​How​ testing is performed, ​Participating facilities">
    <meta name="description" content="">
    <meta name="page_type" content="np-template-header-footer-from-plugin">
    <title>SignUp</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
<link rel="stylesheet" href="SignUp.css" media="screen">
    <script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 4.3.3, nicepage.com">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
    
    
    
    
    
    
    
    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": ""
}</script>
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="SignUp">
    <meta property="og:type" content="website">
  </head>
  <body class="u-body">
    <?php
        include_once 'header.php';
    ?>
    <section class="u-align-center u-clearfix u-image u-shading u-section-1" src="" data-image-width="474" data-image-height="316" id="sec-89ea">
      <?php
          if(isset($_GET["error"])) {
            if($_GET["error"] == "passwordmatch") {
              echo "<p>Passwords dont match!</P>";
            } else if($_GET["error"] == "passwordrequirement") {
              echo "<p>Password doesnt meet requirements!</P>";
            } else if($_GET["error"] == "missinginfo") {
              echo "<p>Please fill out all of the fields!</P>";
            } else if($_GET["error"] == "emailtaken") {
              echo "<p>Email already taken!</P>";
            } else if($_GET["error"] == "prepare") {
              echo "<p>Something went wrong! Try again!</P>";
            } else if($_GET["error"] == "none") {
              echo "<p>Sign up successful!</P>";
            }
          }
      ?>
      <div class="u-align-left u-clearfix u-sheet u-sheet-1">
        <div class="u-form u-form-1">
          <form action="include/SignUp.inc.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="form" style="padding: 10px;" redirect="true">
            <div class="u-form-group u-form-name u-form-partition-factor-2">
              <label for="name-850d" class="u-label">First Name</label>
              <input type="text" placeholder="Enter your First Name" id="name-850d" name="firstName" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="">
            </div>
            <div class="u-form-group u-form-name u-form-partition-factor-2 u-form-group-2">
              <label for="name-f4c1" class="u-label">Last Name</label>
              <input type="text" placeholder="Enter your Last Name" id="name-f4c1" name="lastName" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="">
            </div>
            <div class="u-form-email u-form-group u-form-partition-factor-2">
              <label for="email-850d" class="u-label">Email</label>
              <input type="email" placeholder="Enter a valid email address" id="email-850d" name="email" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
            </div>
            <div class="u-form-group u-form-partition-factor-2 u-form-group-4">
              <label for="text-43fb" class="u-label">Phone Number</label>
              <input type="text" placeholder="Enter your Phone Number" id="text-43fb" name="phoneNumber" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
            </div>
            <div class="u-form-group u-form-group-6">
              <label for="text-53b6" class="u-label">Password</label>
              <input type="password" placeholder="Enter your Password(Required: One Upper, Lower, Digit, and Special Character)" id="text-53b6" name="password" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
            </div>
            <div class="u-form-group u-form-group-7">
              <label for="text-53b6" class="u-label">Repeat Password</label>
              <input type="password" placeholder="Repeat your Password" id="text-53b6" name="passwordRepeat" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
            </div>
            <div class="u-align-left u-form-group u-form-submit">
              <a href="#" class="u-btn u-btn-submit u-button-style">Submit</a>
              <input type="submit" name="submit" value="submit" class="u-form-control-hidden">
            </div>
            <input type="hidden" value="" name="recaptchaResponse">
          </form>
        </div>
      </div>
    </section>
    
    
    
    
    
    
    
    <?php
        include_once 'footer.php';
    ?>

  </body>
</html>