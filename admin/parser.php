<?php
function parseRels($rels){
   $xml=simplexml_load_string($rels) or die("Error: Cannot create object");
   foreach( $xml->Relationship as $curr){
      $arr[(string)$curr['Id'][0]]= (string)$curr['Target'][0];
   }
   return $arr;
}

function getStartPos(&$xml,$currPos,$tag){
   $min = strlen($xml);
   $pos1 = strpos($xml,"<$tag ",$currPos);
   if($pos1!==false){
      $min=min($min,$pos1);
   }
   $pos2 = strpos($xml,"<$tag>",$currPos);
   if($pos2!==false){
      $min=min($min,$pos2);
   }
   return $min;
}

function getInnerText(&$str){
   $currPos = 0;
   $txt="";
   while($currPos!=strlen($str)){
      $currPos = getStartPos($str,$currPos,"w:t");
      if($currPos === strlen($str)) return $txt;
      while($currPos<strlen($str) && $str[$currPos]!='>'){$currPos++;} $currPos++; 
      $txtEndPos = strpos($str,"</w:t>",$currPos)-1;
      $len = $txtEndPos - $currPos +1;
      $runText = substr($str,$currPos,$len);
      $txt.=$runText;
      $currPos = $txtEndPos;
      while($currPos<strlen($str) && $str[$currPos]!='>'){$currPos++;} $currPos++;
   }
   return $txt;
}

function getEndPosOfCurrTag(&$str,$currPos){
   while($currPos<strlen($str) && $str[$currPos]!='>'){$currPos++;} 
   return $currPos+1;
}

function parseParagraph($parContent){
   $imagePos = strpos($parContent,"<w:drawing>");
   $parsedPar = array();
   if($imagePos !== false){
      $parsedPar['type']="image";
      $imageIdStartPos = strpos($parContent,"r:embed=",$imagePos)+strlen("r:embed=")+1;
      $imageIdEndPos = $imageIdStartPos;
      while($parContent[$imageIdEndPos]!=='"'){
         $imageIdEndPos++;
      }
      $imageIdEndPos--;
      $imageIdLen = $imageIdEndPos-$imageIdStartPos+1;
      $imageId = substr($parContent,$imageIdStartPos,$imageIdLen);
      $parsedPar['content'] = $imageId;
   }else{
      $parsedPar['type']="text";
      $parsedPar['content']= getInnerText($parContent);
   }
   return $parsedPar;
}

function parseRow($rowContent){
   $currPos = 0;
   $parsedRow = array();
   while($currPos < strlen($rowContent)){
      $currPos = getStartPos($rowContent,$currPos,'w:tc');
      $currPos = getEndPosOfCurrTag($rowContent,$currPos);
      if($currPos>=strlen($rowContent)) return $parsedRow;
      $endPos = strpos($rowContent,'</w:tc>',$currPos)-1;
      $colContent = substr($rowContent,$currPos,$endPos-$currPos+1);
      $parsedCol = getInnerText($colContent);
      $parsedRow[] = $parsedCol;
      $currPos = getEndPosOfCurrTag($rowContent,$endPos);
   }
   return $parsedRow;
}
function parseTable($tblContent){
   $parsedTbl=array();
   $currPos = 0;
   while($currPos !== strlen($tblContent)){
      $currPos = getStartPos($tblContent,$currPos,'w:tr');
      $currPos = getEndPosOfCurrTag($tblContent,$currPos);
      if($currPos>=strlen($tblContent)) return $parsedTbl;
      $endPos = strpos($tblContent,'</w:tr>',$currPos)-1;
      $rowContent = substr($tblContent,$currPos,$endPos-$currPos+1);
      $parsedRow = parseRow($rowContent);
      $parsedTbl[] = $parsedRow;
      $currPos = getEndPosOfCurrTag($tblContent,$endPos);
   }
   return $parsedTbl;
}
function getNextElement(&$document,$currPos){
   $nextElement = array();
   $nextElementStartPos = strlen($document);
   $nextParPos = getStartPos($document,$currPos,"w:p");
   $nextTblPos = getStartPos($document,$currPos,"w:tbl");
  // echo "$nextParPos"."    ".$nextTblPos."   ";
   if($nextParPos < $nextTblPos){
      $currPos = getEndPosOfCurrTag($document,$currPos);
      $endPos = strpos($document,'</w:p>',$currPos)-1;
      if($endPos === -1) $endPos = $currPos-1;
      $parsedPar = parseParagraph(substr($document,$currPos,$endPos-$currPos+1));
      $currPos = getEndPosOfCurrTag($document,$endPos);
     // print_r($parsedPar);

      $nextElement['type']="par";
      $nextElement['content']=$parsedPar;
      $nextElement['endpos']=$currPos;

   }else if($nextTblPos < $nextParPos){
      $currPos = getEndPosOfCurrTag($document,$currPos);
      $endPos = strpos($document,'</w:tbl>',$currPos)-1;
      $tblContent = substr($document,$currPos,$endPos-$currPos+1);
      $parsedTbl = parseTable($tblContent);
    //  print_r($parsedTbl);
      $currPos = getEndPosOfCurrTag($document,$endPos);

      $nextElement['type']="table";
      $nextElement['content']=$parsedTbl;
      $nextElement['endpos']=$currPos;
      
   }else{
      $nextElement['type']="end";
      $nextElement['endpos']=strlen($document);
   }
   return $nextElement;
}

