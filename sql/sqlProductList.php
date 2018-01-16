<?php
    include('../class/classDb.php');
    include('../class/classOrders.php');
    
    $storeNo = $_POST['storeNo'];
    
    $db = new dbConnection();
    $orders = new orders();
    $orders ->openConnection($db->getDbConnection($storeNo));
    
    $orderListArray = $orders->orderList();
    $t = "<table>";
    $t .="<tr>";
      $t .= "<th>Order no</th>";
      $t .= "<th>Supplier name</th>";
      $t .= "<th>Reference</th>";
      $t .= "<th>Date ordered</th>";
      $t .= "<th>Order Cost</th>";
      $t .= "<th></th>";
    $t .="</tr>";
   for($i=0; $i<count($orderListArray);$i++){
    $t .= "<tr>";
        $t .= "<td>".$orderListArray[$i]['orderNo']."</td>";
        $t .= "<td>".$orderListArray[$i]['supplier']."</td>";
        $t .= "<td>".$orderListArray[$i]['ref']."</td>";
        $t .= "<td>".substr($orderListArray[$i]['dateOrdered'], 0, -13)."</td>";
        $t .= "<td>   (&euro;".$orderListArray[$i]['totalCost'].")</td>";
        $function = "onclick=\"orderDetail('".$orderListArray[$i]['orderNo']."')\"";
        
        $t .= "<td><button class = 'btn btn-primary' id = 'search_".$orderListArray[$i]['orderNo']."' ".$function." ><i class='fa fa-file-excel-o' style='color: #32CD32;' aria-hidden='true'></i> Export to Excel</button></td>";
    $t .= "</tr>";
   }
   $t .= "</table>";
   echo $t;
  
    ?>