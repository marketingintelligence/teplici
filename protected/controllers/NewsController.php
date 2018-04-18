<?php
class NewsController extends Controller {
    public function actionIndex() {

        $criteria = new CDbCriteria();
        $criteria -> condition = " status_int = 1";
        $criteria -> order = "created_at DESC";

        $count = News::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 4;
        $pages->applyLimit($criteria);

        $news = News::model()->findAll($criteria);

        $lang = Yii::app()->user->getState("lang");
        $this->pageTitle = "Новости";
        $this->render('index',array( "news" => $news , "pages" => $pages,"lang" => $lang));
    }

    public function actionShow($url) {
        $criteria = new CDbCriteria();
        $criteria->condition = "status_int ='1' AND url_text = '$url'";

        $news = News::model()->find($criteria);
        if ( $news == null) {
            throw new CHttpException(404, 'Странца не существует.');
        } else {
            $lang = Yii::app()->user->getState("lang");
            $this->pageTitle = "Новости";
            $this->render('show',array( "news" => $news, "url" => $url, "lang" => $lang)); }

    }
}
?>
