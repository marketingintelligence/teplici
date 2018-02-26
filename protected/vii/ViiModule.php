<?php
/**
 * ViiModule class file based in Gii Module.
 *
 * @author Nikolay Noskov <nvnoskov@gmail.com> 
 */

Yii::import('application.vii.CCodeGenerator');
Yii::import('application.vii.CCodeModel');
Yii::import('application.vii.CCodeFile');
Yii::import('application.vii.CCodeForm');
//Yii::import('sysTem.vii.CCodeForm');

class ViiModule extends CWebModule
{
	/**
	 * @var string the password that can be used to access GiiModule.
	 * If this property is set false, then GiiModule can be accessed without password
	 * (DO NOT DO THIS UNLESS YOU KNOW THE CONSEQUENCE!!!)
	 */
	public $password;
	/**
	 * @var array the IP filters that specify which IP addresses are allowed to access GiiModule.
	 * Each array element represents a single filter. A filter can be either an IP address
	 * or an address with wildcard (e.g. 192.168.0.*) to represent a network segment.
	 * If you want to allow all IPs to access gii, you may set this property to be false
	 * (DO NOT DO THIS UNLESS YOU KNOW THE CONSEQUENCE!!!)
	 * The default value is array('127.0.0.1', '::1'), which means GiiModule can only be accessed
	 * on the localhost.
	 */
	public $ipFilters=array('127.0.0.1','::1');
	/**
	 * @var array a list of path aliases that refer to the directories containing code generators.
	 * The directory referred by a single path alias may contain multiple code generators, each stored
	 * under a sub-directory whose name is the generator name.
	 * Defaults to array('application.gii').
	 */
	public $generatorPaths=array('application.gii');
	/**
	 * @var integer the permission to be set for newly generated code files.
	 * This value will be used by PHP chmod function.
	 * Defaults to 0666, meaning the file is read-writable by all users.
	 */
	public $newFileMode=0666;
	/**
	 * @var integer the permission to be set for newly generated directories.
	 * This value will be used by PHP chmod function.
	 * Defaults to 0777, meaning the directory can be read, written and executed by all users.
	 */
	public $newDirMode=0777;

	private $_assetsUrl;

	/**
	 * Initializes the gii module.
	 */
	public function init()
	{
		parent::init();
		Yii::app()->setComponents(array(
			'errorHandler'=>array(
				'class'=>'CErrorHandler',
				'errorAction'=>$this->getId().'/default/error',
			),
			'user'=>array(
				'class'=>'CWebUser',
				'stateKeyPrefix'=>'gii',
				'loginUrl'=>Yii::app()->createUrl($this->getId().'/default/login'),
			),
		), false);
		Yii::app()->setComponents(array(            
            'bootstrap' => array(
                'class' => 'ext.bootstrap.components.Bootstrap',
            )
        ));        
    Yii::app()->bootstrap->init();

		$this->generatorPaths[]='vii.generators';
		$this->controllerMap=$this->findGenerators();
	}

	/**
	 * @return string the base URL that contains all published asset files of vii.
	 */
	public function getAssetsUrl()
	{
		if($this->_assetsUrl===null)
			$this->_assetsUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('vii.assets'));
		return $this->_assetsUrl;
	}

	/**
	 * @param string $value the base URL that contains all published asset files of vii.
	 */
	public function setAssetsUrl($value)
	{
		$this->_assetsUrl=$value;
	}

	/**
	 * Performs access check to vii.
	 * This method will check to see if user IP and password are correct if they attempt
	 * to access actions other than "default/login" and "default/error".
	 * @param CController $controller the controller to be accessed.
	 * @param CAction $action the action to be accessed.
	 * @return boolean whether the action should be executed.
	 */
	public function beforeControllerAction($controller, $action)
	{

		if(parent::beforeControllerAction($controller, $action))
		{
			$route=$controller->id.'/'.$action->id;
			if(!$this->allowIp(Yii::app()->request->userHostAddress) && $route!=='default/error')
				throw new CHttpException(403,"Нет доступа к генераторам кода.");

			$publicPages=array(
				'default/login',
				'default/error',
			);
			if($this->password!==false && Yii::app()->user->isGuest && !in_array($route,$publicPages))
				Yii::app()->user->loginRequired();
			else
				return true;
		}
		return false;
	}

	/**
	 * Checks to see if the user IP is allowed by {@link ipFilters}.
	 * @param string $ip the user IP
	 * @return boolean whether the user IP is allowed by {@link ipFilters}.
	 */
	protected function allowIp($ip)
	{
		if(empty($this->ipFilters))
			return true;
		foreach($this->ipFilters as $filter)
		{
			if($filter==='*' || $filter===$ip || (($pos=strpos($filter,'*'))!==false && !strncmp($ip,$filter,$pos)))
				return true;
		}
		return false;
	}

	/**
	 * Finds all available code generators and their code templates.
	 * @return array
	 */
	protected function findGenerators()
	{
		$generators=array();
		$n=count($this->generatorPaths);
		for($i=$n-1;$i>=0;--$i)
		{
			$alias=$this->generatorPaths[$i];
			$path=Yii::getPathOfAlias($alias);
			if($path===false || !is_dir($path))
				continue;

			$names=scandir($path);
			foreach($names as $name)
			{
				if($name[0]!=='.' && is_dir($path.'/'.$name))
				{
					$className=ucfirst($name).'Generator';
					if(is_file("$path/$name/$className.php"))
					{
						$generators[$name]=array(
							'class'=>"$alias.$name.$className",
						);
					}

					if(isset($generators[$name]) && is_dir("$path/$name/templates"))
					{
						$templatePath="$path/$name/templates";
						$dirs=scandir($templatePath);
						foreach($dirs as $dir)
						{
							if($dir[0]!=='.' && is_dir($templatePath.'/'.$dir))
								$generators[$name]['templates'][$dir]=strtr($templatePath.'/'.$dir,array('/'=>DIRECTORY_SEPARATOR,'\\'=>DIRECTORY_SEPARATOR));
						}
					}
				}
			}
		}
		return $generators;
	}
}