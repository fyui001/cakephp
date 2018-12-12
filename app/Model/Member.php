<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Member extends AppModel{

  public $validate = array(
    'mailaddress' => array(
      'required' => array(
        'rule' => 'notBlank',
        'message' => 'A mailaddress is required'
      )
    ),
    'password' => array(
      'required' => array(
        'rule' => 'notBlank',
        'message' => 'A password is required'
      )
    ),
    'role' => array(
      'valid' => array(
        'rule' => array('inList', array('admin', 'author')),
        'message' => 'Please enter a valid role',
        'allowEmpty' => false
      )
    )
  );

  public function Hash($data){
    if(!empty($data)){
      $Hasher = new BlowfishPasswordHasher();
      $hashdata = $Hasher->hash($data);
    }
    return $hashdata;
  }


  public function beforeSave($options = array()){
    if(!empty($this->data[$this->alias]['password'])){
      $passwordHasher = new BlowfishPasswordHasher();
      $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
    }
    return true;
  }

  public function passhash($passwd, $info){
    if(!empty($info)){
      $passhash = new BlowfishPasswordHasher();
      $Mail = $info['Mail'];
      if($passhash->check($passwd, $info)){
        $status = true;
      }else{
        $status = false;
      }
    }
    return $status;
  }

 /* ハッシュチェック */
  public function hash_check($data, $hashData){
    if(!empty($hashData)){
      $hash = new BlowfishPasswordHasher();
      if($hash->check($data, $hashData)){
        $status = true;
      }else{
        $status = false;
      }
    }
    return $status;
  }

}
