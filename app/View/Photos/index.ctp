<!DOCTYPE html>
<html lang="ja">
<head>
    <title>PhotoLibrary</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/Photos/Mystyle.css">
    <link rel="stylesheet" href="css/Photos/lightbox.min.css">
    <script src="js/Photos/lightbox-plus-jquery.min.js" type="text/javascript"></script>
</head>
<body>
    <header>
    </header>
    <main>
        <?php
        $photo_n = count($photo);
        $SiteURL = SiteURL;
        for ($i=0; $i < $photo_n; $i++) {
            echo "<a href='{$photo[$i]}' data-lightbox='photos'> <img src='{$SiteURL}{$photo[$i]}' width='950'> </a>";
        }
        ?>
    </main>
    <footer></footer>

</body>
</html>
