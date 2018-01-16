<?php
    include('../class/classDb.php');
    include('../class/classOrders.php');

    $storeNo = $_POST['storeNo'];
    $orderNo = $_POST['orderNo'];
    //
    //$db = new dbConnection();
    //$orders = new orders();
    //$orders ->openConnection($db->getDbConnection($storeNo));
    //
    //$orderListArray = $orders->orderList();
    //
    echo $storeNo." - orderNO: ".$orderNo;
    ?>