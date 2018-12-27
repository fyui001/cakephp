<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('AppController', 'Controller');

class MailSentsController extends AppController{
  public $helpers = array('Html', 'Form','Session');


  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow('add', 'sent');
  }
  public function index(){

  }



  public function add(){
    $this->loadModel('Tokens');
    $this->loadModel('Users');
    if($this->request->is('post')){
      $address = $this->request->data['MailSent']['email'];
      if(empty($address)){
        echo 'メールアドレスを入力してください。';
        return false;
      }

      //すでに登録されているメールアドレスかを確認
      $success = $this->Users->find('first', array('conditions' => array('mailaddress' => $address)));
      if(!empty($success)){
        echo 'このメールアドレスはすでに登録されています。';
        return false;
      }



      $exe = ROOT.DS.'app'.DS.'Console'.DS.'cake mail '."{$address}".' > /dev/null & ';
      exec($exe);

        return $this->redirect(array('action' => 'sent'));
    }
  }


  public function sent(){

  }

}