function getTextType($text){
   $text = trim($text);
   $pos=0;
   if($text[$pos]<='9' && $text[$pos]>='0'){
       while($pos<strlen($text) && $text[$pos]<='9' && $text[$pos]>='0'){
           $pos++;
       }
       if($pos<strlen($text) && $text[$pos]==')'){return 'ques';}
       else return 'simple';
   }else if(($text[$pos]<='z' && $text[$pos]>='a') || ($text[$pos]<='Z' && $text[$pos]>='A')){
       $pos++;
       if($pos<strlen($text) && $text[$pos]==')'){return 'opt';}
       else{return 'simple';}
   }else return 'simple';
}

function parseDocx(&$document,$rels){
   $relationship = parseRels($rels);
   $ques_arr = array();
   $currQNo = -1;
   $stat = ""; $opt_arr = array(); $img_arr = array(); $tbl_arr = array();
   $currPos = 0;
   while($currPos<strlen($document)){
      $nextElement=getNextElement($document,$currPos);
      $currPos = $nextElement['endpos'];
      $type = $nextElement['type'];
      if($type === 'par'){
         $parsedPar = $nextElement['content'];
         if($parsedPar['type']==='text'){
            $text = $parsedPar['content'];
            if(trim($text) === "") continue;
            $type = getTextType($text);
            //echo $type."<br>";
            if($type === 'ques'){
            //    echo $stat.'<br />';
               if($stat !== "") $ques_arr[] = new Question($stat,$opt_arr,$img_arr,$tbl_arr);
               $stat = ""; $opt_arr = array(); $img_arr = array(); $tbl_arr = array();
               $currQNo++;
               $pos=0;
               while($text[$pos]!=')'){
                  $pos++;
               }
               $pos++;
               $stat.=substr($text,$pos);
               
            }else if($stat !== "" && $type === 'opt'){
               $pos=0;
               while($text[$pos]!=')'){
                  $pos++;
               }
               $pos++;
               $opt_arr[] = substr($text,$pos);
            }else if($stat !== "" && $type === 'simple'){
               if(empty($opt_arr)){
                  $stat.="<br />".$text;
               }else{
                  $opt_arr[sizeof($opt_arr)-1].="<br />".$text;
               }
            }
         }else if($parsedPar['type']==='image'){
            $imagePath = $relationship[$parsedPar['content']];
            $img_arr[] =  $imagePath;
         }
      }else if($type === 'table'){
         $parsedTbl = $nextElement['content'];
         $tbl_arr[] = $parsedTbl;
      }
   }
//    echo $stat.'<br />';
   $ques_arr[] = new Question($stat,$opt_arr,$img_arr,$tbl_arr);
   print_r($ques_arr);
   return $ques_arr;
}
?>