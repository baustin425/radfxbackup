<?php
  session_start();
    if(!isset($_SESSION["role"]) || $_SESSION["role"] <= 2) {
      header("location: index.php");
    }
    session_abort();
?>

<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="​Radiation effects testing​, ​How​ testing is performed, ​Participating facilities">
    <meta name="description" content="">
    <meta name="page_type" content="np-template-header-footer-from-plugin">
    <title>Admin</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
<link rel="stylesheet" href="Admin.css" media="screen">
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
    <meta property="og:title" content="Admin">
    <meta property="og:type" content="website">
  </head>
  <body class="u-body">
    <?php
        include_once 'header.php';
    ?>
    <section class="u-align-center u-clearfix u-image u-shading u-section-1" src="" data-image-width="474" data-image-height="316" id="sec-89ea">
      <?php
          if(isset($_GET["error"])) {
            if($_GET["error"] == "requestnamecheck") {
              echo "<p>Name must be filled out, contain at least one letter, and not include special characters!</P>";
            } else if($_GET["error"] == "requestdescrptioncheck") {
              echo "<p>Description field must be filled out!</P>";
            } else if($_GET["error"] == "requesttypecheck") {
              echo "<p>Type field must contain int, var, or date!</P>";
            } else if($_GET["error"] == "requestnone") {
              echo "<p>Request form updated!</P>";
            } else if($_GET["error"] == "usernone") {
              echo "<p>User roles updated!</P>";
            } else if($_GET["error"] == "userprepare") {
              echo "<p>Something went wrong, try again!</P>";
            }
          }
      ?>
      <div class="u-clearfix u-sheet u-sheet-1">

        <div class="u-expanded-width u-tab-links-align-left u-tabs u-tabs-1">
          <ul class="u-border-2 u-border-palette-1-base u-spacing-10 u-tab-list u-unstyled" role="tablist">
            <li class="u-tab-item" role="presentation">
              <a class="active u-active-palette-1-base u-button-style u-grey-10 u-tab-link u-text-active-white u-text-black u-tab-link-1" id="link-tab-0da5" href="#tab-0da5" role="tab" aria-controls="tab-0da5" aria-selected="true">Request Form</a>
            </li>
            <li class="u-tab-item" role="presentation">
              <a class="u-active-palette-1-base u-button-style u-grey-10 u-tab-link u-text-active-white u-text-black u-tab-link-2" id="link-tab-14b7" href="#tab-14b7" role="tab" aria-controls="tab-14b7" aria-selected="false">User Approval</a>
            </li>
          </ul>
          <div class="u-tab-content">
          <div class="u-container-style u-tab-active u-tab-pane u-white u-tab-pane-1" id="tab-0da5" role="tabpanel" aria-labelledby="link-tab-0da5">
              <div class="u-container-layout u-valign-top u-container-layout-1">

                <div class="u-form u-form-1">
                  <div>
                    <label for="date-0803" class="u-label">Original Fields</label>
                  </div>
                  <label for="text-53b6" class="u-label">Total Hours</label>
                  <input type="text" placeholder="Total Requested Hours" id="text-53b6" name="hours" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
            <div class="u-form-group u-form-group-7">
              <label for="text-53b6" class="u-label">Test Purpose</label>
              <input type="text" placeholder="Description of the requested test" id="text-53b6" name="purpose" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
            </div>
            <div class="u-form-group u-form-group-7">
              <label for="text-53b6" class="u-label">Additional Information</label>
              <input type="text" placeholder="Any additional important information regarding your test" id="text-53b6" name="info" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
            </div>
            <div class="u-form-group u-form-group-7">
              <label for="text-53b6" class="u-label">Energy Level</label>
              <input type="text" placeholder="Energy level of requested test" id="text-53b6" name="energy" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
            </div>
            <div class="u-form-group u-form-group-7">
              <label for="text-53b6" class="u-label">Ions</label>
              <input type="text" placeholder="Requested Ions" id="text-53b6" name="ions" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
            </div>
            <div class="u-form-group u-form-select u-form-group-1">
              <label for="select-81a6" class="u-label">Facility</label>
              <div class="u-form-select-wrapper">
                <select id="select-81a6" name="facility" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white">
                  <option value="Berkeley">Lawrence Berkeley National Laboratory</option>
                  <option value="A&M">Texas A&M University</option>
                  <option value="NASA">NASA Space Radiation Laboratory</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" version="1" class="u-caret"><path fill="currentColor" d="M4 8L0 4h8z"></path></svg>
              </div>
            </div>
            <div class="u-form-group u-form-select u-form-group-2">
              <label for="select-df75" class="u-label">Vacuum</label>
              <div class="u-form-select-wrapper">
                <select id="select-df75" name="vacuum" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white">
                  <option value="1">Yes</option>
                  <option value="0">No</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" version="1" class="u-caret"><path fill="currentColor" d="M4 8L0 4h8z"></path></svg>
              </div>
            </div>
            <div class="u-form-date u-form-group u-form-group-3">
              <label for="date-0803" class="u-label">Date Requested</label>
              <input type="date" placeholder="MM/DD/YYYY" id="date-0803" name="date" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="">
            </div>
                    <div class="u-form-date u-form-group u-form-group-3">
                      <label for="date-0803" class="u-label">Date Requested</label>
                      <input type="date" placeholder="MM/DD/YYYY" id="date-0803" name="date" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="">
                    </div>
                    <div>
                      <br>
                      <label for="date-0803" class="u-label">Additional Fields</label>
                      <br>
                    </div>
                  <form action="include/Admin.inc.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="form" style="padding: 10px;width: 900px;" redirect="true">
                    <div class="wrapper">
                      <div id="name_fields" style="float:left">
                        <input type="text" name="name_fields[]" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" size="20" placeholder="Name">
                      </div>
                      <div id="type_fields"style="float:left">
                        <input type="text" name="type_fields[]" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" size="20" placeholder="Int, Var, or Date">
                      </div>
                      <div id="description_fields"style="float:left">
                        <input type="text" name="description_fields[]" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" size="20" placeholder="Description">
                      </div>
                      <div id="remove_boxes"style="float:left">
                        <label>Remove</label><br>
                        <input type="checkbox" id="remove_boxes" name="remove_boxes[]" value="selected"><br><br>
                      </div>
                      <div class="controls">
                        <a href="#" id="add_fields"><i class="fa fa-plus"></i>Add More</a>
                        <a href="#" id="remove_fields"><i class="fa fa-plus"></i>Remove Field</a>
                      </div>
                    <script src="Admin.js"></script>
                    <div class="u-align-left u-form-group u-form-submit">
                      <a href="#" class="u-btn u-btn-submit u-button-style">Submit</a>
                      <input type="submit" name="submit" value="submit" class="u-form-control-hidden">
                    </div>           
                  </form>

                </div>
              </div>
            </div>
          </div>
          <div class="u-align-left u-container-style u-tab-pane u-white u-tab-pane-2" id="tab-14b7" role="tabpanel" aria-labelledby="link-tab-14b7">
            <div class="u-container-layout u-valign-top u-container-layout-2">
              <div class="u-form u-form-1">
                <form action="include/Admin.UserApproval.inc.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="form" style="padding: 10px;width: 900px;" redirect="true">
                  <div class="wrapper">
                    <?php
                      include_once "database.php";
                      include_once "classes/UserGatherer.classes.php";

                      $gatherer = new UserGatherer();

                      $users = $gatherer->getWatchers("location: ../Admin.php");
                      for($x = 0; $x < count($users); $x++) {
                        echo "<p>Name: ",$users[$x]["first_name"]," ",$users[$x]["last_name"]," Email: ",$users[$x]["email"]," Phone Number: ",$users[$x]["phone"],"</P>";
                    ?>
                    <div class="u-form-group u-form-select u-form-group-2">
                      <label for="select-df75" class="u-label">Role:</label>
                      <div class="u-form-select-wrapper">
                        <?php
                        echo "<select id='select-df75' name=",$users[$x]["user_id"]," class='u-border-1 u-border-grey-30 u-input u-input-rectangle u-white'>";
                        ?>
                          <?php
                            $selected = $users[$x]["role_id"];
                            echo $selected;
                            if($selected == "0") {
                              echo "<option value='waiting' selected>Viewer</option>";
                              echo "<option value='reject'>Reject</option>";
                              echo "<option value='tester'>Tester</option>";
                              echo "<option value='integrator'>Integrator</option>";
                              echo "<option value='admin'>Admin</option>";
                            } else if($selected == "1") {
                              echo "<option value='waiting'>Viewer</option>";
                              echo "<option value='reject'>Reject</option>";
                              echo "<option value='tester' selected>Tester</option>";
                              echo "<option value='integrator'>Integrator</option>";
                              echo "<option value='admin'>Admin</option>";
                            } else if($selected == "2") {
                              echo "<option value='waiting'>Viewer</option>";
                              echo "<option value='reject'>Reject</option>";
                              echo "<option value='tester'>Tester</option>";
                              echo "<option value='integrator' selected>Integrator</option>";
                              echo "<option value='admin'>Admin</option>";
                            } else if($selected == "3") {
                              echo "<option value='waiting'>Viewer</option>";
                              echo "<option value='reject'>Reject</option>";
                              echo "<option value='tester'>Tester</option>";
                              echo "<option value='integrator'>Integrator</option>";
                              echo "<option value='admin' selected>Admin</option>";
                            }

                          ?>
                        </select>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" version="1" class="u-caret"><path fill="currentColor" d="M4 8L0 4h8z"></path></svg>
                      </div>
                    </div>
                    <br>
                    <br>
                    <br>

                    <?php
                      }
                    ?>
                  <div class="u-align-left u-form-group u-form-submit">
                    <a href="#" class="u-btn u-btn-submit u-button-style">Submit</a>
                    <input type="submit" name="submit" value="submit" class="u-form-control-hidden">
                  </div>           
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    
    
    
    
    
    
    <?php
        include_once 'footer.php';
    ?>
 
  </body>
</html>