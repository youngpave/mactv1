<?php
// Player'ın erişim engeline takılmaması için gerekli izinler
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: *");

// Senin verdiğin asıl yayın linki
$yayin_linki = "http://hayattv.pepbox.xyz:2095/live/smm0917tv2/smm1801zz00bb99/32770.ts";

// Player'a "Bu bir HLS akışıdır" diyoruz (Mimetype kandırması)
header("Content-Type: application/vnd.apple.mpegurl");

// Sunucuyu yormayan yönlendirme (Redirect)
// Bu sayede video verisi sunucudan geçmez, donma yapmaz.
header("Location: " . $yayin_linki);
exit;
?>
