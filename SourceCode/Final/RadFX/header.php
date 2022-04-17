<?php
    session_start();
?>

</head>
  <body data-home-page="HomePage.php" data-home-page-title="HomePage" class="u-body"><header class="u-clearfix u-header u-header" id="sec-d922"><div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <div class="u-clearfix u-expanded-width u-layout-wrap u-layout-wrap-1">
          <div class="u-layout">
            <div class="u-layout-row">
              <div class="u-container-style u-layout-cell u-size-20 u-layout-cell-1">
                <div class="u-container-layout u-container-layout-1">
                    <?php
                        if(isset($_SESSION["loggedin"])) {
                            echo "<div style='text-align:center'>
                                  <a class='u-button-style' title='Welcome!'>" . $_SESSION['name'] . " </a>
                                  <a class='u-login u-login-1' href='include/logout.inc.php' title='Logout'>Log Out</a>
                                  </div>";
                        } else {
                            echo "<a href='SignUp.php' data-page-id='598918230' class='u-btn u-button-style u-hover-palette-1-dark-1 u-palette-1-base u-btn-1'>Sign Up</a>
                                  <a class='u-login u-login-1' href='login.php' title='Login'>Login</a>";
                  
                        }
                    ?>
                </div>
              </div>
              <div class="u-container-style u-layout-cell u-size-14 u-layout-cell-2">
                <div class="u-container-layout u-container-layout-2">
                  <p class="u-text u-text-1">RADFX</p>
                </div>
              </div>
              <div class="u-container-style u-layout-cell u-size-20 u-layout-cell-3">
                <div class="u-container-layout u-container-layout-3">
                  <nav class="u-menu u-menu-dropdown u-offcanvas u-menu-1">
                    <div class="menu-collapse" style="font-size: 1rem; letter-spacing: 0px;">
                      <a class="u-button-style u-custom-left-right-menu-spacing u-custom-padding-bottom u-custom-top-bottom-menu-spacing u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base" href="#">
                        <svg class="u-svg-link" viewBox="0 0 18 18"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#menu-hamburger"></use></svg>
                        <svg class="u-svg-content" version="1.1" id="menu-hamburger" viewBox="0 0 16 16" x="0px" y="0px" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><g><rect y="1" width="16" height="2"></rect><rect y="7" width="16" height="2"></rect><rect y="13" width="16" height="2"></rect>
                        </g></svg>
                      </a>
                    </div>
                    <div class="u-custom-menu u-nav-container">
                        <?php
                        ob_start();
                            if(isset($_SESSION["loggedin"])) {
                              echo "<ul class='u-nav u-unstyled u-nav-1'>";
                              if(isset($_SESSION["role"])) {
                                if($_SESSION["role"] >= 1){
                                  if($_SESSION["role"] > 2) {
                                    echo "<li class='u-nav-item'><a class='u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base' href='Admin.php' style='padding: 28px 16px;'>Admin</a></li>";
                                  }
                                  echo "<li class='u-nav-item'><a class='u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base' href='Profile.php' style='padding: 28px 16px;'>Profile</a>";
                                  echo "</li><li class='u-nav-item'><a class='u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base' href='Request.php' style='padding: 28px 16px;'>Request</a>";
                                }
                                echo "</li><li class='u-nav-item'><a class='u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base' href='Schedule.php' style='padding: 28px 16px;'>Schedule</a>";
                                echo "</li><li class='u-nav-item'><a class='u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base' href='index.php' style='padding: 28px 16px;'>About</a>";
                                echo "</li></ul>";
                              }
                            } else {
                                echo "<ul class='u-nav u-unstyled u-nav-1'></li><li class='u-nav-item'><a class='u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base' href='Schedule.php' style='padding: 28px 16px;'>Schedule</a>";
                                echo "</li><li class='u-nav-item'><a class='u-button-style u-nav-link u-text-active-palette-1-base u-text-hover-palette-2-base' href='index.php' style='padding: 28px 16px;'>About</a>";
                                echo "</li></ul>";
                            }
                        ?>
                    </div>
                    <div class="u-custom-menu u-nav-container-collapse">
                      <div class="u-black u-container-style u-inner-container-layout u-opacity u-opacity-95 u-sidenav">
                        <div class="u-inner-container-layout u-sidenav-overflow">
                          <div class="u-menu-close"></div>
                            <?php
                                if(isset($_SESSION["loggedin"])) {
                                  echo "<ul class='u-align-center u-nav u-popupmenu-items u-unstyled u-nav-2'>";
                                  if(isset($_SESSION["role"])) {
                                    if($_SESSION["role"] >= 1){
                                      if($_SESSION["role"] > 2) {
                                        echo "<li class='u-nav-item'><a class='u-button-style u-nav-link' href='Admin.php' style='padding: 28px 16px;'>Admin</a></li>";
                                      }
                                      echo "<li class='u-nav-item'><a class='u-button-style u-nav-link' href='Profile.php' style='padding: 28px 16px;'>Profile</a>";
                                      echo "</li><li class='u-nav-item'><a class='u-button-style u-nav-link' href='Request.php' style='padding: 28px 16px;'>Request</a>";
                                    }
                                    echo "</li><li class='u-nav-item'><a class='u-button-style u-nav-link' href='Schedule.php' style='padding: 28px 16px;'>Schedule</a>";
                                    echo "</li><li class='u-nav-item'><a class='u-button-style u-nav-link' href='index.php' style='padding: 28px 16px;'>About</a>";
                                    echo "</li></ul>";
                                  }
                                } else {
                                    echo "<ul class='u-align-center u-nav u-popupmenu-items u-unstyled u-nav-2'></li><li class='u-nav-item'><a class='u-button-style u-nav-link' href='Schedule.php' style='padding: 28px 16px;'>Schedule</a>";
                                    echo "</li><li class='u-nav-item'><a class='u-button-style u-nav-link' href='index.php' style='padding: 28px 16px;'>About</a>";
                                    echo "</li></ul>";
                                }
                            ?>
                        </div>
                      </div>
                      <div class="u-black u-menu-overlay u-opacity u-opacity-70"></div>
                    </div>
                  </nav>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>