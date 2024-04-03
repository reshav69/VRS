<?php 
function validate_data($data,$regex){
    if (preg_match($regex, $data)) {
        return true; // Validation successful
    } else {
        return false; // Validation failed
    }
    return null;
}

?>
