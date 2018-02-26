<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass."\n"; ?> {
    public $layout = 'column2';

    public function getTree($type = 'div', $cache = true,$param=array()) {
        if ($type == 'div') {
            if ($cache == false) return $this->showTree();
            $tree = Yii::app()->cache->get('<?php echo $this->class2id($this->modelClass); ?>-tree');
            if ($tree == null) {
                $tree = $this->showTree();
                Yii::app()->cache->set('<?php echo $this->class2id($this->modelClass); ?>-tree', $tree, 3600 * 24);
            }
        } elseif ($type == 'ul') {
            if ($cache == false) return $this->showTreeUl(null,$param);
            $tree = Yii::app()->cache->get('<?php echo $this->class2id($this->modelClass); ?>-tree-ul');
            if ($tree == null) {
                $tree = $this->showTreeUl(null,$param);
                Yii::app()->cache->set('<?php echo $this->class2id($this->modelClass); ?>-tree-ul', $tree, 3600 * 24);
            }
        }
        return $tree;
    }

    public function showTree($pid = null) {
        $f = array('parent' => $pid);

        $result = <?php echo $this->modelClass; ?>::mongo()->find($f)->sort(array('title' => 1));
        foreach ($result as $res) {
            $f = array('parent' => $res['_id']);
            $c = <?php echo $this->modelClass; ?>::mongo()->count($f) > 0 ? true : false;

            $t = array(
                'text' => Yii::app()->controller->renderPartial('_view', array('data' => $res), true),
                'id' => 'data_' . $res['_id'],
                'hasChildren' => $c,
                'expanded' => false,
            );
            if ($c) {
                $t['children'] = $this->showTree($res['_id']);
            }
            $data[] = $t;
        }
        return $data;
    }

    public function showTreeUl($pid = null,$set=array(),$t=false) {

        // TODO выборка по условию или пометки того что нельзя выбрать!
        $r = null;
        $f = array('parent' => $pid);
        if (<?php echo $this->modelClass; ?>::mongo()->count($f) > 0) {
            $result = <?php echo $this->modelClass; ?>::mongo()->find($f)->sort(array('title' => 1));

            foreach ($result as $res) {

                $r .= '<li id="data_' . $res['_id'] . '">';
                if($set['pid']==$res['_id']){
                   $set['block']=true;
                }
                $link=($set['block'])?' class="block-a"':' onclick="_setParent(\'' . $res['_id'] . '\',\'' . $res['title'] . '\')" class="title"';
                $r .= '<a href="javascript:;" '.$link.'>' . $res['title'] . '</a>';
                $c = $this->showTreeUl($res['_id'],$set,$t);
                $set['block']=false;
                if ($c != null) $r .= '<ul>' . $c . '</ul>';
                unset($c);
                $r .= '</li>';
            }
        }
        return $r;
    }


    public function actionIndex() {
        $this->render('index');
    }

    public function actionCreate() {

        $model = new <?php echo $this->modelClass; ?>;
        $this->performAjaxValidation($model);
        if ($_POST['<?php echo $this->modelClass; ?>']) {
            $model->attributes = $_POST['<?php echo $this->modelClass; ?>'];
            if ($model->parent != null) {
                $model->parent = new MongoId($model->parent);
                $parent = <?php echo $this->modelClass; ?>::mongo()->findOne(array('_id' => $model->parent));
 		$parent['ancestors'][] = $model->parent;
                $model->ancestors = $parent['ancestors'];
            }
            $model->image = $this->saveFile('image');
            if ($model->save()) {

                Yii::app()->cache->delete('<?php echo $this->class2id($this->modelClass); ?>-tree-ul');
                Yii::app()->cache->delete('<?php echo $this->class2id($this->modelClass); ?>-tree');
                if (isset($_POST['_saveAdd'])) $this->refresh(); else $this->redirect(array('index'));
            }
        } else {
            $id = Yii::app()->request->getParam('id');
            if ($id != null) {
                $parent = <?php echo $this->modelClass; ?>::mongo()->findOne(array('_id' => new MongoId($id)));
            }<?php
$t='';
foreach($this->columns as $name=>$field)
{
    if($field['type']=='date' || $field['type']=='datetime'){
        echo "
                \$model->{$name} = new MongoDate();";
        $t.="
            \$model->{$name} = SHelper::formDate(\$model->{$name});";
        
    }

}echo "\n";?>
        }
<?php echo $t."\n";?>
        $this->render('_form', array('model' => $model, 'parent' => $parent));
    }

    public function actionUpdate() {
        $id = Yii::app()->request->getParam('id');
        if ($id != null) {
            $model = new <?php echo $this->modelClass; ?>;
            $this->performAjaxValidation($model);

            $n = <?php echo $this->modelClass; ?>::mongo()->findOne(array('_id' => new MongoId($id)));
            $model->_id = new MongoId($id);
            $model->attributes = $n;


            $oldP = $model->parent;
            if ($_POST['<?php echo $this->modelClass; ?>']) {
                $model->attributes = $_POST['<?php echo $this->modelClass; ?>'];
                if($model->parent==null){
                    $model->parent=null;
                    $model->ancestors=null;
                }elseif ($model->parent != null && $oldP != $model->parent) {
                    $model->parent = new MongoId($model->parent);
                    $parent = <?php echo $this->modelClass; ?>::mongo()->findOne(array('_id' => $model->parent));
 		    $parent['ancestors'][] = $model->parent;
                    $model->ancestors = $parent['ancestors'];
                } else $model->parent = $oldP;
                $model->image = $this->saveFile('image');

                if ($model->save()) {
                    Yii::app()->cache->delete('<?php echo $this->class2id($this->modelClass); ?>-tree-ul');
                    Yii::app()->cache->delete('<?php echo $this->class2id($this->modelClass); ?>-tree');
                    if (isset($_POST['_saveAdd'])) $this->refresh(); else $this->redirect(array('index'));
                }
            } else {
                if ($model->parent != null) {
                    $parent = <?php echo $this->modelClass; ?>::mongo()->findOne(array('_id' => new MongoId($model->parent)));
                }
            }<?php echo $t."\n";?>
            $this->render('_form', array('model' => $model, 'update' => true, 'parent' => $parent));
        }

    }


    function actionAjax() {
        if (Yii::app()->request->isAjaxRequest) {

            $action = Yii::app()->request->getParam('action');
            $id = Yii::app()->request->getParam('id');

            switch ($action) {
                case 'on':
                case 'off':
                    $p = str_replace('change_', '', $id);
                    $p = explode('_', $p);
                    if ($p[0] != '' && $p[1] > 0) {
                        if ($action == 'on') {
                            <?php echo $this->modelClass; ?>::mongo()->update(array('_id' => new MongoId($p[1])), array('$set' => array($p[0] => '1')));
                        } elseif ($action == 'off') {
                            <?php echo $this->modelClass; ?>::mongo()->update(array('_id' => new MongoId($p[1])), array('$set' => array($p[0] => '0')));
                        }
                        Yii::app()->cache->delete('<?php echo $this->class2id($this->modelClass); ?>-tree');
                    }
                    break;
                default:
                    break;
            }
        }
    }

    public function actionDelete() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = new MongoId(Yii::app()->request->getParam('id'));
            <?php echo $this->modelClass; ?>::mongo()->remove(array('ancestors' => $id));
            <?php echo $this->modelClass; ?>::mongo()->remove(array('_id' => $id));
            Yii::app()->cache->delete('<?php echo $this->class2id($this->modelClass); ?>-tree-ul');
            Yii::app()->cache->delete('<?php echo $this->class2id($this->modelClass); ?>-tree');
        }
    }

}
