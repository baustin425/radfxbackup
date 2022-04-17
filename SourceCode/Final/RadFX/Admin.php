<?php
/**
 * The admin feature page
 * @author ETurner
 */
  session_start();
  //check to make sure that the user is an admin, if not kick them to the homepage
    if(!isset($_SESSION["role"]) || $_SESSION["role"] <= 2) {
      header("location: index.php");
    }
    session_abort();
?>
<!DOCTYPE html>
<!-- import style/formatting pages -->
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
		"name": ""}
</script>
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="Admin">
    <meta property="og:type" content="website">
  </head>
  <body class="u-body">
    <?php
      //add the header for all pages
        include_once 'header.php';
    ?>
    <section class="u-align-center u-clearfix u-image u-shading u-section-1" src="" data-image-width="474" data-image-height="316" id="sec-89ea">
    <?php
      //display any error code information
          if(isset($_GET["error"])) {
            if($_GET["error"] == "request_name_check") {
              echo "<p style='font-size:30px;'>Name must be filled out, contain at least one letter, and not include special characters!</P>";
            } else if($_GET["error"] == "input_check") {
              echo "<p style='font-size:30px;'>Input must not include special characters!</P>";
            } else if($_GET["error"] == "request_name_match") {
              echo "<p style='font-size:30px;'>That field name is already taken!</P>";
            } else if($_GET["error"] == "admin_count") {
              echo "<p style='font-size:30px;'>Cannot remove the last admin!</P>";
            } else if($_GET["error"] == "password") {
              echo "<p style='font-size:30px;'>Information incorrect!</P>";
            } else if($_GET["error"] == "request_description_check") {
              echo "<p style='font-size:30px;'>Description field must be filled out, contain at least one letter, and not include special characters!</P>";
            } else if($_GET["error"] == "request_type_check") {
              echo "<p style='font-size:30px;'>Type field must contain int, var, or date!</P>";
            } else if($_GET["error"] == "request_edit_none" || $_GET["error"] == "request_add_none") {
              echo "<p style='font-size:30px;'>Form update successful!</P>";
            } else if($_GET["error"] == "user_approval_none") {
              echo "<p style='font-size:30px;'>User roles updated!</P>";
            } else if($_GET["error"] == "change_affiliation_none") {
              echo "<p style='font-size:30px;'>Affiliation updated successfully!</P>";
            } else if($_GET["error"] == "add_affiliation_none") {
              echo "<p style='font-size:30px;'>Affiliation added successfully!</P>";
            } else if($_GET["error"] == "remove_affiliation_none") {
              echo "<p style='font-size:30px;'>Affiliation removed successfully!</P>";
            } else if($_GET["error"] == "affiliation_count") {
              echo "<p style='font-size:30px;'>Cannot remove the base affiliation!</P>";
            } else if($_GET["error"] == "user_reject_none") {
              echo "<p style='font-size:30px;'>User removed!</P>";
            } else if($_GET["error"] == "edit_ion_none") {
              echo "<p style='font-size:30px;'>Ions edited successfully!</P>";
            }else if($_GET["error"] == "add_ion_none") {
              echo "<p style='font-size:30px;'>Ion added!</P>";
            }else if($_GET["error"] == "add_ion_field_none") {
              echo "<p style='font-size:30px;'>Ion field added!</P>";
            }else if($_GET["error"] == "remove_facility_none") {
              echo "<p style='font-size:30px;'>Facility removed successfully!</P>";
            }else if($_GET["error"] == "add_facility_none") {
              echo "<p style='font-size:30px;'>Facility added!</P>";
            }else if($_GET["error"] == "change_facility_none") {
              echo "<p style='font-size:30px;'>Facility edit successful!</P>";
            }else if($_GET["error"] == "add_facility_field_none") {
              echo "<p style='font-size:30px;'>Facility field added successfully!</P>";
            } else if($_GET["error"] == "unbreakable_field") {
              echo "<p style='font-size:30px;'>One of the fields you tried to remove is a permanent field!</P>";
            } else if($_GET["error"] == "facility_count") {
              echo "<p style='font-size:30px;'>You can not remove the last facility!</P>";
            } else if($_GET["error"] == "prepare" || $_GET["error"] == "edit_ion_prepare"|| $_GET["error"] == "ion_del_prepare"|| $_GET["error"] == "req_ion_del_prepare"|| $_GET["error"] == "edit_ion_prepare"|| $_GET["error"] == "add_ion_prepare"|| $_GET["error"] == "change_facility_prepare"|| $_GET["error"] == "add_facility_prepare"|| $_GET["error"] == "remove_facility_ion_prepare"|| $_GET["error"] == "remove_facility_request_prepare"|| $_GET["error"] == "remove_facility_req_ion_prepare"|| $_GET["error"] == "get_facility_req_ion_prepare"|| 
              $_GET["error"] == "remove_facility_prepare" || $_GET["error"] == "remove_affiliation_prepare"|| $_GET["error"] == "remove_affiliation_facility_prepare"|| $_GET["error"] == "get_affiliation_facility_prepare"|| $_GET["error"] == "remove_affiliation_user_prepare"|| $_GET["error"] == "get_affiliation_user_prepare"|| $_GET["error"] == "add_affiliation_prepare"|| $_GET["error"] == "change_affiliation_prepare") {
              echo "<p style='font-size:30px;'>Something went wrong, try again!</P>";
            }
          }
      ?>
      <div class="u-clearfix u-sheet u-sheet-1">
        <!-- add tabs -->
        <div class="u-expanded-width u-tab-links-align-left u-tabs u-tabs-1">
          <ul class="u-border-2 u-border-palette-1-base u-spacing-10 u-tab-list u-unstyled" role="tablist">

            <li class="u-tab-item u-tab-item-4" role="presentation">
              <a class="active u-active-palette-1-base u-button-style u-grey-10 u-tab-link u-text-active-white u-text-black u-tab-link-4" id="tab-995t" href="#link-tab-995t" role="tab" aria-controls="link-tab-995t" aria-selected="true">Request Form</a>
            </li>
            <li class="u-tab-item" role="presentation">
              <a class="u-active-palette-1-base u-button-style u-grey-10 u-tab-link u-text-active-white u-text-black u-tab-link-3" id="link-tab-2917" href="#tab-2917" role="tab" aria-controls="tab-2917" aria-selected="false">User Management</a>
            </li>
            <li class="u-tab-item u-tab-item-4" role="presentation">
              <a class="u-active-palette-1-base u-button-style u-grey-10 u-tab-link u-text-active-white u-text-black u-tab-link-4" id="tab-93fc" href="#link-tab-93fc" role="tab" aria-controls="link-tab-93fc" aria-selected="false">Ions</a>
            </li>
            <li class="u-tab-item u-tab-item-4" role="presentation">
              <a class="u-active-palette-1-base u-button-style u-grey-10 u-tab-link u-text-active-white u-text-black u-tab-link-4" id="tab-666r" href="#link-tab-666r" role="tab" aria-controls="link-tab-666r" aria-selected="false">Facilities</a>
            </li>
          </ul>
          <!-- request form tab -->
          <div class="u-tab-content">

          <div class="u-container-style u-tab-active u-tab-pane u-white u-tab-pane-4" id="link-tab-995t" role="tabpanel" aria-labelledby="link-tab-995t">  
            <div class="u-container-layout u-container-layout-3" >
              <!-- request form subtab buttons -->
              <button onclick="toggleEditRequestForm()">Edit Form</button>
              <button onclick="toggleAddRequestField()">Add Field</button> 
              <br>
              <br>  
                <div class="u-form u-form-2 edit_Request_form">
                  <!-- Edit Request Form sub tab -->
                  <h4 class="u-text u-text-default u-text-1"> Edit Form </h4>
                  <form action="include/Admin.inc.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="request_form" id="request_form" style="padding: 10px;width: 900px;" redirect="true">
                    <div class="wrapper">

                      <!-- Gather information required to generate all tables -->
                      <?php
                        include_once 'database.php';
                        include_once 'classes/ColumnGenerator.classes.php';
                        include_once 'classes/FieldController.classes.php';
                        $database = new Database();
                        $gen = new ColumnGenerator();
                        $field_controller = new FieldController();
                        $conn = $database->connect();//the database connection
                        //get column information from request table
                        $sql = $conn->query("SHOW FULL COLUMNS FROM request");
                        $request_column_info = $sql->fetchAll(PDO::FETCH_ASSOC);
                        //sort request table column information
                        $sql = $conn->prepare("SELECT * FROM fields WHERE table_name = 'request' ORDER BY order_num ASC;");
                        $sql->execute();
                        $request_table_info = $sql->fetchAll(PDO::FETCH_ASSOC);
                        $request_table_info = $gen->reorderEntries($request_table_info, $request_column_info, ["request_id", "facility_id", "user_id", "purpose_id", "approved", "retracted", "time_used", "energy_level"]);
                        //generate alter request from
                        $table = $gen->getColumnsAlterRequestForm(["request_id", "facility_id", "user_id", "purpose_id", "approved", "retracted", "time_used", "energy_level"], "request", "request", $request_table_info);
                      
                        //get column information from ion table
                        $sql = $conn->query("SHOW FULL COLUMNS FROM ion");
                        $ion_column_info = $sql->fetchAll(PDO::FETCH_ASSOC);
                        //sort ion table column information
                        $sql = $conn->prepare("SELECT * FROM fields WHERE table_name = 'ion' ORDER BY order_num ASC;");
                        $sql->execute();
                        $table_info = $sql->fetchAll(PDO::FETCH_ASSOC);
                        $ion_table_info = $gen->reorderEntries($table_info, $ion_column_info, []);
                        
                        //get column information from facility table
                        $sql = $conn->query("SHOW FULL COLUMNS FROM facility");
                        $facility_column_info = $sql->fetchAll(PDO::FETCH_ASSOC);
                        //sort facility table column information
                        $sql = $conn->prepare("SELECT * FROM fields WHERE table_name = 'facility' ORDER BY order_num ASC;");
                        $sql->execute();
                        $table_info = $sql->fetchAll(PDO::FETCH_ASSOC);
                        $facility_table_info = $gen->reorderEntries($table_info, $facility_column_info, []);

                        //get all ions
                        $sql = $conn->prepare("SELECT * FROM ion;");
                        $sql->execute();
                        $ion_table = $sql->fetchAll(PDO::FETCH_ASSOC);
                        //get all facilities
                        $sql = $conn->prepare("SELECT * FROM facility;");
                        $sql->execute();
                        $facility_table = $sql->fetchAll(PDO::FETCH_ASSOC);
                      ?>
                      <p>*Some fields cannot be removed and require input on request form</p>
                      <div class="u-align-left u-form-group u-form-submit">
                        <a href="#" class="u-btn u-btn-submit u-button-style">Submit</a>
                        <input type="submit" name="submit_request_form" value="submit_request_form" class="u-form-control-hidden">
                      </div>
                    </div>
                  </form>
                </div><!-- end edit request form subtab -->

                <div class="u-form u-form-2 add_Request_field">
                  <!-- Add Request Form Field subtab -->
                  <h4 class="u-text u-text-default u-text-1"> Add Field </h4>
                  <form action="include/Admin.inc.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="request_form" style="padding: 10px;width: 900px;" redirect="true">
                    <div class="wrapper">
                    <?php
                        echo '<div class="u-form-group u-form-select u-form-group-1">';
                        echo '<table id="new_Request_field">
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Description</th>
                        </tr>
                        <tr>
                                <td style="text-align:center;"><input type="text" placeholder="name of field" id="newIonName" name="name" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" >
                                <td style="text-align:center;"><select id="newIonenergy" name="type" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white">
                                  <option value="NUMBER">A number or decimal</option>
                                  <option value="VAR">A word or sentence</option>
                                  <option value="DATE">A calendar date</option>
                                </select></td>';
                                echo '<td style="text-align:center;"><input type="text" placeholder="short description" id="newIonDesc" name="description" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" >
                                </td>
                                <td>
                                <div class="u-align-left u-form-group u-form-submit">
                                    <a href="#" class="u-btn u-btn-submit u-button-style">Submit</a>
                                    <input type="submit" name="submit_request_field" value="submit_request_field" class="u-form-control-hidden">
                                </div>
                                </td>
                                </tr>';
                        echo '</table>';
                        echo '</div>';
                        ?>
                    </div>
                  </form>
                </div>
              </div><!-- end add request form field subtab -->
            </div><!-- end request form tab -->
            <!-- Javascript code for the request form tab -->
            <script src="//code.jquery.com/jquery-1.11.1.js"></script>
            <script>
              $(document).ready(function() {
                //hide add field sub tab on start
                hideAddRequestField();
                  //up sorting arrows
                  $(".up").click(function(){
                    var row = this.parentNode.parentNode;//the row associated with this arrow
                    var previous_row = row.previousElementSibling;//the previous row
                    var table = row.parentNode;//the table the arrow is from
                    var top_row = $("#request_form_table").rows;//the top most row

                    //if this isnt the top row then move this row up one
                    if(top_row != previous_row) {
                      table.insertBefore(row, previous_row);
                    }
                  }); 

                  //down sorting arrows
                  $(".down").click(function(){
                      var row = this.parentNode.parentNode;//the row associated with this arrow
                      var next_row = row.nextElementSibling.nextElementSibling;//the row after the next row
                      var table = row.parentNode;//the table the arrow is from

                      //move this row down one
                      table.insertBefore(row, next_row);
                  });
              });

              // toggle hide/show add request field sub tab
              function toggleAddRequestField() {
                if($(".add_Request_field").is(":hidden")) {
                    $(".add_Request_field").fadeIn(0);
                    hideEditRequestForm();
                }
              }

              //hide add request field sub tab
              function hideAddRequestField() {
                $(".add_Request_field").hide();
              }

              // toggle hide/show edit request form sub tab
              function toggleEditRequestForm() {
                if($(".edit_Request_form").is(":hidden")) {
                    $(".edit_Request_form").fadeIn(0);
                    hideAddRequestField();
                }
              }

              //hide edit request form sub tab
              function hideEditRequestForm() {
                $(".edit_Request_form").hide();
              }

              //when the request form submits perform clean up
              $("#request_form").submit(function(eventObject){
                var rows = $("#request_form_table tr");//the rows from the request form
                rows.splice(0, 1);

                var list = new Array();
                var names = new Array();
                var count = 0;
                //loop through all the checkboxes and create post information for any unchecked rows
                for(x = 0; x < rows.length; x++) {
                  var checked = $(rows[x]).closest('tr').find('input:checkbox').is(':checked');
                  //if row is unchecked still make a post entry for it
                  if(!checked || $($(rows[x]).closest('tr').find('input:checkbox')).attr('id') != "requestremove") {
                    var name = ($(rows[x].cells[1]).text().toLowerCase()).replaceAll(" ", "_");
                    var input = document.createElement('input');
                    input.setAttribute('type', "hidden");
                    input.setAttribute('name', "form[" + name + "][field_name]");
                    input.setAttribute('value', name);
                    rows[x].prepend(input);
                    count++;
                  }
                }
              });
            </script>

            <!-- User management tab -->
            <div class="u-container-style u-tab-pane u-white u-tab-pane-2" id="tab-2917" role="tabpanel" aria-labelledby="link-tab-2917">
              <div class="u-container-layout u-container-layout-3" style="text-align:center;">
                <div style="float: left; width: 50%;">
                  <!-- Color code indicator for approved -->
                  <div style="text-align: center; padding: 5px; float: left; width: 50%;" class="u-align-left">
                    <div style="padding: 5px; float: left; width: 50%;" class="u-align-right">
                      <label class="u-label">Approved: </label>
                    </div>
                    <div style="padding: 5px; float: left; width: 50%;" class="u-align-right">
                      <input type="color" value="#00ff00" name="legend" readonly>
                    </div>
                  </div>
                  <!-- Color code indicator for not approved -->
                  <div style="text-align: center; padding: 5px; float: left; width: 50%;" class="u-align-left">
                    <div style="padding: 5px; float: left; width: 50%;" class="u-align-left">
                      <label class="u-label">Not Approved: </label>
                    </div>
                    <div style="padding: 5px; float: left; width: 50%;" class="u-align-left">
                      <input type="color" value="#ff0000" name="legend" readonly>
                    </div>
                  </div>
                </div>
                <div id="user-select" class="u-form u-form-2">
                <?php
                  include_once "database.php";
                  include_once "classes/UserGatherer.classes.php";

                  //get all users from the database
                  $gatherer = new UserGatherer();
                  $users = $gatherer->getAllUsers("location: ../Admin.php");

                 ?>
                  <div>
                  <?php
                  echo '
                  <form action="include/Admin.UserApproval.inc.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="form" id="form" style="padding: 10px;width: 900px;" redirect="true">
                      <div class="wrapper">';
                          echo '<div id="div_label" class="u-form-group u-form-select u-form-group-2">';
                            echo '<div id="user-sel">

                            <table id="user_table">
                              <tr>
                                <th style="text-align:center;">remove</th>
                                <th style="text-align:center;">Name</th>
                                <th style="text-align:center;">Email</th>
                                <th style="text-align:center;">Phone</th>
                                <th style="text-align:center;">Affiliation</th>
                                <th style="text-align:center;">Current Role</th>
                                <th style="text-align:center;">Suggested Role</th>
                              </tr>';
                            //loop through users and display information
                            foreach($users as $user) {
                              $curr_role = $user["role_id"];
                              $sug_role = "Viewer";
                              //if they have not been assigned a role then label them green
                              $app_color = "red";
                              if($curr_role > 0) {
                                $app_color = "green";
                              }
                              //display suggested role
                              if($user["suggested_role_id"] == 1) {
                                $sug_role = "Tester";
                              } else if($user["suggested_role_id"] == 2) {
                                $sug_role = "Integrator";
                              } else if($user["suggested_role_id"] == 3) {
                                $sug_role = "Admin";
                              }
                              //display information about user
                              echo '<tr style="color:',$app_color,';">
                                <td style="text-align:center;"><input onclick="setAltered(',$user["user_id"],')" type="checkbox" name="user[',$user["user_id"],'][remove]"></td>
                                <td style="text-align:center;">',$user["first_name"],' ',$user["last_name"],'</td>
                                <td style="text-align:center;">',$user["email"],'</td>
                                <td style="text-align:center;">',$user["phone"],'</td>
                                <td style="text-align:center;">
                                  <select onclick="setAltered(',$user["user_id"],')" id="select-81a6" name="user[',$user["user_id"],'][affiliation_id]" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white">';
                                  //loop through all facilities and add them to the affiliation select for integrators, prepopulate the already selected affiliation
                                  $aff_sel = "";
                                  $found = false;
                                  foreach($facility_table as $facility) {
                                    $aff_sel = "";
                                    if($user["affiliation_id"] == $facility["facility_id"]) {
                                      $aff_sel = " selected='selected '";
                                      $found = true;
                                    }
                                    echo '<option ',$aff_sel,' value="',$facility["facility_id"],'">',$facility["name"],'</option>';
                                  }
                                  if(!$found) {
                                    $aff_sel = " selected='selected '";
                                  }
                                  echo '<option ',$aff_sel,' value="0">None</option>';
                                  //generate role select drop down and prepopulate with current role
                                echo '</td>
                                <td style="text-align:center;">
                                  <select onclick="setAltered(',$user["user_id"],')" id="select-81a7" name="user[',$user["user_id"],'][role_id]" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white">
                                    <option',(($curr_role == 0)? ' selected="selected" ':""),' value="0">Viewer</option>
                                    <option',(($curr_role == 1)? ' selected="selected" ':""),' value="1">Tester</option>
                                    <option',(($curr_role == 2)? ' selected="selected" ':""),' value="2">Integrator</option>
                                    <option',(($curr_role == 3)? ' selected="selected" ':""),' value="3">Admin</option>
                                </td>
                                <td style="text-align:center;">',$sug_role,'</td>
                                <td><input type="hidden" id="user',$user["user_id"],'" name="user[',$user["user_id"],'][altered]"></td>
                              </tr>';
                            }
                            echo '</table>';
                            
                            ?>

                            <!-- check user for password before submit -->
                            <input type="password" placeholder="Enter your password" id="password" name="password" class='u-border-1 u-border-grey-30 u-input u-input-rectangle u-white' required="required">

                            </div>
                          </div>
                          <div class="u-align-left u-form-group u-form-submit">
                            <a href="#" class="u-btn u-btn-submit u-button-style">Submit</a>
                            <input type="submit" name="submit" value="submit" class="u-form-control-hidden">
                          </div>
                        </div>
                      </form>
                  </div><!-- End user management table -->
                  <!-- Javascript for user management page -->
                  <script src="jquery.js"></script>
                  <script>

                    //if user has been altered set indicator
                    function setAltered(id) {
                      $("#user"+id).val(1);
                    }
                  </script>
                </div>
              </div>
            </div><!-- end user management tab -->
            <!-- Ions tab -->
            <div class="u-container-style u-tab-pane u-white u-tab-pane-3" id="link-tab-93fc" role="tabpanel" aria-labelledby="tab-93fc">
              <div class="u-container-layout u-container-layout-4">
                <div class="u-form u-form-1">
                  <!-- create edit ions sub tab buttons -->
                  <button onclick="toggleEditIons()">Edit Facility Ions</button>
                  <button onclick="toggleAddIon()">Add New Ion</button> 
                  <button onclick="toggleEditIonField()">Edit Ion Fields</button>
                  <button onclick="toggleAddField()">Add Field</button>
                  <br>
                  <br>
                  <!-- edit ions sub tab -->
                  <div class="edit_ions">
                    <form action="include/Admin.Ions.inc.php" method="POST" class="" source="custom" name="edit_ion_form" id="edit_ion_form" style="padding: 10px;width: 900px;" redirect="true">
                      <h4 class="u-text u-text-default u-text-1">Edit Ions</h4>
                      <!-- facility select drodown -->
                      <label for="select-facility" class="u-label">Facility</label>
                      <div class="u-form-select-wrapper">
                          <select id="select-facility-edit-ion" name="facility" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white">
                          <?php
                              foreach($facility_table as $field) {
                              echo '<option value="',$field["facility_id"],'">',$field["description"],'</option>';
                              }
                          ?>
                          <option value="other">All Ions</option>
                          </select>
                          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" version="1" class="u-caret"><path fill="currentColor" d="M4 8L0 4h8z"></path></svg>
                      </div>
                      <?php
                      //ion search bar
                      $ion_inputs = [];
                      echo '<div class="">
                        <label for="text-53b6" class="u-label">Ion Search</label>
                        <input type="text" placeholder="ion name" id="searchbar" name="searchbar" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white">
                      </div>';
                      //create ion tables for each facility
                      foreach($facility_table as $field) {
                          echo '<div class="u-form-group u-form-select u-form-group-1 hidden" id="',$field["facility_id"],'">';
                          echo '<table id=',$field["facility_id"],'>
                          <thead>
                          <tr>
                              <th class="ion_sort">Remove</th>';
                              $ion_headers = $gen->getColumnsAsHeader(["ion_id", "facility_id"], "ion", $ion_column_info, $ion_table_info);
                          echo '
                          </tr>
                          </thead>
                          <tbody>';
                          $count = 0;
                          //create ion table rows
                          foreach($ion_table as $ion) {
                              if($ion["facility_id"] == $field["facility_id"]) {

                                echo '<tr name=ion[',$ion["ion_id"],'][',$ion["name"],']> 
                                <td style="text-align:center;"><input type="checkbox" id="remove_ion" name="ion[',$ion["ion_id"],'][remove]"></td>
                                <td style="text-align:center;">',$ion["name"],'</td>
                                </td>';
                                $ion_inputs = array_merge($ion_inputs, $gen->getColumnsAsTablePopulated(["ion_id", "facility_id", "name"], "ion", "edit_ion_", $ion["ion_id"], $ion_column_info, $ion, $ion_table_info));
                                echo '
                                    </tr>';
                                $count++;
                              }
                          }
                          echo '</tbody>
                          </table>';
                          echo '</div>';
                      }

                      echo '<div class="u-form-group u-form-select u-form-group-1 hidden" id="other">';
                          //create all ions table
                          echo '<table id="other">
                          <thead>
                          <tr>
                              <th>Remove</th>';
                            $ion_headers = $gen->getColumnsAsHeader(["ion_id", "facility_id"], "ion", $ion_column_info, $ion_table_info);
                          echo '
                          </tr>
                          </thead>
                          <tbody>';
                          $count = 0;
                          //loop through and create all ion rows for the table
                          foreach($ion_table as $ion) {

                            echo '<tr name=ion[',$ion["ion_id"],'][',$ion["name"],']> 
                                <td style="text-align:center;"><input type="checkbox" id="remove_ion" name="ion[',$ion["ion_id"],'][remove]"></td>
                                <td style="text-align:center;">',$ion["name"],'</td>
                                </td>';
                                $ion_inputs = array_merge($ion_inputs, $gen->getColumnsAsTablePopulated(["ion_id", "facility_id", "name"], "ion", "edit_ion_", $ion["ion_id"], $ion_column_info, $ion, $ion_table_info));
                                echo '
                                    </tr>';
                                $count++;
                          }
                          echo '</tbody>
                          </table>';
                          echo '</div>';
                      
                      ?>
                      <div class="u-align-left u-form-group u-form-submit">
                        <a href="#" class="u-btn u-btn-submit u-button-style">Submit</a>
                        <input type="submit" name="submit" value="submit" class="u-form-control-hidden">
                      </div>
                    </form>
                  </div><!-- end edit ion sub tab -->
                  <!-- Add ion sub tab -->
                  <form action="include/Admin.Ions.inc.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="ion_form" id="ion_form" style="padding: 10px;width: 900px;" redirect="true">
                    <div class="u-form-group u-form-select u-form-group-1 new_ion" id="new_ion">
                      <h4 class="u-text u-text-default u-text-1">Add Ion</h4> 
                      <!-- select facility dropdown -->
                      <label for="select-facility" class="u-label">Facility</label>
                      <div class="u-form-select-wrapper">
                          <select id="select-facility-add-ion" name="facility_id" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white">
                          <?php
                              foreach($facility_table as $field) {
                              echo '<option value="',$field["facility_id"],'">',$field["description"],'</option>';
                              }
                          ?>
                          </select>
                          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" version="1" class="u-caret"><path fill="currentColor" d="M4 8L0 4h8z"></path></svg>
                      </div>
                      <?php
                      //generate ion column entry boxes from the database
                      $ion_inputs_new = [];
                      echo '<table id="new_ion">
                      <tr>';
                          $ion_headers = $gen->getColumnsAsHeaderUnsortable(["ion_id", "facility_id"], "ion", $ion_column_info, $ion_table_info);
                      echo '
                      </tr>';
                      $ion_inputs_new = array_merge($ion_inputs_new, $gen->getColumnsAsRow(["ion_id", "facility_id"], "ion", "add_ion_", $ion_column_info, $ion_table_info));
                      echo '</tr>';
                      echo '</table>';
                      echo '<div class="u-align-left u-form-group u-form-submit">
                      <a href="#" class="u-btn u-btn-submit u-button-style">Submit</a>
                      <input type="submit" name="submit_ion" value="submit_ion" class="u-form-control-hidden">
                      </div>';
                      echo '</div>';
                      ?>
                  </form>
                  <!-- Add ion field sub tab -->
                  <div class="add_field"> 
                    <form action="include/Admin.Ions.inc.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="field_form" id="field_form" style="padding: 10px;width: 900px;" redirect="true">
                        <?php
                        echo '<div class="u-form-group u-form-select u-form-group-1 new_field">';
                        echo '<h4 class="u-text u-text-default u-text-1">Add Field</h4>';    
                        echo '<table id="new_field">
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Description</th>
                        </tr>
                        <tr>
                                <td style="text-align:center;"><input type="text" placeholder="name of field" id="newIonName" name="name" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" >
                                <td style="text-align:center;"><select id="newIonenergy" name="type" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white">
                                  <option value="NUMBER">A number or decimal</option>
                                  <option value="VAR">A word or sentence</option>
                                  <option value="DATE">A calendar date</option>
                                </select></td>';
                                
                                echo '<td style="text-align:center;"><input type="text" placeholder="short description" id="newIonDesc" name="description" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" >
                                </td>
                                <td>
                                <div class="u-align-left u-form-group u-form-submit">
                                    <a href="#" class="u-btn u-btn-submit u-button-style">Submit</a>
                                    <input type="submit" name="submit_field" value="submit_field" class="u-form-control-hidden">
                                </div>
                                </td>
                                </tr>';
                        echo '</table>';
                        echo '</div>';
                        ?>
                    </form>
                  </div><!-- end add field sub tab -->

                  <!--edit ion fields sub tab -->
                  <div class="u-form u-form-2 edit_ion_form">
                    <h4 class="u-text u-text-default u-text-1"> Ion Form </h4>
                    <p>*Some fields such as Name, Energy, and Max Energy cannot be changed and are thus omitted</p>
                    <form action="include/Admin.Ions.inc.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="edit_ion_form_fields" id="edit_ion_form_fields" style="padding: 10px;width: 900px;" redirect="true">
                      <div class="wrapper">

                        <?php
                          $table = $gen->getColumnsAlterRequestForm(["facility_id", "ion_id", "name", "energy", "max_energy"], "ion", "ion", $ion_table_info);
                        ?>

                        <div class="u-align-left u-form-group u-form-submit">
                          <a href="#" class="u-btn u-btn-submit u-button-style">Submit</a>
                          <input type="submit" name="submit_ion_form" value="submit_ion_form" class="u-form-control-hidden">
                        </div>
                      </div>
                    </form>
                  </div><!-- end edit ion fields sub tab -->

                  <!-- Javascript for ion tab -->
                  <script src="jquery.js"></script>
                  <script>
                    var buttonIndex;

                      $(document).ready(function() {
                          //hide all sub tabs 
                          hideAddIon();
                          hideAddField();
                          hideEditIonField();


                          //adjust ion view when facility is changed
                          $("#select-facility-add-ion").on('change', function() {
                          }).change();

                          //adjust ion view when facility is changed
                          $("#select-facility-edit-ion").on('change', function() {
                              $rows = $('#' + $("#select-facility-edit-ion").val() +' tr');
                              $rows.splice(0, 1);
                              $(".hidden").hide();
                              $(".hidden :input").prop("disabled", true);
                              $("#" + $(this).val()).fadeIn(700);
                              $("#" + $(this).val() + " :input").prop("disabled", false);
                              searchIons('#searchbar');
                          }).change();
                      });

                      //hide add ion sub tab
                      function hideAddIon() {
                          $(".new_ion").hide();
                      }

                      // toggle hide/show add ion sub tab
                      function toggleAddIon() {
                          if($(".new_ion").is(":hidden")) {
                              $(".new_ion").fadeIn(0);
                              hideAddField();
                              hideEditIons();
                              hideEditIonField();
                          }
                      }

                      //hide add field sub tab
                      function hideAddField() {
                          $(".new_field").hide();
                      }

                      // toggle hide/show add field sub tab
                      function toggleAddField() {
                          if($(".new_field").is(":hidden")) {
                              $(".new_field").fadeIn(0);
                              hideAddIon();
                              hideEditIons();
                              hideEditIonField();
                          }
                      }

                      //hide edit ions sub tab
                      function hideEditIons() {
                          $(".edit_ions").hide();
                      }

                      // toggle hide/show edit ion sub tab
                      function toggleEditIons() {
                          if($(".edit_ions").is(":hidden")) {
                              $(".edit_ions").fadeIn(0);
                              hideAddIon();
                              hideAddField();
                              hideEditIonField();
                          }
                      }

                      //hide edit ion field sub tab
                      function hideEditIonField() {
                          $(".edit_ion_form").hide();
                      }

                      // toggle hide/show edit ion field sub tab
                      function toggleEditIonField() {
                          if($(".edit_ion_form").is(":hidden")) {
                              $(".edit_ion_form").fadeIn(0);
                              hideAddIon();
                              hideAddField();
                              hideEditIons();
                          }
                      }

                      //when the edit ion form submits perform clean up
                      $("#edit_ion_form_fields").submit(function(eventObject){
                        var rows = $("#ion_form_table tr");
                          rows.splice(0, 1);

                          var list = new Array();
                          var names = new Array();
                          //loop through all the checkboxes and create post information for any unchecked rows
                          for(x = 0; x < rows.length; x++) {
                            var checked = $(rows[x]).closest('tr').find('input:checkbox').is(':checked');
                            //if row is unchecked still make a post entry for it
                            if(!checked) {
                              var name = ($(rows[x].cells[1]).text().toLowerCase()).replaceAll(" ", "_");
                              var input = document.createElement('input');
                              input.setAttribute('type', "hidden");
                              input.setAttribute('name', "form[" + name + "][field_name]");
                              input.setAttribute('value', name);
                              rows[x].prepend(input);
                            }
                          }
                      });

                      //when the ion form submits perform clean up
                      $("#ion_form").submit(function(eventObject){
                        var facility = $("#select-facility-add-ion").val();
                        //prevent submit if a facility is not selected
                        if(facility == "other")
                        {
                            event.preventDefault();
                            alert("You must select a facility!");
                        } 
                      });

                      //loop through ions and only show ones with letters input into the search bar
                      function searchIons($search_bar) {
                        var val = $($search_bar).val().trim().toLowerCase();
                        for(x = 0; x < $rows.length; x++) {

                          var text = $($rows[x].cells[1]).text().toLowerCase();
                          if(text.indexOf(val)) {
                            $($rows[x]).hide();
                          } else {
                            $($rows[x]).show();
                          }
                        }
                      }

                      //get ion rows for currently selected facility
                      var $rows = $('#' + $("#select-facility-edit-ion").val() +' tr');
                      //remove the headers
                      $rows.splice(0, 1);
                      //whenever something changes in search bar adjust visable ion rows
                      $('#searchbar').keyup(function() {
                        searchIons(this);
                      });

                      //add sorting function to all columns with the sortable class
                      document.querySelectorAll('.sortable').forEach(th => th.addEventListener('click', (() => {
                        var table = th.parentElement.parentElement.parentElement;//the table
                        var column = Array.prototype.indexOf.call(th.parentElement.children, th) + 1;//the selected column
                        var dir = th.classList.contains('sort-des') ? -1:1;//the direction its being sorted, asc = 1, des = -1

                        sortTable(table, column, dir);
                      })));

                      //sort table rows in asc or des order
                      function sortTable(table, column, dir) {
                        var body = table.querySelector('tbody');//the body of the table
                        
                        //sort all rows in the body of the table
                        var sortedRows = $rows.sort((a,b) => {
                          var a_content;
                          var b_content;
                          var a_entry = a.querySelector('td:nth-child(' + column + ')');
                          var b_entry = b.querySelector('td:nth-child(' + column + ')');
                          //check row a for a user input or an entry
                          if($(a_entry).find('input').val() != undefined) {
                            a_content = $(a_entry).find('input').val();
                          } else {
                            a_content = a_entry.textContent.trim();
                          }
                           //check row b for a user input or an entry
                          if($(b_entry).find('input').val() != undefined) {
                            b_content = $(b_entry).find('input').val();
                          } else {
                            b_content = b_entry.textContent.trim();
                          }

                          //compare the input or entry from each row and return whether it is lower or higher(adjusted for which direction you are sorting)
                          return a_content.localeCompare(b_content, 'en', {numeric: true}) * dir;
                        });

                        //remove all rows
                        while(body.firstChild) {
                          body.removeChild(body.firstChild);
                        }

                        //replace all rows sorted
                        for($x = 0; $x < sortedRows.length; $x++) {
                          body.append(sortedRows[$x]);
                        }
                        //set the header to be sorted in the opposite direction on next click
                        table.querySelectorAll('th').forEach(th => th.classList.remove('sort-des'));
                        table.querySelector('th:nth-child(' + column + ')').classList.toggle('sort-des', dir > 0);
                      }
                  </script>
                </div>

              </div>
            </div> <!-- end ion tab -->
            <!-- facility tab -->
            <div class="u-container-style u-tab-pane u-white u-tab-pane-3" id="link-tab-666r" role="tabpanel" aria-labelledby="tab-666r">
              <div class="u-container-layout u-container-layout-4">
                <div class="u-form u-form-1">
                <!-- Generate facility sub tab buttons -->
                <button onclick="toggleEditFacility()">Edit Facility</button> 
                <button onclick="toggleAddFacility()">Add Facility</button>
                <button onclick="toggleEditFacilityForm()">Edit Facility Form</button>
                <button onclick="toggleAddFacilityField()">Add Field</button>
                <br> 
                <br>
                <!-- edit facility sub tab -->
                  <div class="edit_facility">
                  <h4 class="u-text u-text-default u-text-1">Edit Facility</h4>
                    <form action="include/Admin.Facility.inc.php" method="POST" source="custom" name="edit_facility_form" id="edit_facility_form" style="padding: 10px;width: 900px;" redirect="true">
                      <!-- facility drop down -->
                      <label for="select-facility-edit" class="u-label">Facility</label>
                      <div class="u-form-select-wrapper">
                        
                        <select id="select-facility-edit" name="facility_id" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white">
                          <?php
                              foreach($facility_table as $field) {
                              echo '<option value="',$field["facility_id"],'">',$field["description"],'</option>';
                              }
                          ?>
                        </select>
                          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" version="1" class="u-caret"><path fill="currentColor" d="M4 8L0 4h8z"></path></svg>
                      </div>
                      
                      <?php
                      echo '<div class="u-form-group u-form-select u-form-group-1">';
                          //generate prepopulated facility form fields         
                          $table = $gen->getColumns(["facility_id", "affiliation_id"], $field_controller->getRequiredFields("facility"), "facility_", $facility_table_info);
                          echo '<div class="u-align-left u-form-group u-form-submit">
                                  <a href="#" class="u-btn u-btn-submit u-button-style">Submit</a>
                                  ';
                                  ?>
                                  <input type="submit" name="submit" value="submit" class="u-form-control-hidden">
                            </div>
                            </form>
                              <?php
                      echo '</div>';
                      ?>
                    </form>
                    <!-- remove facility button and password check -->
                    <form action="include/Admin.Facility.inc.php" method="POST" source="custom" name="remove_facility" id="remove_facility" style="padding: 10px;width: 900px;" redirect="true">
                      <div class="u-align-left u-form-group u-form-submit">

                        <input type="password" placeholder="Password required for removal" id="password" name="password" class='u-border-1 u-border-grey-30 u-input u-input-rectangle u-white' required="required">
                        <a href="#" class="u-btn u-btn-submit u-button-style">Remove</a>
                        <input type="submit" name="remove" value="remove" class="u-form-control-hidden" onclick='return window.confirm("Are you sure?");'>
                      </div>
                    </form>
                  </div><!-- end edit facility sub tab -->
                  <!-- add facility sub tab -->
                  <div class="add_facility">
                  <h4 class="u-text u-text-default u-text-1">Add Facility</h4>
                    <form action="include/Admin.Facility.inc.php" method="POST" source="custom" name="add_facility_form" id="add_facility_form" style="padding: 10px;width: 900px;" redirect="true">
                      <?php
                      echo '<div class="u-form-group u-form-select u-form-group-1">';
                          //facility select dropdown              
                          $table = $gen->getColumns(["facility_id", "affiliation_id"], $field_controller->getRequiredFields("facility"),  "facility_", $facility_table_info);
                          echo '<div class="u-align-left u-form-group u-form-submit">
                                  <a href="#" class="u-btn u-btn-submit u-button-style">Submit</a>
                                  <input type="submit" name="submit_new" value="submit_new" class="u-form-control-hidden">
                              </div>';
                      echo '</div>';
                      ?>
                    </form>
                  </div>
                  <!--add facility field sub tab -->
                  <div class="u-form u-form-2 add_facility_field">
                    <h4 class="u-text u-text-default u-text-1"> Add Field </h4>
                    <form action="include/Admin.Facility.inc.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="add_facility_field_form" style="padding: 10px;width: 900px;" redirect="true">
                      <div class="wrapper">
                      <?php
                          echo '<div class="u-form-group u-form-select u-form-group-1">';
                          echo '<table id="new_facility_field">
                          <tr>
                              <th>Name</th>
                              <th>Type</th>
                              <th>Description</th>
                          </tr>
                          <tr>
                                  <td style="text-align:center;"><input type="text" placeholder="name of field" id="newIonName" name="name" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" >
                                  <td style="text-align:center;"><select id="newIonenergy" name="type" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white">
                                    <option value="NUMBER">A number or decimal</option>
                                    <option value="VAR">A word or sentence</option>
                                    <option value="DATE">A calendar date</option>
                                  </select></td>';
                                  echo '<td style="text-align:center;"><input type="text" placeholder="short description" id="newIonDesc" name="description" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" >
                                  </td>
                                  <td>
                                  <div class="u-align-left u-form-group u-form-submit">
                                      <a href="#" class="u-btn u-btn-submit u-button-style">Submit</a>
                                      <input type="submit" name="submit_facility_field" value="submit_facility_field" class="u-form-control-hidden">
                                  </div>
                                  </td>
                                  </tr>';
                          echo '</table>';
                          echo '</div>';
                          ?>
                      </div>
                    </form>
                  </div><!--end add facility field sub tab -->
                  <!--edit facility fields sub tab-->
                  <div class="u-form u-form-2 edit_facility_form">
                    <h4 class="u-text u-text-default u-text-1"> Facility Form </h4>
                    <form action="include/Admin.Facility.inc.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="facility_form" id="facility_form" style="padding: 10px;width: 900px;" redirect="true">
                      <div class="wrapper">

                        <?php
                          $table = $gen->getColumnsAlterRequestForm(["facility_id", "affiliation_id"], "facility", "facility", $facility_table_info);
                        ?>

                        <div class="u-align-left u-form-group u-form-submit">
                          <a href="#" class="u-btn u-btn-submit u-button-style">Submit</a>
                          <input type="submit" name="submit_facility_form" value="submit_facility_form" class="u-form-control-hidden">
                        </div>
                      </div>
                    </form>
                  </div><!-- end edit facility sub tab -->
                </div><!-- end facility tab -->
              </div><!-- end tabs -->

              <!-- Javascript for facility tab -->
                  <script src="jquery.js"></script>
                  <script>
                    var table_data = <?php echo json_encode($table)?>;
                    var facility_data = <?php echo json_encode($facility_table)?>;
                      $(document).ready(function() {
                        //hide all sub tabs 
                          hideAddFacility();
                          hideAddFacilityField();
                          hideEditFacilityForm();

                          //when facility changes populate the fields in the form with facility data
                          $("#select-facility-edit").on('change', function() {
                            var selected = 0;
                            //find selected facility
                            for(let x = 0; x < facility_data.length; ++x) {
                              if($(this).val() == facility_data[x]["facility_id"]) {
                                selected = x;
                                break;
                              }
                            }
                            //populate fields with data for the facility
                            for(let x = 0; x < table_data.length; ++x) {
                              if(document.getElementById("facility_" + table_data[x]["Field"]).getAttribute('type') == "hidden") {
                                if(facility_data[selected][table_data[x]["Field"]] == 1) {
                                  $(document.getElementById("facility_" + table_data[x]["Field"])).next('input[type="checkbox"]').prop("checked", true);
                                } else {
                                  $(document.getElementById("facility_" + table_data[x]["Field"])).next('input[type="checkbox"]').prop("checked", false);
                                }
                              }
                              document.getElementById("facility_" + table_data[x]["Field"]).value=facility_data[selected][table_data[x]["Field"]];
                            }
                          }).change();
                      });

                      //hide edit facility sub tab
                      function hideEditFacility() {
                          $(".edit_facility").hide();
                      }

                      // toggle hide/show edit facility sub tab
                      function toggleEditFacility() {
                          if($(".edit_facility").is(":hidden")) {
                              $(".edit_facility").fadeIn(0);
                              hideAddFacility();
                              hideAddFacilityField();
                              hideEditFacilityForm();
                          }
                      }

                      //hide add facility sub tab
                      function hideAddFacility() {
                          $(".add_facility").hide();
                      }

                      // toggle hide/show add facility sub tab
                      function toggleAddFacility() {
                          if($(".add_facility").is(":hidden")) {
                              $(".add_facility").fadeIn(0);
                              hideEditFacility();
                              hideAddFacilityField();
                              hideEditFacilityForm();
                          }
                      }

                      //hide add facility field sub tab
                      function hideAddFacilityField() {
                          $(".add_facility_field").hide();
                      }

                      // toggle hide/show add facility field sub tab
                      function toggleAddFacilityField() {
                          if($(".add_facility_field").is(":hidden")) {
                              $(".add_facility_field").fadeIn(0);
                              hideEditFacility();
                              hideAddFacility();
                              hideEditFacilityForm();
                          }
                      }

                      //hide edit facility form sub tab
                      function hideEditFacilityForm() {
                          $(".edit_facility_form").hide();
                      }

                      // toggle hide/show edit facility form sub tab
                      function toggleEditFacilityForm() {
                          if($(".edit_facility_form").is(":hidden")) {
                              $(".edit_facility_form").fadeIn(0);
                              hideEditFacility();
                              hideAddFacility();
                              hideAddFacilityField();
                          }
                      }

                      //when the remove facility form submits perform clean up
                      $("#remove_facility").submit(function(eventObject){
                        //add facility information for the facility being removed
                        var facility = $("#select-facility-edit").val();
                        var input = document.createElement('input');
                        input.setAttribute('type', "hidden");
                        input.setAttribute('name', "facility_id");
                        input.setAttribute('value', facility);
                        this.prepend(input);
                        
                      });

                      //when the facility form submits perform clean up
                      $("#facility_form").submit(function(eventObject){
                        var rows = $("#facility_form_table tr");
                        rows.splice(0, 1);

                        var list = new Array();
                        var names = new Array();
                        var count = 0;
                        //loop through all the checkboxes and create post information for any unchecked rows
                        for(x = 0; x < rows.length; x++) {
                          var checked = $(rows[x]).closest('tr').find('input:checkbox').is(':checked');
                          //if row is unchecked still make a post entry for it
                          if(!checked) {
                            var name = ($(rows[x].cells[1]).text().toLowerCase()).replaceAll(" ", "_");
                            var input = document.createElement('input');
                            input.setAttribute('type', "hidden");
                            input.setAttribute('name', "form[" + name + "][field_name]");
                            input.setAttribute('value', name);
                            rows[x].prepend(input);
                            count++;
                          }
                        }
                      });

                  </script>
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>
      
    </section>

    <?php
     //add the footer for all pages
        include_once 'footer.php';
    ?>

  </body>
</html>