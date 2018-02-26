$(function() {
    
    $('.select-on-check').live('change', (function() {
        return $('.select-on-check:checked').length > 0 ? $('.action-many').show() : $('.action-many').hide();
    }));
    $('.select-on-check-all').live('change', (function() {
        return $('.select-on-check-all:checked').length > 0 ? $('.action-many').show() : $('.action-many').hide();
    }));
    $('.action-delete-confirm').live('click', function() {
        $.post($(this).attr('rel'), {ids:$('.select-on-check:checked').serializeArray()}, function() {
            var id = $('.grid-view').eq(0).attr('id');
            $.fn.yiiGridView.update(id);
            $('#lean_overlay').click();
        })
    });
    $('.delete-link-tree').live('click',function(e){
        if(confirm('Вы действительно хотите удалить страницу и все вложенные текстовые документы (страницы)?!')){

            $.ajax({
                url:$(this).attr('href'),
                data:{},
                type:'post',
                dataType:'json',
                success:function(ids){
                    if(ids!=undefined){
                        for(i in ids){
                            $('#node-'+ids[i]).remove();
                        }
                    }
                }
            });
        }
        e.preventDefault();
    });
    
    $('.filter a').click(function(){
        $('.filter a').css('font-weight','normal');
        $(this).css('font-weight','bold');
    });

    
    $('#metalink').click(function(e){
        var t = $('#metainfo');
        if(t.is(':visible')){
            t.slideUp();
        }else{
            t.slideDown();
        }
        e.preventDefault();
    });

    $('#window-resize').bind('click',function(){
        if(!$(this).hasClass('expand')){
            $(this).addClass('expand');
            $('#sidebar').fadeOut('fast',function(){
                $('#main').animate({width:'100%'},'fast');
                $.cookie('_timesafe_sidebar_expand',1);
            });
        }else{
            $(this).removeClass('expand');
            $('#main').animate({width:'77%'},'fast',function(){
                $('#sidebar').fadeIn('fast');
                $.cookie('_timesafe_sidebar_expand',0);
            });
        }
    });


// Всё что выше под вопросом, то что ниже точно будет в новой системе.

    $(".content select:not(.nchosen)").chosen();
    $(".toggle-on-check").toggleit();

    $('.datepicker').each(function(i){
        var t = $(this);
        t.parent().css('position','relative');        
        t.after('<div style="position:absolute;top:0;left:0;" id="datepicker-'+i+'"></div>');
        
        $('#datepicker-'+i+'').jCal({
            day:            new Date(parseInt(t.attr('data-time'))),
            days:           1,
            showMonths:     1,
            monthSelect:    true,
            callback:       function (day, days) {
                var Y = day.getFullYear();
                var m = day.getMonth()+1;
                m = m<10?'0'+m:m;
                var d = day.getDate();
                d = d<10?'0'+d:d;
                $(this._target[0]).prev().val(d+'-'+m+'-'+Y)
                $(this._target[0]).slideUp();
            }
        });
        t.click(function(){$('#datepicker-'+i+'').slideDown()});
    });

    
    $('.restore-link').live('click',function(e){
        var t = $(this);
        $('#modal-restore').data('id',t.attr('data-id'));
        $('#modal-restore strong').html('"'+t.attr('data-title')+'"');
        e.preventDefault();
    });

    $('.delete-link-list').live('click',function(e){
        var t = $(this);
        $('#modal-delete').data('id',t.attr('data-id'));
        $('#modal-delete strong').html('"'+t.attr('data-title')+'"');
        e.preventDefault();
    });
});