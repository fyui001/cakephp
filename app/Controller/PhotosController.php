<?php
App::uses('AppController', 'Controller');
App::import('Model', 'Photo');
class PhotosController extends AppController{

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
        $this->response->disableCache();
    }

    public function index (){
        $path = $this->Photo->find('all', array('fields' => 'path', 'conditions' => array('del_flg' => '0')));
        $path_n = count($path);
        for($i = 0; $i < $path_n; $i++){
            $p[$i] = $path[$i]['Photo']['path'];
        }
        $this->set('photo',$p);

    }

    public function add(){

        $FileName = $_FILES['image']['name']; /* ファイル名を変数へ代入 */
        $UploadPath = "/var/www/html/cakephp/app/webroot/Photo/{$FileName}"; /* バリデーション後保存するディレクトリのパス */
        $ViewPath = "/Photo/{$FileName}"; /* データベースに保存するパス */
        $UploadPath_c = "/var/www/html/cakephp/app/tmp/CheckPhoto/{$FileName}"; /* 最初に保存するディレクトリのパス (tmpディレクトリなど)*/

        /* 最初に保存するディレクトリにアップロード */
        if(move_uploaded_file($_FILES['image']['tmp_name'], $UploadPath_c)){

            /*画像を保存しているディレクトリのパスをデータベースへ保存 */
            if($this->Photo->save(array('path' => $UploadPath, 'del_flg' => '0'))){

                try {
                    if($image = new Imagick($UploadPath_c)){
                        $image->writeImage($UploadPath); /* Imagickでアップロードされたファイル画像かどうか確認 */
                        $this->Photo->save(array('path' => $ViewPath)); /* 画像を保存しているディレクトリのパスをデータベースへ保存 */
                        echo 'success';
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


}
