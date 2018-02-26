<?php
/**
 * ETrashBinBehavior class file.
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @link http://code.google.com/p/yiiext/
 * @license http://www.opensource.org/licenses/mit-license.php
 */

/**
 * ETrashBinBehavior allows you to remove the model in the trash bin and restore them when need.
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @version 0.2
 * @package yiiext.behaviors.model.trashBin
 * @since 1.1.4
 */
class ETrashBinBehavior extends CActiveRecordBehavior
{
	/**
	 * @var string The name of the table where data stored.
	 * Required to set on init behavior.
	 * No defaults. Example: "isRemoved".
	 */
	public $trashFlagField;
	/**
	 * @var mixed The value to set for removed model.
	 * Default is 1.
	 */
	public $removedFlag=1;
	/**
	 * @var mixed The value to set for restored model.
	 * Default is 0.
	 */
	public $restoredFlag=0;
	/**
	 * @var bool If except removed model in find results.
	 * Default is false.
	 */
	public $findRemoved=false;
	/**
	 * @param bool The flag to disable filter removed models in the next query.
	 */
	protected $_withRemoved=false;

	public function attach($owner)
	{
		// Check required var trashFlagField
		if(!is_string($this->trashFlagField) || empty($this->trashFlagField))
		{
			throw new CException(Yii::t('yiiext','Required var "{class}.{property}" not set.',
				array('{class}'=>get_class($this),'{property}'=>'trashFlagField')));
		}

		parent::attach($owner);
	}
	/**
	 * Set value for trash field.
	 *
	 * @param mixed Value for trash field.   
	 * @return CActiveRecord
	 */
	public function setTrashFlag($value)
	{
		$t = str_replace('t.', '', $this->trashFlagField);
		$owner=$this->getOwner();
		$owner->{$t}=$value;
		
		return $owner;
	}
	/**
	 * Remove model in trash bin.
	 *
	 * @return CActiveRecord
	 */
	public function remove()
	{
		$t = str_replace('t.', '', $this->trashFlagField);
		return $this->setTrashFlag($this->removedFlag)->save(false,array($t));
	}
	/**
	 * Restore removed model from trash bin.
	 *
	 * @return CActiveRecord
	 */
	public function restore()
	{
		$t = str_replace('t.', '', $this->trashFlagField);
		return $this->setTrashFlag($this->restoredFlag)->save(false,array($t));
	}
	/**
	 * Check if model is removed in trash bin.
	 *
	 * @return bool
	 */
	public function getIsRemoved()
	{
		$t = str_replace('t.', '', $this->trashFlagField);
		return $this->getOwner()->{$t}==$this->removedFlag;
	}
	/**
	 * Disable excepting removed models for next search.
	 *
	 * @return CActiveRecord
	 */
	public function withRemoved()
	{
		$this->_withRemoved=true;
		return $this->getOwner();
	}
	/**
	 * Add condition to query for filter removed models.
	 *
	 * @return CActiveRecord
	 * @since 1.1.4
	 */
	public function filterRemoved()
	{
		$owner=$this->getOwner();

		$criteria=$owner->getDbCriteria();
		
		$criteria->addCondition($this->trashFlagField.'!='.CDbCriteria::PARAM_PREFIX.CDbCriteria::$paramCount);
		$criteria->params[CDbCriteria::PARAM_PREFIX.CDbCriteria::$paramCount++]=$this->removedFlag;		
		return $owner;
	}
	/**
	 * Add condition to query for find removed models.
	 *
	 * @return CActiveRecord
	 * @since 1.1.4
	 */
	public function getRemoved()
	{
		$this->findRemoved = true;
		$owner=$this->getOwner();
		$criteria=$owner->getDbCriteria();
		
		$criteria->addCondition($this->trashFlagField.'='.CDbCriteria::PARAM_PREFIX.CDbCriteria::$paramCount);
		$criteria->params[CDbCriteria::PARAM_PREFIX.CDbCriteria::$paramCount++]=$this->removedFlag;		
		return $owner;
	}
	/**
	 * Count of non-deleted records
	 *
	 * @return CActiveRecord
	 * @since 1.1.4
	 */
	public function nonTrashCount()
	{
		$owner=$this->getOwner();
		$criteria=$owner->getDbCriteria();		
		$criteria->addCondition($this->trashFlagField.'!='.CDbCriteria::PARAM_PREFIX.CDbCriteria::$paramCount);
		$criteria->params[CDbCriteria::PARAM_PREFIX.CDbCriteria::$paramCount++]=$this->removedFlag;		

		return $owner->count();
	}
	/**
	 * Count of non-deleted records
	 *
	 * @return CActiveRecord
	 * @since 1.1.4
	 */
	public function trashCount()
	{
		return $this->getRemoved()->count();
	}
	/**
	 * Add condition before find, for except removed models.
	 *
	 * @param CEvent
	 */
	public function beforeFind(CEvent $event)
	{
		if($this->getEnabled() && !$this->findRemoved && !$this->_withRemoved)
			$this->filterRemoved();

		$this->_withRemoved=false;		
		parent::beforeFind($event);
	}
}
