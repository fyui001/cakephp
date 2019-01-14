<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('AppController', 'Controller');
class ShellmailsController extends AppController{
  public function index($mail){
    $this->loadModel('MailSent');
    $this->loadModel('User');
    $this->loadModel('Token');


    $address = $mail['MailSent']['email'];
    /* findの検索条件 */
    $del_check = array('email' => $address, 'del_flg' => '0');
    /* 検索 */
    $search = $this->MailSent->find('first', array('conditions' => $del_check));
    if(!empty($search)){
      $del_id = $search['MailSent']['id'];
    }

    $dataSource = $this->MailSent->getDataSource();
    try{
      $dataSource->begin();
      /* トークン取得 */
      if($this->MailSent->save($mail)){
        $id = $this->MailSent->getInsertID();
        $db_token = $this->Token->find('first', array('conditions' => array('id' => $id)));
        $token2 = $this->genRandStr(20);
      }else{
        throw new Excption();
      }

      /* トークンを変数に代入 */
      foreach($db_token as $t){
        $token = $t['token'];
        $token_id = $t['id'];
      }
      /*トークンをハッシュ化  */
      $token_hash = $this->MailSent->token_hash($token2);

      $data = $mail;
      $data['MailSent']['key1'] = $token;
      $data['MailSent']['key2'] = $token_hash;
      $data['MailSent']['del_flg'] = '0';



      if($this->MailSent->save($data) && $this->Token->save(array('id' => $token_id, 'del_flg' => '1'))){
        if(!empty($search)){
          if(!$this->MailSent->save(array('id' => $del_id, 'del_flg' => '1'))){
            throw new Excption();
          }
        }
        $dataSource->commit();
        $Mail = "http://app.mogamin.net/users/signup?token={$token}{$token2}";
        $sent = $mail['MailSent']['email'];
        $email = new CakeEmail('singup');
        $email->from('13yun.test@gmail.com');
        $email->to($sent);
        $email->subject('メールアドレスの確認');
        $email->emailFormat('text');
        $email->send("
        このメールは自動で送信しています。

        ご利用ありがとうございます。
        以下のURLからあたらしく登録をしていただけます。

        {$Mail}
        ");


      }else{
        throw new Exception();
      }


    }catch(Exception $e){
      $dataSource->rollback();
    }
  }
}
