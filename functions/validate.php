<?php 
function validate_data($data,$regex){
	if(isset($_POST[$data]) && !empty(trim($_POST[$data]))){
            if(preg_match($regex, $_POST[$data])){
                return $_POST[$data];
            } else {
                $err[$data] = $errorMsg;
            }
        } else {
            $err[$data] = "Enter $data";
        }

}
?>
<?php
if(isset($_POST['btnSubmit'])){
    $err = [];

    function validate($field, $pattern, $errorMsg) {
        global $err;
        if(isset($_POST[$field]) && !empty(trim($_POST[$field]))){
            if(preg_match($pattern, $_POST[$field])){
                return $_POST[$field];
            } else {
                $err[$field] = $errorMsg;
            }
        } else {
            $err[$field] = "Enter $field";
        }
        return null;
    }

    $username = validate('username', "/^[a-z0-9_.]{8,}$/", 'Invalid pattern');
    $email = validate('email', "/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i", 'Invalid email pattern');
    $dob = validate('dob', "/^\d{4}-\d{2}-\d{2}$/", 'Invalid date format');
    $phone = validate('phone', "/^9[0-9]{9}$/", 'Invalid phone, must start with 9 and be 10 digits long');

    if(empty($err)){
        echo 'Successful!!!';
    } else {
        echo '!!!Error Occurred!!!';
    }
}
?>