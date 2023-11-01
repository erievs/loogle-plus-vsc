<!-- ui/elements/community/utils/limit-text.php -->

<?php
function limitTextTo25Chars($text) {
    $maxLength = 25; 

    if (strlen($text) > $maxLength) {
        $text = substr($text, 0, $maxLength - 3) . '...';
    }

    return $text;
}
?>