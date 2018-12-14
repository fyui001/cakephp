<?php
App::uses('AppController', 'Controller');
App::import('Model', 'Photos');
class PhotosController extends AppController{

  public function beforeFilter(){

  }

  public function index (){

  }

  public function add(){
    $this->loadModel('Photos');

    $FilePath = "/var/www/html/cakephp/app/Photo/";
    if(!file_exists($FilePath)){
      mkdir($FilePath);
    }

    /* ファイル名変更 */
    $FileName = $_FILES['image']['name'];
    $UploadPath = "/Photo'{$FileName}'";


    if(move_uploaded_file($_FILES['image']['tmp_name'], $UploadPath)){
      if($this->Photos->save(array('path' => $UploadPath))){
        echo 'success';
      }

    }

  }

  public function upload(){

  }

}
