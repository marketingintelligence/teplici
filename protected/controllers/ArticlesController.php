<?php
class ArticlesController extends Controller {
    public function actionIndex() {
        $criteria = new CDbCriteria();
        $criteria -> condition = " status_int = 1";
        $criteria -> order = " serial_number";

        $count = Articles::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 4;
        $pages->applyLimit($criteria);

        $articles = Articles::model()->findAll($criteria);
        $video = Video::model()->findAll($criteria);

        $lang=Yii::app()->user->getState('lang');
        $this->pageTitle = "Статьи и публикации";
        $this->render('index', array( "articles" => $articles,"pages"=>$pages ,"video" => $video,"lang"=>$lang));
    }
}
?>
