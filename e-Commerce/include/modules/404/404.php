<?php if( !defined("SABIT") ){ exit; } 
seoyaz("Aranılan Sayfa Bulunamadı","","",""); ?>
<meta name="robots" content="noindex,no-follow" />
<link href="/assets/css/404.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="main" class="main">
<!-- Header -->
	<?php include('include/sabit/header.php'); ?>
		<div class="container">
			<div class="zr-404">
				<h1>404</h1>
				<h2>Aranılan Sayfa Bulunamadı....</h2>
				<p>Yukardaki Menüleri Kullanarak Geçiş Yapabilirsiniz</p>
				<div class="home"><a href="/">Anasayfa</a></div>
			</div>
		</div>
<!-- Zr Footer -->
<?php include('include/sabit/footer.php'); ?>		
</div>
<?php _footer(); ?>
<?php _footer_last(); ?>
 </body>
</html>