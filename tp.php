<?php

    $filename = "tb.xml";
    $f = fopen($filename, "r");
    
    $posts = fread($f, filesize($filename));
    fclose($f);
    
    $object = simplexml_load_string($posts);
    
    $p = $object->post;
    $i = 0;
    
    foreach($p as $q) {
        $filename = preg_replace('((^\.)|\/|(\.$))', '_', $q->title);
        
        if ($q->status  == "publish") {
            $title    = "제목 : " . $q->title;
        } else {
            $title    = "제목 : [비공개]" . $q->title;
        }
        
        $tags     = str_replace(">", ", ", $q->category);
        $tags     = "태그 : " . $tags;
        
        $year       = substr($q->date, 0, 4);
        $month      = substr($q->date, 4, 2);
        $day        = substr($q->date, 6, 2);
        
        $date     = "날짜 : " . $year . "/" . $month . "/" . $day;
        $content  = $q->content;
        
        $write_all  = $title . "\n";
        $write_all .= $tags  . "\n";
        $write_all .= $date  . "\n";
        $write_all .= html_entity_decode(strip_tags(str_replace("&nbsp;", "", str_replace("<br ", "  \n<br ", $content))));
        
        $direc = "tblog/" . $year . "-" . $month;
        mkdir($direc);
        
        $write_file = fopen($direc . "/" . $filename, "w");
        fwrite($write_file, $write_all, strlen($write_all));
        fclose($write_file);

    }

    
?>
