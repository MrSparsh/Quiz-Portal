<?php
include('database.php');
    function showTables($cn,$test_id,$ques_id){
        $table_cnt = mysqli_query($cn,"select max(table_num) from Question_tables where test_id=$test_id and ques_id=$ques_id");	
        $table_cnt = mysqli_fetch_row($table_cnt);
        if($table_cnt){
            $table_cnt = $table_cnt[0];
        }else{
            $table_cnt=-1;
        }
        for($i=0;$i<=$table_cnt ;$i++){
            $row_cnt = mysqli_query($cn,"select max(row_num) from Question_tables where test_id=$test_id  AND ques_id=$ques_id and table_num=$i");
            $row_cnt = mysqli_fetch_row($row_cnt);
            $row_cnt = $row_cnt[0];
            $col_cnt = mysqli_query($cn,"select max(column_num) from Question_tables where test_id=$test_id  AND ques_id=$ques_id and table_num=$i");
            $col_cnt = mysqli_fetch_row($col_cnt);
            $col_cnt = $col_cnt[0];
            $table_rs = mysqli_query($cn,"select row_num,column_num,data from Question_tables where test_id=$test_id  AND ques_id=$ques_id and table_num=$i");
            $table = array();
            for($row_num=0;$row_num<=$row_cnt;$row_num++){
                $row=array();
                for($col_num=0;$col_num<=$col_cnt;$col_num++){
                    $row[]='';
                }
                $table[]=$row;
            }
                while($tabledata_row=mysqli_fetch_row($table_rs)){
                $table[$tabledata_row[0]][$tabledata_row[1]] = $tabledata_row[2];			
            }
            $tab='<table class="table table-striped">';
            for($i=0;$i<sizeof($table);$i++){
                $tab.='<tr>';
                for($j=0;$j<sizeof($table[$i]);$j++){
                    $data=$table[$i][$j];
                    $tab.='<td>';
                    $tab.=$data;
                    $tab.='</td>';
                }
                $tab.='</tr>';
            }
            $tab.='</table></p>';
            echo $tab;
        }
    }

    function showOptions($cn,$user_id,$test_id,$ques_id){
        $opt_rs = mysqli_query($cn,"select * from Options where test_id=$test_id  AND ques_id=$ques_id");
        $res=mysqli_query($cn,"select * from UserAnswer where user_id='$user_id' AND test_id=$test_id AND ques_id=$ques_id");
        $hasAnswered=0;
        if(mysqli_num_rows($res)>0)
        {
            $ans_row=mysqli_fetch_row($res);
            $hasAnswered=1;
        }
        ?>
        <div class="form-check">
        <?php
            while($option_row=mysqli_fetch_row($opt_rs)){ 
                echo '<div class="form-group">'; 
                if($hasAnswered==1 && $option_row[2]==$ans_row[3])
                {
                ?>   
                    <input type="radio" name='ans' value=<?php echo $option_row[2] ?> class="form-check-input" checked>
                    <label class="form-check-label"><?php echo $option_row[3] ?></label>
                    
                <?php
                }else{
                ?>
                    <input type="radio" name='ans' value=<?php echo $option_row[2] ?> class="form-check-input">
                    <label class="form-check-label"><?php echo $option_row[3] ?></label>
                <?php
                }
                echo '</div>';
            }   
        ?>
        </div>
        <?php
    }

    function showImages($cn,$test_id,$ques_id){
        $img_rs= mysqli_query($cn,"select * from Images where test_id=$test_id  AND ques_id=$ques_id");
        while($img_row=mysqli_fetch_row($img_rs))
        {
            $path = $img_row[3];
            echo '<img class="img-thumbnail ques-image" src="'.$path.'.jpeg" />';					
        }
    }

    function showQuestion($cn,$test_id,$ques_id){
        $ques_rs=mysqli_query($cn,"select * from Question where test_id=$test_id and ques_id=$ques_id");
        $ques_row= mysqli_fetch_row($ques_rs);
        ?>
        <div class="form-group">
            <h4><?php echo "$ques_row[0])  $ques_row[2]" ?></h4>
        </div>
        <?php
    }
?>