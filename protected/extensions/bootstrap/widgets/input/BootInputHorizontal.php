<?php
/**
 * BootInputHorizontal class file.
 *
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets.input
 */

Yii::import( 'bootstrap.widgets.input.BootInput' );

/**
 * Bootstrap horizontal form input widget.
 *
 * @since 0.9.8
 */
class BootInputHorizontal extends BootInput
{
	/**
	 * Runs the widget.
	 */
	public function run() {
		echo CHtml::openTag( 'div', array( 'class'=>'control-group '.$this->getContainerCssClass().''.( $this->language?( ' -lang -'.$this->language ):'' ) ) );
		parent::run();
		echo '</div>';
	}

	/**
	 * Returns the label for this block.
	 *
	 * @param array   $htmlOptions additional HTML attributes
	 * @return string the label
	 */
	protected function getLabel( $htmlOptions = array() ) {
		$cssClass = 'control-label';
		if ( isset( $htmlOptions['class'] ) )
			$htmlOptions['class'] .= ' '.$cssClass;
		else
			$htmlOptions['class'] = $cssClass;

		return parent::getLabel( $htmlOptions );
	}

	/**
	 * Renders a checkbox.
	 *
	 * @return string the rendered content
	 */
	protected function checkBox() {
		echo '<div class="controls">';
		echo '<label class="checkbox" for="'.CHtml::getIdByName( CHtml::resolveName( $this->model, $this->attribute ) ).'">';
		echo $this->form->checkBox( $this->model, $this->attribute, $this->htmlOptions ).PHP_EOL;
		echo $this->model->getAttributeLabel( $this->attribute );
		echo $this->getError().$this->getHint();
		echo '</label></div>';
	}

