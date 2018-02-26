<?php

class SHelper {
   /* static function GetRecipe($check, $category, $podcategory, $type, $tag) {

        if ($check == 1) {
            if ($tag != null) {
                $tag = addcslashes($tag, '%_');
                $criteria = new CDbCriteria(array(
                    'condition' => "tags_text LIKE :match AND status_int = '1' AND category_text = '" . $category . "' AND podcategory_text = '".$podcategory."' AND type_text = '".$type."'",
                    'params' => array(':match' => "%$tag%")
                ));
            } else {
                $criteria = new CDbCriteria();
                $criteria->condition = "status_int = '1' AND category_text = '" . $category . "' AND podcategory_text = '".$podcategory."' AND type_text = '".$type."'";
            }
        } else {
            $podcategory = addcslashes($podcategory, '%_');
            $criteria = new CDbCriteria(array(
                'condition' => "tags_text LIKE :match AND status_int = '1'",
                'params' => array(':match' => "%$podcategory%")
            ));
        }
        $criteria->order = "created_at DESC";
        $pages = new CPagination(Recipes::model()->count($criteria));
        $pages->pageSize = 12;
        $pages->applyLimit($criteria);
        $model = Recipes::model()->findAll($criteria);
        return array($model, $pages);
   }

   static function Getbuttonlike($id, $type, $count) {
       if (Yii::app()->user->getState('auth') == "OK") {
           $check = Likes::model()->findAll("parent_id = '" . Yii::app()->user->getState('id') . "' AND recipe_id = '".$id."' AND type_int = '".$type."'");
           if ($check != null) {
               $active = "like-active";
           } else {
               $active = null;
           }
           $like_button = '<div class="block-like-box"><i data-id = "'.$id.'" data-type = "'.$type.'" class="add-like fa fa-heart fa-lg '.$active.'"></i>&nbsp;<span class = "likes-count">'.$count.'</span></div>';
       } else {
           $like_button = '<div class="block-like-box"><i data-id = "'.$id.'" data-type = "'.$type.'" class="fa fa-heart fa-lg "></i> <span class = "likes-count">'.$count.'</span></div>';
       }
       return $like_button;
   }*/

}
