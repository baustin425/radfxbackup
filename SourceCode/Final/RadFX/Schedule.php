
<!DOCTYPE html>
<html style="font-size: 16px;">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="​Radiation effects testing​, ​How​ testing is performed, ​Participating facilities">
    <meta name="description" content="">
    <meta name="page_type" content="np-template-header-footer-from-plugin">
    <title>Schedule</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
	<link rel="stylesheet" href="Schedule.css" media="screen">
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
    <meta property="og:title" content="Schedule">
    <meta property="og:type" content="website">
  </head>
  <body class="u-body">
    <?php
        include_once 'header.php';
    ?>
    <section class="u-align-center u-image u-section-1" src="" data-image-width="474" data-image-height="316" id="sec-89ea">
      <div class="u-align-left u-clearfix u-sheet u-sheet-1">
        <div class="u-clearfix u-custom-html u-expanded-width u-custom-html-1">
          <meta charset="utf-8">
          <title></title>
          <meta name="viewport" content="width=device-width, initial-scale=1" user-scalable="no">
          <link rel="stylesheet" href="src/calendarjs.css">		  
         
			<?php
				//If the user is and Admin or Integrator Show Priority Legend
				if(isset($_SESSION["role"]) && $_SESSION["role"] > 1) {
                  	echo '<div style="overflow: hidden;">';
					
                    echo'<table class="u-table-entity">
                              
                      <tbody class="u-table-body">
                        <tr style="height: 30px;">
                          <th class="u-table-cell" style="white-space: nowrap; width: 11%; color: white; text-align: center; min-width: 14%; max-width: 40%">Unapproved</th>
                          <th  class="u-table-cell" style="white-space: nowrap; width: 11%; color: white;  text-align: center; min-width: 14%; max-width: 60%">Approved</th>
                          <th  class="u-table-cell" style="white-space: nowrap; width: 11%; color: white; text-align: center; min-width: 14%; max-width: 40%">Priority 1</th>
                          <th  class="u-table-cell" style="white-space: nowrap; width: 11%; color: white; text-align: center; min-width: 14%; max-width: 40%">Priority 2</th>
                          <th class="u-table-cell" style="white-space: nowrap; width: 11%; color: white; text-align: center; min-width: 14%; max-width: 40%">Priority 3</th>
                          <th  class="u-table-cell" style="white-space: nowrap; width: 11%; color: white; text-align: center; min-width: 14%; max-width: 40%">Priority 4</th>
                          <th  class="u-table-cell" style="white-space: nowrap; width: 11%; color: white; text-align: center; min-width: 14%; max-width: 40%">Priority 5</th>
                          <th class="u-table-cell" style="white-space: nowrap; width: 11%; color: white; text-align: center; min-width: 14%; max-width: 40%">Priority 6</th>
                          <th class="u-table-cell" style="white-space: nowrap; width: 11%; color: white; text-align: center; min-width: 14%; max-width: 40%">Conflict</th>
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
                    </table>';									  
					
					echo '</div>';
				}
				
				?>
			
		<script src="src/calendarjs.js"></script>
          <div class="contents">
            <div id="myCalendar" name="myCalenday" style="width: 100%;"></div>
		  </div>	
				
				
			
			
			<?php
			 
				if(isset($_SESSION["role"]) && $_SESSION["role"] > 1) {				
					
					include_once 'searchBar.php';
					
					echo '<br>';
					echo '<h2>Download Excel Calendar:</h2>';
					echo '<button onclick="exportExcel();">Get Full Schedule</button>	';
					echo '<br>';
					echo '<p></p>	';
					
					if ($_SESSION["role"] > 2){
						echo '<br>';
						echo '<h2>Publish Calendar:</h2>';			
						echo '<input type="password" placeholder="Enter your password" id="password" name="password" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">	';		
						echo '<button onclick="publishEvents(document.getElementById(`password`).value);">Publish Calendar</button>';
						echo '<br>  ';    
						echo '<p></p>';
					}
					
				}
			?>
			
          <script> 
			var currentViewingDate = '';
			
			
			if (window.location.href.includes('?')){
					paramString = window.location.href.split('?')[1];
					paramArray = paramString.split('&'); 
					currentViewingDate = Date.now();
					currentViewingDate = parseInt(paramArray[2].split('=')[1]);
					
				
					
			 }else{
				 currentViewingDate = Date.now();
				 
			 }		
		  
		  </script>
		  	<?php
			  //session_start();
				if(isset($_SESSION["role"]) && $_SESSION["role"] > 1) {				
				echo '<script>';
				echo 'var calendarInstance = new calendarJs( "myCalendar", { 
					exportEventsEnabled: true, 
					manualEditingEnabled: true, 
					showTimesInMainCalendarEvents: false,
					minimumDayHeight: 0,
					maximumEventsPerDayDisplay : 0,						
					organizerName: "RadFX",
					organizerEmailAddress: "radfxSecureEmail@gmail.com",
					visibleDays: [ 0, 1, 2, 3, 4, 5, 6 ]
					},null,(new Date(currentViewingDate)));';
				echo '</script>';
			}else{
				echo '<script>';
				echo 'var calendarInstance = new calendarJs( "myCalendar", { 
					exportEventsEnabled: false, 
					manualEditingEnabled: false, 
					showTimesInMainCalendarEvents: false,
					minimumDayHeight: 0,
					maximumEventsPerDayDisplay : 0,	
					showExtraMainDisplayToolbarButtons : false,					
					organizerName: "RadFX",
					organizerEmailAddress: "radfxSecureEmail@gmail.com",
					visibleDays: [ 0, 1, 2, 3, 4, 5, 6 ]
					},null,(new Date(currentViewingDate)));';
				echo '</script>';
				
			}
		?>
	

			<script>
			getEvents();
			
			
			
			
			//Check For POST search parameters
			//Return All Events if none
			function getEvents() {
				
				if (window.location.href.includes('?')){
					paramString = window.location.href.split('?')[1];
					paramArray = paramString.split('&');
					keepSearchEvents(paramArray[0].split('=')[1], paramArray[1].split('=')[1]); 
					
				}else{
				
					keepSearchEvents("1","[]");
				}
			} 
			
			
			//Retrieve All Events from Database
			//Reset URL to no POST data
			function seeAllEvents(){
				
				var xmlhttp = new XMLHttpRequest();	
					xmlhttp.open("POST", "include/searchEvents.inc.php", true);				
					xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
					xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
					
						var result = JSON.parse( this.responseText );
						
						calendarInstance.clearEvents();					
						calendarInstance.addEvents(result, true, false);
						var displayDate = String(Date.parse(calendarInstance.getCurrentDisplayDate()));						
						window.history.replaceState({}, '', location.pathname+'?facility=0&ions=[]&displayDate='+displayDate);
						window.scrollTo(0, 100);
						}
					};
					
					xmlhttp.send('facility=0&ions=[]');	
			}
			
			//Retrieve Events By Facility and Ion[]
			//Add search parameters to URL for state persistence
			function getSearchEvents() {
				var ions = setEnergy();
				var facility = $("#select-81a6").val();
					
					var xmlhttp = new XMLHttpRequest();	
					xmlhttp.open("POST", "include/searchEvents.inc.php", true);				
					xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
					xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						
						calendarInstance.clearEvents();	
						var result = JSON.parse(this.responseText);															
						calendarInstance.addEvents(result , true, false);						
						window.scrollTo(0, 100);
						var displayDate = String(Date.parse(calendarInstance.getCurrentDisplayDate()));
						window.history.replaceState(null, null, '?facility='+facility+'&ions='+ions+'&displayDate='+displayDate);
						
						}
					};
					
					ions = JSON.stringify(ions);
					xmlhttp.send('facility='+facility+'&ions='+ions);
					
				
			}
			
			
			//Persist State if URL contains parameters
			function keepSearchEvents(facility, ions) {
				
					
					var xmlhttp = new XMLHttpRequest();	
					xmlhttp.open("POST", "include/searchEvents.inc.php", true);				
					xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
					xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						
						calendarInstance.clearEvents();	
						var result = JSON.parse(this.responseText);															
						calendarInstance.addEvents(result , true, false);						
						window.scrollTo(0, 100);
						var displayDate = String(Date.parse(calendarInstance.getCurrentDisplayDate()));
						window.history.replaceState(null, null, '?facility='+facility+'&ions='+ions+'&displayDate='+displayDate);
						
						}
					};
					
					
					xmlhttp.send('facility='+facility+'&ions='+ions);
					
				
			}
			
			
			
			//Publish The Current Calendar From Public Viewing
			function publishEvents(pass) {				
				
				
				var xmlhttp = new XMLHttpRequest();	
				xmlhttp.open("POST", "publishEvents.php", true);				
				xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					
				
					
					if (this.responseText.includes("Insufficent Access")){
						alert ("Insufficent Access");
					}else{
						var responseArray = this.responseText.split('Trigger');
						if (typeof responseArray[1] === 'undefined') {
							alert("Publish Successful")
						}else{
							alert(responseArray[1]);
						}
					}
					
				}
				};
				
				xmlhttp.send('pass='+pass);			
					
				
			}

    
					
      
		</script> 
		<script src='FileSaver.js'></script>
        <script> 
		
		function exportExcel() {
			
			//Return Excel Workbook Generated By exportExcel.php
			//Save As RadFX_Schedule.xlsx
			
			var xmlhttp = new XMLHttpRequest();	
			xmlhttp.open("POST", "exportExcel.php", true);				
			xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xmlhttp.responseType = "arraybuffer";
			xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				
				var blob = new Blob([this.response], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});
				saveAs(blob, 'RadFX_Schedule.xlsx');
			}
			};
			
			xmlhttp.send();			
				
			
		}
		
			</script>
        </div>
		
      </div>
    </section>    
    
    
    
    <?php
        include_once 'footer.php';
    ?>

  </body>
</html>