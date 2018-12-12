<?php
App::uses('AppController', 'Controller');
App::import('Model', 'Photos');
class PhotosController extends AppController{

  public function beforeFilter(){

  }

  public function index (){

  }

  public function add(){
    $this->loadModel('Photo');
    if($this->requst->is('post')){
      var_dump($_FILES);
    }
  }

}
