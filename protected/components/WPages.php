<?php

class WPages extends CWidget {

    public $page = 1;
    public $pages = NULL;
    public $_pages = NULL;
    public $link = '';
    public $maxButtonCount = 4;
    public $type = 'default';

    public function run() {
       $page = (int)Yii::app()->request->getParam('page');
       $this->pages = $this->_pages->getPageCount();
       if ($page > 0 && $page <= $this->pages) {$this->page = $page;}
                            else {$this->page = 1;}
       $this->page = $page;
       $this->page = ($this->page > 1 && $this->page <= $this->pages) ? $this->page : 1;
       $this->render('wPages');
    }

    protected function getPageRange() {
       $currentPage = $this->page;
       $pageCount = $this->pages;
       $beginPage = max(1, $currentPage - (int)($this->maxButtonCount / 2));
       if (($endPage = $beginPage + $this->maxButtonCount - 1) >= $pageCount) {
          $endPage = $pageCount;
          $beginPage = max(1, $endPage - $this->maxButtonCount + 1);
       }
       return array($beginPage, $endPage);
    }
}

?>

