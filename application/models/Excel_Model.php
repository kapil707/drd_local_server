<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Excel_Model extends CI_Model
{
	/*************************staff reports*****************************/
	public function staff_download_item_wise_report($session,$division,$compcode,$from,$to,$download_type)
	{
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		error_reporting(0);
		ob_clean();
		
		$from1 	= date("d-M-Y",strtotime($from));
		$to1 	= date("d-M-Y",strtotime($to));

		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A5','')
		->setCellValue('B5','CODE')
		->setCellValue('C5','CUSTOMER')
		->setCellValue('D5','QTY')
		->setCellValue('E5','FREE')
		->setCellValue('F5','AMOUNT')
		->setCellValue('G5','ADDRESS')
		->setCellValue('H5','MOBILE');
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setCellValueByColumnAndRow(0, 1, "D.R.DISTRIBUTORS PVT.LTD.");
		$sheet->setCellValueByColumnAndRow(0, 2, "F2/6, OKHLA INDUSTRIAL AREA, PHASE 1, NEW DELHI 110020");
		$sheet->setCellValueByColumnAndRow(0, 3, "Item Wise - Customer Wise Sale");
		$sheet->setCellValueByColumnAndRow(0, 4, "From :$from1 To : $to1");
		$sheet->mergeCells('A1:H1');
		$sheet->mergeCells('A2:H2');
		$sheet->mergeCells('A3:H3');
		$sheet->mergeCells('A4:H4');
		$sheet->getStyle('A1')->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
		);
		$sheet->getStyle('A2')->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
		);
		$sheet->getStyle('A3')->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
		);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray(array('font' => array('size' => 18,'bold' => FALSE,'name'  => 'Calibri','color' => ['rgb' => '973939'],)));		
		
		$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '398000'],)));		
		
		$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->applyFromArray(array('font' => array('size' => 15,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '000080'],)));	
		$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getFont()->setUnderline(true);		
		
		$objPHPExcel->getActiveSheet()->getStyle('A4:H4')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '973939'],)));			
		
		$objPHPExcel->getActiveSheet()
        ->getStyle('A5:H5')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('e68c85');
		
		$BStyle = array(
		  'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);
		$objPHPExcel->getActiveSheet()->getStyle('A5:H5')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('A5:H5')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '000000'],)));
		
		$myint_i = 0;
		$query = $this->Corporate_Model->item_wise_report($division,$compcode,$from,$to);
		$rowCount 		= 6;
		$total_qty1 	= 0;
		$total_free1 	= 0;
		$total_amt1 	= 0;
		$itm_c1 = $itm_c2 =0;
		$itm_c3 = $itm_c4 =0;
		$showone = 0;
		$fileok = 0;
		foreach($query as $row)
		{
			$fileok = 1;
			$itemc 	= $row->itemc;
			
			$itm_c3 = $row->itemc;
			if($itm_c3!=$itm_c4)
			{
				if($showone!=0)
				{
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"Total");
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$total_qty);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$total_free);
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,$total_amt);
					
					$objPHPExcel->getActiveSheet()
					->getStyle('A'.$rowCount.':H'.$rowCount)
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setRGB('FDFE9F');
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':H'.$rowCount)->applyFromArray($BStyle);
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':H'.$rowCount)->applyFromArray(array('font' => array('size' => 9,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '0000FF'],)));
					$rowCount++;
				}
			}
			$showone++;
			
			$itm_c1 = $row->itemc;
			if($itm_c1!=$itm_c2)
			{
				$itm_c2 = $row->itemc;
				$itm_c4 = $row->itemc;
				$sheet->mergeCells('A'.$rowCount.':H'.$rowCount);
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"Item : ".$row->name." Packing : ".$row->pack." Current Stock : ".round($row->batchqty));
				$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':H'.$rowCount)->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '973939'],)));		
				$rowCount++;
				
				$total_qty 	= 0;
				$total_free	= 0;
				$total_amt 	= 0;
			}
			
			$c_name 		= $row->c_name;
			$c_address 		= $row->address;
			$c_mobile 		= $row->mobile;
			$c_id 			= $row->altercode;
			
			if($row->vtype=="SR")
			{
				$row->qty 		= 0 - $row->qty;
				$row->netamt 	= 0 - $row->netamt;
			}
				
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,$c_id);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,$c_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$row->qty);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$row->fqty);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,$row->netamt);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,$c_address);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,$c_mobile);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':H'.$rowCount)->applyFromArray($BStyle);
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':H'.$rowCount)->applyFromArray(array('font' => array('size' => 10,'bold' => FALSE,'name'  => 'Calibri')));
			$rowCount++;
			
			$total_qty 	= $total_qty 	+ $row->qty;
			$total_free	= $total_free 	+ $row->fqty;
			$total_amt 	= $total_amt 	+ $row->netamt;
			
			$total_qty1	= $total_qty1	+ $row->qty;
			$total_free1= $total_free1 	+ $row->fqty;
			$total_amt1	= $total_amt1 	+ $row->netamt;			
		}
		
		/**************last walay total ko show ke liya******************/
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"Total");
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$total_qty);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$total_free);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,$total_amt);
		
		$objPHPExcel->getActiveSheet()
		->getStyle('A'.$rowCount.':H'.$rowCount)
		->getFill()
		->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		->getStartColor()
		->setRGB('FDFE9F');
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':H'.$rowCount)->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':H'.$rowCount)->applyFromArray(array('font' => array('size' => 9,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '0000FF'],)));	
		$rowCount++;
		/*******************************************************/
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"Grand Total");
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$total_qty1);
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$total_free1);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,$total_amt1);
		
		$objPHPExcel->getActiveSheet()
        ->getStyle('A'.$rowCount.':H'.$rowCount)
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('FDFE9F');
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':H'.$rowCount)->applyFromArray($BStyle);
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':H'.$rowCount)->applyFromArray(array('font' => array('size' => 9,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '973939'],)));
		
		$name = "Item Wise - Customer Wise Sale";
		if($download_type=="direct_download")
		{
			$file_name = $name.".xls";
			
			//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
			/*$objWriter->save('uploads_sales/kapilkifile.xls');*/
			
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename='.$file_name);
			header('Cache-Control: max-age=0');
			ob_start();
			$objWriter->save('php://output');
			$data = ob_get_contents();
		}
		if($download_type=="cronjob_download")
		{
			if($fileok==1)
			{
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
				$file_name = "corporate_report/item_wise_report_".$user_compcode."_".$user_division."_".time().".xls";
				
				$file_name2 = "email_files/item_wise_report_".$user_compcode."_".$user_division."_".time().".xls";
				$objWriter->save($file_name);
				$objWriter->save($file_name2);
				return $file_name2;
			}
			else
			{
				$file_name = "";
				return $file_name;
			}
		}
	}

	public function staff_download_chemist_wise_report($session,$division,$compcode,$from,$to,$download_type)
	{
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		error_reporting(0);
		ob_clean();
		
		$tbl_staffdetail = $this->db->query("select company_full_name,comp_altercode from tbl_staffdetail where compcode='$compcode'")->row();
		
		$from1 	= date("d-M-Y",strtotime($from));
		$to1 	= date("d-M-Y",strtotime($to));

		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A6','Party Name')
		->setCellValue('B6','Item Name')
		->setCellValue('C6','Division')
		->setCellValue('D6','Pack')
		->setCellValue('E6','Qty.')
		->setCellValue('F6','Free')
		->setCellValue('G6','Amount')
		->setCellValue('H6','Address')
		->setCellValue('I6','Mobile');
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(70);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
		
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setCellValueByColumnAndRow(0, 1, "D.R.DISTRIBUTORS PVT.LTD.");
		$sheet->setCellValueByColumnAndRow(0, 2, "F2/6, OKHLA INDUSTRIAL AREA, PHASE 1, NEW DELHI 110020");
		$sheet->setCellValueByColumnAndRow(0, 3, "CUSTOMER-ITEM WISE SALE");
		$sheet->setCellValueByColumnAndRow(0, 4, "From :$from1 To : $to1");
		$sheet->setCellValueByColumnAndRow(0, 5, "COMPANY : $tbl_staffdetail->comp_altercode  [ $tbl_staffdetail->company_full_name ]");
		
		//$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(25);
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setWrapText(true);
		$sheet->mergeCells('A1:I1');
		$sheet->mergeCells('A2:I2');
		$sheet->mergeCells('A3:I3');
		$sheet->mergeCells('A4:I4');
		$sheet->mergeCells('A5:I5');
		$sheet->getStyle('A1')->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
		);
		$sheet->getStyle('A2')->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
		);
		$sheet->getStyle('A3')->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
		);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray(array('font' => array('size' => 18,'bold' => FALSE,'name'  => 'Calibri','color' => ['rgb' => '973939'],)));		
		
		$objPHPExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '398000'],)));	
		
		$objPHPExcel->getActiveSheet()->getStyle('A3:I3')->applyFromArray(array('font' => array('size' => 15,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '000080'],)));	
		$objPHPExcel->getActiveSheet()->getStyle('A3:I3')->getFont()->setUnderline(true);	
		
		$objPHPExcel->getActiveSheet()->getStyle('A4:I4')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '973939'],)));
		
		$objPHPExcel->getActiveSheet()->getStyle('A5:I5')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '000000'],)));	
		
		$objPHPExcel->getActiveSheet()
        ->getStyle('A6:I6')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('e68c85');
		
		$BStyle = array(
		  'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);
		$objPHPExcel->getActiveSheet()->getStyle('A6:I6')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '000000'],)));
		
		$myint_i = 0;
		$query = $this->Corporate_Model->chemist_wise_report($division,$compcode,$from,$to);
		$rowCount 		= 7;
		$total_qty1 	= 0;
		$total_free1 	= 0;
		$total_amt1 	= 0;
		$fileok=0;
		$myaltercode="";
		foreach($query as $row)
		{		
			$fileok=1;
			if($rowCount!=7)
			{
				if($myaltercode!=$row->altercode)
				{	
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"Total Value ($myaltercode)");
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$total_qty);
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,$total_fqty);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,$total_amt);
					
					$objPHPExcel->getActiveSheet()
					->getStyle('A'.$rowCount.':I'.$rowCount)
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setRGB('FDFE9F');
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray($BStyle);
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray(array('font' => array('size' => 9,'bold' => TRUE,'name'  => 'Arial','color' => ['rgb' => '0000FF'],)));
					
					$rowCount++;
					
					$total_qty = $total_fqty = $total_amt = 0;
					
					$myaltercode=$row->altercode;
				}
			}
			else{
				$myaltercode = $row->altercode;
			}
			if($row->vtype=="SR")
			{
				$row->qty 		= 0 - $row->qty;
				$row->netamt 	= 0 - $row->netamt;
			}
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,$row->c_name."(".$row->altercode.")");
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,$row->name);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,$row->division);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$row->pack);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$row->qty);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,$row->fqty);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,$row->netamt);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,$row->address);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,$row->mobile);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray($BStyle);
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray(array('font' => array('size' => 9,'bold' => false,'name'  => 'Arial','color' => ['rgb' => '000000'],)));
			
			$total_qty 	= $total_qty 	+ $row->qty;
			$total_fqty = $total_fqty 	+ $row->fqty;
			$total_amt 	= $total_amt 	+ $row->netamt;
			
			$total_qty_f 	= $total_qty_f	+ $row->qty;
			$total_fqty_f 	= $total_fqty_f	+ $row->fqty;
			$total_amt_f 	= $total_amt_f	+ $row->netamt;
			$rowCount++;
		}
		
		/***********************************************/
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"Total Value ($myaltercode)");
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$total_qty);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,$total_fqty);
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,$total_amt);
		
		$objPHPExcel->getActiveSheet()
		->getStyle('A'.$rowCount.':I'.$rowCount)
		->getFill()
		->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		->getStartColor()
		->setRGB('FDFE9F');
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray($BStyle);
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray(array('font' => array('size' => 9,'bold' => TRUE,'name'  => 'Arial','color' => ['rgb' => '0000FF'],)));
		
		$rowCount++;
		
		/***********************************************/
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"Grand Total");
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$total_qty_f);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,$total_fqty_f);
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,$total_amt_f);
		
		$objPHPExcel->getActiveSheet()
        ->getStyle('A'.$rowCount.':I'.$rowCount)
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('FDFE9F');
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray($BStyle);
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray(array('font' => array('size' => 9,'bold' => TRUE,'name'  => 'Arial','color' => ['rgb' => '973939'],)));
		
		$name = "Customer - Item Wise Sale";
		if($download_type=="direct_download")
		{
			$file_name = $name.".xls";
			
			//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
			/*$objWriter->save('uploads_sales/kapilkifile.xls');*/
			
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename='.$file_name);
			header('Cache-Control: max-age=0');
			ob_start();
			$objWriter->save('php://output');
			$data = ob_get_contents();
		}
		if($download_type=="cronjob_download")
		{
			if($fileok==1)
			{
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
				$file_name = "corporate_report/chemist_wise_report_".$user_compcode."_".$user_division."_".time().".xls";
				
				$file_name2 = "email_files/chemist_wise_report_".$user_compcode."_".$user_division."_".time().".xls";
				$objWriter->save($file_name);
				$objWriter->save($file_name2);
				return $file_name2;
			}
			else
			{
				$file_name = "";
				return $file_name;
			}
		}
	}

	public function staff_download_stock_and_sales_analysis($session,$division,$compcode,$from,$to,$download_type)
	{
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		error_reporting(0);
		ob_clean();
		
		$tbl_staffdetail = $this->db->query("select company_full_name,comp_altercode from tbl_staffdetail where compcode='$compcode'")->row();
		
		$from1 	= date("d-M-Y",strtotime($from));
		$to1 	= date("d-M-Y",strtotime($to));

		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A6','Item Name')
		->setCellValue('B6','Pack')
		->setCellValue('C6','Opening')
		->setCellValue('D6','Purchase')
		->setCellValue('E6','Purchase Return')
		->setCellValue('F6','Sale')
		->setCellValue('G6','Sale Return')
		->setCellValue('H6','Others')
		->setCellValue('I6','Closing');
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setCellValueByColumnAndRow(0, 1, "D.R.DISTRIBUTORS PVT.LTD.");
		$sheet->setCellValueByColumnAndRow(0, 2, "F2/6, OKHLA INDUSTRIAL AREA, PHASE 1, NEW DELHI 110020\nCIN : U51909DL2004PTC125295  GST No. : 07AABCD9532A1Z1");
		$sheet->setCellValueByColumnAndRow(0, 3, "SALE AND STOCK ANALYSIS");
		$sheet->setCellValueByColumnAndRow(0, 4, "From : $from1 To : $to1");
		$sheet->setCellValueByColumnAndRow(0, 5, "COMPANY : $tbl_staffdetail->comp_altercode  [ $tbl_staffdetail->company_full_name ]");
		$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(25);
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setWrapText(true);
		$sheet->mergeCells('A1:I1');
		$sheet->mergeCells('A2:I2');
		$sheet->mergeCells('A3:I3');
		$sheet->mergeCells('A4:I4');
		$sheet->mergeCells('A5:I5');
		$sheet->getStyle('A1')->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
		);
		$sheet->getStyle('A2')->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
		);
		$sheet->getStyle('A3')->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
		);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray(array('font' => array('size' => 12,'bold' => FALSE,'name'  => 'Arial','color' => ['rgb' => '000000'],)));		
		
		$objPHPExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray(array('font' => array('size' => 8,'bold' => TRUE,'name'  => 'Arial','color' => ['rgb' => '000000'],)));		
		
		$objPHPExcel->getActiveSheet()->getStyle('A3:I3')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Arial','color' => ['rgb' => '000000'],)));	
		$objPHPExcel->getActiveSheet()->getStyle('A3:I3')->getFont()->setUnderline(true);		
		
		$objPHPExcel->getActiveSheet()->getStyle('A4:I4')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Arial','color' => ['rgb' => '000000'],)));
		
		$objPHPExcel->getActiveSheet()->getStyle('A5:I5')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Arial','color' => ['rgb' => '000000'],)));		
		
		$objPHPExcel->getActiveSheet()
        ->getStyle('A6:I6')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('e68c85');
		
		$BStyle = array(
		  'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);
		$objPHPExcel->getActiveSheet()->getStyle('A6:I6')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('A6:I6')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '000000'],)));
		
		$myint_i = 0;
		$query = $this->Corporate_Model->stock_and_sales_analysis($division,$compcode,$from,$to);
		$rowCount 		= 7;
		$total_qty1 	= 0;
		$total_free1 	= 0;
		$total_amt1 	= 0;
		$fileok=0;
		$mydivision = "";
		$total_opening1 = $total_purchase1 = $total_sale1 = $total_sale_return1 = $total_other1 = $total_closing1 = 0;
		foreach($query as $row)
		{	
			if($row->division!=$mydivision)
			{	
				if($rowCount!="7")
				{
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"Total Value ($mydivision)");
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,round($total_opening1,2));
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,round($total_purchase1,2));
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,round($total_purchase_return1,2));
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,round($total_sale1,2));
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,round($total_sale_return1,2));
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,round($total_other1,2));
					$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,round($total_closing1,2));

					$objPHPExcel->getActiveSheet()
					->getStyle('A'.$rowCount.':I'.$rowCount)
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setRGB('FDFE9F');

					$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray($BStyle);

					$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray(array('font' => array('size' => 9,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '0000FF'],)));
					$rowCount++;
				}
				
				$sheet->mergeCells('A'.$rowCount.':I'.$rowCount);
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"Division : ".$row->division);
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray(array('font' => array('size' => 11,'bold' => true,'name'  => 'Calibri','color' => ['rgb' => 'ff0000'],)));
				$rowCount++;
				
				$mydivision = $row->division;
				
				$total_opening1 = $total_purchase1 = $total_sale1 = $total_sale_return1 = $total_other1 = $total_closing1 = 0;
			}
			
			$fileok=1;
			
			$itemc = $row->code;
			
			$open_b		= round($row->open_b);
			$TempOpqty	= round($row->TempOpqty);
			$clqty		= round($row->clqty);
			$TempClqty	= round($row->TempClqty);
			
			
				$final_open  = $clqty - ($open_b);
				$final_close = $clqty;
			
			
			
			$purchase 		= round($row->purchase);
			$sale 			= round($row->sale);	
			$sale_return 	= round($row->sale_return);
			$other1			= round($row->other1);
			$other2 		= round($row->other2);
			
			$total_other = 0;
			if($row->other1_1=="")
			{
				$row->other1_1 = 0;
			}
			
			if($row->other2_1=="")
			{
				$row->other2_1 = 0;
			}
			
			$other = 0;			
			if($other2!=0)
			{		
				$other 			= $other1 - $other2;
				$total_other 	= $row->other1_1;
			}
			else{
				$other 			= 0 - $other1;
				$total_other 	= 0 - $row->other1_1;
			}
			
			if($row->purchase1=="")
			{
				$row->purchase1 = 0;
			}
			$total_purchase = ($row->purchase1);	
			
			if($row->sale1=="")
			{
				$row->sale1 = 0;
			}
			$total_sale = ($row->sale1);
			
			if($row->sale_return1=="")
			{
				$row->sale_return1 = 0;
			}
			$total_sale_return = ($row->sale_return1);
			
			if($purchase=="")
			{
				$purchase = 0;
			}
			
			
			if($closing1=="0")
			{
				$closing 	= 0;
			}
			
			$total_opening = $final_open  * $row->costrate;
			$total_closing = $final_close * $row->costrate;
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,$row->name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,$row->pack);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,$final_open);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$purchase);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$purchase_return);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,$sale);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,$sale_return);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,$other);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,$final_close);
			//$objPHPExcel->getActiveSheet()->getStyle('H'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray($BStyle);
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray(array('font' => array('size' => 8,'bold' => false,'name'  => 'Calibri','color' => ['rgb' => '000000'],)));
			
			$total_opening1 	= $total_opening1 	+ $total_opening;
			$total_purchase1 	= $total_purchase1 	+ $total_purchase;
			$total_sale1 		= $total_sale1 		+ $total_sale;
			$total_sale_return1 = $total_sale_return1+ $total_sale_return;
			$total_other1 		= $total_other1 	+ $total_other;
			$total_closing1 	= $total_closing1 	+ $total_closing;
			
			/**************full total*******************************/
			$total_opening1_f 		= $total_opening1_f 	+ $total_opening;
			$total_purchase1_f		= $total_purchase1_f 	+ $total_purchase;
			$total_sale1_f			= $total_sale1_f 		+ $total_sale;
			$total_sale_return1_f 	= $total_sale_return1_f	+ $total_sale_return;
			$total_other1_f 		= $total_other1_f 		+ $total_other;
			$total_closing1_f 		= $total_closing1_f 	+ $total_closing;
			
			$rowCount++;
		}
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"Total Value ($row->division)");
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,round($total_opening1,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,round($total_purchase1,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,round($total_purchase_retrun1,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,round($total_sale1,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,round($total_sale_return1,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,round($total_other1,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,round($total_closing1,2));

		$objPHPExcel->getActiveSheet()
		->getStyle('A'.$rowCount.':I'.$rowCount)
		->getFill()
		->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		->getStartColor()
		->setRGB('FDFE9F');

		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray($BStyle);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray(array('font' => array('size' => 9,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '0000FF'],)));
		$rowCount++;
		
		/******full total***********************/
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"Total :");
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,round($total_opening1_f,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,round($total_purchase1_f,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,round(0,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,round($total_sale1_f,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,round($total_sale_return1_f,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,round($total_other1_f,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,round($total_closing1_f,2));
		
		$objPHPExcel->getActiveSheet()
        ->getStyle('A'.$rowCount.':I'.$rowCount)
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('FDFE9F');
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray($BStyle);
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray(array('font' => array('size' => 9,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '973939'],)));
		
		$name = "Sales And Stock Report";
		if($download_type=="direct_download")
		{
			$file_name = $name.".xls";
			
			//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
			/*$objWriter->save('uploads_sales/kapilkifile.xls');*/
			
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename='.$file_name);
			header('Cache-Control: max-age=0');
			ob_start();
			$objWriter->save('php://output');
			$data = ob_get_contents();
		}
		if($download_type=="cronjob_download")
		{
			if($fileok==1)
			{
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
				$file_name = "corporate_report/sales_and_stock_report_".$user_compcode."_".$user_division."_".time().".xls";
				
				$file_name2 = "email_files/sales_and_stock_report_".$user_compcode."_".$user_division."_".time().".xls";
				$objWriter->save($file_name);
				$objWriter->save($file_name2);
				return $file_name2;
			}
			else
			{
				$file_name = "";
				return $file_name;
			}
		}
	}
	
	public function staff_download_stock_and_sales_analysis_month($session,$division,$compcode,$from,$to,$download_type)
	{
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		error_reporting(0);
		ob_clean();
		
		$tbl_staffdetail = $this->db->query("select company_full_name,comp_altercode from tbl_staffdetail where compcode='$compcode'")->row();
		
		$from1 	= date("d-M-Y",strtotime($from));
		$to1 	= date("d-M-Y",strtotime($to));

		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A6','Item Name')
		->setCellValue('B6','Pack')
		->setCellValue('C6','Opening')
		->setCellValue('D6','Purchase')
		->setCellValue('E6','Purchase Return')
		->setCellValue('F6','Sale')
		->setCellValue('G6','Sale Return')
		->setCellValue('H6','Others')
		->setCellValue('I6','Closing');
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setCellValueByColumnAndRow(0, 1, "D.R.DISTRIBUTORS PVT.LTD.");
		$sheet->setCellValueByColumnAndRow(0, 2, "F2/6, OKHLA INDUSTRIAL AREA, PHASE 1, NEW DELHI 110020\nCIN : U51909DL2004PTC125295  GST No. : 07AABCD9532A1Z1");
		$sheet->setCellValueByColumnAndRow(0, 3, "SALE AND STOCK ANALYSIS");
		$sheet->setCellValueByColumnAndRow(0, 4, "From : $from1 To : $to1");
		$sheet->setCellValueByColumnAndRow(0, 5, "COMPANY : $tbl_staffdetail->comp_altercode  [ $tbl_staffdetail->company_full_name ]");
		$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(25);
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setWrapText(true);
		$sheet->mergeCells('A1:I1');
		$sheet->mergeCells('A2:I2');
		$sheet->mergeCells('A3:I3');
		$sheet->mergeCells('A4:I4');
		$sheet->mergeCells('A5:I5');
		$sheet->getStyle('A1')->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
		);
		$sheet->getStyle('A2')->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
		);
		$sheet->getStyle('A3')->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
		);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray(array('font' => array('size' => 12,'bold' => FALSE,'name'  => 'Arial','color' => ['rgb' => '000000'],)));		
		
		$objPHPExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray(array('font' => array('size' => 8,'bold' => TRUE,'name'  => 'Arial','color' => ['rgb' => '000000'],)));		
		
		$objPHPExcel->getActiveSheet()->getStyle('A3:I3')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Arial','color' => ['rgb' => '000000'],)));	
		$objPHPExcel->getActiveSheet()->getStyle('A3:I3')->getFont()->setUnderline(true);		
		
		$objPHPExcel->getActiveSheet()->getStyle('A4:I4')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Arial','color' => ['rgb' => '000000'],)));
		
		$objPHPExcel->getActiveSheet()->getStyle('A5:I5')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Arial','color' => ['rgb' => '000000'],)));		
		
		$objPHPExcel->getActiveSheet()
        ->getStyle('A6:I6')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('e68c85');
		
		$BStyle = array(
		  'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);
		$objPHPExcel->getActiveSheet()->getStyle('A6:I6')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('A6:I6')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '000000'],)));
		
		$myint_i = 0;
		$query = $this->Corporate_Model->stock_and_sales_analysis($division,$compcode,$from,$to);
		$rowCount 		= 7;
		$total_qty1 	= 0;
		$total_free1 	= 0;
		$total_amt1 	= 0;
		$fileok=0;
		$mydivision = "";
		$total_opening1 = $total_purchase1 = $total_sale1 = $total_sale_return1 = $total_other1 = $total_closing1 = 0;
		foreach($query as $row)
		{	
			if($row->division!=$mydivision)
			{	
				if($rowCount!="7")
				{
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"Total Value ($mydivision)");
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,round($total_opening1,2));
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,round($total_purchase1,2));
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,round($total_purchase_return1,2));
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,round($total_sale1,2));
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,round($total_sale_return1,2));
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,round($total_other1,2));
					$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,round($total_closing1,2));

					$objPHPExcel->getActiveSheet()
					->getStyle('A'.$rowCount.':I'.$rowCount)
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setRGB('FDFE9F');

					$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray($BStyle);

					$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray(array('font' => array('size' => 9,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '0000FF'],)));
					$rowCount++;
				}
				
				$sheet->mergeCells('A'.$rowCount.':I'.$rowCount);
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"Division : ".$row->division);
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray(array('font' => array('size' => 11,'bold' => true,'name'  => 'Calibri','color' => ['rgb' => 'ff0000'],)));
				$rowCount++;
				
				$mydivision = $row->division;
				
				$total_opening1 = $total_purchase1 = $total_sale1 = $total_sale_return1 = $total_other1 = $total_closing1 = 0;
			}
			
			$fileok=1;
			
			$itemc = $row->code;
			
			$open_b		= round($row->open_b);
			$TempOpqty	= round($row->TempOpqty);
			$clqty		= round($row->clqty);
			$TempClqty	= round($row->TempClqty);
			
			/*if($dbchange=="0"){
				$final_open  = $clqty - ($open_b);
				$final_close = $clqty;
			}*/
			
			
			$purchase 		= round($row->purchase);
			$sale 			= round($row->sale);	
			$sale_return 	= round($row->sale_return);
			$other1			= round($row->other1);
			$other2 		= round($row->other2);
			
			$total_other = 0;
			if($row->other1_1=="")
			{
				$row->other1_1 = 0;
			}
			
			if($row->other2_1=="")
			{
				$row->other2_1 = 0;
			}
			
			$other = 0;			
			if($other2!=0)
			{		
				$other 			= $other1 - $other2;
				$total_other 	= $row->other1_1;
			}
			else{
				$other 			= 0 - $other1;
				$total_other 	= 0 - $row->other1_1;
			}
			
			
				$final_open  = $TempOpqty - ($open_b);
				$final_close = $TempOpqty;
				
				/*
				$sale_return 	= round($row->sale_return);
				if($sale_return==""){
					$sale_return = "0";
				}
				$purchase 		= round($row->purchase);
				if($purchase==""){
					$purchase = "0";
					$other = abs($other); //jab purchase 0  ha to other nagtive nahi hoga
				}
				$sale 			= round($row->sale);
				if($sale==""){
					$sale = "0";
				}
				$final_close 	= $TempOpqty;	
				
				$purchase_return = round($row->purchase_return);
				if($purchase_return==""){
					$purchase_return = "0";
				}

				$final_open  	= ($TempOpqty) - ($purchase - $sale - $purchase_return) -  ($sale_return) - ($other);*/
			
			
			if($row->purchase1=="")
			{
				$row->purchase1 = 0;
			}
			$total_purchase = ($row->purchase1);	
			
			if($row->sale1=="")
			{
				$row->sale1 = 0;
			}
			$total_sale = ($row->sale1);
			
			if($row->sale_return1=="")
			{
				$row->sale_return1 = 0;
			}
			$total_sale_return = ($row->sale_return1);
			
			if($purchase=="")
			{
				$purchase = 0;
			}
			
			
			if($closing1=="0")
			{
				$closing 	= 0;
			}
			
			$total_opening = $final_open  * $row->costrate;
			$total_closing = $final_close * $row->costrate;
			
			$final_ans = ($final_close + ($purchase - $purchase_return)) - ($sale - $sale_return) + ($other);
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,$row->name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,$row->pack);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,$final_open);
			//$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,$final_close);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$purchase);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$purchase_return);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,$sale);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,$sale_return);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,$other);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,$final_close);
			//$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,$final_ans);
			//$objPHPExcel->getActiveSheet()->getStyle('H'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray($BStyle);
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray(array('font' => array('size' => 8,'bold' => false,'name'  => 'Calibri','color' => ['rgb' => '000000'],)));
			
			$total_opening1 	= $total_opening1 	+ $total_opening;
			$total_purchase1 	= $total_purchase1 	+ $total_purchase;
			$total_sale1 		= $total_sale1 		+ $total_sale;
			$total_sale_return1 = $total_sale_return1+ $total_sale_return;
			$total_other1 		= $total_other1 	+ $total_other;
			$total_closing1 	= $total_closing1 	+ $total_closing;
			
			/**************full total*******************************/
			$total_opening1_f 		= $total_opening1_f 	+ $total_opening;
			$total_purchase1_f		= $total_purchase1_f 	+ $total_purchase;
			$total_sale1_f			= $total_sale1_f 		+ $total_sale;
			$total_sale_return1_f 	= $total_sale_return1_f	+ $total_sale_return;
			$total_other1_f 		= $total_other1_f 		+ $total_other;
			$total_closing1_f 		= $total_closing1_f 	+ $total_closing;
			
			$rowCount++;
		}
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"Total Value ($row->division)");
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,round($total_opening1,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,round($total_purchase1,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,round($total_purchase_retrun1,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,round($total_sale1,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,round($total_sale_return1,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,round($total_other1,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,round($total_closing1,2));

		$objPHPExcel->getActiveSheet()
		->getStyle('A'.$rowCount.':I'.$rowCount)
		->getFill()
		->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		->getStartColor()
		->setRGB('FDFE9F');

		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray($BStyle);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray(array('font' => array('size' => 9,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '0000FF'],)));
		$rowCount++;
		
		/******full total***********************/
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"Total :");
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,round($total_opening1_f,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,round($total_purchase1_f,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,round(0,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,round($total_sale1_f,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,round($total_sale_return1_f,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,round($total_other1_f,2));
		$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,round($total_closing1_f,2));
		
		$objPHPExcel->getActiveSheet()
        ->getStyle('A'.$rowCount.':I'.$rowCount)
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('FDFE9F');
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray($BStyle);
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray(array('font' => array('size' => 9,'bold' => TRUE,'name'  => 'Calibri','color' => ['rgb' => '973939'],)));
		
		$name = "Sales And Stock Report";
		if($download_type=="direct_download")
		{
			$file_name = $name.".xls";
			
			//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
			/*$objWriter->save('uploads_sales/kapilkifile.xls');*/
			
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename='.$file_name);
			header('Cache-Control: max-age=0');
			ob_start();
			$objWriter->save('php://output');
			$data = ob_get_contents();
		}
		if($download_type=="cronjob_download")
		{
			if($fileok==1)
			{
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
				$file_name = "corporate_report/sales_and_stock_report_".$user_compcode."_".$user_division."_".time().".xls";
				
				$file_name2 = "email_files/sales_and_stock_report_".$user_compcode."_".$user_division."_".time().".xls";
				$objWriter->save($file_name);
				$objWriter->save($file_name2);
				return $file_name2;
			}
			else
			{
				$file_name = "";
				return $file_name;
			}
		}
	}


	public function staff_download_stock_and_sales_analysis_month_html($session,$division,$compcode,$from,$to)
	{		
		$tbl_staffdetail = $this->db->query("select company_full_name,comp_altercode from tbl_staffdetail where compcode='$compcode'")->row();
		
		$from1 	= date("d-M-Y",strtotime($from));
		$to1 	= date("d-M-Y",strtotime($to));		
		
		$return  = "<br><br><h1>SALE AND STOCK ANALYSIS</h1>D.R.DISTRIBUTORS PVT.LTD.";
		$return.= "<br>F2/6, OKHLA INDUSTRIAL AREA, PHASE 1, NEW DELHI 110020\nCIN : U51909DL2004PTC125295  GST No. : 07AABCD9532A1Z1";
		$return.= "<br>SALE AND STOCK ANALYSIS";
		$return.= "<br>From : $from1 To : $to1";
		$return.= "<br>COMPANY : $tbl_staffdetail->comp_altercode [ $tbl_staffdetail->company_full_name ] ";
		

		$myint_i = 0;
		$query = $this->Corporate_Model->stock_and_sales_analysis($division,$compcode,$from,$to);
		$rowCount 		= 7;
		$total_qty1 	= 0;
		$total_free1 	= 0;
		$total_amt1 	= 0;
		$fileok=0;
		$mydivision = "";
		$total_opening1 = $total_purchase1 = $total_sale1 = $total_sale_return1 = $total_other1 = $total_closing1 = 0;
		
		$return.= "<table border='1' width='100%'>";
		$return.= "<tr>";
			$return.= "<th>Item Name</th>";
			$return.= "<th>Pack</th>";
			$return.= "<th>Opening</th>";
			$return.= "<th>Purchase</th>";
			$return.= "<th>Purchase Return</th>";
			$return.= "<th>Sale</th>";
			$return.= "<th>Sale Return</th>";
			$return.= "<th>Others</th>";
			$return.= "<th>Closing</th>";
		$return.= "</tr>";
		
		foreach($query as $row)
		{	
			if($row->division!=$mydivision)
			{	
				$return.= "<tr><td colspan='9'>division : $row->division </td></tr>";
				
				$mydivision = $row->division;
				
				$total_opening1 = $total_purchase1 = $total_sale1 = $total_sale_return1 = $total_other1 = $total_closing1 = 0;
			}
			
			$fileok=1;
			
			$itemc = $row->code;
			
			$open_b		= round($row->open_b);
			$TempOpqty	= round($row->TempOpqty);
			$clqty		= round($row->clqty);
			$TempClqty	= round($row->TempClqty);
			
			$purchase 		= round($row->purchase);
			$sale 			= round($row->sale);	
			$sale_return 	= round($row->sale_return);
			$other1			= round($row->other1);
			$other2 		= round($row->other2);
			
			$total_other = 0;
			if($row->other1_1=="")
			{
				$row->other1_1 = 0;
			}
			
			if($row->other2_1=="")
			{
				$row->other2_1 = 0;
			}
			
			$other = 0;			
			if($other2!=0)
			{		
				$other 			= $other1 - $other2;
				$total_other 	= $row->other1_1;
			}
			else{
				$other 			= 0 - $other1;
				$total_other 	= 0 - $row->other1_1;
			}
			
			
			$final_open  = $TempOpqty - ($open_b);
			$final_close = $TempOpqty;
			
			
			if($row->purchase1=="")
			{
				$row->purchase1 = 0;
			}
			$total_purchase = ($row->purchase1);	
			
			if($row->sale1=="")
			{
				$row->sale1 = 0;
			}
			$total_sale = ($row->sale1);
			
			if($row->sale_return1=="")
			{
				$row->sale_return1 = 0;
			}
			$total_sale_return = ($row->sale_return1);
			
			if($purchase=="")
			{
				$purchase = 0;
			}
			
			
			if($closing1=="0")
			{
				$closing 	= 0;
			}
			
			$total_opening = $final_open  * $row->costrate;
			$total_closing = $final_close * $row->costrate;
			
			$final_ans = ($final_close + ($purchase - $purchase_return)) - ($sale - $sale_return) + ($other);
			

			$return.= "<tr>";
				$return.= "<td>$row->name</td>";
				$return.= "<td>$row->pack</td>";
				$return.= "<td>$final_open</td>";
				$return.= "<td>$purchase</td>";
				$return.= "<td>$purchase_return</td>";
				$return.= "<td>$sale</td>";
				$return.= "<td>$sale_return</td>";
				$return.= "<td>$other</td>";
				$return.= "<td>$final_close</td>";
			$return.= "</tr>";

			
			$total_opening1 	= $total_opening1 	+ $total_opening;
			$total_purchase1 	= $total_purchase1 	+ $total_purchase;
			$total_sale1 		= $total_sale1 		+ $total_sale;
			$total_sale_return1 = $total_sale_return1+ $total_sale_return;
			$total_other1 		= $total_other1 	+ $total_other;
			$total_closing1 	= $total_closing1 	+ $total_closing;
			
			/**************full total*******************************/
			$total_opening1_f 		= $total_opening1_f 	+ $total_opening;
			$total_purchase1_f		= $total_purchase1_f 	+ $total_purchase;
			$total_sale1_f			= $total_sale1_f 		+ $total_sale;
			$total_sale_return1_f 	= $total_sale_return1_f	+ $total_sale_return;
			$total_other1_f 		= $total_other1_f 		+ $total_other;
			$total_closing1_f 		= $total_closing1_f 	+ $total_closing;
			
			$rowCount++;
			
		}
		$return.= "</table>";
		
		return $return;
		
	}


    public function create_invoice_excle($vdt,$vno,$gstvno,$u_name,$chemist_id,$download_type)
	{
		
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		error_reporting(0);
		//ob_clean();		

		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1','SUPPLIER')
		->setCellValue('B1','BILL NO.')
		->setCellValue('C1','DATE')
		->setCellValue('D1','COMPANY')
		->setCellValue('E1','CODE')
		->setCellValue('F1','BARCODE')
		->setCellValue('G1','ITEM NAME')
		->setCellValue('H1','PACK')
		->setCellValue('I1','BATCH')
		->setCellValue('J1','EXPIRY')
		->setCellValue('K1','QTY')
		->setCellValue('L1','F.QTY')
		->setCellValue('M1','HALFP')
		->setCellValue('N1','FTRATE')
		->setCellValue('O1','SRATE')
		->setCellValue('P1','MRP')
		->setCellValue('Q1','DIS')
		->setCellValue('R1','EXCISE')
		->setCellValue('S1','VAT')
		->setCellValue('T1','ADNLVAT')
		->setCellValue('U1','AMOUNT')
		->setCellValue('V1','LOCALCENT')
		->setCellValue('W1','SCM1')
		->setCellValue('X1','SCM2')
		->setCellValue('Y1','SCMPER')
		->setCellValue('Z1','HSNCODE')
		->setCellValue('AA1','CGST')
		->setCellValue('AB1','SGST')
		->setCellValue('AC1','IGST')
		->setCellValue('AD1','PSRLNO')
		->setCellValue('AE1','TCSPER')
		->setCellValue('AF1','TCSAMT')
		->setCellValue('AG1','ALTERCODE');
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(14);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:AG1')->applyFromArray(array('font' => array('size' =>10,'bold' => TRUE,'name'  => 'Arial','color' => ['rgb' => '800000'],)));
		
		$objPHPExcel->getActiveSheet()
        ->getStyle('A1:AG1')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('ccffff');
		
		$BStyle = array(
		  'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);
		$objPHPExcel->getActiveSheet()->getStyle('A1:AG1')->applyFromArray($BStyle);
		
		$invoice_message_body = "<table border='1' width='100%'><tr><td>ITEM NAME</td><td>QTY</td><td>BATCH</td><td>EXPIRY</td></tr>";
		
		$result = $this->Drd_Invoice_Model->create_invoice_query($vdt,$vno);
		$rowCount = 2;
		$fileok=0;
		foreach($result as $row)
		{
			$fileok=1;
			$vdt = strtotime($row->vdt);
			$vdt = date('d/m/Y',$vdt);
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,$u_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,$gstvno);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,$vdt);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$row->company_full_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$row->itemc);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,(int)$row->item_code);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,$row->item_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,$row->packing);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,$row->batch);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount,$row->expiry);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount,$row->qty);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount,$row->fqty);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount,$row->halfp);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount,$row->ftrate);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount,$row->ntrate);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount,$row->mrp);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount,$row->dis);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount,$row->excise);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount,"0");
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount,$row->adnlvat);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount,$row->netamt);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount,$row->localcent);
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount,$row->scm1);
			$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount,$row->scm2);
			$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount,$row->scmper);
			$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount,$row->hsncode);
			$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount,$row->cgst);
			$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount,$row->sgst);
			$objPHPExcel->getActiveSheet()->SetCellValue('AC'.$rowCount,$row->igst);
			$objPHPExcel->getActiveSheet()->SetCellValue('AD'.$rowCount,$row->psrlno);
			$objPHPExcel->getActiveSheet()->SetCellValue('AE'.$rowCount,"0");
			$objPHPExcel->getActiveSheet()->SetCellValue('AF'.$rowCount,"0");
			$objPHPExcel->getActiveSheet()->SetCellValue('AG'.$rowCount,$chemist_id);
			
			
			$item_name  = $row->item_name;
			$qty  		= $row->qty;
			$batch  	= $row->batch;
			$expiry  	= $row->expiry;
			$invoice_message_body.= "<tr><td>$item_name</td><td>$qty</td><td>$batch</td><td>$expiry</td></tr>";
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':AG'.$rowCount)->applyFromArray($BStyle);
			$rowCount++;
		}
		
		$invoice_message_body.= "</table>";
		
		$name = $gstvno;
		if($download_type=="direct_download")
		{
			echo $file_name = $name.".xls";
			
			//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
			/*$objWriter->save('uploads_sales/kapilkifile.xls');*/
			
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename='.$file_name);
			header('Cache-Control: max-age=0');
			ob_start();
			$objWriter->save('php://output');
			$data = ob_get_contents();
		}
		
		if($download_type=="cronjob_download")
		{
			if($fileok==1)
			{
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
				$file_name = "email_files/".$name.".xls";
				$objWriter->save($file_name);
				
				$file_name2 = "invoice_files/".$name.".xls";
				$objWriter->save($file_name2);
				
				$x[0] = $file_name;
				$x[1] = $invoice_message_body;
 				return $x;
			}
			else
			{
				$file_name = "";
				return $file_name;
			}
		}
	}

	public function create_delete_invoice_excle($gstvno,$delete_query,$delete_query2,$download_type)
	{
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		error_reporting(0);
		ob_clean();
		

		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1','Code')
		->setCellValue('B1','Item Name')
		->setCellValue('C1','vno')
		->setCellValue('D1','vdt')
		->setCellValue('E1','slcd')
		->setCellValue('F1','amt')
		->setCellValue('G1','Namt')
		->setCellValue('H1','Remarks')
		->setCellValue('I1','Descp');
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray(array('font' => array('size' =>10,'bold' => TRUE,'name'  => 'Arial','color' => ['rgb' => '800000'],)));
		
		$objPHPExcel->getActiveSheet()
        ->getStyle('A1:I1')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('ccffff');
		
		$BStyle = array(
		  'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($BStyle);
		
		$whatsapp_message_delete_tbl = "<br>Following items have been *Delete* from your order:";		
		$invoice_message_body_delete_tbl = "<br><br>Following items have been <b>Delete</b> from your order: <br><br><table border='1' width='100%'><tr><td>Sr.No.</td><td>ITEM NAME</td><td>QTY</td></tr>";
		
		
		$whatsapp_message_edit_tbl = "<br>Following items have been *Edit* from your order:";
		$invoice_message_body_edit_tbl = "<br><br>Following items have been <b>Edit</b> from your order: <br><br><table border='1' width='100%'><tr><td>Sr.No.</td><td>ITEM NAME</td><td>QTY</td></tr>";

		
		$invoice_message_body_edit = $invoice_message_body_delete = "";
		
		$rowCount = 2;
		$fileok=0;
		$myi = 1;
		$myj = 1;
		
		$result = $delete_query;
		foreach($result as $row)
		{
			
			$vdt = strtotime($row->vdt);
			$vdt = date('m/d/Y',$vdt);
			
			$vno 		= $row->vno;
			$itemc 		= $row->itemc;
			$item_name 	= $row->item_name;
			$slcd  		= $row->slcd;
			$amt  		= $row->amt;
			$namt  		= $row->namt;
			$remarks  	= $row->remarks;
			$descp  	= $row->descp;
			
			$fileok=1;
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,$itemc);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,$item_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,$vno);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$vdt);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$slcd);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,$amt);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,$namt);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,$remarks);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,$descp);	

			$item_remarks1 = $remarks;
			if (stripos($item_remarks1, "#INSTANT") !== false) {
				$item_remarks1="ITEM DELETE";
			}
			if($item_remarks1=="ITEM DELETE"){
				$whatsapp_message_delete.="<br>*$myi*. *$item_name*<br>*Quantity : $amt*";				
				$invoice_message_body_delete.="<tr><td>$myi</td><td>$item_name</td><td>$amt</td></tr>";
				$myi++;
			}
			
			if (stripos($item_remarks1, "OLD QTY") !== false) {
				//echo "hello";
				$xmy = str_replace(" ","",$item_remarks1);
				$xmy = str_replace("OLDQTY:","OLDQTY,",$xmy);
				$xmy = str_replace("NEWQTY:","NEWQTY,",$xmy);
				$xmy = str_replace("BATCH","BATCH,",$xmy);
				$str_arr = explode(",",$xmy);
				$min = (int)$str_arr[1];
				$max = (int)$str_arr[2];
			
				if($min>$max){
					$item_remarks1="ITEM EDIT";
				}
			}
			if($item_remarks1=="ITEM EDIT"){
				$whatsapp_message_edit.="<br>*$myj*. *$item_name*<br>*Quantity : $amt*";				
				$invoice_message_body_edit.="<tr><td>$myj</td><td>$item_name</td><td>$amt</td></tr>";
				$myj++;
			}
						
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray($BStyle);
			$rowCount++;
		}
		
		$result = $delete_query2;
		foreach($result as $row)
		{
			
			$vdt = strtotime($row->vdt);
			$vdt = date('m/d/Y',$vdt);
			
			$vno 		= $row->vno;
			$itemc 		= $row->itemc;
			$item_name 	= $row->item_name;
			$slcd  		= $row->slcd;
			$amt  		= $row->amt;
			$namt  		= "0";
			$remarks  	= "ITEM DELETE";
			$descp  	= "ITEM DELETE";
			
			$fileok=1;
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,$itemc);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,$item_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,$vno);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$vdt);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$slcd);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,$amt);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,$namt);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,$remarks);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,$descp);	

			$item_remarks1 = $remarks;
			if (stripos($item_remarks1, "#INSTANT") !== false) {
				$item_remarks1="ITEM DELETE";
			}
			if($item_remarks1=="ITEM DELETE"){
				$whatsapp_message_delete.="<br>*$myi*. *$item_name*<br>*Quantity : $amt*";				
				$invoice_message_body_delete.="<tr><td>$myi</td><td>$item_name</td><td>$amt</td></tr>";
				$myi++;
			}
									
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->applyFromArray($BStyle);
			$rowCount++;
		}
		$invoice_message_body_delete_val = $whatsapp_message_delete_var = "";
		if($invoice_message_body_delete){
			$whatsapp_message_delete_var = $whatsapp_message_delete_tbl.$whatsapp_message_delete;
			$invoice_message_body_delete_val = $invoice_message_body_delete_tbl.$invoice_message_body_delete."</table>";
		}
		
		$invoice_message_body_edit_val = $whatsapp_message_edit_var = "";
		if($invoice_message_body_edit){
			$whatsapp_message_edit_var = $whatsapp_message_edit_tbl.$whatsapp_message_edit;
			$invoice_message_body_edit_val = $invoice_message_body_edit_tbl.$invoice_message_body_edit."</table>";
		}
		
		$name = "delete_".$gstvno;
		if($download_type=="direct_download")
		{
			$file_name = $name.".xls";
			
			//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
			/*$objWriter->save('uploads_sales/kapilkifile.xls');*/
			
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename='.$file_name);
			header('Cache-Control: max-age=0');
			ob_start();
			$objWriter->save('php://output');
			$data = ob_get_contents();
		}
		if($download_type=="cronjob_download")
		{
			if($fileok==1)
			{
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
				$file_name = "email_files/".$name.".xls";
				$objWriter->save($file_name);
				
				$file_name2 = "invoice_files/".$name.".xls";
				$objWriter->save($file_name2);
				
				$x[0] = $file_name;
				$x[1] = $invoice_message_body_edit_val.$invoice_message_body_delete_val;
				$x[2] = $whatsapp_message_edit_var.$whatsapp_message_delete_var;
 				return $x;
			}
			else
			{
				$file_name = "";
				return $file_name;
			}
		}
	}
	
	public function pendingorder_excel($result,$download_type="")
	{
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		error_reporting(0);
		ob_clean();		

		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A6','COMPANY')
		->setCellValue('B6','COMP UPC')
		->setCellValue('C6','Name')
		->setCellValue('D6','Pack')
		->setCellValue('E6','Qty.')
		->setCellValue('F6','Free');
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
		
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->setCellValueByColumnAndRow(0, 1, "D.R.DISTRIBUTORS PVT.LTD.");
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(32);
		$sheet->setCellValueByColumnAndRow(0, 2, "F2/6, OKHLA INDUSTRIAL AREA, PHASE 1, NEW DELHI 110020");
		$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
		$sheet->setCellValueByColumnAndRow(0, 3, "ORDER FORM");
		$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(28);
		$sheet->setCellValueByColumnAndRow(0, 4, "DATE : ".date("d M Y"));
		$sheet->setCellValueByColumnAndRow(0, 5, "");
		//$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(25);
		$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setWrapText(true);
		$sheet->mergeCells('A1:F1');
		$sheet->mergeCells('A2:F2');
		$sheet->mergeCells('A3:F3');
		$sheet->mergeCells('A4:F4');
		$sheet->mergeCells('A5:F5');
		$sheet->getStyle('A1')->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
		);
		$sheet->getStyle('A2')->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
		);
		$sheet->getStyle('A3')->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
		);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray(array('font' => array('size' => 16,'bold' => FALSE,'name'  => 'Arial','color' => ['rgb' => 'ad0000'],)));		
		
		$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Arial','color' => ['rgb' => '000000'],)));		
		
		$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->applyFromArray(array('font' => array('size' => 14,'bold' => TRUE,'name'  => 'Arial','color' => ['rgb' => 'ad0000'],)));	
		$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getFont()->setUnderline(true);		
		
		$objPHPExcel->getActiveSheet()->getStyle('A4:F4')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Arial','color' => ['rgb' => '0000ff'],)));
		
		$objPHPExcel->getActiveSheet()->getStyle('A5:F5')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Arial','color' => ['rgb' => '0000ff'],)));		
		
		$objPHPExcel->getActiveSheet()
        ->getStyle('A6:F6')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('ffff99');
		
		$BStyle = array(
		  'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);
		$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->applyFromArray($BStyle);
		$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->applyFromArray(array('font' => array('size' => 9,'bold' => TRUE,'name'  => 'Arial','color' => ['rgb' => '800000'],)));
		$objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(18);
		
		$rowCount 	= 7;
		$mydivision = "";
		foreach($result as $row)
		{
			$fileok=1;
			if($row->division!=$mydivision)
			{
				$sheet->mergeCells('A'.$rowCount.':F'.$rowCount);
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"Division : ".$row->division);
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':F'.$rowCount)->applyFromArray(array('font' => array('size' => 8,'bold' => true,'name'  => 'Arial','color' => ['rgb' => '000000'],)));
				$rowCount++;
				
				$mydivision = $row->division;
			}
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,$row->company_full_name);
			//$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,"");
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,$row->name);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$row->pack);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$row->qty);
			//$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,"");
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':F'.$rowCount)->applyFromArray($BStyle);
			
			$rowCount++;
		}
		$sheet->setCellValueByColumnAndRow(0, 5,"Name : ".$row->company_full_name);
		
		$name = "New Order Report";
		if($download_type=="direct_download")
		{
			$file_name = $name.".xls";
			
			//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
			/*$objWriter->save('uploads_sales/kapilkifile.xls');*/
			
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename='.$file_name);
			header('Cache-Control: max-age=0');
			ob_start();
			$objWriter->save('php://output');
			$data = ob_get_contents();
		}
		if($download_type=="cronjob_download")
		{
			if($fileok==1)
			{
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
				$file_name = "pendingorder_excel/new_order_report_".time().".xls";
				$objWriter->save($file_name);
				return $file_name;
			}
			else
			{
				$file_name = "";
				return $file_name;
			}
		}
	}
}