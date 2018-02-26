<?php

class SController extends RController {
    public $layout = 'main';


    public function filterRights($filterChain) {


        $filter                 = new RightsFilter;
        $filter->allowedActions = $this->allowedActions();

        $filter->filter($filterChain);

    }

    public function allowedActions() {
        return '';
    }

    public function accessDenied($message = null) {
        if ($message === null)
            $message = Rights::t('core', 'You are not authorized to perform this action.');

        $user = Yii::app()->getUser();
        if ($user->isGuest === true)
            $user->loginRequired();
        else
            throw new CHttpException(403, $message);
    }

    public function filters() {
        return array(
            'rights',
        );
    }
}