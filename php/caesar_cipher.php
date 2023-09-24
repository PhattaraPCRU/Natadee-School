<?php
function caesar_cipher($str, $shift) {
    $str = strtoupper($str);
    $result = "";
    for ($i = 0; $i < strlen($str); $i++) {
        $ascii = ord($str[$i]);
        if ($ascii >= 65 && $ascii <= 90) {
            $result .= chr((($ascii - 65 + $shift) % 26) + 65);
        } else {
            $result .= $str[$i];
        }
    }
    return $result;
}
?>