<?php
include 'parser.php';
include 'QuesDataModel.php';
function read_docx($filename){
   $document = '';
   $rels = '';
   //$zip = zip_open($filename);
   $zip = new ZipArchive;
   if(true === $zip->open($filename)){
      $actual_filename = explode('.',$filename);
      $actual_filename = $actual_filename[0];
      $zip = zip_open($filename);
      if (!$zip || is_numeric($zip)) return false;
      while ($zip_entry = zip_read($zip)) {
         if (zip_entry_open($zip, $zip_entry) == FALSE) continue;
         $ext = explode('.', zip_entry_name($zip_entry));
         $ext = end($ext);
         if (zip_entry_name($zip_entry) == "word/document.xml"){
            $document .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));	
         }else if(zip_entry_name($zip_entry) == "word/_rels/document.xml.rels"){
            $rels .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
         }
      }
      zip_close($zip);
      $ques_arr = parseDocx($document,$rels);
      return $ques_arr;
   }
}
?>