<?php
include 'config.php';

if (isset($_GET['id'])) {
    $kanal_id = htmlspecialchars($_GET['id']);
    $link = yayinLinkiAl($kanal_id);
    
    // Tarayıcıya bu linkin bir video yayını olduğunu söylüyoruz
    header("Location: $link");
    exit;
} else {
    echo "Kanal ID belirtilmedi.";
}
?>
