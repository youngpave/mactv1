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
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');

$response = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

// İNDİRME SORUNUNU ÇÖZEN KRİTİK KISIM:
header("Content-Type: application/vnd.apple.mpegurl");
header("Content-Disposition: inline; filename='playlist.m3u8'");

if (strpos($url, '.m3u8') !== false) {
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
            $output .= "proxy.php?url=" . urlencode($line) . "\n";
        } else {
            $output .= $line . "\n";
        }
    }
    echo $output;
} else {
    // .ts dosyaları için doğru tipi bas
    header("Content-Type: video/MP2T");
    echo $response;
}
?>
