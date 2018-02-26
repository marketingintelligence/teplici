<?php
/**
 * BootInputVertical class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets.input
 */

Yii::import('bootstrap.widgets.input.BootInput');

/**
 * Bootstrap vertical form input widget.
 * @since 0.9.8
 */
class BootInputVertical extends BootInput
{
	/**
	 * Renders a CAPTCHA.
	 * @return string the rendered content
	 */
	protected function captcha()
	{
		echo $this->getLabel().'<div class="captcha">';
		echo '<div class="widget">'.$this->widget('CCaptcha', $this->data, true).'</div>';
		echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	/**
	 * Renders a checkbox.
	 * @return string the rendered content
	 */
	protected function checkBox()
	{
		echo '<label class="checkbox" for="'.CHtml::getIdByName(CHtml::resolveName($this->model, $this->attribute)).'">';
		echo $this->form->checkBox($this->model, $this->attribute, $this->htmlOptions).PHP_EOL;
		echo $this->model->getAttributeLabel($this->attribute);
		echo $this->getError().$this->getHint();
		echo '</label>';
	}

	/**
	 * Renders a list of checkboxes.
	 * @return string the rendered content
	 */
	protected function checkBoxList()
	{
		echo $this->getLabel();
		echo $this->form->checkBoxList($this->model, $this->attribute, $this->data, $this->htmlOptions);
		echo $this->getError().$this->getHint();
	}

	/**
	 * Renders a list of inline checkboxes.
	 * @return string the rendered content
	 */
	protected function checkBoxListInline()
	{
		$this->htmlOptions['inline'] = true;
		$this->checkBoxList();
	}

	/**
	 * Renders a drop down list (select).
	 * @return string the rendered content
	 */
	protected function dropDownList()
	{
		echo $this->getLabel();
		echo $this->form->dropDownList($this->model, $this->attribute, $this->data, $this->htmlOptions);
		echo $this->getError().$this->getHint();
	}

	/**
	 * Renders a file field.
	 * @return string the rendered content
	 */
	protected function fileField()
	{
		$className = get_class($this->model);
		echo $this->getLabel();		
		$type = 'image';
		if(strstr($this->attribute,'image')){
	        $image = 'upload/'.$className.'/sm/'.$this->model->getAttribute($this->attribute);
	        $fImage = 'upload/'.$className.'/full/'.$this->model->getAttribute($this->attribute);
	    }else{
	    	$type = 'file';
	    	$image = 'upload/'.$className.'/'.$this->model->getAttribute($this->attribute);
	    }
        if(is_file($image)){
            $size = getimagesize($image);
            if($type==='image')
        	    echo '<div class="span3">'.CHtml::link(CHtml::image('/'.$image.'','',array('width'=>$size['0'],'height'=>$size['1'])),'/'.$fImage).'&nbsp;</div>';
        	else{
        		echo '<div class="span3">'.CHtml::link('Показать ('.round(filesize($image)/1024/1024).' Мб)','/'.$image,array('class'=>'btn','target'=>'_blank')).'&nbsp;</div>';
        	}
        		

            echo '<div class="offset3">';
            echo CHtml::button('Изменить',array('class'=>'btn info','onclick'=>'js:$("#file-'.$this->attribute.'").addClass("in");$(this).addClass("disabled")')).'&nbsp;';
            echo CHtml::button('Удалить',array('class'=>'btn error','onclick'=>'js:if($("#'.$this->attribute.'-delete").val()==""){$(this).val("Не удалять").addClass("success"); $("#'.$this->attribute.'-delete").val(1);}else{$(this).val("Удалить").removeClass("success");$("#'.$this->attribute.'-delete").val("");}')).'<br>';                    
            echo $this->form->fileField($this->model,$this->attribute,array('class'=>'input-file fade out','id'=>'file-'.$this->attribute)); 
            echo CHtml::hiddenField($this->attribute.'-src',$this->model->getAttribute($this->attribute));
            echo CHtml::hiddenField($this->attribute.'-delete','');
            echo '</div>';
        }else{
            echo $this->form->fileField($this->model,$this->attribute,array('class'=>'input-file')); 
        }        
		echo $this->getError().$this->getHint();

	}
	// protected function fileField()
	// {
	// 	echo $this->getLabel();
	// 	echo $this->form->fileField($this->model, $this->attribute, $this->htmlOptions);
	// 	echo $this->getError().$this->getHint();
	// }

	/**
	 * Renders a password field.
	 * @return string the rendered content
	 */
	protected function passwordField()
	{
		echo $this->getLabel();
		echo $this->form->passwordField($this->model, $this->attribute, $this->htmlOptions);
		echo $this->getError().$this->getHint();
	}

	/**
	 * Renders a radio button.
	 * @return string the rendered content
	 */
	protected function radioButton()
	{
		echo '<label class="radio" for="'.CHtml::getIdByName(CHtml::resolveName($this->model, $this->attribute)).'">';
		echo $this->form->radioButton($this->model, $this->attribute, $this->htmlOptions).PHP_EOL;
		echo $this->model->getAttributeLabel($this->attribute);
		echo $this->getError().$this->getHint();
		echo '</label>';
	}

	/**
	 * Renders a list of radio buttons.
	 * @return string the rendered content
	 */
	protected function radioButtonList()
	{
		echo $this->getLabel();
		echo $this->form->radioButtonList($this->model, $this->attribute, $this->data, $this->htmlOptions);
		echo $this->getError().$this->getHint();
	}

	/**
	 * Renders a list of inline radio buttons.
	 * @return string the rendered content
	 */
	protected function radioButtonListInline()
	{
		$this->htmlOptions['inline'] = true;
		$this->radioButtonList();
	}

	/**
	 * Renders a textarea.
	 * @return string the rendered content
	 */
	protected function textArea()
	{
		echo $this->getLabel();
		echo $this->form->textArea($this->model, $this->attribute, $this->htmlOptions);
		echo $this->getError().$this->getHint();
	}

	/**
	 * Renders a text field.
	 * @return string the rendered content
	 */
	protected function textField()
	{
		echo $this->getLabel();
		echo $this->getPrepend();
		echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
		echo $this->getAppend();
		echo $this->getError().$this->getHint();
	}

	protected function autoField()
	{
		$params=array();
		$rName = $this->relation[relation];
		$relations = $this->model->relations();
		$relation = $relations[$this->relation[relation]];
		$params=array(
			'model'=>$relation[1]
		);

		if($this->relation['title']!='') $params['title'] = $this->relation['title'];
		if($this->relation['add']!='') $params['add'] = $this->relation['add'];

		echo $this->getLabel().'<div class="input">';
		//'auto-field-'.$rName
		$id = CHtml::resolveNameId($this->model,$this->attribute, $this->htmlOptions);		
		unset($this->htmlOptions['id']);
		$this->widget(
        'zii.widgets.jui.CJuiAutoComplete',
        array(
        	 'id'       => $rName . '-field',
             'name'       => $this->relation['relation'] . '-field',
             'value'      => $this->model->$rName->title,
             'source'     => $this->controller->createUrl('json/index', $params),
             'themeUrl'   => '/css/bootstrap',
             'theme'      => 'timesafe',
             'options'    => array(
                'minLength'=> '3',
                'select'   => 'js:function(e,ui){                 	
                    $("#'.$id . '").val(ui.item.id)
                }'
             ),
             'htmlOptions'=>$this->htmlOptions
        ));
        echo CHtml::activeHiddenField($this->model,$this->attribute);
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	protected function dateField()
	{
		echo $this->getLabel().'<div class="input">';		
		$at = $this->attribute;
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name'=>get_class($this->model).'['.$this->attribute.']',            
            'value'=>date("d-m-Y",$this->model->$at),
            'themeUrl'=>'/css/bootstrap',            
            'theme'=>'timesafe',
            'attribute'=>'created_at',
            // additional javascript options for the date picker plugin
            'options'=>array(
                'showAnim'=>'fold',
                'dateFormat'=>'dd-mm-yy'
            ),
            'htmlOptions'=>$this->htmlOptions
        ));
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	/**
	 * Renders an uneditable field.
	 * @return string the rendered content
	 */
	protected function uneditableField()
	{
		echo $this->getLabel();
		echo CHtml::tag('span', $this->htmlOptions, $this->model->{$this->attribute});
		echo $this->getError().$this->getHint();
	}
}
