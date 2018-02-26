<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    public $layout = 'main';
    public $print = false;
    public $DESCRIPTION = '';
    public $KEYWORDS = '';
    public $TEMP = array();
    public $langs = array('ru', 'kz', 'eng');
    public $menu = array();
    public $lang;
    public $breadcrumbs = array();    
    public $_pageTitle = null;
    public $filter = array();
    public $sidebar = array('news');        
    public $city;

    function init()
    {

        parent::init();
        $app = Yii::app();
        $this->lang = 'ru';
        $app->language = 'ru';
        $lang = Yii::app()->request->getParam('lang');
		preg_match('/^([^.]+)\.alinex\.kz/i', $_SERVER['HTTP_HOST'], $matches); 
        /*if ($lang != 'ru' && $lang != 'kz') {
            unset($lang);
        }*/
		if(isset($matches[1]) and $matches[1] != 'www') {
			if ($matches[1] == 'kaz') {
				$app->session['language'] = 'kz'; 
			} else {
				$app->session['language'] = 'eng'; 
			}
		} else { 
			$app->session['language'] = 'ru';
		}
		if (!isset($app->session['language'])) { $app->session['language'] = 'ru'; }
        /*if (isset($lang)) {
            $app->language = $lang;
            $app->session['language'] = $app->language;
        }*/
        if (isset($app->session['language'])) {
            $app->language = $app->session['language'];
        }
        $this->lang = $app->language;
        // SID
/*        $SID = null;
        $SID = (isset(Yii::app()->request->cookies['vesna_sid'])) ? Yii::app()->request->cookies['vesna_sid']->value
                : null;
        if ($SID === null) {
            $SID = md5('VSID=' . $_SERVER['HTTP_USER_AGENT'] . '|' . $_SERVER['REMOTE_ADDR']);
            $cookie = new CHttpCookie('vesna_sid', $SID);
            $cookie->expire = time() + 60 * 60 * 24 * 180;
            Yii::app()->request->cookies['vesna_sid'] = $cookie;
        }*/
//        $app->clientScript->registerScript('vsid', "var sid = '{$SID}',remove_addr='{$_SERVER['REMOTE_ADDR']}',user_agent='{$_SERVER['HTTP_USER_AGENT']}';", 0);
    }

    protected function beforeAction($action) {
        foreach ($_GET as $key=>$val) {
            if (is_string($val)) {
                $_GET[$key]=addcslashes(str_replace("'", "''", $val), "\000\n\r\\\032");
            }
        }
        foreach ($_POST as $key=>$val) {
            if (is_string($val)) {
                $_POST[$key]=addcslashes(str_replace("'", "''", $val), "\000\n\r\\\032");
            }
        }

   /*     $cookie_val = (isset(Yii::app()->request->cookies['city']->value)) ?
            json_decode(Yii::app()->request->cookies['city']->value,true) : '';
        if (!$cookie_val){
            $SxGeo = new SxGeo('SxGeoCity.dat');
            $ip = Yii::app()->request->userHostAddress;
            $city = $SxGeo->get('178.88.0.0');
            $cookie_val = array(
                "city"=>$city['city']
            );
            $cookie = new CHttpCookie('city', json_encode($cookie_val));
            $cookie->expire = time()+100; 
            Yii::app()->request->cookies['city'] = $cookie;
        }
        $this->city = $cookie_val['city'];*/



        if (Yii::app()->request->getParam('print')) {
            $this->layout = 'print';
            $this->print = true;
        }
        //$this->DESCRIPTION = SysModule::model()->findByAttributes(array('name' => $this->lang . '-description'))->value;
        //$this->KEYWORDS = SysSetting::model()->findByAttributes(array('name' => $this->lang . '-keywords'))->value;
        Yii::app()->clientScript->registerCoreScript('jquery');
        //Yii::app()->clientScript->registerScriptFile('/js/jquery.the-modal.js');

        if (parent::beforeAction($action)) {
            return true;
        }
        else
            return false;
    }

    public function getPageTitle(){
        if($this->_pageTitle) return $this->_pageTitle;
        else{
            return SysSetting::model()->findByAttributes(array('name' => $this->lang . '-metatitle'))->value;
        }
    }
    public function setPageTitle($title){
        $this->_pageTitle = $title;
    }

    public function beforeRender()
    {
        if (!empty($this->DESCRIPTION)) {
            Yii::app()->clientScript->registerMetaTag($this->DESCRIPTION, 'description');
        }
        if (!empty($this->KEYWORDS)) {
            Yii::app()->clientScript->registerMetaTag($this->KEYWORDS, 'keywords');
        }
        return true;
    }

    public function registerMeta($model = null, $title = '')
    {
        if ($model !== null) {
            $name = get_class($model);
            $id = $model->id;
            $attributes = array(
                'parent_id' => $model->id,
                'module' => $name,
                'lang' => Yii::app()->language
            );

            $meta = Meta::model()->findByAttributes($attributes);
			if ($_SESSION['language'] == 'kz') {
				$this->pageTitle = $model->title_kaz.$title;
			} else {
				if ($meta) {
					if ($meta->title != "") {
						$this->pageTitle = $meta->title;
					} else {
						$this->pageTitle = $model->title.$title;
					}
					$this->DESCRIPTION = $meta->description;
					$this->KEYWORDS = $meta->keywords;
				} else {
					$this->pageTitle = $model->title.$title;
				}
			}
        }
    }


    private $_pageCaption = null;
    private $_pageDescription = null;

    /**
     * @return string the page heading (or caption). Defaults to the controller name and the action name,
     * without the application name.
     */
    public function getPageCaption()
    {
        return '123';
        if ($this->_pageCaption !== null)
            return $this->_pageCaption;
        else
        {
            $name = ucfirst(basename($this->getId()));
            if ($this->getAction() !== null && strcasecmp($this->getAction()->getId(), $this->defaultAction))
                return $this->_pageCaption = $name . ' ' . ucfirst($this->getAction()->getId());
            else
                return $this->_pageCaption = $name;
        }
    }

    /**
     * @param string $value the page heading (or caption)
     */
    public function setPageCaption($value)
    {
        $this->_pageCaption = $value;
    }

    /**
     * @return string the page description (or subtitle). Defaults to the page title + 'page' suffix.
     */
    public function getPageDescription()
    {
        if ($this->_pageDescription !== null)
            return $this->_pageDescription;
        else
        {
            return Yii::app()->name . ' ' . $this->getPageCaption() . ' page';
        }
    }

    /**
     * @param string $value the page description (or subtitle)
     */
    public function setPageDescription($value)
    {
        $this->_pageDescription = $value;
    }

   function getScontent($text, $num) {
      $content = strip_tags($text);
      $content = str_replace("&nbsp;", " ", $content);
      $content = trim ($content);
      if (mb_strlen($content, "UTF-8") > $num) {
                  $content = mb_substr($content, 0, $num, "UTF-8");
                  $content_new = '';
                  $content_arr = explode(" ", $content);
                  if (is_array($content_arr)) {
                     foreach ($content_arr as $key=> $val) {
                        if ($key < sizeof($content_arr) - 1) {$content_new .= $val.' ';}
                     }
                  }
                  if ($content_new) {$content = trim($content_new).'...';}
      }
      return $content;
   }

   public function padej($all) {
          if ((($all-1)%10 == 0) && ((($all-11)%100 != 0))) {
                           return 1;
                        }
                        elseif ((($all-2)%10 == 0 || ($all-3)%10 == 0 || ($all-4)%10 == 0) && ((($all-12)%100 != 0)) && ((($all-13)%100 != 0)) && ((($all-14)%100 != 0))) {
                           return 2;
                        }
                        else {
                           return 3;
                        }
      }

    public function saveFile( $model, $name = null, $type = null ) {


        $modelClass = get_class( $model );

        $count = count( $_FILES[$modelClass]['name'][$name] );

        $ActiveR = CActiveRecord::model( $modelClass );
        $options = $ActiveR->options();
        $options = $options['images'];
        $images = json_decode( $model->$name, true );
        if($images===null) $images = array();        
        for ( $i=0; $i<$count; $i++ ) {

            $tmp = $_POST[$name . '-src-'.$i];
            if ( $_POST[$name . '-delete-'.$i]=='1' ) {
                if ( is_array( $options ) ) {
                    foreach ( $options as $type => $size ) {
                        $path = '/' . $type;
                        if ( is_file( 'upload/' . $modelClass . $path . '/' . $tmp ) ) unlink( 'upload/' . $modelClass . $path . '/' . $tmp );
                    }
                }else {
                    if ( is_file( 'upload/' . $modelClass . '/' . $tmp ) ) unlink( 'upload/' . $modelClass . '/' . $tmp );
                }
                unset( $images[$i] );

            }else if ( $name !== null ) {
                if ( is_file( $name ) ) {
                    $path = pathinfo( $name );
                    $size = getimagesize( $name );
                    if ( $type == null ) {
                        switch ( $size[2] ) {
                        case 1:
                            $type = 'image/gif';
                            break;
                        case 2:
                            $type = 'image/jpeg';
                            break;
                        case 3:
                            $type = 'image/png';
                            break;
                        default:
                            $type = 'image/jpeg';
                        }
                    }
                    $UPimage = new CUploadedFile( $path['basename'], $name, $type, filesize( $name ), 0 );
                    $field = 'image';
                } else {
                    $field = $name;
                    $UPimage = CUploadedFile::getInstanceByName($modelClass.'['.$name.']['.$i.']');            
                    // $UPimage = CUploadedFile::getInstance( $model, $name );
                }

                if ( $UPimage !== NULL ) {

                    $path = pathinfo( $UPimage->name );
                    if ( $model->id )
                        $id = $model->id;
                    else
                        $id = 'temp'.rand( 1000, 99999 );
                    $id .='-'.$i;
                    $fileName = $modelClass . '-' .$field .'-' . $id .  '.' . strtolower( $path["extension"] );

                    if ( strstr( $UPimage->type, 'image' ) ) {
                        Yii::import( 'application.extensions.image.Image' );
                        if ( !is_file( $name ) ) {
                            $temp = 'upload/tmp_' . $modelClass . '_' . $fileName;
                            $UPimage->saveAs( $temp ); // save the uploaded file
                            $imageOrig = new Image( $temp );
                        } else {
                            $temp = $name;
                            $imageOrig = new Image( $name );
                        }

                        $w = $imageOrig->width;
                        $h = $imageOrig->height;

                        if ( is_array( $options ) ) {
                            foreach ( $options as $type => $size ) {
                                $image = $imageOrig;
                                $path = '/' . $type;

                                if ( !is_dir( 'upload/' . $modelClass . $path ) ) {
                                    mkdir( 'upload/' . $modelClass . $path, 0777, true );
                                }
                                $rt = $w/$h < $size['width']/$size['height'];
                                if ( $size['type'] === 'crop' ) {

                                    if ( $w > $size['width'] || $h > $size['height'] ) {

                                        if ( $w>$h ) {
                                            if ( $rt )
                                                $image->resize( $size['width'], $size['height'], 4 );
                                            else
                                                $image->resize( $size['width'], $size['height'], 3 );
                                            $image->crop( $size['width'], $size['height'] );
                                        } else {
                                            if ( !$rt )
                                                $image->resize( $size['width'], $size['height'], 4 );
                                            else
                                                $image->resize( $size['width'], $size['height'], 3 );
                                            $image->crop( $size['width'], $size['height'], 0 );
                                        }
                                    }else {
                                        $image->resize( $size['width'], $size['height'] );
                                    }
                                } else
                                    if ( $w > $size['width'] || $h > $size['height'] ) {
                                        $image->resize( $size['width'], $size['height'] );
                                    }

                                // echo 'upload/' . $modelClass . $path . '/' . $fileName;
                                $image->save( 'upload/' . $modelClass . $path . '/' . $fileName );

                            }
                        } else {
                            $imageOrig->save( 'upload/' . $modelClass . '/' . $fileName ); // save the uploaded file
                        }
                        unlink( $temp );
                        unset ( $image );
                        unset ( $imageOrig );
                    } else {
                        $UPimage->saveAs( 'upload/' . $modelClass . '/' . $fileName ); // save the uploaded file
                    }

                    // return $fileName;
                    $images[$i] = $fileName;
                } elseif ( $_POST[$name . '-src-'.$i] != '' ) {
                    $images[$i] = $_POST[$name . '-src-'.$i];
                    // return $_POST[$name . '-src-'.$i];
                }
            }
        }

        return json_encode(array_values($images));
    }      

}
