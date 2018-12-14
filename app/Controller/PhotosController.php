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
    debug($_FILES);

    $FilePath = "/Photo/"; /* バリデーション後保存するディレクトリ */
    $FilePath_c = "/var/www/html/cakephp/app/tmp/CheckPhoto/"; /* 最初に保存するディレクトリのパス */
    $FileName = $_FILES['image']['name']; /* ファイル名を変数へ代入 */

    if(!file_exists($FilePath_c)){
      mkdir($FilePath_c);  /* ディレクトリが存在しない場合は其れを作成 */
    }

    $UploadPath_c = "{$FilePath_c}{$FileName}";/* パスとファイル名を結合 */

    /* tmpディレクトリにアップロード */
    if(move_uploaded_file($_FILES['image']['tmp_name'], $UploadPath_c)){
      if($this->Photos->save(array('path' => $UploadPath_c))){
        echo "success\n";

        try {
          $name = "{$FilePath}{$FileName}";
          $image = new Imagick("/var/www/html/cakephp/app/tmp/CheckPhoto/IMG_0019.JPG");
          if(ture){
            $image->writeImage("/var/www/html/cakephp/app/webroot/Photo/IMG_0019.JPG");
          }else{
            throw new Exception();
          }
        }catch(Exception $e) {
          echo "にゃーん";
        }


      }else{
        echo 'あっぷろーどに失敗';
    }

  }
}

  public function upload(){

  }

}
