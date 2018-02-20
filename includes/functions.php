<?php 

    function ValidateFormData($FormData){
        $FormData = trim(stripslashes(htmlspecialchars(strip_tags(str_replace( array( '(', ')' ), '', $FormData  )), ENT_QUOTES )));
        return $FormData;

    }

?>