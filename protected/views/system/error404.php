<html>
    <head>
        <title>Ошибка 404. Страница не найдена!</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style>
            html, body {
                height:100%;
                min-height:100%;
                background:url('/media/img/flowers.jpg') no-repeat;
                background-size:cover;
                overflow:hidden;
            }

            #container {
                width:100%;
                height:100%;
                position:relative;
            }
            #content {
                width:600px;
                height:600px;
                position:absolute;
                top:50%;
                left:50%;
                margin:-280px 0 0 -300px;
            }
            #content h1 {
                text-align:center;
            }
            #content h2 {
                font-size:30px;
                color:#a4b540;
                line-height:32px;
            }
            #content p {
                font-size:22px;
                margin-bottom:20px;
/*
                color:#bccf4f;
*/
            }
            .error-404 h2 {
                float:left;
                width:200px;
                height:200px;
                margin-top:10px;
            }
            a {
                color:#000000;
            }
            a:hover {
                opacity: 0.7;
            }
            #question {
                color: #a4b540;
            }
        </style>
    </head>
    <body>
        <div id="container">
            <div id="content" class="error-404">
                <h1>
                    <a href="/" title="На главную страницу"><img src="/media/img/logo.png" width="120"></a>
                </h1>
                <h2>Ошибка 404</h2>
                <p>Неправильно набран адрес, или такой страницы на сайте больше не существует.</p>
                <p id="question"><strong>Что делать?</strong><br><a href="/">Вернуться на главную страницу!</a></p></div>
        </div>
    </body>
</html>