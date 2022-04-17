<?php
/**
 * controls what default fields can be removed or moved and stores information about their required status
 * @author ETurner
 */
class FieldController {
    /**
     * @param table the table being checked for default fields
     * @return required_fields the default fields that must be filled out be a user
     */
    public function getRequiredFields($table) {
        $required_fields = array();
        if($table == "request") {
            array_push($required_fields,
            "affiliation_name",
            "total_hours" ,
            "earliest_date",
            "facility_and_ion_table"
            );
        } else if($table == "facility") {
            array_push($required_fields,
            "name",
            "description" ,
            "color"
            );
        } 
        return $required_fields;
    }

    /**
     * @param table the table being checked for default fields
     * @return required_fields the default fields that cannot be removed from the database
     */
    public function getUnbreakableFields($table) {
        $required_fields = array();
        if($table == "request") {
            array_push($required_fields,
            "affiliation_name",
            "affiliation_description",
            "affiliation_email",
            "affiliation_phone_number",
            "total_hours" ,
            "earliest_date",
            "purpose_of_test",
            "description",
            "shift",
            "facility_and_ion_table"
            );
        } else if($table == "facility") {
            array_push($required_fields,
            "name",
            "description" ,
            "max_energy_required",
            "color"
            );
        } if($table == "ion") {
            array_push($required_fields,
            "max_energy",
            "energy",
            "name"
            );
        } 
        return $required_fields;
    }

    /**
     * @param table the table being checked for default fields
     * @return required_fields the default fields that cannot be moved on their forms
     */
    public function getUnmoveableFields($table) {
        $required_fields = array();
        if($table == "ion") {
            array_push($required_fields,
            "max_energy",
            "energy",
            "name"
            );
        } 
        return $required_fields;
    }

}