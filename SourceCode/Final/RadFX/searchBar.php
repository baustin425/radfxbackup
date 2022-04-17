<!DOCTYPE html>
<div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-container-style u-white" >
          <div class="u-form u-form-1">
          <form onsubmit="return false" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="form" id="form" style="padding: 10px;" redirect="true">            
            <div class="u-form-group u-form-group-7">

              <?php
			        //This File Creates The Search Bar and Form for Facility/Ion[] Choice
                include_once 'database.php';
                include_once 'classes/ColumnGenerator.classes.php';
                include_once 'classes/FieldController.classes.php';
				
                $gen = new ColumnGenerator();
                $database = new Database();
                $field_controller = new FieldController();
                
                $conn = $database->connect();//the database connection
                //the column info from the request page
                $sql = $conn->query("SHOW FULL COLUMNS FROM request");
                $request_column_info = $sql->fetchAll(PDO::FETCH_ASSOC);
                $table = "";

                //all the ion information from the database
                $sql = $conn->prepare("SELECT * FROM ion;");
                $sql->execute();
                $ion_table = $sql->fetchAll(PDO::FETCH_ASSOC);
				
                //if an integrator get facility information
                if(isset($_SESSION["role"]) && $_SESSION["role"] > 2) {
                  $sql = $conn->prepare("SELECT * FROM facility;");
                  $sql->execute();
                  $facility_table = $sql->fetchAll(PDO::FETCH_ASSOC);
                  
                }else{
                  $sql = $conn->prepare("SELECT * FROM facility WHERE facility_id = ?;");
                  $sql->execute([$_SESSION['affiliation']]);
                  $facility_table = $sql->fetchAll(PDO::FETCH_ASSOC);
                }

                //get ion column information
                $sql = $conn->query("SHOW FULL COLUMNS FROM ion");
                $ion_column_info = $sql->fetchAll(PDO::FETCH_ASSOC);
                //get all field information for the ion table and sort the ion columns accordingly
                $sql = $conn->prepare("SELECT * FROM fields WHERE table_name = 'ion' ORDER BY order_num ASC;");
                $sql->execute();
                $table_info = $sql->fetchAll(PDO::FETCH_ASSOC);
                $ion_table_info = $gen->reorderEntries($table_info, $ion_column_info, []);
              ?>

              <div class="u-form-group u-form-select u-form-group-1">
                <label for="select-81a6" class="u-label">Facility Search</label>
                <div class="u-form-select-wrapper">
                  <select id="select-81a6" name="facility" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white">
                    <?php
                      //facility select dropdown 						
                      foreach($facility_table as $field) {
                        echo '<option value="',$field["facility_id"],'">',$field["description"],'</option>';
                      }
					  
                    ?>
                    
                  </select>
                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" version="1" class="u-caret"><path fill="currentColor" d="M4 8L0 4h8z"></path></svg>
                </div>
				<?php
					echo 	'<button onclick="getSearchEvents();">Search Events</button>';
					echo	'<button onclick="seeAllEvents();">View All Events</button>' 
				?>
              </div>
              <div class="u-form-group u-form-select u-form-group-1">
              <!--ion search bar-->
                <label for="text-53b6" class="u-label">Ion Search</label>
                <input type="text" placeholder="ion name" id="searchbar" name="searchbar" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white">
              </div>
              <?php
			  
              $energy_table = array();
              $energy_table["other"][0] = "0";
              //loop through the ions for each facility and create ion tables for each
                foreach($facility_table as $field) {
                  echo '<div class="u-form-group u-form-select u-form-group-1 hidden" id="',$field["facility_id"],'">';
                  
                    //generate ion field tale headers
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
                        $gen->getColumnsAsHeader(["ion_id", "facility_id", "energy", "name", "max_energy"], "ion", $ion_column_info, $ion_table_info);
                      }
                    echo'</tr>
                    </thead>
                    <tbody>';
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
                    echo '</tbody>
                    </table>';
                  echo '</div>';
                }
                //create the all ion, ion table
                echo '<div class="u-form-group u-form-select u-form-group-1 hidden" id="other">';
                    //generate ion fields headers for the table
                    echo '<table id="other">
                    <thead>
                    <tr>
                      <th class="sortable">Select</th>
                      <th class="sortable">Name</th>
                      <th class="sortable">Energy(A MEV)</th>';
                      $gen->getColumnsAsHeader(["ion_id", "facility_id", "energy", "name"], "ion", $ion_column_info, $ion_table_info);
                    echo '</tr>
                    </thead>
                    <tbody>';
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
                    echo '</tbody>
                    </table>';
                  echo '</div>';

                  echo '<div class="u-form-group u-form-select u-form-group-1" id="energy_input_div"';
                    echo '<br>';
                    echo "<label for='text-53b6' class='u-label'>Ions labeled with 0 energy require a custom energy amount:</label>"; //label the input field with the fields formatted name
                    echo '<input type="number" placeholder="custom energy amount" id="energy_input" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required>';

                  echo '</div>';
				  echo 	'<button onclick="getSearchEvents();">Search Events</button>';				  
                ?>
              
              <!-- Javascript for searchbar -->
              <script src="jquery.js"></script>
              <script>
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

            
                //hide all ions not belonging to the default facility selected on start up
                $(document).ready(function() {
                  $("#energy_input").prop('required', false);
                  $("#energy_input").prop('disabled', true);
                  $("#energy_input_div").hide();

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
                
                //loops through the visible ions and returns a list of the checked ones
                function setEnergy() {
                  var ion_list= new Array();
                  var count = 0;
                    for(x = 0; x < $rows.length; x++) {
                      var checked = $($rows[x]).closest('tr').find('input:checkbox').is(':checked');
                      if(checked) {
                     
                        var name = $($rows[x]).closest('tr').find('input:checkbox').attr("name").split("][")[0];						
						            name = name.split("[")[1];					 
                        ion_list[count] = name;
                      
                        count++;
                      }
                    }
                    return ion_list;
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
                   
            </form>
            </div>
          </div>
        </div>