	/**
	 * Renders a list of checkboxes.
	 *
	 * @return string the rendered content
	 */
	protected function checkBoxList() {
		echo $this->getLabel();
		echo '<div class="controls">';
		echo $this->form->checkBoxList( $this->model, $this->attribute, $this->data, $this->htmlOptions );
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	/**
	 * Renders a list of inline checkboxes.
	 *
	 * @return string the rendered content
	 */
	protected function checkBoxListInline() {
		$this->htmlOptions['inline'] = true;
		$this->checkBoxList();
	}

	/**
	 * Renders a drop down list (select).
	 *
	 * @return string the rendered content
	 */
	protected function dropDownList() {
		echo $this->getLabel();
		echo '<div class="controls">';
		echo $this->form->dropDownList( $this->model, $this->attribute, $this->data, $this->htmlOptions );
		echo $this->getError().$this->getHint();
		echo '</div>';
	}
	protected function singleFileField() {
		$images = $this->model->getAttribute( $this->attribute );
		if(json_decode($images,true)===null){
			$images = array($images);
		}else{
			$images = json_decode($images,true);
		}
			
		$className = get_class( $this->model );
		echo $this->getLabel().'<div class="controls">';
		if($images){
			foreach ($images as $key => $image){
				$type = 'image';
				if ( strstr( $this->attribute, 'image' ) ) {
					$showimage = 'upload/'.$className.'/tm/'.$image;
					$fImage = 'upload/'.$className.'/full/'.$image;
				}else {
					$type = 'file';
					$showimage = 'upload/'.$className.'/'.$image;
				}
				if ( is_file( $showimage ) ) {
					$size = getimagesize( $showimage );
					if ( $type==='image' )
						echo '<div class="span3"><span class="label label-inverse"><i class="icon-caret-right"></i> '.($key+1).'</span> '.CHtml::link( CHtml::image( '/'.$showimage.'', '', array( 'width'=>$size['0'], 'height'=>$size['1'] ) ), '/'.$fImage, array( 'target'=>'_blank' ) ).'&nbsp;</div>';
					else {
						echo '<div class="span3">'.CHtml::link( '<i class="icon-search"></i> Показать ('.round( filesize( $showimage )/1024 ).' Кб)', '/'.$showimage, array( 'class'=>'btn', 'target'=>'_blank' ) ).'&nbsp;</div>';
					}


					echo '<div class="offset3">';
					echo CHtml::htmlButton( '<i class="icon-pencil"></i> Изменить', array( 'class'=>'btn btn-info', 'onclick'=>'js:$("#file-'.$this->attribute.'-'.$key.'").addClass("in");$(this).addClass("disabled")' ) ).'&nbsp;';
					echo CHtml::htmlButton( '<i class="icon-remove-circle"></i> Удалить', array( 'class'=>'btn btn-danger', 'onclick'=>'js:if($("#'.$this->attribute.'-delete-'.$key.'").val()==""){$(this).html("<i class=icon-ok-circle></i> Не удалять").addClass("btn-success"); $("#'.$this->attribute.'-delete-'.$key.'").val(1);}else{$(this).html("<i class=icon-remove-circle></i> Удалить").removeClass("btn-success");$("#'.$this->attribute.'-delete-'.$key.'").val("");}' ) ).'<br>';
					// echo $this->form->fileField( $this->model, $this->attribute, array( 'class'=>'input-file fade out', 'id'=>'file-'.$this->attribute ) );
					echo CHtml::fileField($className.'['.$this->attribute.']['.$key.']','', array( 'class'=>'input-file fade out', 'id'=>'file-'.$this->attribute.'-'.$key ) );
					echo CHtml::hiddenField( $this->attribute.'-src-'.$key, $image );
					echo CHtml::hiddenField( $this->attribute.'-delete-'.$key, '' );
					echo '</div>';
				}else {
					echo CHtml::fileField($className.'['.$this->attribute.']['.$key.']','', array( 'class'=>'input-file'));
					//echo $this->form->fileField( $this->model, $this->attribute, array( 'class'=>'input-file' ) );
				}
			}
		}else{
			$key = 0;
			echo CHtml::fileField($className.'['.$this->attribute.']['.$key.']','', array( 'class'=>'input-file', 'id'=>'file-'.$this->attribute.'-'.$key ) );
		}
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	/**
	 * Renders a file field.
	 *
	 * @return string the rendered content
	 */
	protected function fileField() {

		$images = $this->model->getAttribute( $this->attribute );
		if(json_decode($images,true)===null){
			$images = array($images);
		}else{
			$images = json_decode($images,true);
		}
			
		$className = get_class( $this->model );
		echo $this->getLabel().'<div class="controls">';
			foreach ($images as $key => $image) {
				echo '<div class="clearfix">';
			$type = 'image';
			if ( strstr( $this->attribute, 'image' ) ) {
				$showimage = 'upload/'.$className.'/sm/'.$image;
				$fImage = 'upload/'.$className.'/full/'.$image;
			}else {
				$type = 'file';
				$showimage = 'upload/'.$className.'/'.$image;
			}
			if ( is_file( $showimage ) ) {
				$size = getimagesize( $showimage );
				if ( $type==='image' )
					echo '<div class="span3"><span class="label label-inverse"><i class="icon-caret-right"></i> '.($key+1).'</span> '.CHtml::link( CHtml::image( '/'.$showimage.'', '', array( 'width'=>$size['0'], 'height'=>$size['1'] ) ), '/'.$fImage, array( 'target'=>'_blank' ) ).'&nbsp;</div>';
				else {
					echo '<div class="span3">'.CHtml::link( '<i class="icon-search"></i> Показать ('.round( filesize( $showimage )/1024/1024 ).' Мб)', '/'.$showimage, array( 'class'=>'btn', 'target'=>'_blank' ) ).'&nbsp;</div>';
				}


				echo '<div class="offset3">';
				echo CHtml::htmlButton( '<i class="icon-pencil"></i> Изменить', array( 'class'=>'btn btn-info', 'onclick'=>'js:$("#file-'.$this->attribute.'-'.$key.'").addClass("in");$(this).addClass("disabled")' ) ).'&nbsp;';
				echo CHtml::htmlButton( '<i class="icon-remove-circle"></i> Удалить', array( 'class'=>'btn btn-danger', 'onclick'=>'js:if($("#'.$this->attribute.'-delete-'.$key.'").val()==""){$(this).html("<i class=icon-ok-circle></i> Не удалять").addClass("btn-success"); $("#'.$this->attribute.'-delete-'.$key.'").val(1);}else{$(this).html("<i class=icon-remove-circle></i> Удалить").removeClass("btn-success");$("#'.$this->attribute.'-delete-'.$key.'").val("");}' ) ).'<br>';
				// echo $this->form->fileField( $this->model, $this->attribute, array( 'class'=>'input-file fade out', 'id'=>'file-'.$this->attribute ) );
				echo CHtml::fileField($className.'['.$this->attribute.']['.$key.']','', array( 'class'=>'input-file fade out', 'id'=>'file-'.$this->attribute.'-'.$key ) );
				echo CHtml::hiddenField( $this->attribute.'-src-'.$key, $image );
				echo CHtml::hiddenField( $this->attribute.'-delete-'.$key, '' );
				echo '</div>';
			}else {
				echo CHtml::fileField($className.'['.$this->attribute.']['.$key.']','', array( 'class'=>'input-file'));
				//echo $this->form->fileField( $this->model, $this->attribute, array( 'class'=>'input-file' ) );
			}
			echo $this->getError().$this->getHint();
			echo '</div><hr>';
		}
		echo '
		
		<button class="btn btn-mini btn-success addimage" type="button"><i class="icon-plus"></i> добавить ещё</button>		
		</div>
		';
		Yii::app()->clientScript->registerScript('adding-images',"
			$('.addimage').on('click',function(){
				var  p = $(this).parent();
				$(this).before('<div class=\"clearfix\"><span class=\"label label-inverse\"><i class=\"icon-caret-right\"></i> '+(p.children('div').length+1)+'</span> <input type=\"file\" name=\"".$className.'['.$this->attribute."]['+p.children('div').length+']\"/></div><hr>');
			});
");



	}
	// protected function fileField()
	// {
	//  echo $this->getLabel();
	//  echo '<div class="controls">';
	//  echo $this->form->fileField($this->model, $this->attribute, $this->htmlOptions);
	//  echo $this->getError().$this->getHint();
	//  echo '</div>';
	// }

	/**
	 * Renders a password field.
	 *
	 * @return string the rendered content
	 */
	protected function passwordField() {
		echo $this->getLabel();
		echo '<div class="controls">';
		echo $this->form->passwordField( $this->model, $this->attribute, $this->htmlOptions );
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	/**
	 * Renders a radio button.
	 *
	 * @return string the rendered content
	 */
	protected function radioButton() {
		echo '<div class="controls">';
		echo '<label class="radio" for="'.CHtml::getIdByName( CHtml::resolveName( $this->model, $this->attribute ) ).'">';
		echo $this->form->radioButton( $this->model, $this->attribute, $this->htmlOptions ).PHP_EOL;
		echo $this->model->getAttributeLabel( $this->attribute );
		echo $this->getError().$this->getHint();
		echo '</label></div>';
	}

	/**
	 * Renders a list of radio buttons.
	 *
	 * @return string the rendered content
	 */
	protected function radioButtonList() {
		echo $this->getLabel();
		echo '<div class="controls">';
		echo $this->form->radioButtonList( $this->model, $this->attribute, $this->data, $this->htmlOptions );
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	/**
	 * Renders a list of inline radio buttons.
	 *
	 * @return string the rendered content
	 */
	protected function radioButtonListInline() {
		$this->htmlOptions['inline'] = true;
		$this->radioButtonList();
	}

	/**
	 * Renders a textarea.
	 *
	 * @return string the rendered content
	 */
	protected function textArea() {
		echo $this->getLabel();
		echo '<div class="controls">';
		echo $this->form->textArea( $this->model, $this->attribute, $this->htmlOptions );
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	/**
	 * Renders a text field.
	 *
	 * @return string the rendered content
	 */
	protected function textField() {
		echo $this->getLabel();
		echo '<div class="controls">';
		echo $this->getPrepend();
		echo $this->form->textField( $this->model, $this->attribute, $this->htmlOptions );
		echo $this->getAppend();
		echo $this->getError().$this->getHint();
		echo '</div>';
	}



	protected function autoField() {
		$params=array();
		$rName = $this->relation[relation];
		$relations = $this->model->relations();
		$relation = $relations[$this->relation[relation]];

		$params=array(
			'model'=>$relation[1]
		);

		if ( $this->relation['title']!='' ) $params['title'] = $this->relation['title'];
		if ( $this->relation['add']!='' ) $params['add'] = $this->relation['add'];

		echo $this->getLabel().'<div class="controls"><div class="input-append">';
		//'auto-field-'.$rName
		CHtml::resolveNameId( $this->model, $this->attribute, $this->htmlOptions );
		$id = $this->htmlOptions['id'];
		unset( $this->htmlOptions['id'] );
		$this->widget(
			'zii.widgets.jui.CJuiAutoComplete',
			array(
				'id'       => $rName . '-field',
				'name'       => $this->relation['relation'] . '-field',
				'value'      => $this->model->$rName->title,
				'source'     => $this->controller->createUrl( 'json/index', $params ),
				'themeUrl'   => '/css/bootstrap',
				'theme'      => 'timesafe',
				'options'    => array(
					'minLength'=> '3',
					'select'   => 'js:function(e,ui){
                    $("#'.$id . '").val(ui.item.id)
                }'
				),
				'htmlOptions'=>$this->htmlOptions
			) );
		echo CHtml::activeHiddenField( $this->model, $this->attribute );
		echo '<span class="add-on"><a class="auto-list" data-source="'.$id.'" data-sourceTitle="'.$this->relation['relation'] . '-field" data-model="'.$params['model'].'" data-title="'.$params['title'].'" href="#listing" data-toggle="modal"><i class="icon-th-list"></i></a></span></div>';
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	protected function dateField() {
		echo $this->getLabel().'<div class="controls">';
		$at = $this->attribute;
		CHtml::resolveNameID( $this->model, $this->attribute, $this->htmlOptions );
		echo '
		<div class="input-append date" id="calendar-'.$this->htmlOptions['id'].'" data-date="'.date( "d-m-Y", $this->model->$at ).'" data-date-format="dd-mm-yyyy">
		'.CHtml::activeTextField( $this->model, $this->attribute, array( 'value'=>date( "d-m-Y", $this->model->$at ), 'class'=>'span2', 'maxlength'=>10 ) ).'<span class="add-on"><i class="icon-calendar"></i></span>
	</div>';
		Yii::app()->clientScript->registerScript( 'calendar-'.$this->htmlOptions['id'], '
			$("#calendar-'.$this->htmlOptions['id'].'").bdatepicker();' );
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	protected function dateTimeField() {
		echo $this->getLabel().'<div class="controls">';
		$at = $this->attribute;
		CHtml::resolveNameID( $this->model, $this->attribute, $this->htmlOptions );
		echo '
		<div class="input-append date" id="calendar-'.$this->htmlOptions['id'].'" data-date="'.date( "d-m-Y", $this->model->$at ).'" data-date-format="dd-mm-yyyy">
		'.CHtml::activeTextField( $this->model, $this->attribute, array( 'value'=>date( "d-m-Y", $this->model->$at ), 'class'=>'span2', 'maxlength'=>10 ) ).'<span class="add-on"><i class="icon-calendar"></i></span>
	</div>
<div class="input-append bootstrap-timepicker-component">
    <input type="text" name="_time['.$this->attribute.']" id="time-'.$this->htmlOptions['id'].'" class="timepicker-default input-small" value="'.date( "H:i", $this->model->$at ).'"><span class="add-on">
        <i class="icon-time"></i>
    </span>
</div>';
		Yii::app()->clientScript->registerScript( 'calendar-'.$this->htmlOptions['id'], '
			$("#calendar-'.$this->htmlOptions['id'].'").bdatepicker();
			$("#time-'.$this->htmlOptions['id'].'").timepicker();' );
		echo $this->getError().$this->getHint();
		echo '</div>';
	}

	/**
	 * Renders a CAPTCHA.
	 *
	 * @return string the rendered content
	 */
	protected function captcha() {
		echo $this->getLabel();
		echo '<div class="controls"><div class="captcha">';
		echo '<div class="widget">'.$this->widget( 'CCaptcha', $this->data, true ).'</div>';
		echo $this->form->textField( $this->model, $this->attribute, $this->htmlOptions );
		echo $this->getError().$this->getHint();
		echo '</div></div>';
	}

	/**
	 * Renders an uneditable field.
	 *
	 * @return string the rendered content
	 */
	protected function uneditableField() {
		echo $this->getLabel();
		echo '<div class="controls">';
		echo CHtml::tag( 'span', $this->htmlOptions, $this->model->{$this->attribute} );
		echo $this->getError().$this->getHint();
		echo '</div>';
	}
}
