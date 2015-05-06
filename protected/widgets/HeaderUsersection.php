<?php 
class HeaderUsersection extends CWidget {
	
	public $type;
	
    public function init() {
    	
    }
    
    public function run() {
    	//$model = (isset(Yii::app()->session['search_model']) ? Yii::app()->session['search_model'] : new SearchForm("search"));
    	//$this->render('search_form', array('model'=>$model, 'type'=>isset($this->type) ? $this->type : 2));
        $this->render('headerSmalllink');
    }
}

