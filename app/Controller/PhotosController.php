<?php
App::uses('AppController', 'Controller');
App::import('Model', 'Photo');
class PhotosController extends AppController{

  public function beforeFilter(){

  }

  public function index (){
    $path = $this->Photo->find('all', array('fields' => 'path'));
    $path_n = count($path);
    header("Content-Type: image/JPG");
    //header("Content-Type: image/png");
    for($i = 0; $i < $path_n; $i++){
      $p[] = $path[$i]['Photo']['path'];
    }
    $image = new Imagick($p[1]);
    echo $image;


    return $p;
  }

  public function add(){

    $FileName = $_FILES['image']['name']; /* ファイル名を変数へ代入 */
    $FilePath = "/var/www/html/cakephp/app/webroot/Photo/"; /* バリデーション後保存するディレクトリのパス */
    $FilePath_c = "/var/www/html/cakephp/app/tmp/CheckPhoto/"; /* 最初に保存するディレクトリのパス */
    $UploadPath = "{$FilePath}{$FileName}"; /* パスとファイル名結合 */
    $UploadPath_c = "{$FilePath_c}{$FileName}";/* パスとファイル名を結合(チェック用) */

    /* tmpディレクトリにアップロード */
    if(move_uploaded_file($_FILES['image']['tmp_name'], $UploadPath_c)){

      /*画像を保存しているディレクトリのパスをデータベースへ保存 */
      if($this->Photo->save(array('path' => $UploadPath))){
        echo "success\n";
        try {
          if($image = new Imagick($UploadPath_c)){
            $image->writeImage($UploadPath); /* Imagickでアップロードされたファイル画像かどうか確認 */
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
