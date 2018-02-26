<?php
/**
 * BootInputBlock class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
 
class BootInput extends CInputWidget
{
	/**
	 * @var BootActiveForm the associated form widget.
	 */
	public $form;
	/**
	 * @var string the input label text.
	 */
	public $label;
	/**
	 * @var string the input type.
	 * Following types are supported: checkbox, checkboxlist, dropdownlist, filefield, password,
	 * radiobutton, radiobuttonlist, textarea, textfield, captcha and uneditable.
	 */
	public $type;
	public $language=false;
	public $relation=false;
	/**
	 * @var array the data for list inputs.
	 */
	public $data = array();

	/**
	 * Initializes the widget.
	 * This method is called by {@link CBaseController::createWidget}
	 * and {@link CBaseController::beginWidget} after the widget's
	 * properties have been initialized.
	 */
	public function init()
	{
		if ($this->form === null)
			throw new CException('Failed to initialize widget! Form is not set.');

		if ($this->model === null)
			throw new CException('Failed to initialize widget! Model is not set.');

		if ($this->type === null)
			throw new CException('Failed to initialize widget! Input type is not set.');
	}

	/**
	 * Executes the widget.
	 * This method is called by {@link CBaseController::endWidget}.
	 */
	public function run()
	{
		$errorCss = $this->model->hasErrors($this->attribute) ? ' '.CHtml::$errorCss : '';
		echo CHtml::openTag('div', array('class'=>'clearfix'.$errorCss.($this->language!==false?' -lang -'.$this->language:'')));

		switch ($this->type)
		{
			case 'checkbox':
				$this->checkBox();
				break;

			case 'checkboxlist':
				$this->checkBoxList();
				break;

			case 'dropdownlist':
				$this->dropDownList();
				break;

			case 'filefield':
				$this->fileField();
				break;

			case 'password':
				$this->passwordField();
				break;

			case 'radiobutton':
				$this->radioButton();
				break;

			case 'radiobuttonlist':
				$this->radioButtonList();
				break;

			case 'textarea':
				$this->textArea();
				break;

			case 'textfield':
				$this->textField();
				break;

			case 'datefield':
				$this->dateField();
				break;

			case 'autofield':
				$this->autoField();
				break;

			case 'captcha':
				$this->captcha();
				break;

			case 'uneditable':
				$this->uneditableField();
				break;

			default:
				throw new CException('Failed to run widget! Input type is invalid.');
		}

		echo '</div>';
	}

	protected function checkBox()
	{
		echo '<div class="input"><div class="inputs-list">';
		echo '<label for="'.CHtml::getIdByName(CHtml::resolveName($this->model, $this->attribute)).'">';
		echo $this->form->checkBox($this->model, $this->attribute, $this->htmlOptions).' ';
		echo '<span>'.$this->model->getAttributeLabel($this->attribute).'</span>';
		echo $this->getError().$this->getHint();
		echo '</label></div></div>';
	}

	protected function checkBoxList()
	{
		echo $this->getLabel().'<div class="input">';
		echo $this->form->checkBoxList($this->model, $this->attribute, $this->data, $this->htmlOptions);
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	protected function dropDownList()
	{
		echo $this->getLabel().'<div class="input">';
		echo $this->form->dropDownList($this->model, $this->attribute, $this->data, $this->htmlOptions);
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	protected function fileField()
	{
		echo $this->getLabel().'<div class="input row">';
        $image = 'upload/'.get_class($this->model).'/sm/'.$this->model->getAttribute($this->attribute);
        $fImage = 'upload/'.get_class($this->model).'/full/'.$this->model->getAttribute($this->attribute);
        if(is_file($image)){
            $size = getimagesize($image);
            echo '<div class="span3">'.CHtml::link(CHtml::image('/'.$image.'','',array('width'=>$size['0'],'height'=>$size['1'])),'/'.$fImage).'&nbsp;</div>';
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
		echo '</div>';

	}

	protected function passwordField()
	{
		echo $this->getLabel().'<div class="input">';
		echo $this->form->passwordField($this->model, $this->attribute, $this->htmlOptions);
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	protected function radioButton()
	{
		echo '<div class="input"><div class="inputs-list">';
		echo '<label for="'.CHtml::getIdByName(CHtml::resolveName($this->model, $this->attribute)).'">';
		echo $this->form->radioButton($this->model, $this->attribute, $this->htmlOptions).' ';
		echo '<span>'.$this->model->getAttributeLabel($this->attribute).'</span>';
		echo $this->getError().$this->getHint();
		echo '</label></div></div>';
	}

	protected function radioButtonList()
	{
		echo $this->getLabel().'<div class="input">';
		echo $this->form->radioButtonList($this->model, $this->attribute, $this->data, $this->htmlOptions);
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	protected function textArea()
	{
		echo $this->getLabel().'<div class="input">';
		echo $this->form->textArea($this->model, $this->attribute, $this->htmlOptions);
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	protected function textField()
	{
		echo $this->getLabel().'<div class="input">';
		echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
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
        CHtml::resolveNameId($this->model,$this->attribute, $this->htmlOptions);
        $id = $this->htmlOptions['id'];
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
                    $("#'. $id . '").val(ui.item.id)
                }'
             ),
             'htmlOptions'=>$this->htmlOptions
        ));
        echo CHtml::activeHiddenField($this->model,$this->attribute);
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	protected function captcha()
	{
		echo $this->getLabel().'<div class="input"><div class="captcha">';
		echo '<div class="widget">'.$this->widget('CCaptcha', array('showRefreshButton'=>false), true).'</div>';
		echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
		echo $this->getError().$this->getHint();
		echo '</div></div>';
	}

	protected function uneditableField()
	{
		echo $this->getLabel().'<div class="input">';
		echo '<span class="uneditable-input">'.$this->model->{$this->attribute}.'</span>';
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	/**
	 * Returns the label for this block.
	 * @return string the label
	 */
	protected function getLabel()
	{
		if ($this->label !== false && !in_array($this->type, array('checkbox', 'radio')) && $this->hasModel())
			return $this->form->labelEx($this->model, $this->attribute);
		else if ($this->label !== null)
			return $this->label;
		else
			return '';
	}

	/**
	 * Returns the hint text for this block.
	 * @return string the hint text
	 */
	protected function getHint()
	{
		if (isset($this->htmlOptions['hint']))
		{
			$hint = $this->htmlOptions['hint'];
			unset($this->htmlOptions['hint']);
			return '<span class="help-block">'.$hint.'</span>';
		}
		else
			return '';
	}

	/**
	 * Returns the error text for this block.
	 * @return string the error text
	 */
	protected function getError()
	{
		return $this->form->error($this->model, $this->attribute);
	}
}
