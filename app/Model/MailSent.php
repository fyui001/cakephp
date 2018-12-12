<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');


class MailSent extends AppModel{
  public function token_hash($token){
    if(!empty($token)){
      $tokenHasher = new BlowfishPasswordHasher();
      $tokenhash = $tokenHasher->hash($token);
    }
    return $tokenhash;

  }
  public function token_check($token, $token_hash){
    if(!empty($token_hash)){
      $hash = new BlowfishPasswordHasher();
      if($hash->check($token, $token_hash)){
        $status = true;
      }else{
        $status = false;
      }
    }
    return $status;
  }


}
