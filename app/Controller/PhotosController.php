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

    $FileName = $_FILES['image']['name']; /* ファイル名を変数へ代入 */
    $FilePath = "/var/www/html/cakephp/app/webroot/Photo/"; /* バリデーション後保存するディレクトリ */
    $UploadPath = "{$FilePath}{$FileName}"; /* パスとファイル名を結合 */
    $FilePath_c = "/var/www/html/cakephp/app/tmp/CheckPhoto/"; /* 最初に保存するディレクトリのパス (tmpディレクトリなど)*/
    $UploadPath_c = "{$FilePath_c}{$FileName}";/* パスとファイル名を結合 */

    /* 最初に保存するディレクトリにアップロード */
    if(move_uploaded_file($_FILES['image']['tmp_name'], $UploadPath_c)){
      if($this->Photos->save(array('path' => $UploadPath))){
        echo "success\n";
        /* Imagickでバリデーション */
        try {
          if($image = new Imagick($UploadPath_c)){
            $image->writeImage($UploadPath);
          }else{
            throw new Exception();
          }
        }catch(Exception $e) {
          echo "これは画像ではありません";
        }

      }else{
        echo 'あっぷろーどに失敗';
    }

  }
}

  public function upload(){

  }

}
