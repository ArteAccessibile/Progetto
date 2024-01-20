<?php
   function clearInput($value) {
    $value = trim($value);          
    $value = strip_tags($value);    

    return $value;
}
?>