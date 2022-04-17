<?php
/**
 * The request form page
 * @author ETurner
 */
  session_start();
  //check to make sure that the user is an admin, if not kick them to the homepage
    if(!isset($_SESSION["role"]) || $_SESSION["role"] < 1) {
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
    <title>Request</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
<link rel="stylesheet" href="Request.css" media="screen">
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
    <meta property="og:title" content="Request">
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
            if($_GET["error"] == "ion") {
              echo "<p style='font-size:30px;'>Something was wrong with your ion cocktail! Please try again!</P>";
            } else if($_GET["error"] == "request") {
              echo "<p style='font-size:30px;'>Something went wrong with your form! Try again!</P>";
            } else if($_GET["error"] == "input_check") {
              echo "<p style='font-size:30px;'>Avoid using special characters in your input and try again!</P>";
            } else if($_GET["error"] == "deleted") {
              echo "<p style='font-size:30px;'>Your request has been deleted!</P>";
            } else if($_GET["error"] == "event") {
              echo "<p style='font-size:30px;'>A Calendar Event was not created, please contact an admin for assistance or submit the form again.</P>";
            } else if($_GET["error"] == "prepare") {
              echo "<p style='font-size:30px;'>Something went wrong! Try again!</P>";
            } else if($_GET["error"] == "none") {
              echo "<p style='font-size:30px;'>Request submitted successfully!</P>";
            }
          }
      ?>
    
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-container-style u-white">
          <div class="u-form u-form-1">
          <form action="include/Request.inc.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="form" id="form" style="padding: 10px;" redirect="true">            
            <div class="u-form-group u-form-group-7">
              <div id="facility_location"></div>
              <!-- Gather information required to generate all tables -->
              <?php
                include_once 'database.php';
                include_once 'classes/ColumnGenerator.classes.php';
                include_once 'classes/FieldController.classes.php';
                $gen = new ColumnGenerator();
                $database = new Database();
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
                //generate request from
                $table = $gen->getColumns(["request_id", "facility_id", "user_id", "purpose_id", "approved", "retracted", "time_used", "starting_time", "energy_level"], $field_controller->getRequiredFields("request"), "", $request_table_info);

                //get all ions
                $sql = $conn->prepare("SELECT * FROM ion;");
                $sql->execute();
                $ion_table = $sql->fetchAll(PDO::FETCH_ASSOC);
                //get all facilities
                $sql = $conn->prepare("SELECT * FROM facility;");
                $sql->execute();
                $facility_table = $sql->fetchAll(PDO::FETCH_ASSOC);

                //get column information from ion table
                $sql = $conn->query("SHOW FULL COLUMNS FROM ion");
                $ion_column_info = $sql->fetchAll(PDO::FETCH_ASSOC);
                //sort ion table column information
                $sql = $conn->prepare("SELECT * FROM fields WHERE table_name = 'ion' ORDER BY order_num ASC;");
                $sql->execute();
                $table_info = $sql->fetchAll(PDO::FETCH_ASSOC);
                $ion_table_info = $gen->reorderEntries($table_info, $ion_column_info, []);

                //set affiliation information based on users organazation information
                $affiliation_info["name"] = $_SESSION["org_name"];
                $affiliation_info["description"] = $_SESSION["org_description"];
                $affiliation_info["email"] = $_SESSION["org_email"];
                $affiliation_info["number"] = $_SESSION["org_phone"];
              ?>

              <div id="facility_stuff">
                <div class="u-form-group u-form-select u-form-group-1">
                  <!-- facility select dropdown -->
                  <label for="select-81a6" class="u-label">Facility*</label>
                  <div class="u-form-select-wrapper">
                    <select id="select-81a6" name="facility" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white">
                      <?php
                        foreach($facility_table as $field) {
                          echo '<option value="',$field["facility_id"],'">',$field["description"],'</option>';
                        }
                      ?>
                      <option value="other">All Ions</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" version="1" class="u-caret"><path fill="currentColor" d="M4 8L0 4h8z"></path></svg>
                  </div>
                </div>
                <div class="u-form-group u-form-select u-form-group-1">
                   <!-- ion searchbar -->
                  <label for="text-53b6" class="u-label">Ion Search</label>
                  <input type="text" placeholder="ion name" id="searchbar" name="searchbar" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white">
                </div>
                <?php
                $energy_table = array();
                $energy_table["other"][0] = "0";
                //loop through the ions for each facility and create ion tables for each
                  foreach($facility_table as $field) {
                    echo '<div class="u-form-group u-form-select u-form-group-1 hidden" id="',$field["facility_id"],'">';
                    
                    //generate ion field table headers
                      echo '<table id=',$field["facility_id"],'>
                      <thead>
                      <tr>
                        <th class="sortable">Select</th>
                        <th class="sortable">Name</th>
                        <th class="sortable">Energy(A MEV)</th>';
                        //if the facility requires max energy then include the column, otherwise just generate the normal columns
                        if($field["max_energy_required"] == 1) {
                          $gen->getColumnsAsHeader(["ion_id", "facility_id", "energy", "name"], "ion", $ion_column_info, $ion_table_info);
                        } else {
                          $gen->getColumnsAsHeader(["ion_id", "facility_id", "energy", "max_energy", "name"], "ion", $ion_column_info, $ion_table_info);
                        }
                      echo'</thead>
                      </tr>';
                      echo '<tbody>';
                      //generate all ion rows
                      foreach($ion_table as $ion) {
                        if($ion["facility_id"] == $field["facility_id"]) {

                          //if ion is from this facility add it to the associative array
                          if(array_key_exists($ion["facility_id"], $energy_table)) {
                            $check = false;
                            for($x = 0; $x < count($energy_table[$ion["facility_id"]]); $x++) {
                              if($energy_table[$ion["facility_id"]][$x] == $ion["energy"]) {
                                $check = true;
                                break;
                              }
                            }
                            if(!$check) {
                              array_push($energy_table[$ion["facility_id"]], $ion["energy"]);
                              
                              $check = false;
                              for($y = 0; $y < count($energy_table["other"]); $y++) {
                                if($energy_table["other"][$y] == $ion["energy"]) {
                                  $check = true;
                                  break;
                                }
                              }
                              if(!$check) {
                                array_push($energy_table["other"], $ion["energy"]);
                              }
                            }
                          } else {//add all misc ions to the associative array
                            $energy_table[$ion["facility_id"]][0] = $ion["energy"];

                            $check = false;
                            for($x = 0; $x < count($energy_table["other"]); $x++) {
                              if($energy_table["other"][$x] == $ion["energy"]) {
                                $check = true;
                                break;
                              }
                            }
                            if(!$check) {
                              array_push($energy_table["other"], $ion["energy"]);
                            }
                          }

                          //add ion row to table
                          echo '<tr name=',$ion["name"],'>
                              <td style="text-align:center;"><input type="checkbox" id="ionselect" name="ion[',$ion["ion_id"],'][select]"></td>
                              <td style="text-align:center;">',$ion["name"],'</td>';
                              //if energy is 0 then make an input instead of an entry
                              if($ion["energy"] == 0) {
                                echo "<td><input type='number' placeholder='custom energy' id='energy' value='0' class='u-border-1 u-border-grey-30 u-input u-input-rectangle u-white'></td>";
                              }else {
                                echo '<td style="text-align:center;">',$ion["energy"],'</td>';
                              }
                              //if facility requires max energy then display the ions max energy in the max energy column
                              if($field["max_energy_required"] == 1) {
                                echo '<td style="text-align:center;">',$ion["max_energy"],'</td>';
                              }
                              //add additional ion information
                              $gen->getColumnsAsTableEntries(["ion_id", "facility_id", "name", "energy", "max_energy"], $ion, $ion_table_info);
                          echo '
                              </td>
                            </tr>';
                          
                        }
                      }
                      echo "</tbody>";
                      echo '</table>';
                    echo '</div>';
                  }

                  //create the all ion, ion table
                  echo '<div class="u-form-group u-form-select u-form-group-1 hidden" id="other">';
                    //generate ion fields headers for the table
                      echo '<table id="other_table">
                      <thead>
                      <tr>
                        <th class="sortable">Select</th>
                        <th class="sortable">Name</th>
                        <th class="sortable">Energy(A MEV)</th>';
                        $gen->getColumnsAsHeader(["ion_id", "facility_id", "energy", "name"], "ion", $ion_column_info, $ion_table_info);
                      echo '</thead>
                      </tr>';
                      echo '<tbody>';
                      //loop through the entire array of ions and put them in the all ion table
                      foreach($ion_table as $ion) {
                            echo '<tr>
                              <td style="text-align:center;"><input type="checkbox" id="ionselect" name="',$ion["facility_id"],'"></td>
                              <td style="text-align:center;">',$ion["name"],'</td>';
                              //if energy is 0 then make an input instead of an entry
                              if($ion["energy"] == 0) {
                                echo "<td><input type='number' placeholder='custom energy' id='energy' value='0' class='u-border-1 u-border-grey-30 u-input u-input-rectangle u-white'></td>";
                              }else {
                                echo '<td style="text-align:center;">',$ion["energy"],'</td>';
                              }
                              //display max energy requirement for all ions
                              echo '<td style="text-align:center;">',$ion["max_energy"],'</td>';
                              //add additional ion information
                              $gen->getColumnsAsTableEntries(["ion_id", "facility_id", "name", "energy", "max_energy"], $ion, $ion_table_info);
                            echo '
                              </td>
                            </tr>';
                      }
                      echo '</tbody>';
                      echo '</table>';
                    echo '</div>';

                    echo '<div class="u-form-group u-form-select u-form-group-1" id="energy_input_div"';
                      echo '<br>';
                      echo "<label for='text-53b6' class='u-label'>Ions labeled with 0 energy require a custom energy amount:</label>"; //label the input field with the fields formatted name
                      echo '<input type="number" placeholder="custom energy amount" id="energy_input" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required>';

                    echo '</div>';
                  ?>
                </div>
              
              <!-- Javascript for request page -->
              <script src="jquery.js"></script>
              <script>
                var ion_data = <?php echo json_encode($ion_table)?>;//the ion table information
                var affiliation_info = <?php echo json_encode($affiliation_info)?>;//the affiliation information

                //if the ion checkbox is clicked
                $('input[id="ionselect"]').change(function(){
                  var facility = $("#select-81a6").val();//currently selected facility
                  //if all ion table showing then switch to the facility of the selected ion and hide all other ions
                  if(facility == "other")
                  {
                    var name = $(this).attr("name");
                    var input = $(this).closest('tr').find('input[type="text"]');
                    $("#select-81a6").val(name);
                    $(".hidden").hide();
                    $(".hidden :input").prop("disabled", true);
                    $("#" + $("#select-81a6").val()).fadeIn(700);
                    $("#" + $("#select-81a6").val() + " :input[type='checkbox']").prop("disabled", false);
                    $('[name='+input.attr("id")+']').prop("checked", true);
                  } else {
                    //set required and disabled based on if the box is being checked or unchecked
                    var checked = $(this).is(':checked');
                    var input = $(this).closest('tr').find('input[type="number"]');
                    input.prop('required', checked);
                    input.prop('disabled', !checked);
                  }
                })

                //loop through ions and only show ones with letters input into the search bar
                function searchIons($search_bar) {
                  var val = $($search_bar).val().trim().toLowerCase();
                    for(x = 0; x < $rows.length; x++) {

                      var text = $($rows[x].cells[name_col]).text().toLowerCase();
                      if(text.indexOf(val)) {
                        $($rows[x]).hide();
                      } else {
                        $($rows[x]).show();
                      }
                    }
                }

              //get ion rows for currently selected facility
              var $rows = $('#' + $("#select-81a6").val() +' tr');
              var name_col;
              var energy_col;
              var max_energy_col;
              //loop through the field headers and determine which ones are the name, energy, and max energy columns
              for($x = 0; $x < $rows[0].cells.length; $x++) {
                if($($rows[0].cells[$x]).text() == "Name") {
                  name_col = $x;
                }
                if($($rows[0].cells[$x]).text() == "Energy(A MEV)") {
                  energy_col = $x;
                }
                if($($rows[0].cells[$x]).text() == "Max Energy") {
                  max_energy_col = $x;
                }
              }
              //remove the headers
              $rows.splice(0, 1);
              //whenever something changes in search bar adjust visable ion rows
                $('#searchbar').keyup(function() {
                  searchIons(this);
                });

                var $shifts = $('#shift td');

                //hide all ions not belonging to the default facility selected on start up
                $(document).ready(function() {
                  $("#facility_stuff").appendTo($("#facility_and_ion_table"));//add ion table to form at placeholder

                  $("#energy_input").prop('required', false);
                  $("#energy_input").prop('disabled', true);
                  $("#energy_input_div").hide();

                  //prefill affiliation info into the form
                  if(affiliation_info["name"] != "") {
                    $("#affiliation_name").val(affiliation_info["name"]);
                    $("#affiliation_description").val(affiliation_info["description"]);
                    $("#affiliation_email").val(affiliation_info["email"]);
                    $("#affiliation_phone_number").val(affiliation_info["number"]);
                  }

                  //when the facility changes hide/reveal appropriate ions and disable any hidden ions so they are not submitted
                  $("#select-81a6").on('change', function() {
                    $rows = $('#' + $("#select-81a6").val() +' tr');
                    $rows.splice(0, 1);
                    $(".hidden").hide();
                    $(".hidden :input").prop("disabled", true);
                    $("#" + $(this).val()).fadeIn(700);
                    $("#" + $(this).val() + " :input[type='number']").prop("disabled", false);
                    $("#" + $(this).val() + " :input[type='checkbox']").prop("disabled", false);
                    $("#" + $(this).val() + " :input[type='checkbox']").prop("checked", false);
                    searchIons('#searchbar');
                  }).change();

                });
              

                //preform cleanup before submitting the form
                $("#form").submit(function(event){
                        var facility = $("#select-81a6").val();//currently selected facility
                        //make sure a facility is selected
                        if(facility == "other")
                        {
                            event.preventDefault();
                            alert("You must select a facility!");
                        }

                        //make sure a shift is selected
                        var shift_num = checkShifts();
                        if(shift_num == -1) {
                          alert("Please select a shift");
                          event.preventDefault();
                          return;
                        }

                        //make sure total hours is above 0
                        if(parseInt($("#total_hours").val()) <= 0) {
                          alert("Total hours must be a postive number");
                          event.preventDefault();
                          return;
                        }
                        
                        //compare ion energy to max energy and block if it is required and one of the ions is above the max energy of another
                        var energy_value = getHighestEnergy();
                        var energy = parseInt(energy_value, 10);
                        if(energy < 0) {
                          alert("You must select an ion");
                          event.preventDefault();
                          return;
                        } else if(energy == 0) {
                          energy =  $("#energy_input").val();
                          if(!checkIonMaxEnergy(energy)) {
                            alert("A selected ion exceeds the max energy of another");
                            event.preventDefault();
                            return;
                          }
                        } else {
                          if(!checkIonMaxEnergy(energy)) {
                            alert("A selected ion exceeds the max energy of another");
                            event.preventDefault();
                            return;
                          }
                        }

                        //add energy of highest energy ion to the form as a hidden field
                        var input = document.createElement('input');
                        input.setAttribute('type', "hidden");
                        input.setAttribute('name', "energy_level");
                        input.setAttribute('value', energy);
                        this.prepend(input);

                        //add selected ions ot the post info
                        var ion_list = setEnergy();
                        for($x = 0; $x < ion_list.length; $x++) {
                          input = document.createElement('input');
                          input.setAttribute('type', "hidden");
                          input.setAttribute('name', ion_list[$x][0]);
                          input.setAttribute('value', ion_list[$x][1]);
                          form.prepend(input);
                        }

                        //remove the shift field and add the boxes to the post info
                        $(this).children('#shift').remove();
                        $("#shift").prop('disabled', true);
                        disableShifts();
                        input = document.createElement('input');
                        input.setAttribute('type', "hidden");
                        input.setAttribute('name', "shift");
                        input.setAttribute('value', shift_num);
                        this.prepend(input);
 
                        //remove the searchbar so its not added to the post info
                        $(this).children('#searchbar').remove();
                });

                //compare energy levels of selected ions to determine compatability
                function checkIonMaxEnergy(energy) {
                  var $row_heads = $('#' + $("#select-81a6").val() +' tr');
                  var check = false;
                  //find max energy column
                  for($x = 0; $x < $row_heads[0].cells.length; $x++) {
                    if($($row_heads[0].cells[$x]).text() == "Max Energy") {
                      max_energy_col = $x;
                      check = true;
                    }
                  }
                  //if no max energy column then return true
                  if(!check) { return true; }
                  var val;
                  var matching = true;
                  //compare all ions to find lowest max energy and compare it to highest energy supplied
                    for(x = 0; x < $rows.length; x++) {
                      var checked = $($rows[x]).closest('tr').find('input:checkbox').is(':checked');
                      if(checked) {
                        val = parseInt($($rows[x].cells[max_energy_col]).text(), 10);
                        if(val < energy) {
                          matching = false;
                          return false;
                        }
                      }
                    }

                    return matching;
                }

                //find the ion with the highest energy level
                function getHighestEnergy() {
                  var val = -1;
                  //loop through ions to find highest energy selected ion
                    for(x = 0; x < $rows.length; x++) {
                      var checked = $($rows[x]).closest('tr').find('input:checkbox').is(':checked');
                      if(checked) {
                        var curr_val;
                        if($($rows[x].cells[energy_col]).find('input').val() == undefined) {
                          curr_val = $($rows[x].cells[energy_col]).text();
                        } else {
                          curr_val = $($rows[x].cells[energy_col]).find('input').val();
                        }
                        if(val == null) {
                          val = curr_val;
                        } else {
                          if(curr_val > val) {
                            val = curr_val;
                          }
                        }
                      }
                    }

                    return val;
                }

                //set the energy for each ion in the post info
                function setEnergy() {
                  var ion_list = new Array();
                  var count = 0;
                    for(x = 0; x < $rows.length; x++) {
                      var checked = $($rows[x]).closest('tr').find('input:checkbox').is(':checked');
                      if(checked) {
                        var curr_val;
                        if($($rows[x].cells[energy_col]).find('input').val() == undefined) {
                          curr_val = $($rows[x].cells[energy_col]).text();
                        } else {
                          curr_val = $($rows[x].cells[energy_col]).find('input').val();
                        }
                        var name = $($rows[x]).closest('tr').find('input:checkbox').attr("name").split("select")[0] + "energy]";
                        ion_list[count]=new Array();
                        ion_list[count][0] = name;
                        ion_list[count][1] = curr_val;
                        count++;
                      }
                    }

                    return ion_list;
                }

                //confirm a shift is selected
                function checkShifts() {
                  var val = "";
                  var confirmed = false;
                    for(x = 0; x < $shifts.length; x++) {
                      var checked = $($shifts[x]).closest('td').find('input:checkbox').is(':checked');
                      if(checked) {
                        val += "1";
                        confirmed = true;
                      } else {
                        val += "0";
                      }
                    }

                    if(confirmed) {
                      return val;
                    } else {
                      return -1;
                    }
                }

                //remove shifts from the post info
                function disableShifts() {
                  var val = "";
                  for(x = 0; x < $shifts.length; x++) {
                      var box = $($shifts[x]).closest('td').find('input:checkbox');
                      box.prop('disabled', true);
                    }
                }

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

              <div class="u-align-left u-form-group u-form-submit">
                <a href="#" class="u-btn u-btn-submit u-button-style">Submit</a>
                <input type="submit" name="submit" value="submit" class="u-form-control-hidden">
              </div>            
            </form>
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
