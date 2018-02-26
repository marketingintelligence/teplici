<?

class FaqForm extends CFormModel{

	public $title;
	public $parent_Themes_id
	public $city;
	public $urlMail;
	public $question;
	public function rules(){
		return array(
			array('parent_Themes_id,title,city,urlEmail,question','required'),
			array('urlMail','email'),
		);
	}


	public function attributeLabels(){
		return array(
            'id' => '№',
            'parent_Themes_id'=>'Темы',
            'title' => 'Ф.И.О',
            'city' => 'Город',
            'urlMail' => 'E-mail',
            'question' => 'Текст вопроса',
            'status'=>'Статус',

			
		);
	}


}
?>