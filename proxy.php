<?php
/**
 * MAÇTV VIP - PHP Proxy Motoru
 */
error_reporting(0);
set_time_limit(0);

if (!isset($_GET['url'])) {
    die("Hata: URL belirtilmedi.");
}

$url = $_GET['url'];
$user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
curl_setopt($ch, CURLOPT_REFERER, 'https://google.com/');

$response = curl_exec($ch);
$content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

// M3U8 listesi ise içindeki yolları düzenle
if (strpos($url, '.m3u8') !== false) {
    header("Content-Type: application/vnd.apple.mpegurl");
    
    $base_url = substr($url, 0, strrpos($url, '/') + 1);
    $lines = explode("\n", $response);
    $new_content = "";

    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) continue;

        if (strpos($line, '#') === 0) {
            $new_content .= $line . "\n";
        } else {
            // Göreceli (relative) linkleri tam linke çevir
            if (strpos($line, 'http') !== 0) {
                $line = $base_url . $line;
            }
            // Parçaları tekrar bu proxy üzerinden geçir
            $new_content .= "proxy.php?url=" . urlencode($line) . "\n";
        }
    }
    echo $new_content;
} else {
    // .ts video parçası ise doğrudan veriyi gönder
    header("Content-Type: " . $content_type);
    echo $response;
}
?>
