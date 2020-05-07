<?php
   session_start();
   include 'readDocx.php';
   include 'database.php';
   include('PHPExcel/Classes/PHPExcel.php');
   extract($_POST);

   //Extracting Data From Answer File
   


   //Extracting Data From Question File
   if(isset($_FILES['ques_file'])){
      $errors= array();
      $file_name = $_FILES['ques_file']['name'];
      $file_size =$_FILES['ques_file']['size'];
      $file_tmp =$_FILES['ques_file']['tmp_name'];
      $file_type=$_FILES['ques_file']['type'];
      $file_ext=explode('.',$file_name);
      $file_ext=strtolower(end($file_ext));
      $extensions= array("docx");
      $actual_filename = explode('.',$file_name);
      $actual_filename = $actual_filename[0];
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a docx file for Questions.";
      }
      
      if(empty($errors)==true){
         echo "No error";
         move_uploaded_file($file_tmp,"uploads/".$file_name);
        
         $ques_arr = read_docx("uploads/".$file_name);
         $n_ques = sizeof($ques_arr);
         
         mysqli_query($cn,"insert into Test(loginid,Duration,test_password,positive,negative) values ('$_SESSION[loginid]',$duration,'$test_password',$positive,$negative)") ;
         

         $test_id1 = mysqli_query($cn,"select max(test_id) from test where loginid = '$_SESSION[loginid]'");
         $test_id2 = mysqli_fetch_row($test_id1);
         $test_id = $test_id2[0];
         echo "<p align=center>Test $test_id Added Successfully.</p>";
         $_SESSION['test_id'] = $test_id;
         for($ques_num=1;$ques_num<=sizeof($ques_arr);$ques_num++){
            $ques = $ques_arr[$ques_num-1];
         // echo "insert into question values($ques_num,'test2','$ques->stat',2,1)".'<br>';
            mysqli_query($cn,"insert into Question values($ques_num,$test_id,'$ques->stat',0)");
            echo $ques->stat."<br/>";
            $tab='';
            
            foreach($ques->img as $img_no){
               $img_path = './admin/uploads/'.$actual_filename."/word/media/image".$img_no;
            //  echo "insert into images values('test2',$ques_num,$img_no,'$img_path')".'<br>';
               mysqli_query($cn,"insert into Images values($test_id,$ques_num,$img_no,'$img_path')");
               $tag = '<img src="./uploads/'.$actual_filename."/word/media/image".$img_no.'.jpeg">';
               echo $tag;
            }

            $tab='<table border="1">';
            for($k=0;$k<sizeof($ques->table);$k++){
               for($i=0;$i<sizeof($ques->table[$k]);$i++){
                     $tab.='<tr>';
                     for($j=0;$j<sizeof($ques->table[$k][$i]);$j++){
                              $data=$ques->table[$k][$i][$j];
            //                echo "insert into question_tables values('test2',$ques_num,$k,$i,$j,'$data')".'<br>';
                              mysqli_query($cn,"insert into Question_Tables values($test_id,$ques_num,$k,$i,$j,'$data')");
                              $tab.='<td>';
                              $tab.=$ques->table[$k][$i][$j];
                              $tab.='</td>';
                     }
                     $tab.='</tr>';
               }
            }
            $tab.='</table>';
            echo $tab;
            for($opt_num=1;$opt_num<=sizeof($ques->opt_arr);$opt_num++){
               $opt = $ques->opt_arr[$opt_num-1];
               //echo "insert into options values('test2',$ques_num,$opt_num,'$opt')".'<br>';
               mysqli_query($cn,"insert into Options values($test_id,$ques_num,$opt_num,'$opt')");
               echo $opt."<br/>";
            }
            echo "<br/>";
            }

            // Handling the answer excel sheet
            
            
         echo "Success";
      }else{
         print_r($errors);
      }
   }
   if(isset($_FILES['ans_file'])){
      
      $file_name = $_FILES['ans_file']['name'];
      $file_size =$_FILES['ans_file']['size'];
      $file_tmp =$_FILES['ans_file']['tmp_name'];
      $file_type=$_FILES['ans_file']['type'];
      $file_ext=explode('.',$file_name);
      $file_ext=strtolower(end($file_ext));
      $extensions= array("xlsx");
      $actual_filename = explode('.',$file_name);
      $actual_filename = $actual_filename[0];
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a xlsx file for Answer.";
      }else{
         move_uploaded_file($file_tmp,"uploads/".$file_name);
         $excel=PHPExcel_IOFactory::load("uploads/".$file_name);
         $excel->setActiveSheetIndex(0);
         $i=1;
         while($excel->getActiveSheet()->getCell('A'.$i)->getValue()!="")
         {
            $id=$excel->getActiveSheet()->getCell('A'.$i)->getValue();
            $option_num=$excel->getActiveSheet()->getCell('B'.$i)->getValue();
            echo "Update question set true_ans=$option_num where test_id=$_SESSION[test_id] AND ques_id= $id ";
            mysqli_query($cn,"update question set true_ans=$option_num where test_id=$_SESSION[test_id] AND ques_id= $id ");	
            $i++;
         }
      }
   }
?>