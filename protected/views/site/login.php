<section class="news fix">
    <div class="news-list" style="text-align: center; ">
        <div class="list-item" style = "padding:20px;">
            <h3>Вход в Административную часть </h3>
            <?php $form = $this->beginWidget('CActiveForm', array('id' => 'login-form', 'method' => 'post', 'enableAjaxValidation' => 'false')); ?>
            <div class="pb-5" style=" padding-top: 1.5em;"><strong>Логин: <span class="t-orange">*</span></strong></div>
            <div class="pb-20">
                <?php echo $form->textField($model, 'username', array('class'=>'field', 'style'=>"padding:10px 6px; border: 1px solid #f8b803;")); ?>
                <div class="pt-5"><span class="t-orange"><?php echo $form->error($model,'username');?></span></div>
            </div>
            <div class="pb-5" style = "padding-top:20px;"><strong>Пароль: <span class="t-orange">*</span></strong></div>
            <div class="pb-20"">
                <?php echo $form->passwordField($model, 'password', array('class'=>'field','style'=>"padding:10px 6px; border: 1px solid #f8b803;"))?>
                <div class="pt-5"><span class="t-orange"><?php echo $form->error($model,'password');?></span></div>
            </div>
            <div class="pb-20" style = "padding-top:10px; text-align:center;">
                <button style = "position:relative;" type="submit" class="read-btn">Войти</button>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</section>
