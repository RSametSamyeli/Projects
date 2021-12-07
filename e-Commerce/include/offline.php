<?php if( !defined("SABIT") ){ exit; } 
$kapak = glob("uploads/offline/offline.*");
seoyaz("Yakında","","","");
?>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<body>
<div class="container-fluid" style="text-align:center;">
	<div class="col-md-12">
		<a href="<?php echo @$def['offlinelink']; ?>" target="_blank"><img src="/<?php echo $kapak[0]?>"  style="margin:auto; width:100%;" class="img-responsive"/></a>
	</div>
</div>

<?php _footer(); ?>
<?php _footer_last(); ?>
 </body>
</html>