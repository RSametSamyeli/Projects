<?php  
$connect = mysqli_connect("localhost", "izbarco", "Samy3li.32", "izbarco_sosyal");
$output = '';
if(isset($_POST["export"]))
{
 $query = "SELECT * FROM tbl_customer";
 $result = mysqli_query($connect, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>ADI</th>  
                         <th>NUMARA</th>
                         <th>MAIL</th>
                         <th>OZEL-1</th>
                         <th>OZEL-2</th>
                         <th>OZEL-3</th>
                         <th>OZEL-4</th>
                         <th>OZEL-5</th> 
                    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
    <tr>  
                         <td>'.$uye['adsad'].'</td>  
                         <td>'.$uye['telefon'].'</td>  
                         <td>'.$row["City"].'</td>  
      					 <td>'.$uye['mail'].'</td>  
                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=download.xls');
  echo $output;
 }
}
    ?>
