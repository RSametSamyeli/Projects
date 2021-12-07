<?php if (isset($_SESSION['yonetim'])) { ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Yönetim Paneli</title>
        <link rel="stylesheet" href="stil.css">
        <link href="../stil/fa/css/fontawesome-all.css" rel="stylesheet">
        <meta charset="utf8">
        <script type="text/javascript" src="../stil/jquery.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">


<?php } else {
    header("location:giris.php");
} ?>