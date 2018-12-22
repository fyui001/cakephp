<?php
App::uses('AppController', 'Controller');
class PostcodesController extends AppController{
  public function index(){

  }
  public function add(){
    $PostNum = $this->request->data['PostNum']; /* POSTされたデータを変数に格納 */
    $status = true; /* バリデーションのStatus、tureを初期セット */
    $Message = ''; /* エラーメッセージを入れる変数 */
    //$this->autoRender = false;
    if($PostNum == ''){
        $Message = '郵便番号を入力してください';
        $status = false;
        $success = array('Status' => $status, 'Message' => $Message);
    }else if(!preg_match('/^[0~9]{3}-[0~9]{4}$/') || !preg_match('/^[0~9]{7}$/')){
      $Message = 'この郵便番号は有効ではありません';
      $status = false;
      $success = array('Status' => $status, 'Message' => $Message);
    }else if(preg_match('/^[0~9]{3}-[0~9]{4}$/')){
      $PostNum = str_replace(array('-', 'ー'), '', $PostNum);
    }

    $data = $this->Postcode->finde('all', array('conditions' => $PostNum));
    if($data == NULL){
      $Message = 'この郵便番号は存在しません';
      $status = false;
      $success = array('Status' => $status, 'Message' => $Message);
    }else{
      $data_arr = array();
      $address = array();
      foreach($data as $value){
        $data_arr['Prefecture'] = $value['Postcode']['Prefecture'];
        $data_arr['City'] = $value['Postcode']['City'];
        $data_arr['Town'] = $value['Postcode']['Town'];
        $address[] = $data_arr;
      }
      $success = array('Status' => $status, 'address' => $address);
      echo json_encode($success);
    }



  }

}
