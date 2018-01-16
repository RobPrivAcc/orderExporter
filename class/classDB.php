 <?php
 class dbConnection{
    
    /*
        0 - Petzone
        1 - Donaghmede
        2 - Petco
        3 - Charlestown
        4 - Swords
    */
    
    
    private $user = "sa";
    private $password = "SMITH09ALPHA";
    private $index;
    
    private $dbConnectionArray;
  
    function __construct(){
        $array[0] = array(
                         'shopName' => 'petzone',
                         'server' => 'sqlsrv:Server=83.70.181.34,1317;Database=petshoptest',
                         'localServer' => 'sqlsrv:Server=192.168.1.2\SQLEXPRESS;Database=petshoptest',//SANGOTILL2\SQLEXPRESS
                         'user' => $this -> user,
                         'password' => $this -> password,
                         'shopNo' => 'PTZ01'
                        );
        $array[1] = array(
                        'shopName' => 'donaghmede',
                        'server' => 'sqlsrv:Server=86.47.50.197,1317;Database=petshoptest',
                        'localServer' => 'sqlsrv:Server=192.168.1.7\SQLEXPRESS;Database=petshoptest',//DESKTOP-REFEMD1\SQLEXPRESS
                        'user' => $this -> user,
                        'password' => $this -> password,
                        'shopNo' => 'PTZ02'           
                    );
        $array[4] = array(
                        'shopName' => 'swords',
                        'server' => 'sqlsrv:Server=95.44.179.19,1317;Database=Petshoptest',
                        'localServer' => 'sqlsrv:Server=192.168.1.5\SQLEXPRESS;Database=Petshoptest',// SANGOTILL3
                        'user' => $this -> user,
                        'password' => $this -> password,
                        'shopNo' => 'PTZ05'           
                    );
        $array[2] = array(
                        'shopName' => 'petco',
                        'server' => 'sqlsrv:Server=86.47.51.83,1317;Database=petshoptest',
                        'localServer' => 'sqlsrv:Server=192.168.1.16\SQLEXPRESS;Database=petshoptest',//SANGOTILL1\SQLEXPRESS
                        'user' => $this -> user,
                        'password' => $this -> password,
                        'shopNo' => 'PTZ03'
                    );
        $array[3] = array(
                        'shopName' => 'charlestown',
                        'server' => 'sqlsrv:Server=86.44.78.210,1317;Database=PremierEPOS',
                        'localServer' => 'sqlsrv:Server=192.168.1.2\SQLEXPRESS;Database=PremierEPOS',
                        'user' => $this -> user,
                        'password' => $this -> password,
                        'shopNo' => 'PTZ04'
                    );
        $this->dbConnectionArray = $array;
    }
  
    public function getMaxIndex(){
        return count($this -> dbConnectionArray);
    }
    
    public function getShopName(){
        return $this -> dbConnectionArray[$this -> index]['shopName'];
    }
    
    public function getShopNo(){
         return $this -> dbConnectionArray[$this -> index]['shopNo'];
    }

    public function getDbConnection($index){
        $this -> index = $index;
        if($this -> index > $this -> getMaxIndex()){
            return "Out of range. Max index =".count($this -> dbConnectionArray);
        }else{
            return $this -> dbConnectionArray[$this -> index];
        }
     }

     public function getShopsName(){
      $shopNameArray = "";
      
      for ($i = 0; $i < $this -> getMaxIndex(); $i++){
         $shopNameArray[] = array($this -> dbConnectionArray[$i]['shopName'],$this -> dbConnectionArray[$i]['shopNo']);
      }
      return $shopNameArray;
     }
}
?>