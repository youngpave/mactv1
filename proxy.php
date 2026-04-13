
<?php
error_reporting(0);
set_time_limit(0);

if (!isset($_GET['url'])) { die("URL parametresi eksik."); }
$url = $_GET['url'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');

$response = curl_exec($ch);
$content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

// Tarayıcıya bunun bir video akışı olduğunu zorla öğretiyoruz
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/vnd.apple.mpegurl");

if (strpos($url, '.m3u8') !== false) {
    // Segmentlerin tam yolunu bulmak için ana dizini alıyoruz
    $base_url = substr($url, 0, strrpos($url, '/') + 1);
    
    $lines = explode("\n", $response);
    foreach ($lines as &$line) {
        $line = trim($line);
        if ($line && $line[0] !== '#') {
            // Eğer link tam değilse başına ana dizini ekle
            if (strpos($line, 'http') === false) {
                $line = $base_url . $line;
            }
            // Parçaları da proxy üzerinden geçirmeye zorla
            $line = "proxy.php?url=" . urlencode($line);
        }
    }
    echo implode("\n", $lines);
} else {
    // .ts dosyaları için doğru header
    header("Content-Type: video/mp2t");
    echo $response;
}
?>
