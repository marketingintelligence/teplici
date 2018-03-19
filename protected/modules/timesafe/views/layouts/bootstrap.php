<!DOCTYPE html>
<html lang="en">`
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title><?=$this->pageTitle?> - Система администрирования сайта</title>    
    <link rel="shortcut icon" href="/css/bootstrap/favicon.ico" />
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap/timesafe.css" media="all">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap/font-awesome.css" media="all">
    <style type="text/css">
        body {
            padding-top: 60px;
        }
    </style>

</head>

<body>
<?php $this->widget('bootstrap.widgets.BootNavbar', array(
    'brand'=>'Теплицы',
    'brandUrl'=>'/',
    'collapse'=>true,
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.BootMenu',
            'items'=>array(
                array('label'=>'Навигация','url'=>'#','icon'=>'icon-th','items'=>array(
                    array('label'=>'Социальные сети', 'url'=>array('social/list'),'icon'=>'icon-link'),
                    array('label'=>'Контакты', 'url'=>array('contacts/list'),'icon'=>'icon-link'),
                    array('label'=>'Страницы', 'url'=>array('pages/list'),'icon'=>'icon-link'),
                )),

                array('label'=>'Новости','url'=>array('news/list'),'icon'=>'icon-th'),
                array('label'=>'Статьи','url'=>'#','icon'=>'list-alt','items'=>array(
                    array('label'=>'Статьи','url'=>array('articles/list'),'icon'=>'icon-file'),
                    array('label'=>'Видео','url'=>array('video/list'),'icon'=>'icon-facetime-video'),
                )),
                array('label'=>'Ассоциации','url'=>'#','icon'=>'icon-table','items'=>array(
                    array('label'=>'Поставщики', 'url'=>array('supplier/list'),'icon'=>'icon-truck'),
                    array('label'=>'Комбинаты', 'url'=>array('combinates/list'),'icon'=>'icon-table'),
                )),
                array('label'=>'Партнеры','url'=>array('partners/list'),'icon'=>'icon-picture'),
                array('label'=>'Выставки','url'=>'#','icon'=>'icon-table','items'=>array(
                    array('label'=>'Пресс релизы', 'url'=>array('exupload/list'),'icon'=>'icon-table'),
                    array('label'=>'План выставки', 'url'=>array('explan/list'),'icon'=>'icon-save'),
                    array('label'=>'Программа выставки', 'url'=>array('exprogram/list'),'icon'=>'icon-tasks'),
                    array('label'=>'Выставки текст', 'url'=>array('extext/list'),'icon'=>'icon-file'),
                    array('label'=>'Список участников', 'url'=>array('partlist/list'),'icon'=>'icon-table'),
                    array('label'=>'Страны', 'url'=>array('countries/list'),'icon'=>'icon-flag'),
                    /*array('label'=>'Выставка draft', 'url'=>array('exhibition/list'),'icon'=>'icon-table'),*/
                )),
            ),
        ),
         
        array(
            'class'=>'bootstrap.widgets.BootMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                array('label'=>'Настройки', 'url'=>'#','icon'=>'cogs', 'items'=>array(                                    
                    
                       array('label'=>'Администратор', 'url'=>array('user/list'),'icon'=>'user'),
                )),
                array('label'=>Yii::app()->user->name, 'url'=>'#','icon'=>'user', 'items'=>array(
               
                  /*  array('label'=>'Права доступа', 'url'=>array('authItem/permissions'),'icon'=>'cog'),*/
                    
                    '---',
                    array('label'=>'Выход', 'url'=>'/site/logout', 'icon'=>'off'),
                )),
            ),
        ),        
    ),
)); ?>


<div class="container-fluid">
    <div class="row-fluid">
<? if(count($this->menu)>0 || count($this->filter)>0):?>
    <? if (!Yii::app()->user->isGuest): ?>
    
        <div class="span2">
        <? if(count($this->menu)>0): ?>
        <div class="well">            
            <h4><i class="icon-list"></i> Меню</h4>
            <hr>
            <ul class="vmenu">
                <? foreach ($this->menu as $menu):?>
                <li><a href="<?=CHtml::normalizeUrl($menu['url'])?>"><?=$menu['label']?></a></li>
                <? endforeach; ?>
            </ul>            
        </div>
        <? endif ?>

        <? $this->widget('timesafe.components.WFilter'); ?>
        <? $this->widget('timesafe.components.WTrash'); ?>
      
        </div>
    
    <? endif ?>
    <div class="span10">
        <div class="content">
<? else: ?>
    <div class="span12">
    <div class="content" style="margin-left:0">
<? endif;?>

        
        <?php if (!empty($this->breadcrumbs)):?>
        <?php $this->widget('bootstrap.widgets.BootBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
            'homeLink'=>array('label'=>'Главная','url'=>array('hello/index')),
        )); ?>
        <? endif;?>
        <?php
            echo $content;
        ?>
                 <?php $this->beginWidget('BootModal', array('id' => 'listing')); ?>
            <div class="modal-header">
                <a class="close" data-dismiss="modal">&times;</a>
                <h3><i class="icon-th-list"></i> </h3>
            </div>
            <div class="modal-body">
                <p></p>
                <strong></strong>
            </div>
            <div class="modal-footer">
                <?php echo CHtml::link('<i class="icon-ok"></i> Закрыть', '#',array('class'=>'btn', 'data-dismiss'=>'modal')); ?>                                
            </div>

            <?php $this->endWidget(); ?>
        <script type="text/javascript" src="/js/admin/plugins.js"></script>
        <script type="text/javascript" src="/js/admin/script.js"></script>
        <script type="text/javascript">
        
$(function(){
    $('.auto-list').click(function(){                    
        var t = $(this);
        $.ajax({ url:'/timesafe/json/list',data:{model:t.attr('data-model'),title:t.attr('data-title')},
            dataType:'json',
            success:function(m){
                if(m.title!=undefined){
                    $('#listing').find('h3').html('<i class="icon-th-list"></i> '+m.title);
                }
                var list = '';
                var id = $('#'+t.attr('data-source')).val();
                for (i in m.data){
                    list +='<label class="radio"><input id="list-'+m.data[i].id+'" type="radio" value="'+m.data[i].id+'" '+(id==i?'checked="checked"':'')+' name="list'+t.attr('data-model')+'">'+m.data[i].title+'</label>';
                }
                $('#listing').find('.modal-body').html(list);
                $('#listing input').change(function(){
                    $('#'+t.attr('data-source')).val(this.value);
                    $('#'+t.attr('data-sourceTitle')).val(m.data[this.value].title);
                });
            }
        });
    });
})
</script>
    </div>
    </div>
</div>

    <footer>
        <p>&copy; Maint Company <?=date('Y')?></p>
    </footer>
    <div class="timesafe-message"><?php $this->widget('bootstrap.widgets.BootAlert');?></div>
</body>
</html>


