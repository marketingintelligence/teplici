$( document ).ready(function() {
    var url = window.location.href;
    $(".menu a").each(function () {
        var href = $(this).attr("href");
        if (url.indexOf(href) + 1) {
           $(this).parents('.menu').find(".active_h").css('display', 'block');
            document.title = $(this).text();
        }
    });
    setInterval(function () {
        $('.modal-button').addClass('animated jello');
        setTimeout(function () {
            $('.modal-button').removeClass('animated jello');
        }, 6000);
    }, 7000);
    $('.news-body a').hover(
        function(){
            $(this).parents('.news-body').parents('.news-item').addClass('active');
            $(this).parents('.news-body').parents('.news-item').find('img').addClass('active');
            },
        function(){
            $(this).parents('.news-body').parents('.news-item').removeClass('active');
            $(this).parents('.news-body').parents('.news-item').find('img').removeClass('active');
        }
    );
    $('.n-news-button a').hover(
        function(){
            $(this).parents('.n-news-button').parents('.n-news-body').parents('.n-news-item').find('.n-news-item-img').find('img').addClass('active');
        },
        function(){
            $(this).parents('.n-news-button').parents('.n-news-body').parents('.n-news-item').find('.n-news-item-img').find('img').removeClass('active');
        }
    );
    $("body").on("click",".back",function(){
       alert('eng');
    });

    $( ".menu a" ).hover(
        function() {
            $( ".menu a" ).css('opacity', '0.5');
            $(this).css('opacity', '1');
        }, function() {
            $( ".menu a" ).css('opacity', '1');
        }
    );



    $("body").on("click",".n-news-button a",function(e){
        e.preventDefault();
        var h2 = $(this).parent('.n-news-button').parent('.n-news-body').find('.bottom-border');
        $('.bottom-border').animate({height: '4.7em'});
        $('.bottom-border').not(h2).removeClass('active');
        $('.n-news-button a').text('Читать дальше');
        if(!h2.hasClass('active')){
            h2.addClass('active');
            var text = $(this);
            h2.animate({height: h2.get(0).scrollHeight}, 1000, function(){h2.height('auto');}).promise().done(function () {
                text.text('Закрыть');
            });
        }else{
            h2.animate({height: '4.7em'}).removeClass('active');
            this.text('Читать дальше');
        }
        });

    $("body").on("click",".p-left a",function(e){
        e.preventDefault();
        $('.p-left a').removeClass('active');
        $(this).addClass('active');
        var id = $(this).data('id');
        $('.comb').removeClass('active animated slideInLeft').addClass('animated slideOutLeft').fadeOut().promise().done(function () {
            $('#combinat-' + id).removeClass('animated slideOutLeft').addClass('active animated slideInLeft').fadeIn();
        })
    });

   /* $("body").on("click",".p-right a",function(e){
        e.preventDefault();
        $('.p-right a').removeClass('active');
        $(this).addClass('active');
        var id = $(this).data('id');
        $('.post').removeClass('active animated slideInRight').addClass('animated slideOutRight').fadeOut().promise().done(function () {
            $('#postavshik-' + id).removeClass('animated slideOutRight').addClass('active animated slideInRight').fadeIn();
        })
    });*/

    /*$("body").on("click",".modal-button",function(e){
        e.preventDefault();
        $('.black-bg').fadeIn(0);
        $('.modal-form').fadeIn(0).addClass('animated slideInDown');
    });*/

    /* кнопка в footer*/
    /*$("body").on("click",".bmiddle .bb3",function(e){
        e.preventDefault();
        $('footer span.success').fadeIn(0);
        $('footer span.message').fadeOut(0);
    });*/
/*
    $("body").on("click",".bmiddle .bb3",function(){
        var name=$(".name").val();var email=$(".email").val();var error=0;if(email==""){
            $(".email").css("background","#D66161");error++;}
            if(error==0){
            Send(name,email);
        }
    });*/
    function Send(name,email,text) {
        $.ajax({
            type:"POST",
            url:"mail.php",
            data:{name:name,email:email,text:text},
            success:function(){
                $('footer span.success').fadeIn(0);
                $("#footer-form").fadeOut(300);
                $(".border2").css("margin-top","9em");
                $('footer span.message').fadeOut(0);

                /*$('.before').animate({opacity:'0',width:'80%'},500,function(){$('.call-window-box2').append("<div class='transform' style='position:absolute;top:50%; left: 50%;width: 100%; text-align: center;'>Спасибо за обращение<br> в нашу компанию!<br> <br>Менеджер в скором времени<br> свяжется с Вами.</div>")});*/
            }
        });
    }

    $('#footer-form').submit(function(e) {
        e.preventDefault();
        var name=$(".name").val();
        var text=$(".messages").val();
        var email=$(".email").val();var error=0;if(email==""){error++;}
        if(error==0){
            Send(name,email,text);
        }
    })

    //Кнопка "нужна теплица"
    /*
    $("body").on("click",".modal-form .bb2",function(e){
        e.preventDefault();
        var name=$(".name").val();var phone=$(".phone").val();var error=0;if(phone==""){
            $(".phone").css("background","#D66161");error++;}if(error==0){
            Send(name,phone);}
    });*/
    $("body").on("click",".black-bg",function(){
        $(this).fadeOut(0);
        $('.modal-form').fadeOut(0).removeClass('animated slideInDown');
    });
    $("body").on("click",".close",function(){
        $('.black-bg').fadeOut(0);
        $('.modal-form').fadeOut(0).removeClass('animated slideInDown');
    });
    if ($(window).width() < 901) {
        var height = $('header').height();
        $('body').css('margin-top', height);
        var scrollModal = $('footer').offset().top-700;
        $(window).scroll(function() {
            var scrolled = $(window).scrollTop();
            if (scrolled > scrollModal) {
                $('.modal-button').css('top', '20%');
            }else{
                $('.modal-button').css('top', '80%');
            }
        });
        $("body").on("click",".href",function(e){
            e.preventDefault();
            var id = $(this).data("id");
            var route = $(this).data('route');
            console.log(route);
            $('a.href li').removeClass('active_li mobile-no').promise().done(function () {
                $('a.href[data-id='+id+'] li').addClass('active_li');
            });
            if( id == 1 ) {
                if ($(window).width() < 471) {
                    $('.active_nav').css({height: '1.7em'});
                }else{
                    $('.active_nav').css({height: '1.5em'});
                }
                $(".item1").removeClass('animated fadeInRight').addClass('animated fadeOutRight').fadeOut().promise().done(function () {
                $('.content').removeClass('active animated fadeInLeft fadeOutLeft').fadeOut().promise().done(function () {
                    $('#' + id).addClass('active animated fadeInLeft').fadeIn();
                });
                });
                $('.dropdown').slideUp();
            } else if( id == 2 ) {
                if ($(window).width() < 471) {
                    $('.active_nav').css({height: '4.8em'});
                }else{
                    $('.active_nav').css({height: '3.3em'});
                }
                $(".item1").removeClass('animated fadeInRight').addClass('animated fadeOutRight').fadeOut().promise().done(function () {
                    $('.content').removeClass('active animated fadeInLeft fadeOutLeft').fadeOut().promise().done(function () {
                        $('#' + id).addClass('active animated fadeInLeft').fadeIn();
                    });
                });
                $('.dropdown').slideUp();
            } else if( id == 3 ) {
                if ($(window).width() < 471) {
                    $('.active_nav').css({height: '7.8em'});
                }else{
                    $('.active_nav').css({height: '5.5em'});
                }
                  
                var valFileDownloadPath = '/upload/Exupload/'+route;
                window.open(valFileDownloadPath);
                /*$(".item1").removeClass('animated fadeInRight').addClass('animated fadeOutRight').fadeOut().promise().done(function () {
                    $('.content').removeClass('active animated fadeInLeft fadeOutLeft').fadeOut().promise().done(function () {
                        $('#' + id).addClass('active animated fadeInLeft').fadeIn();
                    });
                });*/

                $('.dropdown').slideUp();
            } else if( id == 4 ) {
                if ($(window).width() < 471) {
                    $('.active_nav').css({height: '10.6em'});
                }else{
                    $('.active_nav').css({height: '7.7em'});
                }
                $(".item1").removeClass('animated fadeInRight').addClass('animated fadeOutRight').fadeOut().promise().done(function () {
                    $('.content').removeClass('active animated fadeInLeft fadeOutLeft').fadeOut().promise().done(function () {
                        $('#' + id).addClass('active animated fadeInLeft').fadeIn();
                    });
                });
                $('.dropdown').slideUp();
            } else if( id == 5 ) {
                if ($(window).width() < 471) {
                    $('.active_nav').css({height: '13.5em'});
                }else{
                    $('.active_nav').css({height: '9.7em'});
                }
                $(".item1").removeClass('animated fadeInRight').addClass('animated fadeOutRight').fadeOut().promise().done(function () {
                    $('.content').removeClass('active animated fadeInLeft fadeOutLeft').fadeOut().promise().done(function () {
                        $('#' + id).addClass('active animated fadeInLeft').fadeIn();
                    });
                });
                $('.dropdown').slideUp();
            } else if( id == 6 ) {
                if ($(window).width() < 471) {
                    $('.active_nav').css({height: '16.5em'});
                }else{
                    $('.active_nav').css({height: '11.9em'});
                }
                $(".item1").removeClass('animated fadeInRight').addClass('animated fadeOutRight').fadeOut().promise().done(function () {
                    $('.content').removeClass('active animated fadeInLeft fadeOutLeft').fadeOut().promise().done(function () {
                        $('#' + id).addClass('active animated fadeInLeft').fadeIn();
                    });
                });
                $('.dropdown').slideUp();
            } else if( id == 2015 ) {
                if ($(window).width() < 471) {
                    $('.active_nav').css({height: '19.5em'});
                }else{
                    $('.active_nav').css({height: '13.4em'});
                }
                $('.dropdown').slideToggle();
                $('.dropdown li').removeClass('active');
            }
        });
        $("body").on("click",".back-vystvka a",function(e){
            e.preventDefault();
                $('.content').removeClass('active animated fadeInLeft').addClass('animated fadeOutLeft').fadeOut().promise().done(function () {
                    $(".item1").removeClass('animated fadeOutRight').addClass('animated fadeInRight').fadeIn()
                });
        });
        $("body").on("click",".dropdown li",function(e){
            e.preventDefault();
            $('.dropdown li').removeClass('active');
            $(this).addClass('active');
            var id = $(this).parents('a').data("id");
            var routes = $(this).parents('a').data("routes");

            var valFileDownloadPath = '/upload/Exupload/'+routes;

            alert(valFileDownloadPath);
            
            window.open(valFileDownloadPath);
           /* $(".item1").removeClass('animated fadeInRight').addClass('animated fadeOutRight').fadeOut().promise().done(function () {
                $('.content').removeClass('active animated fadeInLeft fadeOutLeft').fadeOut().promise().done(function () {
                    $('#' + id).addClass('active animated fadeInLeft').fadeIn();
                });
        });*/

        });
        $('.black-bg').css('cursor', 'pointer');
        $('path').css('cursor', 'pointer');
        $("body").on("click","path",function(){
            var id = $(this).attr('id');
            $('.hidden, path').removeClass('active');
            $('.hidden').removeClass('animated slideInLeft').addClass('animated slideOutRight').fadeOut().promise().done(function () {
                $('#show-' + id).removeClass('animated slideOutRight').fadeIn(0).addClass('animated slideInLeft');
            });
        });

        $("body").on("click",".f-button .bbtm",function(e){
            e.preventDefault();
            $('.margg').fadeOut(0).promise().done(function () {
                $('.mobile-slide').slideDown();
            });
        });
        
        $(".mobile-menu a").each(function () {
            var href = $(this).attr("href");
            if (url.indexOf(href) + 1) {
                $(this).addClass('active');
            }
        });
        $("body").on("click",".logo",function(e){
            e.preventDefault();
            $('.mobile-menu').slideToggle();
        });
        $("body").on("click",".share",function(){
            $('ul.li').slideToggle();
        });
        $("body").on("click",".flip-container",function(){
            $('.front').fadeOut(0);
            $('.back').fadeIn(0);
        });

        var scrollPosM = $('.section-block').offset().top-300;
        var onceM = false;
        $(window).scroll(function() {
            var scrolled = $(window).scrollTop();
            if ((scrolled > scrollPosM) && !onceM) {
                onceM = true;
                var once = false;
                function ggg () {
                    animateOn(1);
                    once = true;
                }
                ggg();
                function animateOn(activeTxt) {
                    if (activeTxt == 1) {
                        activeTxt = 2;
                    }
                    if (activeTxt == 9) {
                        activeTxt = 1;
                        animateOn(activeTxt + 1);
                    }
                    if (once && activeTxt == 1) {
                        return;
                    }
                    $('.flex-box[data-id='+activeTxt+']').addClass('active');
                    setTimeout(function() {
                        $('.flex-box[data-id='+activeTxt+']').removeClass('active');
                        if (!once && activeTxt == 1) {
                            return;
                        }
                        animateOn(activeTxt + 1);
                    }, 2000);
                }
            }
        });
    }else{
        $("body").on("click",".href",function(e){
            e.preventDefault();
            var id = $(this).data("id");
            $('a.href li').removeClass('active_li').promise().done(function () {
                $('a.href[data-id='+id+'] li').addClass('active_li');
            });
            if( id == 1 ) {
                $('.active_nav').css({height: '1.5em'});
                $('.content').removeClass('active animated fadeInRight').fadeOut().promise().done(function () {
                    $('#' + id).addClass('active animated fadeInRight').fadeIn();
                })
                $('.dropdown').slideUp();
            } else if( id == 2 ) {
                $('.active_nav').css({height: '3.3em'});
                $('.content').removeClass('active animated fadeInRight').fadeOut().promise().done(function () {
                    $('#' + id).addClass('active animated fadeInRight').fadeIn();
                })
                $('.dropdown').slideUp();
            } else if( id == 3 ) {
                $('.active_nav').css({height: '5.5em'});
                $('.content').removeClass('active animated fadeInRight').fadeOut().promise().done(function () {
                    $('#' + id).addClass('active animated fadeInRight').fadeIn();
                })
                $('.dropdown').slideUp();
            } else if( id == 4 ) {
                $('.active_nav').css({height: '7.7em'});
                $('.content').removeClass('active animated fadeInRight').fadeOut().promise().done(function () {
                    $('#' + id).addClass('active animated fadeInRight').fadeIn();
                })
                $('.dropdown').slideUp();
            } else if( id == 5 ) {
                $('.active_nav').css({height: '9.7em'});
                $('.content').removeClass('active animated fadeInRight').fadeOut().promise().done(function () {
                    $('#' + id).addClass('active animated fadeInRight').fadeIn();
                })
                $('.dropdown').slideUp();
            } else if( id == 6 ) {
                $('.active_nav').css({height: '11.9em'});
                $('.content').removeClass('active animated fadeInRight').fadeOut().promise().done(function () {
                    $('#' + id).addClass('active animated fadeInRight').fadeIn();
                })
                $('.dropdown').slideUp();
            } else if( id == 2015 ) {
                $('.active_nav').css({height: '14em'});
                $('.dropdown').slideToggle();
                $('.dropdown li').removeClass('active');
            }
        });
        $("body").on("click",".dropdown li",function(e){
            e.preventDefault();
            $('.dropdown li').removeClass('active');
            $(this).addClass('active');
            var id = $(this).parents('a').data("id");
            $('.content').removeClass('active animated fadeInRight').fadeOut().promise().done(function () {
                $('#' + id).addClass('active animated fadeInRight').fadeIn();
            })

        });

        function svgfalse() {
            setTimeout(function () {$('.svg .big-circle,.svg  .circle-line2').css('opacity', '0').fadeOut(0).removeClass('animated zoomIn');},0);
            setTimeout(function () {$('.svg .border-2').css('opacity', '0').fadeOut(0).removeClass('border2-an');},0);
            setTimeout(function () {$('.svg .border-1').css('opacity', '0').fadeOut(0).removeClass('border-1-an');},0);
            setTimeout(function () {$('.svg .circle-line').css('opacity', '0').fadeOut(0).removeClass('animated zoomIn');},0);
            setTimeout(function () {$('.svg .text').css('opacity', '0').fadeOut(0).removeClass('animated fadeIn');},0);
            $('.hidden').fadeOut(0);
        }
        $( "path" ).hover(
            function() {
                var id = $(this).attr('id');
                $('#show-' + id).fadeIn(0);
                function svg() {
                    setTimeout(function () {$('#show-' + id).find('.big-circle,.circle-line2').fadeIn(0).css('opacity', '1').addClass('animated zoomIn');},0);
                    setTimeout(function () {$('#show-' + id).find('.border-2').fadeIn(0).css('opacity', '1').addClass('border2-an');},700);
                    setTimeout(function () {$('#show-' + id).find('.border-1').fadeIn(0).css('opacity', '1').addClass('border-1-an');},1700);
                    setTimeout(function () {$('#show-' + id).find('.circle-line').fadeIn(0).css('opacity', '1').addClass('animated zoomIn');},2700);
                    setTimeout(function () {$('#show-' + id).find('.text').fadeIn(0).css('opacity', '1').addClass('animated fadeIn');},3700);
                }
                clearTimeout(svgfalse);
                svg();
            }, function() {
                svgfalse();
            }
        );
        setTimeout(function () {$('.language').fadeIn().addClass('animated slideInDown');},500);
        setTimeout(function () {$('.flip-container').fadeIn(0).addClass('animated flipInY');},2000);
        setTimeout(function () {$('.header-container').css('opacity', '1').addClass('animated zoomIn');},1500);
        setTimeout(function () {$('.title h1, .title h2').css('opacity', '1').addClass('animated slideInDown');},1500);
        setTimeout(function () {$('.white_blocks').css('opacity', '1').addClass('animated slideInLeft');},2000);
        var width = $(window).width();
        if(width > "1600"){
            var scrollPos5 = $('footer').offset().top-700;
            var once5 = false;
            $(window).scroll(function() {
                var scrolled = $(window).scrollTop();
                if ((scrolled > scrollPos5) && !once5) {
                    once5 = true;
                    $('.form .item').css('opacity', '1').addClass('animated slideInDown');
                }
            });
        }else {
            var scrollPos5 = $('footer').offset().top-600;
            var once5 = false;
            $(window).scroll(function() {
                var scrolled = $(window).scrollTop();
                if ((scrolled > scrollPos5) && !once5) {
                    once5 = true;
                    $('.form .item').css('opacity', '1').addClass('animated slideInDown');
                }
            });
        }


    var scrollPos6 = $('section.news').offset().top - 400;
    var once6 = false;
    $(window).scroll(function() {
        var scrolled = $(window).scrollTop();
        if ((scrolled > scrollPos6) && !once6) {
            once6 = true;
            $('.n1').fadeIn(0).addClass('animated fadeIn').animate({opacity: 1}, 1000,  function () {
                $('.n2').fadeIn(0).addClass('animated fadeIn').animate({opacity: 1}, 1000,  function () {
                    $('.n3').fadeIn(0).addClass('animated fadeIn').animate({opacity: 1}, 1000,  function () {
                    });
                });
            });
        }
    });
        $( ".owl-left, .owl-right" ).hover(
            function() {
                $(this).find("img").attr('src', '/media/img/part/r.png');
            }, function() {
                $(this).find("img").attr('src', '/media/img/part/l.png');
            }
        );
}});


