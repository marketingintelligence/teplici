<?php
/**
 * BootInput class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets.input
 */

/**
 * Bootstrap input widget.
 * Used for rendering inputs according to Bootstrap standards.
 */
abstract class BootInput extends CInputWidget
{
	// The different input types.
	const TYPE_CHECKBOX = 'checkbox';
	const TYPE_CHECKBOXLIST = 'checkboxlist';
	const TYPE_CHECKBOXLIST_INLINE = 'checkboxlist_inline';
	const TYPE_SINGLEFILE = 'singlefilefield';
	const TYPE_DROPDOWN = 'dropdownlist';
	const TYPE_FILE = 'filefield';
	const TYPE_PASSWORD = 'password';
	const TYPE_RADIO = 'radiobutton';
	const TYPE_RADIOLIST = 'radiobuttonlist';
	const TYPE_RADIOLIST_INLINE = 'radiobuttonlist_inline';
	const TYPE_TEXTAREA = 'textarea';
	const TYPE_TEXT = 'textfield';
	const TYPE_AUTOTEXT = 'autofield';
	const TYPE_DATETEXT = 'datefield';
	const TYPE_DATETIMETEXT = 'datetimefield';
	const TYPE_CAPTCHA = 'captcha';
	const TYPE_UNEDITABLE = 'uneditable';

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
	/**
	 * @var array the data for list inputs.
	 */
	public $data = array();


	public $language=false;
	public $relation=false;

	/**
	 * Initializes the widget.
	 * @throws CException if the widget could not be initialized.
	 */
	public function init()
	{
		if (!isset($this->form))
			throw new CException(__CLASS__.': Failed to initialize widget! Form is not set.');

		if (!isset($this->model))
			throw new CException(__CLASS__.': Failed to initialize widget! Model is not set.');

		if (!isset($this->type))
			throw new CException(__CLASS__.': Failed to initialize widget! Input type is not set.');

		if ($this->type === self::TYPE_UNEDITABLE)
		{
			$cssClass = 'uneditable-input';
			if (isset($this->htmlOptions['class']))
				$this->htmlOptions['class'] .= ' '.$cssClass;
			else
				$this->htmlOptions['class'] = $cssClass;
		}
	}

	/**
	 * Runs the widget.
	 * @throws CException if the widget type is invalid.
	 */
	public function run()
	{
		switch ($this->type)
		{
			case self::TYPE_CHECKBOX:
				$this->checkBox();
				break;

			case self::TYPE_CHECKBOXLIST:
				$this->checkBoxList();
				break;

			case self::TYPE_CHECKBOXLIST_INLINE:
				$this->checkBoxListInline();
				break;

			case self::TYPE_DROPDOWN:
				$this->dropDownList();
				break;

			case self::TYPE_FILE:
				$this->fileField();
				break;

			case self::TYPE_SINGLEFILE:
				$this->singleFileField();
				break;

			case self::TYPE_PASSWORD:
				$this->passwordField();
				break;

			case self::TYPE_RADIO:
				$this->radioButton();
				break;

			case self::TYPE_RADIOLIST:
				$this->radioButtonList();
				break;

			case self::TYPE_RADIOLIST_INLINE:
				$this->radioButtonListInline();
				break;

			case self::TYPE_TEXTAREA:
				$this->textArea();
				break;

			case self::TYPE_TEXT:
				$this->textField();
				break;

			case self::TYPE_AUTOTEXT:
				$this->autoField();
				break;
			case self::TYPE_DATETEXT:
				$this->dateField();
				break;
			case self::TYPE_DATETIMETEXT:
				$this->dateTimeField();
				break;

			case self::TYPE_CAPTCHA:
				$this->captcha();
				break;

			case self::TYPE_UNEDITABLE:
				$this->uneditableField();
				break;

			default:
				throw new CException(__CLASS__.': Failed to run widget! Type is invalid.');
		}
	}

	/**
	 * Returns the label for the input.
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the label
	 */
	protected function getLabel($htmlOptions = array())
	{
		if ($this->label !== false && !in_array($this->type, array('checkbox', 'radio')) && $this->hasModel())
			return $this->form->labelEx($this->model, $this->attribute, $htmlOptions);
		else if ($this->label !== null)
			return $this->label;
		else
			return '';
	}

	protected function getPrepend($htmlOptions = array())
	{
		if ($this->hasAddOn())
		{
			$cssClass = 'add-on';
			if (isset($htmlOptions['class']))
				$htmlOptions['class'] .= ' '.$cssClass;
			else
				$htmlOptions['class'] = $cssClass;

			$cssClass = $this->getInputContainerCssClass();
			ob_start();
			echo '<div class="'.$cssClass.'">';
			if (isset($this->htmlOptions['prepend']))
				echo CHtml::tag('span', $htmlOptions, $this->htmlOptions['prepend']);
			return ob_get_clean();
		}
		else
			return '';
	}

	protected function getAppend($htmlOptions = array())
	{
		if ($this->hasAddOn())
		{
			$cssClass = 'add-on';
			if (isset($htmlOptions['class']))
				$htmlOptions['class'] .= ' '.$cssClass;
			else
				$htmlOptions['class'] = $cssClass;

			ob_start();
			if (isset($this->htmlOptions['append']))
				echo CHtml::tag('span', $htmlOptions, $this->htmlOptions['append']);
			echo '</div>';
			return ob_get_clean();
		}
		else
			return '';
	}

	protected function getInputContainerCssClass()
	{
		if (isset($this->htmlOptions['prepend']))
			return 'input-prepend';
		else if (isset($this->htmlOptions['append']))
			return 'input-append';
		else
			return '';
	}

	protected function hasAddOn()
	{
		return isset($this->htmlOptions['prepend']) || isset($this->htmlOptions['append']);
	}

	/**
	 * Returns the error text for the input.
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the error text
	 */
	protected function getError($htmlOptions = array())
	{
		return $this->form->error($this->model, $this->attribute, $htmlOptions);
	}

	/**
	 * Returns the hint text for the input.
	 * @return string the hint text
	 */
	protected function getHint()
	{
		if (isset($this->htmlOptions['hint']))
		{
			$hint = $this->htmlOptions['hint'];
			unset($this->htmlOptions['hint']);
			return '<p class="help-block">'.$hint.'</p>';
		}
		else
			return '';
	}

	/**
	 * Returns the container CSS class for the input.
	 * @return string the CSS class.
	 */
	protected function getContainerCssClass()
	{
		if ($this->model->hasErrors($this->attribute))
			return CHtml::$errorCss;
		else
			return '';
	}

	/**
	 * Renders a checkbox.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function checkBox();

	/**
	 * Renders a list of checkboxes.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function checkBoxList();

	/**
	 * Renders a list of inline checkboxes.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function checkBoxListInline();

	/**
	 * Renders a drop down list (select).
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function dropDownList();

	/**
	 * Renders a file field.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function fileField();

	/**
	 * Renders a password field.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function passwordField();

	/**
	 * Renders a radio button.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function radioButton();

	/**
	 * Renders a list of radio buttons.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function radioButtonList();

	/**
	 * Renders a list of inline radio buttons.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function radioButtonListInline();

	/**
	 * Renders a textarea.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function textArea();

	/**
	 * Renders a text field.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function textField();

	/**
	 * Renders a text field.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function autoField();

	/**
	 * Renders a text field.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function dateField();
	/**
	 * Renders a date field.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function dateTimeField();

	/**
	 * Renders a CAPTCHA.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function captcha();

	/**
	 * Renders an uneditable field.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function uneditableField();
}
