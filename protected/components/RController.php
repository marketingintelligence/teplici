<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class RController extends Controller
{
    /**
     *
     *
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $criteria = array();
    public $layout = 'bootstrap';
    /**
     *
     *
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    public $filterOption = array();
    public $filter = array();
    public $tree = false;
    /**
     *
     *
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

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
                    $fileName = $modelClass . '-' .$field .'-' . time() .  '.' . strtolower( $path["extension"] );

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

    private function imageResize() {

    }

    public function deleteFile( $model, $name = null ) {
        $modelClass = get_class( $model );
        if ( is_file( 'upload/' . $modelClass . '/' . $model->$name ) )
            unlink( 'upload/' . $modelClass . '/' . $model->$name );
        if ( is_file( 'upload/' . $modelClass . '/sm/' . $model->$name ) )
            unlink( 'upload/' . $modelClass . '/sm/' . $model->$name );
    }

    public function beforeAction( $action ) {

        $_filter = Yii::app()->request->getQuery( '_filter' );


        if ( parent::beforeAction( $action ) )
            return true;
        else
            return false;
    }

    public function saveMeta( $model, $metaPOST ) {
        $name = get_class( $model );
        $id = $model->id;
        $attributes = array(
            'parent_id' => $model->id,
            'module' => $name,
            'lang' => Yii::app()->language
        );
        $meta = Meta::model()->findByAttributes( $attributes );
        if ( !$meta ) {
            $meta = new Meta();
            $meta->attributes = $attributes;
        }
        $meta->title = $metaPOST['title'];
        $meta->keywords = $metaPOST['keywords'];
        $meta->description = $metaPOST['description'];
        return $meta->save();
    }

    public function filterRights( $filterChain ) {


        $filter = new RightsFilter;
        $filter->allowedActions = $this->allowedActions();

        $filter->filter( $filterChain );

    }

    /**
     *
     *
     * @return string the actions that are always allowed separated by commas.
     */
    public function allowedActions() {
        return '';
    }

    /**
     * Denies the access of the user.
     *
     * @param string  $message the message to display to the user.
     * This method may be invoked when access check fails.
     * @throws CHttpException when called unless login is required.
     */
    public function accessDenied( $message=null ) {
        if ( $message===null )
            $message = Rights::t( 'core', 'You are not authorized to perform this action.' );

        $user = Yii::app()->getUser();
        if ( $user->isGuest===true )
            $user->loginRequired();
        else
            throw new CHttpException( 403, $message );
    }

    public function filters() {
        return array(
            'rights',
        );
    }

    public function createUrl( $route, $params=array(), $ampersand='&' ) {
        if ( $route==='' )
            $route=$this->getId().'/'.$this->getAction()->getId();
        else if ( strpos( $route, '/' )===false )
                $route=$this->getId().'/'.$route;
            if ( $route[0]!=='/' && ( $module=$this->getModule() )!==null )
                $route=$module->getId().'/'.$route;

            foreach ( $params as $key => $param ) {
                if ( $param=='' ) unset( $params[$key] );
                if ( is_array( $param ) ) {
                    foreach ( $param as $k=>$v )
                        if ( $v=='' ) unset( $params[$key][$k] );
                }
            }
        return Yii::app()->createUrl( trim( $route, '/' ), $params, $ampersand );
    }


}
