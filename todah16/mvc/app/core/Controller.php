<?php
class Controller {
	
	public function model($model) {
		require_once '../app/models/' . $model . '.php';
		//return new $model();
	}
    
    public function viewOnly($view) {
        require_once '../app/views/' . $view . '.php';
    }
	
	public function view($view, $viewbag = []) {
		require_once '../app/views/' . $view . '.php';
	}
    
    public function viewExtraViewbag($view, $viewbag = [], $viewbagExtra=[]) {
		require_once '../app/views/' . $view . '.php';
	}
    
	
	public function post () {
		return $_SERVER['REQUEST_METHOD'] === 'POST';
	}
	
	public function get () {
		return $_SERVER['REQUEST_METHOD'] === 'GET';
	}
	
}