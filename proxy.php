<?php
error_reporting(0);
set_time_limit(0);

if (!isset($_GET['url'])) { die("URL Yok"); }
$url = $_GET['url'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
// ÖNEMLİ: IPTV panelleri bu User-Agent'ı sever
curl_setopt($ch, CURLOPT_USERAGENT, 'IPTVSmarters/1.0.3 (iPad; iOS 13.4.1; Scale/2.00)');

$response = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

if (strpos($url, '.m3u8') !== false) {
    header("Content-Type: application/vnd.apple.mpegurl");
    
    // Link yapısını parçala (Segmentler için)
    $base = (strpos($url, '?') !== false) ? explode('?', $url)[0] : $url;
    $base_url = substr($base, 0, strrpos($base, '/') + 1);

    $lines = explode("\n", $response);
    $output = "";
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line && $line[0] !== '#') {
            if (strpos($line, 'http') !== 0) {
                $line = $base_url . $line;
            }
            // Kendi proxy dosya ismini kontrol et (proxy.php olmalı)
            $output .= "proxy.php?url=" . urlencode($line) . "\n";
        } else {
            $output .= $line . "\n";
        }
    }
    echo $output;
} else {
    header("Content-Type: " . $info['content_type']);
    echo $response;
}
?>
