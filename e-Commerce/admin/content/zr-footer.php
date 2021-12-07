<?php if(!isset($_SESSION["adminoturum"]) or !defined("SABIT")) { header("location:/index.php"); exit;}
if($_SESSION['anahtar'] != md5($_SERVER['HTTP_USER_AGENT'])) { header("location:/index.php");  exit;} ?>
<div class="zr-footer-alt hidden-print">
					<small>&copy; 2018 <strong>Ofisimo.com Yazılım Hizmetleri v1</strong></small>
</div>
  <script type="text/javascript" src="assets/js/bootstrap.js"></script>
  <script type="text/javascript" src="assets/js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="assets/js/jquery-ui/js/jquery-ui.js"></script>
  <script type="text/javascript" src="assets/js/jquery.slimscroll.min.js"></script>
  <script type="text/javascript" src="assets/js/fileinput.js"></script>	
  <script type="text/javascript" src="assets/js/bootbox.min.js"></script>  
  <script type="text/javascript" src="assets/js/jquery.nicescroll.js"></script>
  <script type="text/javascript" src="assets/js/breakpoints.js"></script>
  <script type="text/javascript" src="assets/js/icheck/icheck.min.js"></script>
  <script type="text/javascript" src="assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
  <script type="text/javascript" src="assets/js/tinymce/tinymce.min.js"></script>
  <script type="text/javascript" src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>	
  <script type="text/javascript" src="assets/js/loader.js"></script>
  <script type="text/javascript" src="assets/js/gsap/main-gsap.js"></script>
  <script type="text/javascript" src="assets/js/jquery.scrollTo.min.js"></script>
  <script type="text/javascript" src="assets/js/zr-main.js"></script>