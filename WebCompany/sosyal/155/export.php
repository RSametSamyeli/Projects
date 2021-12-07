<?php session_start();
if ($_SESSION['yonetim'] != "") {
    require_once '../ayar.php';
$output = '';
if(isset($_POST["export"]))
{
 $query = "SELECT * FROM uye";
 $result = mysqli_query($connect, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>ADI</th>  
                         <th>NUMARA</th>
                         <th>MAIL</th>
                    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
    <tr>  
                         <td>'echo $uye['adsad']'</td>  
                         <td>'echo $uye['adsad']'</td> 
      					 <td>'echo $uye['adsad']'</td>  
                    </tr>
   ';
  }
  $output .= '</table>';/*
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=download.xls');*/
  echo $output;
  echo "İşlem Başarılı";
 }
}
    ?>
