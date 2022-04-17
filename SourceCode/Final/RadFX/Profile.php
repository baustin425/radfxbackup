<?php
  session_start();
  if(!isset($_SESSION["role"]) || $_SESSION["role"] < 1) {
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
    <title>Profile</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
  <link rel="stylesheet" href="Profile.css" media="screen">
  <link
      href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css"
      rel="stylesheet"
    />
    <script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 4.3.3, nicepage.com">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
    
    
    
    
    
    
    
    
    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": ""}
  </script>
    <script>
      function editTabP(){
        $(document).ready(function(){
          console.log('Test');
          
          $a = document.getElementById("link-tab-0da5");
          $a.classList.remove('active');
          $a.setAttribute("aria-selected", false);
          $b = document.getElementById("tab-0da5");
          $b.classList.remove('u-tab-active');
          
          $c = document.getElementById("tab-93fc");
          $c.classList.add('u-tab-active');
          $d = document.getElementById("link-tab-93fc");
          $d.classList.add('active');
          $d.setAttribute("aria-selected", true);
          
          $sel = document.getElementById("edit_options");
          $sel.value = "pass";
          display($sel);
        
        });
      }
    </script>
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="Profile">
    <meta property="og:type" content="website">
  </head>
  <body class="u-body">
    <?php
        include_once 'header.php';
        include_once 'database.php';  

        include "classes/Profile.classes.php";     
        $profile = new Profile($_SESSION['loggedin'], $_SESSION['name'], $_SESSION['id'], $_SESSION['role']);       
        $profile->getSplitRequests();
    ?>
    <section class="u-align-center u-clearfix u-image u-shading u-section-1" src="" data-image-width="474" data-image-height="316" id="sec-89ea">
    <script src="jquery.js"></script>
    
    <?php
          if(isset($_GET["error"])) {
            if($_GET["error"] == "prepare") {
              echo "<p style='font-size:30px;'>Something went wrong! Try again!</P>";
            } else if($_GET["error"] == "insert") {
              echo "<p style='font-size:30px;'>Something went wrong! Try again!</P>";
            } else if($_GET["error"] == "preg") {
              echo "<p style='font-size:30px;'>New Password doesnt meet requirements!</P>";
              echo '<script> editTabP() </script>';
            } else if($_GET["error"] == "verify") {
              echo "<p style='font-size:30px;'>Old passwords don't match, please try again!</P>";
              echo '<script> editTabP() </script>';
            } else if($_GET["error"] == "editname") {
              echo "<p style='font-size:30px;'>Something went wrong! Try again!</P>";
            } 
          } else if(isset($_GET['success'])){
            if($_GET["success"] == "priority") {
              echo "<p style='font-size:30px;'>Priority Changed Successfully</P>";
            } else if($_GET["success"] == "name") {
              echo "<p style='font-size:30px;'>Name Changed Successfully</P>";
            } else if($_GET["success"] == "password") {
              echo "<p style='font-size:30px;'>Password Changed Successfully</P>";
            } else if($_GET["success"] == "organization") {
              echo "<p style='font-size:30px;'>Organization Changed Successfully</P>";
            }
          }
          //  debug echo
          //echo ''. $_SESSION['activetab'] .'';
          //echo ''. $_SESSION['testing'] .'';
          //un: #CAC9C9 ap: #083448 p1:#E6783D p2: #C7430A p3: #C2C200 p4: #FFF700 p5: #0C850A p6: #00FF00 TAMU: #FFFF00 NASA: Berkley:
      ?>
      <div class="u-clearfix u-sheet u-sheet-1">
        <!--<img class="u-image u-image-default u-preserve-proportions u-image-1" src="images/download2.jpg" alt="" data-image-width="474" data-image-height="474"> -->
        <div id="tabs" class="u-expanded-width u-tab-links-align-left u-tabs u-tabs-1">
          <ul class="u-border-2 u-border-palette-1-base u-spacing-10 u-tab-list u-unstyled" role="tablist">
            <li id="1" class="u-tab-item" role="presentation">
              <a class="active u-active-palette-1-base u-button-style u-grey-10 u-tab-link u-text-active-white u-text-black u-tab-link-1" id="link-tab-0da5" href="#tab-0da5" role="tab" aria-controls="tab-0da5" aria-selected="false">Requests</a>
            </li>
            <li id="2" class="u-tab-item" role="presentation">
              <a class="u-active-palette-1-base u-button-style u-grey-10 u-tab-link u-text-active-white u-text-black u-tab-link-3" id="link-tab-2917" href="#tab-2917" role="tab" aria-controls="tab-2917" aria-selected="false">Messenger</a>
            </li>
            <li id="3" class="u-tab-item u-tab-item-4" role="presentation">
              <a class="u-active-palette-1-base u-button-style u-grey-10 u-tab-link u-text-active-white u-text-black u-tab-link-4" id="link-tab-93fc" href="#tab-93fc" role="tab" aria-controls="tab-93fc" aria-selected="false">Edit Profile</a>
            </li>
          </ul>
          <div class="u-tab-content">
            <div class="u-container-style u-tab-pane u-tab-active u-white u-tab-pane-1" id="tab-0da5" role="tabpanel" aria-labelledby="link-tab-0da5">
              <div class="u-container-layouts u-valign-top u-container-layout-1">
                <!-- Removed u-table-responsive because it caused horizontal scrollbar to not work -->
                <div class="u-expanded-width u-table u-table-1">
                  <?php
                  if($_SESSION['role'] > 1){
                  ?>
                  <div style="margin: 0 auto; margin-bottom: 25px;">
                    <table class="u-table-entity" style="height: 100%; overflow: auto; margin: 0 auto;">
                              
                      <tbody class="u-table-body">
                        <tr style="height: 51px;">
                          <th class="u-table-cell" style="white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Unapproved</th>
                          <th  class="u-table-cell" style="white-space: nowrap; text-align: center; min-width: 14%; max-width: 60%">Approved</th>
                          <th  class="u-table-cell" style="white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Priority 1</th>
                          <th  class="u-table-cell" style="white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Priority 2</th>
                          <th class="u-table-cell" style="white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Priority 3</th>
                          <th  class="u-table-cell" style="white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Priority 4</th>
                          <th  class="u-table-cell" style="white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Priority 5</th>
                          <th class="u-table-cell" style="white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Priority 6</th>
                          <th class="u-table-cell" style="white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Conflict</th>
                        </tr>
                        <tr>
                          <td style="text-align: center;"><input type="color" value="#484848" name="legend" readonly></td>
                          <td style="text-align: center;"><input type="color" value="#083448" name="legend" readonly></td>
                          <td style="text-align: center;"><input type="color" value="#E6783D" name="legend" readonly></td>
                          <td style="text-align: center;"><input type="color" value="#C7430A" name="legend" readonly></td>
                          <td style="text-align: center;"><input type="color" value="#C2C200" name="legend" readonly></td>
                          <td style="text-align: center;"><input type="color" value="#FFF700" name="legend" readonly></td>
                          <td style="text-align: center;"><input type="color" value="#0C850A" name="legend" readonly></td>
                          <td style="text-align: center;"><input type="color" value="#00FF00" name="legend" readonly></td>
                          <td style="text-align: center;"><input type="color" value="#FF0000" name="legend" readonly></td>
                        <tr>
                      </tbody>
                    </table>
                  </div>
                  <?php
                  }
                  if(isset($_SESSION['requests'])){
                    
                    $database = new Database();
                    $sql = $database->connect()->prepare("SELECT * FROM ion;");
                    $sql->execute();
                    $ion_table = $sql->fetchAll(PDO::FETCH_ASSOC);

                    if($_SESSION['requests'][0] != null){
                        $req = $_SESSION['requests'][0];

                        if($_SESSION['role'] == 1){
                          echo '
                        <div style="margin-bottom: 25px;">
                          <table style="width: 10%; height: 100%; overflow: auto; border-collapse: collapse;">      
                            <tbody class="u-table-body">
                              <tr style="height: 51px;">
                                <th class="u-table-cell" style="white-space: nowrap; text-align: center; min-width: 14%; max-width: 50%">Unapproved</th>
                                <th  class="u-table-cell" style="white-space: nowrap; text-align: center; min-width: 14%; max-width: 50%">Approved</th>
                              </tr>
                              <tr>
                                <td style="text-align: center;"><input type="color" value="#CAC9C9" name="legend" readonly></td>
                                <td style="text-align: center;"><input type="color" value="#083448" name="legend" readonly></td>
                              <tr>
                            </tbody>
                          </table>
                        </div>';
                          echo '
                          <table class="u-table-entity" style="height: 100%; overflow: auto;">
                            
                            <tbody class="u-table-alt-grey-5 u-table-body">
                              <tr style="height: 51px;">
                                <th class="u-table-cell" style="font-weight: bold; text-align: center; min-width: 14%; max-width: 40%">Request ID</th>
                                <th  class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 30%; max-width: 60%">Description of Test</th>
                                <th  class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Ion/Energy</th>
                                <th  class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Date/Time : From/To</th>
                                <th class="u-table-cell" style="font-weight: bold; text-align: center; min-width: 14%; max-width: 40%">Total Hours</th>
                                <th  class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Location</th>
                                <th  class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Edit Link</th>
                              </tr>';
                          for($x = 0; $x < count($req); $x++){
                            if($req[$x][count($req[$x])-2] == "No Calendar Event"){
                              echo '
                                <tr style="height: 51px;text-align:center; color:purple;">';
                            } else if($req[$x][count($req[$x])-4] == "Not Approved"){
                              echo '
                                <tr style="height: 51px;text-align:center; color:#484848">';
                            } else if($req[$x][count($req[$x])-4] == "Approved"){
                              echo '
                                <tr style="height: 51px;text-align:center; color:#083448;">';
                            }

                            for($y = 0; $y < count($req[$x]); $y++){
                              //if this is the request ion column
                              if($y == 1){
                                echo '
                                  <td class="u-table-cell" style="white-space: nowrap; min-width: 30%;">'. $req[$x][$y] .'</td>';
                              } else if($y == 2) {
                                //convert comma seperation strin of ion ids to array
                                $ion_array = explode(",", $req[$x][$y]);
                                $energy_array = explode(",", $req[$x][$y+1]);
                                
                                $ion_names = "";
                                //loop through array and create string of ion names by converting the ion ids
                                $en = 0;
                                foreach($ion_table as $ion) {
                                  if(in_array($ion["ion_id"], $ion_array)) { 
                                    $ion_names .= $ion["name"]."-".$energy_array[$en]." ";
                                    $en++;
                                  }
                                  
                                }
                                //display ion names
                                echo '<td class="u-table-cell" style="">'.$ion_names .'</td>';
                              } else if($y == 3){

                              } else if($y == 4){
                                echo '<td class="u-table-cell;" style="white-space: nowrap">';
                                for($t = 0; $t < count($req[$x][$y]); $t++){
                                  echo ''.($t+1).': From: '. $req[$x][$y][$t][0] .'<br>To: '.$req[$x][$y][$t][1].'<br>';
                                }
                                echo '</td>';
                              } else if($y == 6){
                                if(isset($req[$x][10])){
                                  echo '
                                    <td class="u-table-cell;" style="color: '.$req[$x][11].'; -webkit-text-stroke-width: .25px;
                                    -webkit-text-stroke-color: black;">'. $req[$x][$y] .'</td>';
                                } else {
                                    echo '
                                    <td class="u-table-cell;">'. $req[$x][$y] .'</td>';
                                }
                              } else if($y == 7){
                                  echo '
                                  <td class="u-table-cell"><a href="./'. $req[$x][$y] .'">Click To Edit Request</a></td>';
                              } else if($y == 8){

                              } else if($y == 9){

                              } else if($y == 10){

                              } else if($y == 11){

                              } else {
                                  echo '
                                  <td class="u-table-cell;">'. $req[$x][$y] .'</td>';
                              }
                            
                            }
                          }
                          echo '  
                            </tbody>
                          </table>';
                        } else if($_SESSION['role'] == 2){
                          echo '<form action="include/Profile.inc.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-inner-form" name="form" id="form" redirect="true">';
                          echo '
                          <table class="u-table-entity" style="height: 100%; overflow: auto;">
                            
                            <tbody class="u-table-alt-grey-5 u-table-body">
                              <tr style="height: 51px;">
                                <th class="u-table-cell" style="font-weight: bold;; text-align: center; min-width: 14%; max-width: 40%">Request ID</th>
                                <th class="u-table-cell" style="font-weight: bold; text-align: center; min-width: 14%; max-width: 40%">Current Priority</th>
                                <th class="u-table-cell" style="font-weight: bold; text-align: center; min-width: 14%; max-width: 40%">Priority Change<br>(0-6)</th>
                                <th  class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Date/Time : From/To</th>
                                <th class="u-table-cell" style="font-weight: bold; text-align: center; min-width: 14%; max-width: 40%">Total Hours</th>
                                <th  class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Location</th>
                                <th  class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 30%; max-width: 60%">Description of Test</th>
                                <th  class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Ion/Energy</th>
                              </tr>';
                          $pBool = false;
                          for($x = 0; $x < count($req); $x++){
                            if($req[$x][count($req[$x])-2] == "No Calendar Event"){
                              echo '
                                <tr style="height: 51px;text-align:center; color:purple">';
                                $pBool = false;
                            } else if($req[$x][count($req[$x])-4] == "Not Approved"){
                              echo '
                                <tr style="height: 51px;text-align:center; color:#484848;">';
                                $pBool = true;
                            } else if($req[$x][count($req[$x])-4] == "Approved"){
                              echo '
                                <tr style="height: 51px;text-align:center; color:#083448;">';
                                $pBool = true;
                            }

                            for($y = 0; $y < count($req[$x]); $y++){
                              //if this is the request ion column
                              if($y == 0) echo '<td class="u-table-cell;">'. $req[$x][$y] .'</td>';
                              else if($y == 1){
                                if(isset($req[$x][10])){
                                  echo '
                                    <td class="u-table-cell;" style="color: '.$req[$x][10].'">'. $req[$x][9] .'</td>';
                                } else {
                                    echo '
                                    <td class="u-table-cell;">'. $req[$x][9] .'</td>';
                                }
                              } else if($y == 2) {
                                if($pBool){
                                  echo '
                                        <td class="u-table-cell;" style="text-align: center;"><input type="number" style="width: 100%; text-align: center" value="'.$req[$x][9].'" name="'.$req[$x][0].'" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" onchange="match(this)"></td>';
                                }
                                
                                
                              } else if($y == 3){
                                echo '<td class="u-table-cell;" style="white-space: nowrap">';
                                for($t = 0; $t < count($req[$x][4]); $t++){
                                  echo ''.($t+1).': From: '. $req[$x][4][$t][0] .'<br>To: '.$req[$x][4][$t][1].'<br>';
                                }
                                echo '</td>';
                              } else if($y == 4){
                                echo '<td class="u-table-cell;">'. $req[$x][5] .'</td>';
                              } else if($y == 5){
                                if(isset($req[$x][10])){
                                  echo '
                                    <td class="u-table-cell;" style="color: '.$req[$x][11].'; -webkit-text-stroke-width: .25px;
                                    -webkit-text-stroke-color: black;">'. $req[$x][6] .'</td>';
                                } else {
                                    echo '
                                    <td class="u-table-cell;">'. $req[$x][$y] .'</td>';
                                }
                              } else if($y == 6){
                                echo '
                                  <td class="u-table-cell" style="white-space: nowrap; min-width: 30%;">'. $req[$x][1] .'</td>';
                              } else if($y == 7){
                                //convert comma seperation strin of ion ids to array
                                $ion_array = explode(",", $req[$x][2]);
                                $energy_array = explode(",", $req[$x][3]);
                                
                                $ion_names = "";
                                //loop through array and create string of ion names by converting the ion ids
                                $en = 0;
                                foreach($ion_table as $ion) {
                                  if(in_array($ion["ion_id"], $ion_array)) { 
                                    $ion_names .= $ion["name"]." -".$energy_array[$en]."<br>";
                                    $en++;
                                  }
                                  
                                }
                                //display ion names
                                echo '<td class="u-table-cell" style="">'.$ion_names .'</td>';
                              }
                            
                            }

                            echo '</tr>';
                          }
                            echo '  
                            </tbody>
                          </table>';
                          echo '<input type="password" placeholder="Enter your password" id="pass" name="password" style="margin-top: 12px;" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
                          
                            <div class="wrapper">
                              <div class="u-align-left u-form-group u-form-submit">
                                <input type="submit" name="prio_submit" value="Submit" class="u-btn u-btn-submit u-button-style">
                              </div>
                            </div>
                          </form>';
                        } else if($_SESSION['role'] == 3){
                          echo '<form action="include/Profile.inc.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-inner-form" name="form" id="form" redirect="true">';
                          echo '
                          <table class="u-table-entity" style="height: 100%; overflow: auto;">
                            
                            <tbody class="u-table-alt-grey-5 u-table-body">
                              <tr style="height: 51px;">
                              <th class="u-table-cell" style="font-weight: bold;; text-align: center; min-width: 14%; max-width: 40%">Request ID</th>
                              <th class="u-table-cell" style="font-weight: bold; text-align: center; min-width: 14%; max-width: 40%">Current Priority</th>
                              <th class="u-table-cell" style="font-weight: bold; text-align: center; min-width: 14%; max-width: 40%">Priority Change<br>(0-6)</th>
                              <th  class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Date/Time : From/To</th>
                              <th class="u-table-cell" style="font-weight: bold; text-align: center; min-width: 14%; max-width: 40%">Total Hours</th>
                              <th  class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Location</th>
                              <th  class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 30%; max-width: 60%">Description of Test</th>
                              <th  class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Ion/Energy</th>
                            </tr>';
                          $pBool = false;
                          for($x = 0; $x < count($req); $x++){
                            if($req[$x][count($req[$x])-2] == "No Calendar Event"){
                              echo '
                                <tr style="height: 51px;text-align:center; color:purple;">';
                                $pBool = false;
                            } else if($req[$x][count($req[$x])-4] == "Not Approved"){
                              echo '
                                <tr style="height: 51px;text-align:center; color:#484848">';
                                $pBool = true;
                            } else if($req[$x][count($req[$x])-4] == "Approved"){
                              echo '
                                <tr style="height: 51px;text-align:center; color:#083448;">';
                                $pBool = true;
                            }

                            for($y = 0; $y < count($req[$x]); $y++){
                              //request id
                              if($y == 0) echo '<td class="u-table-cell;">'. $req[$x][$y] .'</td>';
                              else if($y == 1){ //Priority
                                if(isset($req[$x][10])){
                                  echo '
                                    <td class="u-table-cell;" style="color: '.$req[$x][10].';  -webkit-text-stroke-width: .25px;
                                    -webkit-text-stroke-color: black;">'. $req[$x][9] .'</td>';
                                } else {
                                    echo '
                                    <td class="u-table-cell;">'. $req[$x][9] .'</td>';
                                }
                              } else if($y == 2) { //priority change
                                if($pBool){
                                  echo '
                                        <td class="u-table-cell;" style="text-align: center;"><input type="number" style="width: 100%; text-align: center" value="'.$req[$x][9].'" name="'.$req[$x][0].'" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" onchange="match(this)"></td>';
                                }
                                
                                
                              } else if($y == 3){ //event dates
                                echo '<td class="u-table-cell;" style="white-space: nowrap">';
                                for($t = 0; $t < count($req[$x][4]); $t++){
                                  echo ''.($t+1).': From: '. $req[$x][4][$t][0] .'<br>To: '.$req[$x][4][$t][1].'<br>';
                                }
                                echo '</td>';
                              } else if($y == 4){ //hours
                                echo '<td class="u-table-cell;">'. $req[$x][5] .'</td>';
                              } else if($y == 5){ //facility
                                if(isset($req[$x][11])){
                                  echo '
                                    <td class="u-table-cell;" style="color: '.$req[$x][11].'; -webkit-text-stroke-width: .25px;
                                    -webkit-text-stroke-color: black;">'. $req[$x][6] .'</td>';
                                } else {
                                    echo '
                                    <td class="u-table-cell;">'. $req[$x][$y] .'</td>';
                                }
                              } else if($y == 6){ //request description
                                echo '
                                  <td class="u-table-cell" style="white-space: nowrap; min-width: 30%;">'. $req[$x][1] .'</td>';
                              } else if($y == 7){ //ions/energy
                                //convert comma seperation strin of ion ids to array
                                $ion_array = explode(",", $req[$x][2]);
                                $energy_array = explode(",", $req[$x][3]);
                                
                                $ion_names = "";
                                //loop through array and create string of ion names by converting the ion ids
                                $en = 0;
                                foreach($ion_table as $ion) {
                                  if(in_array($ion["ion_id"], $ion_array)) { 
                                    $ion_names .= $ion["name"]."- ".$energy_array[$en]."<br>";
                                    $en++;
                                  }
                                }
                                //display ion names
                                echo '<td class="u-table-cell" style="">'.$ion_names.'</td>';
                              }
                            }
                            echo '</tr>';
                          }
                          echo '  
                            </tbody>
                          </table>';
                          echo '<input type="password" placeholder="Enter your password" id="pass" name="password" style="margin-top: 12px;" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
                          
                            <div class="wrapper">
                              <div class="u-align-left u-form-group u-form-submit">
                                <input type="submit" name="prio_submit" value="Submit" class="u-btn u-btn-submit u-button-style">
                              </div>
                            </div>
                          </form>';
                          
                        }
                      } else {
                        echo '
                        <table class="u-table-entity" style="height: 100%; overflow: auto;">
                          
                          <tbody class="u-table-alt-grey-5 u-table-body">
                            <tr style="height: 51px;">
                              <th class="u-table-cell" style="font-weight: bold; text-align: center; max-width: 40%">Request ID</th>
                              <th  class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 30%; max-width: 60%">Description of Test</th>
                              <th  class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Ion/Energy</th>
                              <th  class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Datetime</th>
                              <th class="u-table-cell" style="font-weight: bold; text-align: center; min-width: 14%; max-width: 40%;">Total Hours</th>
                              <th  class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Location</th>
                              <th  class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Edit Link</th>
                              <th class="u-table-cell" style="font-weight: bold; white-space: nowrap; text-align: center; min-width: 14%; max-width: 40%">Current Proirity</th>
                            </tr>';
                            echo '  
                        </tbody>
                      </table>';
                      }
                  } 
                  ?>
                </div>
              </div>
            </div>
           <div class="u-container-style u-tab-pane u-white u-tab-pane-2" id="tab-2917" role="tabpanel" aria-labelledby="link-tab-2917">
              <div class="u-container-layout u-container-layout-3" style="text-align:center;">
                <div class="u-form u-form-2">
                  <form action="include/contact.inc.php" method="POST" name="form" source="custom" style="padding: 10px;" redirect="true">
                    <div class="u-form-group u-form-group-7" style="min-height: 60px;" >
                      <?php
                      
                      include_once "database.php";
                      include_once "classes/UserGatherer.classes.php";

                      $gatherer = new UserGatherer();
                      
                      $users = $gatherer->getAllUsers("location: ../profile.php");
                      echo "
                      <select id='contact_list' style='min-height: 60px; overflow: auto;' name='contactlist[]' class='u-border-1 u-border-grey-30 u-input u-input-rectangle u-white' style='resize: vertical;' onchange='selectFirst(this.value);' required>";
                      
                      for($x = 0; $x < count($users); $x++) {
                        $email = $users[$x]["email"];
                        $id = $users[$x]["user_id"];
                        //if so, the select does not include current user
                        if($_SESSION['name'] == $users[$x]["email"]){
                          continue;
                        } else {
                          echo '<option value='.$id.'>'. $users[$x]['first_name']. ' ' . $users[$x]['last_name'] .'</option>';
                          //added the sub option because email is cut off by screen size
                          echo '<option style="background:#eeeeee" value='.$id.', 1'.'>&nbsp;⮡ &nbsp;'. 'Email: ' . $email .'</option>';
                        }
                      }
                        echo 
                      '</select>';
                      
                      ?>
                    </div>
                    <div class="u-form-group u-form-group-7">
                      <input type="text" placeholder="Enter Subject Here" id="text-0007" name="subject" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required>
                    </div>
                    <div class="u-form-group u-form-group-7">
                      <textarea type="text" placeholder="Enter Message Here" id="text-0008" name="message" class="u-border-1 u-border-grey-30 u-input-1 u-input-rectangle u-white" style="min-height: 400px; resize: vertical" required></textarea>
                    </div>
                    <div class="u-align-left u-form-group u-form-submit">
                      <a href="#" class="u-btn u-btn-submit u-button-style">Send</a>
                      <input type="submit" name="submit" value="submit" class="u-form-control-hidden">
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="u-container-style u-tab-pane u-white u-tab-pane-3" id="tab-93fc" role="tabpanel" aria-labelledby="link-tab-93fc">
              <div class="u-container-layouts u-valign-top u-container-layout-1">
                <?php 
                include_once "database.php";
                include_once "classes/Profile.classes.php";

                $profile = new Profile($_SESSION['loggedin'], $_SESSION['name'], $_SESSION['id'], $_SESSION['role']);
                $org = $profile->getOrganization();

                if($_SESSION['role'] == 0){ 
                  $role = "Viewer";
                } else if($_SESSION['role'] == 1){ 
                  $role = "Tester";
                } else if($_SESSION['role'] == 2){ 
                  $role = "Integrator";
                } else if($_SESSION['role'] == 3){ 
                  $role = "Admin";
                }
                ?>
                <div style="text-align: center; max-width: 200%; margin-bottom: 12px;">
                  <table class="u-table-entity" style="height: 100%; overflow: auto; display: flex;">
                    
                    <tbody class="u-table-alt-grey-5 u-table-body">
                      <tr style="height: 51px;">
                        <th class="u-table-cell" style="white-space: nowrap; text-align: center; min-width: 0%; max-width: 40%;">Name</th>
                        <th  class="u-table-cell" style="white-space: nowrap; text-align: center; min-width: 0%; max-width: 40%">Email</th>
                        <th  class="u-table-cell" style="text-align: center; min-width: 0%; max-width: 40%">Approved Role</th>
                        <th  class="u-table-cell" style="white-space: nowrap; text-align: center; min-width: 0%; max-width: 40%">Organization</th>
                      </tr>
                      <tr>
                        <td style="padding: 15px;"><?= $_SESSION['fullname'] ?></td>
                        <td style="padding: 15px;"><?= $_SESSION['name'] ?> </td>
                        <td style="padding: 15px;"><?= $role ?></td>
                        <td style="padding: 15px;"> <?php
                          $output = array();
                          for($o = 0; $o < count($org); $o++){
                            if($org[$o] != null){
                              echo ''.$org[$o].'<br>'; 
                              array_push($output, true);
                            } else {
                              array_push($output, false);
                            }
                          }
                          $bool = false;
                          if($output[0] == false && $output[1] == false && $output[2] == false && $output[3] == false){
                            echo 'No Organization Information<br>';
                            $bool = true;
                          }
                          if($output[0] == false && $bool == false) echo 'No Organization Name<br>';
                          if($output[1] == false && $bool == false) echo 'No Organization Phone Number<br>';
                          if($output[2] == false && $bool == false) echo 'No Organization Email<br>';
                          if($output[3] == false && $bool == false) echo 'No Organization Description<br>';
                          
                          ?> </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div id='form-select' class='u-form-group u-form-group-6' style='max-width: 100%; margin-top: 12px'>
                      <select id='edit_options' name='edits' class='u-border-1 u-border-grey-30 u-input u-input-rectangle u-white' onchange='display(this);'>
                        <option value=""> Select Account Information To Edit</option>
                        <option id="changen" value="name"> Change First Or Last Name</option>
                        <option id="changep" value="pass"> Change Password</option>
                        <option id="changea" value="affiliation"> Change Organization</option>
                      </select>
                </div>
                        
                <div id="name" class="u-form-group u-form-name u-form-partition-factor-2" style="display: none;">
                  <form action="include/Profile.inc.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="name_form" style="padding: 10px; width: 100%;" redirect="true">
                    <div class="u-form-group u-form-name u-form-partition-factor-2">
                      <label for="text-0001" class="u-label">Current First Name</label>
                      
                      <?php $name = explode(" ", $_SESSION['fullname']);?>

                      <input placeholder="Previous" id="text-0001" name="prev_first" value="<?php echo $name[0]; ?>" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
                    </div>
                    <div class="u-form-group u-form-name u-form-partition-factor-2 u-form-group-2">
                      <label for="text-0002" class="u-label">Current Last Name</label>
                      <input type="text" placeholder="Previous" id="text-0002" name="prev_last" value="<?php echo $name[1] ?>" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
                    </div>
                    <div class="u-form-group u-form-name u-form-partition-factor-2">
                      <label for="text-0003" class="u-label">New First Name</label>
                      <input type="text" placeholder="New First Name" id="text-0003" name="new_first" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
                    </div>
                    <div class="u-form-group u-form-name u-form-partition-factor-2 u-form-group-2">
                      <label for="text-0004" class="u-label">New Last Name</label>
                      <input type="text" placeholder="New Last Name" id="text-0004" name="new_last" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
                    </div>
                    <div class="u-align-left u-form-group u-form-submit">
                      <input id="name_sub" type="submit" name="name_submit" value="Submit" class="u-btn u-btn-submit u-button-style">
                    </div>
                  </form>
                </div>
                <div id="password" style="display: none;">
                  <form action="include/Profile.inc.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="pass_form" style="padding: 10px;width: 100%;" redirect="true">
                    <div class="u-form-group u-form-group-7">
                        <label for="text-0015" class="u-label">Old Password</label>
                        <input type="password" placeholder="Previous" id="text-0015" name="prev_pass" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
                      </div>
                    <div class="u-form-group u-form-group-7">
                      <label for="text-0005" class="u-label">Repeat Old Password</label>
                      <input type="password" placeholder="Repeat Previous" id="text-0005" name="rep_prev_pass" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
                    </div>
                    <div class="u-form-group u-form-group-7">
                      <label for="text-0006" class="u-label">New Password</label>
                      <input type="password" placeholder="Enter your new Password (Required: One Upper, Lower, Digit, and Special Character)" id="text-0006" name="new_pass" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
                    </div>
                    <div class="u-align-left u-form-group u-form-submit">
                      <input id="pass_sub" type="submit" name="pass_submit" value="Submit" class="u-btn u-btn-submit u-button-style">
                    </div>
                  </form>
                </div>
              
                <div id="affiliation" class="u-align-left" style="display: none;">
                  <form action="include/Profile.inc.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="pass_form" style="padding: 10px;width: 900px;" redirect="true">
                    <div class="u-form-group u-form-name u-form-partition-factor-2">
                      <label for="text-0020" class="u-label">Organization Name</label>
                      <input placeholder="Name" id="text-0020" name="org_name" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
                    </div>
                    <div class="u-form-group u-form-name u-form-partition-factor-2 u-form-group-2">
                      <label for="text-0021" class="u-label">Organization Phone Number</label>
                      <input type="text" placeholder="Phone Number" id="text-0021" name="org_phone" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
                    </div>
                    <div class="u-form-group u-form-name u-form-partition-factor-2">
                      <label for="text-0022" class="u-label">Organization Email</label>
                      <input type="text" placeholder="Email" id="text-0022" name="org_email" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
                    </div>
                    <div class="u-form-group u-form-name u-form-partition-factor-2 u-form-group-2">
                      <label for="text-0023" class="u-label">Organization Description</label>
                      <input type="text" placeholder="Description" id="text-0023" name="org_dec" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
                    </div>    
                    <div class="u-align-left u-form-group u-form-submit">
                        <input type="submit" name="aff_submit" value="Submit" class="u-btn u-btn-submit u-button-style">
                    </div>
                </div>
              </div>
                <script>
                  function display(that) {
                    // hide all edit functions separate divs
                    document.getElementById("name").style.display = "none";
                    document.getElementById("password").style.display = "none";
                    document.getElementById("affiliation").style.display = "none";

                    // get value of select element then display correct one depending on select's value
                    $d = document.getElementById("edit_options").value;
                    if($d == "name"){
                      document.getElementById("name").style.display = "block";
                    } else if($d == "pass") {
                      document.getElementById("password").style.display = "block";
                    } else if($d == "affiliation") {
                      document.getElementById("affiliation").style.display = "block";
                    }
                  }

                  //contact_list function to select its parent option - formatting for mobile devices
                  function selectFirst(SelVal) {
                    var arrSelVal = SelVal.split(",")
                    if (arrSelVal.length > 1) {
                      Valuetoselect = arrSelVal[0];
                      document.getElementById("contact_list").value = Valuetoselect;
                    }
                  }
                  
                  function match(that){
                    if(that.value < 0){
                      alert("Notice -> Request priority must be between 0 and 6.");
                      that.value = 0;
                    } else if(that.value > 6){
                      alert("Notice -> Request priority must be between 0 and 6.");
                      that.value = 6;
                    }
                  }
                </script>
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