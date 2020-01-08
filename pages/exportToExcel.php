<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');
ini_set('max_input_vars', 9000);
include('../class/classDb.php');
include('../class/classOrders.php');
include('../class/classXML.php');


    $storeNo = $_POST['storeNo'];
    $orderNo = $_POST['orderNo'];
	
	
	$xml = new xmlFile($_SERVER["DOCUMENT_ROOT"].'/dbXML.xml');
    $db = new dbConnection($xml->getConnectionArray());
	//$db = new dbConnection();
    $orders = new orders();
    $orders ->openConnection($db->getDbConnection($storeNo));
    $shopName = $db->getShopName();
    $orderListArray = $orders->generateProductsArray($orderNo);


require_once dirname(__FILE__) . '/../class/Excel/PHPExcel.php';

$objPHPExcel = new PHPExcel();

$cellArray = array("A","B","C","D","E","F");


$objPHPExcel->getProperties()->setCreator("Robert Kocjan")
							 ->setLastModifiedBy("Robert Kocjan")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Ordered QTY')
			->setCellValue('B1', 'Name')
			->setCellValue('C1', 'Barcode')
			->setCellValue('D1', 'Price')
			->setCellValue('E1', 'Supplier Code');
    
    $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
	    
    $columnWidth = 12;
    
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth($columnWidth);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth($columnWidth+5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth($columnWidth+5);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth($columnWidth+5);


    
    $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setWrapText(TRUE);

$cellNo = 2;
for ($i = 0; $i < count($orderListArray); $i++){
    
    $index = 0;
    
    
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$cellNo, ($orderListArray[$i]["pack"]*$orderListArray[$i]["caseQty"]));
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$cellNo, $orderListArray[$i]["name"]);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$cellNo, $orderListArray[$i]["Barcode"]);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$cellNo, $orderListArray[$i]["Price"]);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$cellNo, $orderListArray[$i]["suppCode"]);
	
	
	
    $totalSold = 0;
	$totalSoldQty = 0;
     

    $cellNo++;
}


$objPHPExcel->setActiveSheetIndex(0);

$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$date = date("Y-m-d");
$fileName = $shopName."_".$orderNo."_(".$date.")";
$fileName = str_replace(" ","_",$fileName).'.xlsx';




$objWriter->save('../files/'.$fileName);


$directory = explode("\\",dirname(dirname(__FILE__)));

$pathToFile = dirname(pathinfo(__FILE__)['dirname']).'\\files\\'.$fileName;

if (file_exists($pathToFile)){
    echo "Click to download <a href = '/".$directory[count($directory)-1]."/files/".$fileName."'>".$fileName."</a>";    
}else{
    echo "Ups.. something went wrong and file wasn't created. Contact Robert.";    
}


?>