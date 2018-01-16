<?php
class orders{
    
    private $pdo=null;
    private $petcoPDO = null;
    
    private function showDate(){
        return date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")-90,   date("Y")));
    }
    
    function openConnection($dbConnectionArray){
        
        try{
           $this->pdo = new PDO($dbConnectionArray["server"],$dbConnectionArray["user"],$dbConnectionArray["password"]);
        }catch (Exception $e){
            $this->pdo = new PDO($dbConnectionArray["localServer"],$dbConnectionArray["user"],$dbConnectionArray["password"]);
        }
    }
    
    
     function orderList(){
        $orderArray = array();
            $sql = "SELECT RepOrderNo, DateOrdered, Supplier, TotalCost,InvoiceRef 
FROM [RepMain] where [StockAdded] = 0 AND ([StockReceived] = 0 OR [OrderSent] = 0) AND [InvoiceRef] not like '% > %'ORDER BY [DateOrdered] DESC";
            $query = $this->pdo->prepare($sql);
            $query->execute();
                $a='';
            while($row = $query->fetch()){
              //$a .='orderNo => '.$row['RepOrderNo'].'   dateOrdered => '.$row['DateOrdered'].'   supplier => '.$row['Supplier'].'    totalCost =>  '.round($row['TotalCost'],2);
              $orderArray[] = array('orderNo' => $row['RepOrderNo'], 'ref'=> $row['InvoiceRef'] ,'dateOrdered' => $row['DateOrdered'],'supplier' => $row['Supplier'], 'totalCost' => round($row['TotalCost'],2));
            }
            
            //$petcoPDO = null;
        return $orderArray;
    }

    function generateProductsArray($orderNo){
                $productsArray = array();
            $sql = "SELECT [Quantity]
                    ,[Nameofitem]
                    ,[Barcode]
                    ,[Price]
                    ,[CodeSup]
                    ,[PackSize]
                    ,[CaseQuantity]
                FROM [RepSub] where OrderNo = '$orderNo' ORDER BY CodeSup ASC";
            $query = $this->pdo->prepare($sql);
            $query->execute();
                $a='';
            while($row = $query->fetch()){
              //$a .='orderNo => '.$row['RepOrderNo'].'   dateOrdered => '.$row['DateOrdered'].'   supplier => '.$row['Supplier'].'    totalCost =>  '.round($row['TotalCost'],2);
              $productsArray[] = array('qty' => $row['Quantity'],'name' => $row['Nameofitem'],'Barcode' => $row['Barcode'], 'Price' => round($row['Price'],2), 'suppCode'=> $row['CodeSup'], 'pack' => $row['PackSize'], 'caseQty' => $row['CaseQuantity']);
            }
            
           
        return $productsArray;
    }
}
?>