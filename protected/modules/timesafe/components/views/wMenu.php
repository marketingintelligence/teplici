<div class="topbar">
    <div class="topbar-inner" data-dropdown="dropdown">
        <div class="container-fluid">
            <a class="brand" href="/" target="_blank"><?=Yii::app()->name?></a>
            <ul class="nav">
                <?php
                foreach ($models as $model):
                    if ($model->count > 0):
                        $active = false;
                        $childHTML = '';
                        foreach ($model->child as $child):

                            if (ucfirst($child->name) == $id) $active = true;
                            $childHTML .= '<li><a href="' . $this->controller->createUrl($child->name . '/index') . '">' . $child->title . '</a></li>';
                        endforeach;

                        ?>
                        <li data-dropdown="dropdown" class="dropdown<?=$active ? ' active' : ''?>">
                            <a href="#" class="dropdown-toggle"><?=$model->title?></a>
                            <ul data-dropdown="dropdown" class="dropdown-menu">
                                <?= $childHTML ?>
                            </ul>
                        </li>
                        <?
                    else:

                        ?>
                        <li data-dropdown="dropdown">
                            <a href="<?=$this->controller->createUrl($model->name . '/index')?>"><?=$model->title?></a>
                        </li>
                        <?
                    endif;
                    ?>


                    <?php endforeach ?>
            </ul>
            <p class="pull-right"><?php echo CHtml::link('Выход', array('/site/logout'), array('class' => 'btn primary small')); ?></p>

            <p class="pull-right">&nbsp;</p>

            <p class="pull-right"><a href="#"><?=Yii::app()->user->name?></a></p>
        </div>
    </div>
</div>
