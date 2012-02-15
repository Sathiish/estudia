<?php  Configure::write('debug', 0); ?>
<?php 
    foreach ($results As $k=>$v) { 
        $value=''; 
        foreach ($fields As $i =>$j) { 
            $value .= '"'.$v[$model][$j].'",'; 
        } 
       
        echo "<li class=\"".$input_id."\">";
        echo $this->Html->link($v[$model][$search], array(
               "controller" => "courtags",
               "action" => "addtag",
               $v[$model]['id']
            ));
        echo "</li>";
    } 
?> 