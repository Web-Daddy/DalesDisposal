<?php
function EWD_OTP_Export_To_Excel() {
		global $wpdb;
		global $EWD_OTP_orders_table_name;
		global $EWD_OTP_customers;
		global $EWD_OTP_sales_reps;
		global $EWD_OTP_fields_table_name;
		global $EWD_OTP_fields_meta_table_name;

		ob_clean();
		
		$Email_Confirmation = get_option("EWD_OTP_Email_Confirmation");
		
		include_once(EWD_OTP_CD_PLUGIN_PATH . '/PHPExcel/Classes/PHPExcel.php');

		if (isset($_GET['Format_Type'])) {$Format_Type = $_GET['Format_Type'];}
		if (isset($_GET['Sales_Rep_ID'])) {$Sales_Rep_ID = $_GET['Sales_Rep_ID'];}
		if (isset($_GET['Sales_Rep_Email'])) {$Sales_Rep_Email = $_GET['Sales_Rep_Email'];}
		if (isset($_GET['Customer_ID'])) {$Customer_ID = $_GET['Customer_ID'];}
		if (isset($_GET['Customer_Email'])) {$Customer_Email = $_GET['Customer_Email'];}

		if (isset($_GET['Sales_Rep_ID']) or isset($_GET['Customer_ID'])) {$Front_End_Download = true;}
		else {$Front_End_Download = false;}

		if ($Email_Confirmation == "Order_Email" and (isset($Customer_ID) or isset($Sales_Rep_ID))) {
			if (isset($Customer_ID)) {
				$Sql = "SELECT Customer_ID FROM $EWD_OTP_customers WHERE Customer_ID=%d AND Customer_Email=%s"; 
				$Arguments = array($Customer_ID, $Customer_Email);
			}
			if (isset($Sales_Rep_ID)) {
				$Sql = "SELECT Sales_Rep_ID FROM $EWD_OTP_sales_reps WHERE Sales_Rep_ID=%d AND Sales_Rep_Email=%s"; 
				$Arguments = array($Sales_Rep_ID, $Sales_Rep_Email);
			}

			$wpdb->get_results($wpdb->prepare($Sql, $Arguments));
			if ($wpdb->num_rows == 0) {return;}
		}

		if (!isset($Customer_ID) and !isset($Sales_Rep_ID) and !is_admin()) {return;}
		
		// Instantiate a new PHPExcel object 
		$objPHPExcel = new PHPExcel();  
		// Set the active Excel worksheet to sheet 0 
		$objPHPExcel->setActiveSheetIndex(0);  

		// Print out the regular order field labels
		$objPHPExcel->getActiveSheet()->setCellValue("A1", "Name");
		$objPHPExcel->getActiveSheet()->setCellValue("B1", "Number");
		$objPHPExcel->getActiveSheet()->setCellValue("C1", "Order Status");
		$objPHPExcel->getActiveSheet()->setCellValue("D1", "Order Status Updated (Read-Only)");
		$objPHPExcel->getActiveSheet()->setCellValue("E1", "Display");
		$objPHPExcel->getActiveSheet()->setCellValue("F1", "Notes Public");
		$objPHPExcel->getActiveSheet()->setCellValue("G1", "Notes Private");
		$objPHPExcel->getActiveSheet()->setCellValue("H1", "Email");

		//start of printing column names as names of custom fields  
		$column = 'I';
		$Sql = "SELECT * FROM $EWD_OTP_fields_table_name";
		$Custom_Fields = $wpdb->get_results($Sql);
		foreach ($Custom_Fields as $Custom_Field) {
     		$objPHPExcel->getActiveSheet()->setCellValue($column."1", $Custom_Field->Field_Name);
    		$column++;
		}  

		//start while loop to get data  
		$rowCount = 2;  
		$Sql = "SELECT * FROM $EWD_OTP_orders_table_name WHERE 1=%d ";
		$Arguments = array(1);
		if (isset($Customer_ID)) {$Sql .= "AND Customer_ID=%d "; $Arguments[] = $Customer_ID;}
		if (isset($Sales_Rep_ID)) {$Sql .= "AND Sales_Rep_ID=%d "; $Arguments[] = $Sales_Rep_ID;}
		$Orders = $wpdb->get_results($wpdb->prepare($Sql, $Arguments));
		foreach ($Orders as $Order)  
		{  
    	 	$objPHPExcel->getActiveSheet()->setCellValue("A" . $rowCount, $Order->Order_Name);
				$objPHPExcel->getActiveSheet()->setCellValue("B" . $rowCount, $Order->Order_Number);
				$objPHPExcel->getActiveSheet()->setCellValue("C" . $rowCount, $Order->Order_Status);
				$objPHPExcel->getActiveSheet()->setCellValue("D" . $rowCount, $Order->Order_Status_Updated);
				$objPHPExcel->getActiveSheet()->setCellValue("E" . $rowCount, $Order->Order_Display);
				$objPHPExcel->getActiveSheet()->setCellValue("F" . $rowCount, $Order->Order_Notes_Public);
				$objPHPExcel->getActiveSheet()->setCellValue("G" . $rowCount, $Order->Order_Notes_Private);
				$objPHPExcel->getActiveSheet()->setCellValue("H" . $rowCount, $Order->Order_Email);
				
				$column = 'I';
    		foreach ($Custom_Fields as $Custom_Field) {  
        	  $MetaValue = $wpdb->get_var($wpdb->prepare("SELECT Meta_Value FROM $EWD_OTP_fields_meta_table_name WHERE Order_ID=%d AND Field_ID=%d", $Order->Order_ID, $Custom_Field->Field_ID));

        		$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $MetaValue);
        		$column++;
    		}  
    		$rowCount++;
		} 

		if ($Front_End_Download) {$objPHPExcel->getActiveSheet()->removeColumn('G');}

		// Redirect output to a client’s web browser (Excel5) 
		if (isset($Format_Type) and $Format_Type == "CSV") {
			header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="Order_Export.csv"'); 
			header('Cache-Control: max-age=0'); 
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
			$objWriter->save('php://output');
		}
		else {
			header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="Order_Export.xls"'); 
			header('Cache-Control: max-age=0'); 
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
			$objWriter->save('php://output');
		}

		exit();
}
?>