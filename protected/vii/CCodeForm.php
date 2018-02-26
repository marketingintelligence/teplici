<?php
/**
 * CCodeForm class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CCodeForm represents the form for collecting code generation parameters.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: CCodeForm.php 2799 2011-01-01 19:31:13Z qiang.xue $
 * @package system.gii
 * @since 1.1.2
 */
class CCodeForm extends CActiveForm
{
	/**
	 * @var CCodeModel the code model associated with the form
	 */
	public $model;

	/**
	 * Initializes the widget.
	 * This renders the form open tag.
	 */
	public $htmlOptions = array('class'=>'form form-horizontal');
	public function init()
	{
		echo <<<EOD
<div class="form gii">
	<p class="note">
		<span class="required">*</span> Обязательные поля.<br>
		Нажми на <span class="sticky">подсвеченные поля</span> для редактирования.
	</p>
EOD;
		parent::init();
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		$templates=array();
		foreach($this->model->getTemplates() as $i=>$template){
			$path = strstr($template,'vii/');			
			$templates[$i]=ucfirst(basename($template)).' ('.$path.')';
		}

		$this->renderFile(Yii::getPathOfAlias('vii.views.common.generator').'.php',array(
			'model'=>$this->model,
			'templates'=>$templates,
		));

		parent::run();

		echo "</div>";
	}
}