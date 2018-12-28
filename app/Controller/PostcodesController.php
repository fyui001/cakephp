<?php
App::uses('AppController', 'Controller');
class PostcodesController extends AppController{
  public function beforeFilter() {
      parent::beforeFilter();
      $this->Auth->allow('index');
      $this->response->disableCache();
  }

  public function index(){

  }
  public function add(){
    $PostNum = $this->request->data['PostNum']; /* POSTされたデータを変数に格納 */
    $status = true; /* バリデーションのStatus、tureを初期セット */
    $message = ''; /* エラーメッセージを入れる変数 */
    $PostNum = str_replace(array('-', 'ー'), '', $PostNum); /* ハイフンが入っていればそれを除く */
    ///$this->autoRender = false;
    try {

      /* データの空チェックとバリデーション */
      if($PostNum == ''){
        $message = "郵便番号を入力してください";
        $status = false;
        $result = array('Status' => $status, 'Message' => $message);
        throw new Exception();
      }else if(!preg_match("/^[0-9]{7}$/", $PostNum)){
        $message = "この郵便番号は有効ではありません";
        $status = false;
        $result = array('Status' => $status, 'Message' => $message);
        throw new Exception();
      }

      $data = $this->Postcode->find('all', array('conditions' => array('PostNum' => $PostNum)));  /* 住所を検索 */

      /* 検索結果が空ならfalse */
      if(empty($data)){
        $message = "この郵便番号は存在しません";
        $status = false;
        $result = array('Status' => $status, 'Message' => $message);
        throw new Exception();
      }else{
        $data_arr = array();
        $address = array();
        foreach($data as $value){
          $data_arr['prefecture'] = $value['Postcode']['Prefecture'];
          $data_arr['city'] = $value['Postcode']['City'];
          $data_arr['town'] = $value['Postcode']['Town'];
          $address[] = $data_arr;
        }
        $result = array('Status' => $status, 'address' => $address);
      }

    }catch (Exception $e) {
      echo json_encode($result);
      exit;
    }
    echo json_encode($result);


  }

}
