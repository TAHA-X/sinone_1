<?php

try {
    $tmp = $_FILES['RemoteFile']['tmp_name'];
    move_uploaded_file($tmp, 'imgs/'.$_FILES["RemoteFile"]["name"]);
} catch (Exception $e) {
    echo "execpetion";
}
?>