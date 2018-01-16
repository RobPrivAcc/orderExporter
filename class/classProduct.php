<?php
class product{
    
    private $pdo=null;
    private $petcoPDO = null;
    
    private function showDate(){
        return date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")-90,   date("Y")));
    }
    
    function openConnection($dbConnectionArray,$storeOrAway,$storeIndex){
        if($storeOrAway == 99){
            $this->pdo = new PDO($dbConnectionArray["server"],$dbConnectionArray["user"],$dbConnectionArray["password"]);
        }else{
            if($storeOrAway == $storeIndex){
                $this->pdo = new PDO($dbConnectionArray["localServer"],$dbConnectionArray["user"],$dbConnectionArray["password"]);
            }else{
                $this->pdo = new PDO($dbConnectionArray["server"],$dbConnectionArray["user"],$dbConnectionArray["password"]);
            }
            
        }
    }
    
    //private function getPetcoDbString(){
    //   $tempPdo = null;
    //    try{
    //        throw new Exception($tempPdo = new PDO("sqlsrv:Server=86.47.51.83,1317;Database=petshoptest","sa","SMITH09ALPHA")); // charlestown db test
    //    }catch(Exception $e){
    //        $tempPdo = new PDO("sqlsrv:Server=Server=192.168.1.2\SQLEXPRESS;Database=petshoptest","sa","SMITH09ALPHA");
    //    }
    //    $this->petcoPDO = $tempPdo;
    //}
    
    /*
     *
     *Gettind list of all supplier name's and add it to select list
     *
     */
    //function supplierList(){
    //    $this->getPetcoDbString();
    //    //$petcoPDO = this->getPetcoDbString();
    //    $option = "";
    //        $sql = "SELECT [Supplier] FROM [Suppliers] ORDER BY [Supplier] ASC";
    //        $query = $this->petcoPDO->prepare($sql);
    //        $query->execute();
    //            
    //        while($row = $query->fetch()){
    //          $option .= "<option>".$row['Supplier']."</option>";
    //        }
    //        
    //        $petcoPDO = null;
    //    return $option;
    //}
    
    
    /*
     **
     **
     ** get all products from choosen supplier
     **
     **
     **/
    
    function allProdFromSupplier($supplierName){
        $petcoPDO = new PDO("sqlsrv:Server=86.47.51.83,1317;Database=petshoptest","sa","SMITH09ALPHA");
        
        
            $sql = "SELECT [Name of Item], [Selling Price], [InternalRefCode], [CodeSup] FROM [Stock] WHERE [SupplierName] = '".$supplierName."' AND Discontinued = '0' ORDER BY [Name of Item] ASC";
            $query = $petcoPDO->prepare($sql);
            $query->execute();
            
            $prodFromSupArray = array();    
            while($row = $query->fetch()){
              $prodFromSupArray[] = array('name' => $row['Name of Item'],'salePrice' => round($row['Selling Price'],2),'supCode' => $row['CodeSup'],'intCode' => $row['InternalRefCode']);
            }
            
            $petcoPDO = null;
        return $prodFromSupArray;
    }
    
    
    
    function saleDetails($supplierName){
        $sql = "SELECT [Name of Item],SUM([QuantityBought]) as total, [Selling Price], (SUM([QuantityBought]) * [Selling Price]) as [value], Quantity
                FROM Stock
                	inner join [Orders] on [Name of Item] = [NameOfItem]
                	inner join [Days] on [Order Number] = OrderNo
				WHERE [Date] > '".$this->showDate()."'
                    AND SupplierName = '".$supplierName."' AND Discontinued = 0
                    group by [Selling Price],Quantity,[Name of Item] order by Stock.[Name of Item] ASC;";
    
        $query = $this->pdo->prepare($sql);
        $query->execute();
        
        $productArray = array();
        
        while($row = $query->fetch()){
            $productArray[] = array('name' => $row['Name of Item'], 'sold' => round($row['total'],2), 'currentQty' => $row['Quantity']);
        }
        return $productArray;
    }
    
    function qtyDetails($supplierName){
        $sql = "SELECT [Name of Item], Quantity,[Selling Price]
                FROM Stock
                WHERE SupplierName = '".$supplierName."' AND Discontinued = 0
                ORDER BY [Name of Item] ASC;";
                
        $query = $this->pdo->prepare($sql);
        $query->execute();
        
        $qtyArray = array();

        while($row = $query->fetch()){
            $qtyArray[$row['Name of Item']] = array('qty' => $row['Quantity'], 'sellPrice' => round($row['Selling Price'],2));
        }
        
        return $qtyArray;
    }
    
    
    function getDate(){
        return $this->showDate();
    }
    
    function close(){
        $this->pdo = null;
    }
}
?>