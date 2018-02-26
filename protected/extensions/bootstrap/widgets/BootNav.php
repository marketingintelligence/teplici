<?php
/**
 * BootNav class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright  Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('bootstrap.widgets.BootWidget');

/**
 * Bootstrap topbar navigation widget with support for dropdown menus.
 * @since 0.9.7
 */
class BootNav extends BootWidget {
    /**
     * @var string the URL for the brand link.
     */
    public $brandUrl;
    /**
     * @var string the text for the brand link.
     */
    public $brandText;
    /**
     * @var array the HTML attributes for the brand link.
     */
    public $brandOptions = array();
    /**
     * @var array the primary menu items.
     */
    public $primaryItems = array();
    /**
     * @var array the secondary menu items.
     */
    public $secondaryItems = array();
    /**
     * @var array the HTML attributes for the primary menu.
     */
    public $primaryOptions = array();
    /**
     * @var array the HTML attributes for the secondary menu.
     */
    public $secondaryOptions = array();

    /**
     * Runs the widget.
     */
    public function run() {
        

        $this->brandText = Yii::app()->name;
        $this->brandUrl = Yii::app()->createUrl('site/index');

        if (isset($this->htmlOptions['class']))
            $this->htmlOptions['class'] .= ' topbar';
        else
            $this->htmlOptions['class'] = 'topbar';

        if (isset($this->brandOptions['class']))
            $this->brandOptions['class'] .= ' brand';
        else
            $this->brandOptions['class'] = 'brand';

        if (isset($this->brandUrl))
            $this->brandOptions['href'] = $this->brandUrl;

        if (isset($this->primaryOptions['class']))
            $this->primaryOptions['class'] .= ' nav';
        else
            $this->primaryOptions['class'] = 'nav';

        if (isset($this->secondaryOptions['class']))
            $this->secondaryOptions['class'] .= ' secondary-nav';
        else
            $this->secondaryOptions['class'] = 'secondary-nav';

        echo CHtml::openTag('div', $this->htmlOptions);
        echo '<div class="topbar-inner"><div class="container-fluid">';
        echo CHtml::openTag('a', $this->brandOptions);
        echo $this->brandText;
        echo '</a>';
        if(!Yii::app()->user->isGuest)
        if ($this->beginCache('TimesafeNavMenu', array('duration' => 3600))) {

            $this->primaryItems = array(
                array('label' => 'Главная', 'url' => array('hello/index')),

            );

            $models = SysModule::model()->findAll('status and parent_id=0');
            foreach ($models as $model) {
                $data = array(
                    'label' => $model->title,
                    'url' => array($model->name . '/index'),
                );
                if (SysModule::model()->count('status and parent_id=' . $model->id) > 0) {
                    unset($data['url']);
                    $childs = SysModule::model()->findAll('status and parent_id=' . $model->id);
                    foreach ($childs as $child) {
                        $data['items'][] = array(
                            'label' => $child->title,
                            'url' => array($child->name . '/index'),
                        );
                    }
                }
                $this->primaryItems[] = $data;
            }

            $this->secondaryItems = array(
                array('label' => 'Настройки', 'items' => array(
                    array('label' => 'Пользователи', 'url' => array('user/list')),
                    array('label' => 'Назначение прав', 'url' => array('assignment/view')),
                    array('label' => 'Кеш', 'url' => array('cache/index')),
                    '---',
                    array('label' => 'Выход', 'url' => '#'),
                )),
            );
            if (!empty($this->primaryItems)) {
                $this->controller->widget('bootstrap.widgets.BootMenu', array(
                    'type' => '',
                    'items' => $this->primaryItems,
                    'htmlOptions' => $this->primaryOptions,
                ));
            }
            echo '<p class="pull-right"><a href="'.Yii::app()->createUrl('/site/logout').'" class="btn error">Выйти</a></p>';
            if (!empty($this->secondaryItems)) {
                $this->controller->widget('bootstrap.widgets.BootMenu', array(
                    'type' => '',
                    'items' => $this->secondaryItems,
                    'htmlOptions' => $this->secondaryOptions,
                ));
            }

            
            $this->endCache();
        }
        echo '</div></div></div>';
    }
}
