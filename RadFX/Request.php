<!DOCTYPE html>
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
        include_once 'header.php';
    ?>
    <section class="u-align-center u-clearfix u-image u-shading u-section-1" src="" data-image-width="474" data-image-height="316" id="sec-89ea">
      <div class="u-clearfix u-sheet u-sheet-1">
        <div class="u-form u-form-1">
        <form action="include/Request.inc.php" method="POST" class="u-clearfix u-form-custom-backend u-form-spacing-10 u-form-vertical u-inner-form" source="custom" name="form" style="padding: 10px;" redirect="true">            <div class="u-form-group u-form-group-7">
              <label for="text-53b6" class="u-label">Total Hours</label>
              <input type="text" placeholder="Total Requested Hours" id="text-53b6" name="hours" class="u-border-1 u-border-grey-30 u-input u-input-rectangle u-white" required="required">
            </div>
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
            <div class="u-align-left u-form-group u-form-submit">
              <a href="#" class="u-btn u-btn-submit u-button-style">Submit</a>
              <input type="submit" name="submit" value="submit" class="u-form-control-hidden">
            </div>            
          </form>
        </div>
      </div>
    </section>
    
    
    
    
    
    
    
    <?php
        include_once 'footer.php';
    ?>
 
  </body>
</html>