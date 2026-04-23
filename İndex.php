<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>MaçTV - Canlı İzle</title>
    <script src="https://cdn.jsdelivr.net/npm/@clappr/player@latest/dist/clappr.min.js"></script>
    <style>
        body { background: #0f172a; color: white; font-family: sans-serif; text-align: center; }
        #player { width: 80%; margin: 20px auto; aspect-ratio: 16/9; background: #000; border-radius: 10px; overflow: hidden; }
        .kanal-liste { display: flex; justify-content: center; gap: 10px; margin-top: 20px; }
        .kanal-btn { padding: 10px 20px; background: #3b82f6; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>

    <h1>MaçTV Canlı Yayın</h1>

    <div id="player"></div>

    <div class="kanal-liste">
        <a href="?kanal=32770" class="kanal-btn">TRT 1</a>
        <a href="?kanal=12345" class="kanal-btn">Diğer Kanal</a>
    </div>

    <script>
        <?php
        // Eğer bir kanal seçilmişse onu oynat, seçilmemişse TRT 1'i varsayılan yap
        $secili_kanal = isset($_GET['kanal']) ? $_GET['kanal'] : '32770';
        ?>

        var player = new Clappr.Player({
            source: "oynat.php?id=<?php echo $secili_kanal; ?>",
            parentId: "#player",
            autoPlay: true,
            width: '100%',
            height: '100%',
            watermark: "MaçTV", position: 'top-right',
        });
    </script>

</body>
</html>
