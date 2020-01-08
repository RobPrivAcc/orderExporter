<!doctype html>
<html lang="en">
  <head>
    <title>Order to Excel Export</title>
        <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="css/myCSS.css">
    
  </head>
  <body>
    <?php
        //include("class/classOrders.php");
        //include("class/classDB.php");
        include("class/classDb.php");
        include("class/classXML.php");
    ?>
    <div class="container-fluid" id="mainContainer">
        <div class="row">
          <div class='col-xs-10 col-10'>
            <div class="radio">
            <?php
            
              $xml = new xmlFile($_SERVER["DOCUMENT_ROOT"].'/dbXML.xml');
              $db = new dbConnection($xml->getConnectionArray());
          
          #    $db = new dbConnection();
              
              //print_r($db -> getShopsName());
              $shopsArray = $db -> getShopsName();
              $radio = "";
              for($i=0; $i < count($shopsArray);$i++){
                $radio .= "<label><input type='radio' name = 'shopNo' value='".$i."'/>".$shopsArray[$i][0]." (".$shopsArray[$i][1].") &nbsp;&nbsp;</label>";
              }
              echo $radio;
            ?>  
            </div>
          </div>
          
          <div class='col-xs-2 col-2'>
              <button class = "btn btn-default" id = "search" onclick="store();"><i class="fa fa-search" aria-hidden="true"></i></button>
          </div>
        </div>
        
        <div class="row">
          <div class='col-xs-12 col-12'>
            <div id="result" style="width: 100%;"></div>
          </div>
        </div>
    </div>

        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  
  <script>
    function store(){
      
        var storeNo = $("[name='shopNo']:checked").val();
            
        $.post( "sql/sqlProductList.php", { storeNo: storeNo })
            .done(function( data ) {
                $('#result').html(data);
            });
        }
        
    function orderDetail(id){
      var storeNo = $("[name='shopNo']:checked").val();
              $.post( "pages/exportToExcel.php", { storeNo: storeNo, orderNo: id })
            .done(function( data ) {
                $('#result').html(data);
            });
    }
  </script>
</body>
</html>