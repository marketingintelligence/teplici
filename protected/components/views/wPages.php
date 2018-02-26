<?
include 'translate.php';
if ($this->pages > 1):
  list($beginPage, $endPage) = $this->getPageRange();


  $get = $_GET;
  $get2 = $_GET;
  $getmin1 = $_GET;
  $getmin2 = $_GET;
  $getmax1 = $_GET;
  $getmax2 = $_GET;
  $gets = $_GET;

  unset($get['page']);
  $link = str_replace(".html", '/page/', $this->controller->createUrl('', $get));
  $get['page'] = $this->page - 1;?>
<div class="page-navi">
    <?$get['page'] = $this->page - 1;
	if ($get['page'] == "1") {
		$left = str_replace("?page=1", "", $this->controller->createUrl('', $get));
	} else {
    	$left = $this->controller->createUrl('', $get);
	}
    if ($this->page > 1):?>
    <a href="<?=$left?>#top"><span class="link"> ← <?=$array[Yii::app()->session->itemAt('language')]['pred']?></span></a>
    <? else: $left = '#'; ?>
     <span class="link"> ← <?=$array[Yii::app()->session->itemAt('language')]['pred']?></span>
    <? endif;?>


        <?
        $max = 0;
        for ($i = $beginPage; $i <= $endPage; ++$i) {

        if($this->page<5 && $this->pages<5){
          $get['page'] = $i;
          if($i<7){
          if ($i == $this->page){
                 echo '<a class="page active" href="#">'. $i .'</a>';
          }else{
			  if ($i != 1) {
              	echo '<a class="page" href="?page='.$i.'">'. $i .'</a>';
			  } else {
				$bodytag = str_replace(".html?page=1", "/", $this->controller->createUrl('', $get));
				echo '<a class="page" href="'.$bodytag.'">'. $i .'</a>';
			  }
          }
        }
      }

        if($this->page<=5 && $this->pages>5){
          $get['page'] = $i;
          if($i<6){
          if ($i == $this->page){
                 echo '<a class="page active" href="#">'. $i .'</a>';
          }else{
              echo '<a class="page" href="'.$this->controller->createUrl('', $get) . '">'. $i .'</a>';
          }
              if($i==5){
                    echo '<span class="page">...</span>';
                    $get['page'] = $this->pages;
                    echo '<a class="page" href="'.$this->controller->createUrl('', $get).'">'.$this->pages.'</a>';
              }
           }
        }

        if($this->page>=5 && $this->pages>8 && $this->pages-5 > $i){
          $get['page'] = 1;

          $getmin1['page'] = $this->page-1;
          $getmin2['page'] = $this->page-2;
          $getcmin1 = $this->page-1;
          $getcmin2 = $this->page-2;

          $getmax1['page'] = $this->page+1;
          $gettop = $this->page+1;
          $getmax2['page'] = $this->page+2;
          $getcmax1 = $this->page+1;
          $getcmax2 = $this->page+2;

          $getcurrent = $this->page;

           if($this->page<$i && $max==0){

              if($i==$gettop){
                    echo '<a class="page" href="'.$this->controller->createUrl('', $get) . '">1</a>';
                    echo '<span class="page">...</span>';
                    $get['page'] = $this->page-2;
                    echo '<a class="page" href="'.$this->controller->createUrl('', $get) . '">'. $getcmin2 .'</a>';
                    $get['page'] = $this->page-1;
                    echo '<a class="page" href="'.$this->controller->createUrl('', $get) . '">'. $getcmin1 .'</a>';

                 }
              echo '<a class="page active" href="#">'. $getcurrent .'</a>';
              $get['page'] = $this->page+1;
              echo '<a class="page" href="'.$this->controller->createUrl('', $get) . '">'. $getcmax1 .'</a>';
              $get['page'] = $this->page+2;
              echo '<a class="page" href="'.$this->controller->createUrl('', $getmax2) . '">'. $getcmax2 .'</a>';
              echo '<span class="page">...</span>';
          if($max==0){
              $get['page'] = $this->pages;
              echo '<a class="page" href="'.$this->controller->createUrl('', $get).'">'.$this->pages.'</a>';
                  }
              $max++;
           }


        }
         if($this->page>5 &&  $this->pages-6 < $i){
          $get['page'] = 1;
          $current = $this->page;
          $gets['page'] = $i;
          $getspages = $i;
               if($max==0){
                  echo '<a class="page" href="'.$this->controller->createUrl('', $get) . '">1</a>';
                  echo '<span class="page">...</span>';
                  $max++;
          }
          if($getspages==$current){
          echo '<a class="page active" href="#">'. $current .'</a>';
          }else{
          echo '<a class="page" href="'.$this->controller->createUrl('', $gets).'">'. $i .'</a>';

          }


    }


}
        ?>

       <?$get['page'] = $this->page + 1;
       $right = $this->controller->createUrl('', $get);
       if ($this->page < $this->pages):?>
       <a href="<?=$right?>#top"><span class="link"><?=$array[Yii::app()->session->itemAt('language')]['sled']?> →</span></a>
       <? else: $right = '#'; ?>
       <span class="link"><?=$array[Yii::app()->session->itemAt('language')]['sled']?> →</span>
       <? endif;?>

</div>

<?Yii::app()->clientScript->registerCoreScript('jquery')->registerScript('pagesJS', "
$(document).keyup(function(e){
    if(e.ctrlKey){
    if(e.keyCode==37){ document.location.href='$left';}else if(e.keyCode==39){ document.location.href='$right';}}});", $i);
endif; ?>


