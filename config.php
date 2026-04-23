<?php
// IPTV Panel Bilgilerin
$panel_url = "http://hayattv.pepbox.xyz:2095";
$username  = "smm0917tv2";
$password  = "smm1801zz00bb99";

// Yayın linkini oluşturma fonksiyonu
function yayinLinkiAl($kanal_id) {
    global $panel_url, $username, $password;
    // Clappr için .ts yerine .m3u8 formatını zorlamak daha stabildir
    return "$panel_url/live/$username/$password/$kanal_id.m3u8";
}
?>
