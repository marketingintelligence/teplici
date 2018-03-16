<?
class Feedback extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function modelTitle()
    {
        return 'Заявки';
    }

    public function tableName()
    {
        return 'feedback';
    }

    public function getNiceDate() {
        return date( 'd.m.Y', $this->created_at );
    }

    public function rules()
    {
        return array(
            array('created_at', 'numerical', 'integerOnly'=>true),
            array('name, serial_number, text', 'length', 'max'=>5000),
            array('email','email'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'created_at' => 'Дата создания',
            'name' => 'Имя',
            'text' => 'Сообщение',
            'serial_number' => 'Порядковый номер',
        );
    }

    public function search()
    {
        $criteria=new CDbCriteria;
        $criteria->compare('id',$this->id);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('name',$this->created_at,true);

        $pagination = array('pageSize'=> 10);
        return new CActiveDataProvider($this,array(
            'criteria'   => $criteria,
            'pagination' => $pagination
        ));
    }

    public function beforeValidate() {
        if ($this->created_at==0) {
            $this->created_at=time();
        }
        if (strstr($this->created_at,'-')) {
            $date=explode('-',$this->created_at);
            $minute = $hour = 0;
            if(isset($_POST['_time']['created_at'])){
                $time = explode(':',$_POST['_time']['created_at']);
                $hour = (int)$time[0];
                $minute = (int)$time[1];
            }
            $this->created_at=mktime( $hour, $minute, 0, $date[1], $date[0], $date[2] );
        }
        return true;
    }

    public function defaultScope() {
        return array(
            'order' => 'created_at DESC, id + 0 DESC',
        );
    }

}
?>
