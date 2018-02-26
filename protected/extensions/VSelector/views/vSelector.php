<div class="pt-5"><a href="#" class="mark-green-plus" id="selector-open" ><?=$mValue>0?$this->model->parentCategory->title:'Выбрать категорию'?></a></div>
    <div class="rel">
        <div class="float-category-lists" id="selector-container" style="display:none;">
        
        <div class="pb-5 t-13">Напечатайте название категории</div>
        <div class="pb-10">
            <?

            $this->widget('zii.widgets.jui.CJuiAutoComplete', 
            array(
                'name' => 'selector',
                'value'=> $this->model->parentCategory->title,
                'source' => $this->controller->createUrl('json'),
                'themeUrl'   => '/css',
                'theme'      => 'swistok',
                'options' => array(
                   'minLength' => '2',
                   'select' => 'js:function(e,ui){
                        $("#Product_parent_Category_id").val(ui.item.id); 
                        checkData();              
                    }'
                ),
                'htmlOptions' => array(  
                   'class'=>'field'
                ),
            ));
            echo CHtml::activeHiddenField($this->model,$this->attribute);
            ?>
        </div>

        <div class="pb-5 t-13">Или выберите из списка:</div>
        <div class="pb-10">

            <div class="scroll-hor-overflow">
                <ul class="list-category-block">
                    <li id="level-0">
                        <div class="list-category-block">
                            <div class="scroll">
                                <?php foreach ($models as $key => $model): ?>
                                <a href="#<?=$model->id?>" <?=$ancestors[0]==$model->id?' class="selected"':''?>><?=$model->title_ru?><? if($model->childCount>0):?> <span>&gt;&gt;</span><? endif; ?></a>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </li>
                    <?                    
                    if(count($ancestors)>0){
                        foreach ($ancestors as $key => $value) {
                            $cats = Category::model()->with('childCount')->findAll(array(
                                'condition'=>'status and parent_id=:parent',
                                'params'=>array(':parent'=>(int)$value),
                                'select'=>'title_ru,id',
                                'order'=>'title_ru ASC'
                            )); 
                            if(count($cats)>0){?>
                    <li>
                        <div class="list-category-block-arr">
                            <img width="9" height="12" alt="" src="/img/08_list_category_arr.png">
                        </div>
                    </li>
                    <li id="level-<?=$value?>">
                        <div class="list-category-block">
                            <div class="scroll">
                                <?php foreach ($cats as $k => $cat):
                                 ?>
                                <a href="#<?=$cat->id?>" <?=($ancestors[$key+1]==$cat->id || $cat->id==$mValue)?' class="selected"':''?>><?=$cat->title_ru?><? if($cat->childCount>0):?> <span>&gt;&gt;</span><? endif; ?></a>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </li>
                            <?
                            }
                        }
                    }
                    ?>                   

                </ul>
                <div class="clear">&nbsp;</div>

            </div>
            <br>
            <style type="text/css" media="screen">
                .selector-slider{
                    position: relative
                }
                .ui-draggable{
                    width:38px;
                }
            </style>
            <div class="selector-slider" style="display:none;">
                <div class="fr"><a href="#"><img width="9" height="12" class="db " alt="" src="/img/05_scroll-right.png"></a></div>
            <div class="fl"><a href="#"><img width="9" height="12" class="db" alt="" src="/img/05_scroll-left.png"></a></div>    
            <?
            $this->beginWidget('zii.widgets.jui.CJuiDraggable', array(
    // additional javascript options for the draggable plugin
    'options'=>array(
        'scope'=>'myScope',
        'axis'=>"x",
        'containment'=> "parent",
        'drag'=>'js:function(e,ui){
            ui.position.left;
            var p = Math.round(100/698*ui.position.left);
            var diff = $("ul.list-category-block").width()-734;
            left = diff/100*p;
            $("ul.list-category-block").css("left","-"+left+"px");
        }'
    ),
));
    echo '<div class="begunok" style="margin:0 9px;left:698px;"></div>';

$this->endWidget();?>
            
            </div>
            
            <div class="clear">&nbsp;</div>

            <div style="top: -7px;" class="rel"><div class="list-category-scroll-line">&nbsp;</div></div>
            
            <div class="clear">&nbsp;</div>

            <br>
            <div class="fr t-12 pt-5">Не нашли нужную категорию? Обратитесь в <a href="/site/contact.html?title=Не нашли нужную категорию" target="_blank">службу поддержки</a></div>
            <div class="fl">                
                <button class="standart-active" type="button" id="selector-close"><div>Выбрать</div></button>
            </div>
            <div class="fl pt-5 pl-20"><a class="d-gray" href="#" id="selector-cancel">Отмена</a></div>
        </div>
        
    </div>
    </div>
    <script type="text/javascript" charset="utf-8">
            $(function(){
                $('#selector-open').click(function(e){
                    $('#selector-container').fadeIn('fast',function(){
                        $('div.list-category-block').each(function(){                    
                            var t= $(this);
                            var s = t.find('.selected');                            
                            if(s.length>0)
                                t.scrollTop(s.get(0).offsetTop);                    
                        });
                    });
                    e.preventDefault();
                });
                $('#selector-close').click(function(e){
                    $('#selector-container').fadeOut('fast');
                    $('#selector-open').text($('#selector').val());
                    checkData();
                    e.preventDefault();
                });
                $('#selector-cancel').click(function(e){
                    $("#Product_parent_Category_id,#selector").val('');                    
                    $('#selector-container').fadeOut('fast');
                    $('#level-0').nextAll().remove();
                    $('.list-category-block a.selected').removeClass('selected');
                    checkData();
                    e.preventDefault();
                });
                $('.list-category-block a').live('click',function(e){
                    var t = $(this);
                    var parent = t.parents('li');
                    var id = t.attr('href').replace('#','');
                    $("#Product_parent_Category_id").val(id);
                    $("#selector").val(t.text().replace('>>',''));
                    parent.find('.selected').removeClass('selected');                    
                    t.addClass('selected');
                    parent.nextAll().remove();

                    $.ajax({
                        url:'<?=$this->controller->createUrl('VSelector')?>',
                        data:{
                            level:id
                        },
                        success:function(m){
                            if(m!=''){
                                parent.nextAll('li').remove();        
                                parent.after(m);
                                var w = 0;
                                $('ul.list-category-block').children('li').each(function(){
                                    w+=$(this).width();                                
                                });
                                $('ul.list-category-block').width(w+'px');
                                var diff = w-734;
                                if(diff>0){
                                    $('.selector-slider').fadeIn();
                                    $('.selector-slider .ui-draggable').css('left','698px');
                                }else{
                                    $('.selector-slider').fadeOut();
                                }
                                $("ul.list-category-block").animate({"left":"-"+diff+"px"});
                            }
                        }
                    });                   
                    e.preventDefault();
                });

                
            });
    </script>