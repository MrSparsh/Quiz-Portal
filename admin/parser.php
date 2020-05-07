<?php
class Parser{
    var $pos,$content,$ques_arr;
    function extract_text($endtag){
        $text=array();
        $text[]='';
        $text[]=0;
        while($this->pos<strlen($this->content) && !$this->matches($endtag)){
            if($this->matches('<w:t ')||$this->matches('<w:t>')){
                $this->go_to_end();
                while($this->pos<strlen($this->content) && !$this->matches('</w:t>')){
                    $text[0].=$this->content[$this->pos];
                    $this->pos++;
                }
            }else if($this->matches('<wp:docPr')){
                $text[1]++;
            }
            $this->pos++;
        }
        return $text;
    }
    function matches($str){
        
        $end=0;
        for($i=0;$i<strlen($str) && $this->pos+$i<strlen($this->content) ;$i++){
            if($str[$i]!=$this->content[$this->pos+$i]){
                return false;
            }
            $end=$this->pos+$i;
        }
        $this->pos=$end;
        return true;
    }
    function go_to_end(){
        for(;$this->pos<strlen($this->content);$this->pos++){
            if($this->content[$this->pos]=='>'){
                $this->pos++;
                return;
            }
        }
    }
    function extract_statement($line){
        $i=0;
        while($i<strlen($line) && $line[$i]!=')'){
            $i++;
        }
        $i++;
        $stat="";
        while($i<strlen($line)){
            $stat.=$line[$i];
            $i++;
        }
        return trim($stat);
    }
    function get_type($line){
        $i=0;
        if($line[$i]<='9' && $line[$i]>='0'){
            while($i<strlen($line) && $line[$i]<='9' && $line[$i]>='0'){
                $i++;
            }
            if($i<strlen($line) && $line[$i]==')'){return 'ques';}
            else return 'simple';
        }else if(($line[$i]<='z' && $line[$i]>='a') || ($line[$i]<='Z' && $line[$i]>='A')){
            $i++;
            if($i<strlen($line) && $line[$i]==')'){return 'opt';}
            else{return 'simple';}
        }else return 'simple';
    }

    function extract_meaning($content){
        $this->pos=0;
        $this->content=$content;
        $this->ques_arr=array();
        $img_no=1;
        $q_no=-1;$opt_no=-1;$stat="";$opt_arr=array();$img=array();$table=array();
        for(;$this->pos<strlen($this->content);$this->pos++){
            if($this->matches('<w:p ')){
                $this->go_to_end();
                $arr = $this->extract_text('</w:p>');
                $line = $arr[0]; $line =  trim($line);$img_cnt=$arr[1];
                if($img_cnt>0)
                for($i=0;$i<$img_cnt;$i++){
                    $img[]=$img_no;
                    $img_no++;
                }
                if(strlen($line)==0){continue;}
                $type = $this->get_type($line);
                if($type == 'ques'){
                    if($q_no!=-1){
                        $this->ques_arr[]=new Question($stat,$opt_arr,$img,$table);
                    }
                    $q_no++;
                    $opt_no=-1;
                    $opt_arr=array();
                    $img=array();
                    $stat=$this->extract_statement($line);
                    $table=array();
                }else if($type=='opt'){
                    $opt_no++;
                    $opt_arr[]=$this->extract_statement($line);
                }else if($type=='simple'){
                    if($opt_no>=0){
                        $opt_arr[$opt_no].=$line;
                    }else if($q_no>=0){
                        $stat.=$line;
                    }
                }
                
            }else if($this->matches("<w:tbl>")){
                $tab=array();
                for(;!$this->matches('</w:tbl>');$this->pos++){ 
                    if($this->matches('<w:tr ')){
                        $row=array();
                        for(;$this->pos<strlen($this->content);$this->pos++){
                            if($this->matches('<w:tc>')){
                                $text=$this->extract_text('</w:tc>');
                                $text=$text[0];
                                $row[]=$text;
                            }else if($this->matches('</w:tr>')){
                                break;
                            }
                        }
                        $tab[]=$row;
                    }
                }
                $table[]=$tab;
            }
        }
        if($q_no!=-1){
            $this->ques_arr[]=new Question($stat,$opt_arr,$img,$table);
        }
        return $this->ques_arr;
    }

}

?>