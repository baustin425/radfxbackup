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
            if($_GET["error"] == "infoincorrect") {
              echo "<p>Incorrect username or password!</P>";
            } else if($_GET["error"] == "prepare") {
              echo "<p>Something went wrong! Try again!</P>";
            }
          }
      ?>
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-clearfix u-custom-html u-expanded-width u-custom-html-1">
          <meta charset="utf-8">
          <title></title>
          <link href="login.css" rel="stylesheet" type="text/css">
          <div class="login">
            <h1>RadFX Login</h1>
            <form action="include/login.inc.php" method="post">
              <label for="username"><i class="fa-user fas"></i>
              </label>			  
              <input type="text" name="username" placeholder="Email" id="username" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="">
              <label for="password"><i class="fa-lock fas"></i>
              </label>
              <input type="password" name="password" placeholder="Password" id="password" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="">
              <input type="submit" name="submit" value="Login">
            </form>
          </div>
        </div>
      </div>
    </section>
    
    <?php
        include_once 'footer.php';
    ?>

  </body>
</html>