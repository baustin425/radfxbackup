<?php
/* handles all the ion form submissions and calls the appropriate classes for altering the databases
 * @author ETurner
 */

if(isset($_POST["submit"])) {//was this submitted from the edit ions form?
    include "../database.php";
    include "../classes/Admin.Ions.classes.php";

    $ion = new Ion();

    $ion->editIons($_POST);
    header("location: ../Admin.php?error=edit_ion_none");
} else if(isset($_POST["submit_ion"])) {//was this submitted from the add ion form?
    include "../database.php";
    include "../classes/Admin.Ions.classes.php";

    $ion = new Ion();

    $ion->addIon($_POST);
    header("location: ../Admin.php?error=add_ion_none");
}else if(isset($_POST["submit_ion_form"])) { //was this submitted from the add facility form?
    include "../database.php";
    include "../classes/Admin.classes.php";

    $admin = new Admin();

    $admin->editColumns($_POST, "ion");
    header("location: ../Admin.php?error=request_edit_none");
} else if(isset($_POST["submit_field"])) {//was this submitted from the add ion field form?
    include "../database.php";
    include "../classes/Admin.classes.php";

    $admin = new Admin();

    $admin->addColumn($_POST['name'], $_POST['type'], $_POST['description'], "ion");
    header("location: ../Admin.php?error=add_ion_field_none");
} else { //return error if you reached this page any other way
    header("location: ../Admin.php?error=prepare");
}
