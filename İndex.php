<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaçTV - Canlı Yayın</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            background-color: #000;
            overflow: hidden; /* Kaydırma çubuklarını gizler */
        }

        .player-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Yükleniyor yazısı (isteğe bağlı) */
        .loading {
            position: fixed;
            z-index: -1;
            color: #fff;
            font-family: sans-serif;
        }
    </style>
</head>
<body>

    <div class="loading">Yayın Yükleniyor...</div>

    <div class="player-container">
        <?php
            // Yayın linki
            $stream_url = "https://lovetier.bz/player/beinsports1tr";
        ?>
        
        <iframe 
            src="<?php echo $stream_url; ?>" 
            allow="autoplay; encrypted-media; fullscreen; pips" 
            allowfullscreen 
            scrolling="no">
        </iframe>
    </div>

</body>
</html>
