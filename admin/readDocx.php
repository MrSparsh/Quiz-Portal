<?php
include 'parser.php';
include 'QuesDataModel.php';
include 'database.php';
function read_docx($filename){
   $cn=mysqli_connect("localhost","root","","new_database");
 $content = '';
 //$zip = zip_open($filename);
 $zip = new ZipArchive;
 if(true === $zip->open($filename))
 $actual_filename = explode('.',$filename);
 $actual_filename = $actual_filename[0];
 $zip->extractTo("./".$actual_filename."/");
 $zip = zip_open($filename);
 if (!$zip || is_numeric($zip)) return false;

 while ($zip_entry = zip_read($zip)) {
     if (zip_entry_open($zip, $zip_entry) == FALSE) continue;
     $ext = explode('.', zip_entry_name($zip_entry));
     $ext = end($ext);
     if (zip_entry_name($zip_entry) == "word/document.xml"){
        $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));	
     }
     else{
        continue;
     }
     zip_entry_close($zip_entry);
 }

 zip_close($zip);

  
 $parser = new Parser;

  
  
 $ques_arr = $parser->extract_meaning($content);
      return $ques_arr;
}
?>