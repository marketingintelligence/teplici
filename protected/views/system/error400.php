<?php 

$file = @file("http://".$_SERVER["HTTP_HOST"]."/site/error/type/400.html"); 
if (is_array($file)) {
    foreach ($file as $fil) {
        echo $fil;
    }
}
else {echo '<script type="text/javascript">document.location.href="http://'.$_SERVER["HTTP_HOST"].'/site/error/type/400.html"</script>';}

?>