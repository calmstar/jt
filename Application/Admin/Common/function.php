<?php

//读取excel数据，并转化为数组
function excelToArray($filePath){

    Vendor("PHPExcel.PHPExcel");   
    $objPHPExcel = new PHPExcel();   
    $PHPReader = new PHPExcel_Reader_Excel2007(); //默认是excel2007  
    if(!$PHPReader->canRead($filePath)){   
    	//如果不成功的时候用以前的版本来读取
        $PHPReader = new PHPExcel_Reader_Excel5();   
        if(!$PHPReader->canRead($filePath)){   
            echo 'no Excel';   
            return ;   
        }   
    }   

    $PHPExcel = $PHPReader->load($filePath);  
    $currentSheet = $PHPExcel->getSheet(0);  
    //取得一共有多少列  
    $allColumn = $currentSheet->getHighestColumn();     
    //取得一共有多少行  
    $allRow = $currentSheet->getHighestRow();  
     
    $excelData = array(); 
    for($currentRow = 1;$currentRow<=$allRow;$currentRow++){  
        for($currentColumn='A';$currentColumn<=$allColumn;$currentColumn++){  
            $address = $currentColumn.$currentRow;  
            $excelData[$currentRow-1][] =  $currentSheet->getCell($address)->getValue();  
        }  
    }
    return $excelData;
}


   /**
 * 导出excel表格（适合没有单元格合并的情况）
 * @param array $data 二维数组
 * @param array $table_head 表头（即excel工作表的第一行标题）
 * @param string $file_name 文件名
 * @param string $sheet_name 工作表名
 */
function export_excel(array $data=array(), array $table_head=array(),array $data2=array(), array $table_head2=array(), $file_name='JMoocTest', $sheet_name='sheet') 
{
    
    vendor('PHPExcel.PHPExcel');   // 将Vendor目录中的PHPExcel/PHPExcel.php类文件引入

    $objPHPExcel = new PHPExcel();  // 创建PHPExcel对象

    // 设置excel文件的属性，在excel文件->属性->详细信息，可以看到这些值
    $objPHPExcel->getProperties()  //获得文件属性对象，给下文提供设置资源
                ->setCreator( "admin")     //设置文件的创建者
                ->setLastModifiedBy( "admin")    //最后修改者
                ->setTitle( "JMoocTest" )    //标题
                ->setSubject( "JMoocTest" )  //主题
                ->setDescription( "JMoocTest") //描述
                ->setKeywords( "JMoocTest")    //关键字
                ->setCategory( "export file");               //类别

    // 设置Excel文档的第一张sheet（工作表）为活动表，即当前操作的表。
    $objPHPExcel->setActiveSheetIndex(0);

    // 获取当前操作的工作表
    $activeSheet = $objPHPExcel->getActiveSheet();

    // 设置工作表的名称
    $activeSheet->setTitle($sheet_name);


    // 输入数据到Excel中

    // 返回字符A的  ASCII 码值
    $column = ord('A');    
    // 设置工作表的表头
    foreach ($table_head as $k=>$v) {
        // 字体大小
        $activeSheet->getStyle(chr($column)."1")->getFont()->setSize(13); 
        // 加粗
        $activeSheet->getStyle(chr($column)."1")->getFont()->setBold(true); 
        // 列宽
        $chars = strlen($v);   // 统计字节数
        $activeSheet->getColumnDimension(chr($column))->setWidth($chars*2);
        // 设置单元格的值
        $activeSheet->setCellValue(chr($column)."1", $v);
        // 设置左对齐
        $activeSheet->getStyle(chr($column))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $column++;
    }
    $column = ord('A');   // 返回字符的  ASCII 码值
    // 将$data中的数据填充到单元格中
    foreach ($data as $row=>$col) {
        $i=0;
        foreach ($col as $k=>$v ) {
            $activeSheet->setCellValue(chr($column+$i).($row+2), $v);
            $i++;
        }
    }
    
    // ------ 自制重复的开始------------

    //每个考生的考试信息data2和table_head2
    // 返回字符A的  ASCII 码值
    $column = ord('A');    

    // 设置工作表的表头
    foreach ($table_head2 as $k=>$v) {
        // 字体大小
        $activeSheet->getStyle(chr($column)."5")->getFont()->setSize(13); 
        // 加粗
        $activeSheet->getStyle(chr($column)."5")->getFont()->setBold(true); 
        // 列宽
        $chars = strlen($v);   // 统计字节数
        $activeSheet->getColumnDimension(chr($column))->setWidth($chars*2);
        // 设置单元格的值
        $activeSheet->setCellValue(chr($column)."5", $v);
        // 设置左对齐
        $activeSheet->getStyle(chr($column))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $column++;
    }

    $column = ord('A');   // 返回字符的  ASCII 码值
    // 将$data中的数据填充到单元格中
    foreach ($data2 as $row=>$col) {
        $i=0;
        foreach ($col as $k=>$v ) {
            $activeSheet->setCellValue(chr($column+$i).($row+6), $v);
            $i++;
        }
    }
    // ------ 自制重复的结束------------


    // 导出Excel表格
    $file_name .= date('Ymd');   // 文件名
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$file_name.'.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
    $objWriter->save('php://output');
}


  // 系统信息
function degToArray($shuzu,$deg){

    $info['table'] = $shuzu;

    foreach($info['table'] as $k=>&$v){
        foreach($deg as $kk=>$vv){
            if($v['course_id'] == $vv['course_id']){
                if($vv['difficulty'] == 1){
                    $v['eas_num'] = $vv['deg_num'];
                    continue;
                }
                if($vv['difficulty'] == 2){
                    $v['com_num'] = $vv['deg_num'];
                    continue;
                }
                if($vv['difficulty'] == 3){
                    $v['dif_num'] = $vv['deg_num'];
                    continue;
                }
            }
        }
        if(!isset($v['eas_num'])){
            $v['eas_num'] = 0;
        }
        if(!isset($v['com_num'])){
            $v['com_num'] = 0;
        }
        if(!isset($v['dif_num'])){
            $v['dif_num'] = 0;
        }
    }
    unset($v);

    return $info['table'];
}

function showToArray($shuzu,$show){
    $info['table'] = $shuzu;
    foreach($info['table'] as $k=>&$v){
        foreach($show as $kk=>$vv){
            if($v['course_id'] == $vv['course_id']){
                if($vv['is_show'] == 0){
                    $v['no'] = $vv['show_num'];
                }
                if($vv['is_show'] == 1){
                    $v['yes'] = $vv['show_num'];
                }
            }
        }
        if(!isset($v['yes'])){
            $v['yes'] = 0;
        }
        if(!isset($v['no'])){
            $v['no'] = 0;
        }
    }
    unset($v);
    return $info['table'];
}