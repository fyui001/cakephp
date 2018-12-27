<?php
App::uses('AppController', 'Controller');
App::import('Model', 'MailSents');
class UsersController extends AppController{



    public function beforeFilter() {
        parent::beforeFilter();
        // ユーザー自身による登録とログアウトを許可する
        $this->Auth->allow('signup', 'logout', 'again');
        $this->response->disableCache();
    }

    public function index(){
        if($this->request->is('post')){

        }

    }

    public function logout(){
        $cookietime = time()-60*60*24;
        setcookie("usrname", "", $cookietime, "/");
        setcookie("logintoken", "", $cookietime, "/");

        $this->redirect($this->Auth->logout());

    }

    public function again(){

    }

    /* サインアップ */
    public function signup(){
        $this->loadModel('MailSents');
        $this->loadModel('Tokens');

        /* -- メールアドレスとURLのバリデーション処理 --*/
        $token = $this->request->query['token'];
        $token_len = strlen($token);
        if($token_len !== 40){
            $this->redirect(array('action' => 'again'));
        }
        /* トークンの仕分け */
        $token1 = substr($token, 0, 20);
        $token2 = substr($token, 20, 20);

        /* 整合性確認 */
        $info = $this->MailSents->find('first', array('conditions' => array('key1' => $token1)));
        if(empty($info)){
            $this->redirect(array('action' => 'again'));
        }

        /* トークン２の整合性確認 */
        $token2_hash = $info['MailSents']['key2'];
        $token_check = $this->User->hash_check($token2, $token2_hash);

        /* トークンの有効性確認 */
        if($token_check == true){
            $check = $this->MailSents->find('first', array(
                'conditions' => array('key1' => $token1, 'del_flg' => '0')
            ));
            $check2 = $this->MailSents->find('all', array(
                'conditions' => array('key1' => $token1, 'del_flg' => '1')
            ));

            /* トークンが古い場合の処理 */
            if(!empty($check2)){
                $this->redirect(array('action' => 'again'));
                return;
            }
        }else{
            $this->redirect(array('action' => 'again'));
            return ;
        }
        if($token_check == false){
            $this->redirect(array('action' =>'again'));
        }



        /* --ここからユーザーの登録処理-- */
        if($this->request->is('post')){
            $Status = true;
            $Message = '';
            $data = $this->request->data;
            $address = $data['User']['mailaddress'];
            $passwd = $data['User']['password'];
            $MailS = $check['MailSents']['email'];

            /* メールアドレスのバリデーション */
            if($address == NULL || $address == ''){
                $Message .= "メールアドレスを入力してください"."<br/>";
                $Status  = false;
                echo $Message;
            }elseif($address !== $MailS){
                $Message .= "メールアドレスが一致しません"."<br/>";
                $Status = false;
                echo $Message;
            }
            /* パスワードのバリデーション */
            if($passwd == NULL || $passwd == ''){
                $Message .= "パスワードを入力してください";
                $Status = false;
                echo $Message;
            }

            if($Status == true){
                $del_flg = '1';
                $id = $check['MailSents']['id'];
                $dataSource = $this->User->getDataSource();
                try{
                    $transactionBegun = false;
                    $transactionBegun = $dataSource->begin();
                    if($this->User->save($data) && $this->MailSents->save(array('id' => $id, 'del_flg' => $del_flg))){
                        if($transactionBegun){
                            $dbCommit = $dataSource->commit() !== false;
                        }
                        if($dbCommit){
                            return $this->redirect(array('action' => 'aftersignup'));
                        }
                    }else{
                        throw new Exception();
                    }
                }catch(Exception $e){
                    $dataSource->rollback();
                    echo 'にゃーん';
                }
            }
        }
    }

    public function aftersignup(){

    }

    public function afterlogin(){

    }


    /* ログイン */
    public function login(){
        $this->loadModel('Mailtoken');
        $status = true;

        /* cookieの存在確認とバリデーション処理 */
        if(isset($_COOKIE['logintoken']) && isset($_COOKIE["usrname"])){
            $status = false;
            $usrname = $_COOKIE["usrname"];
            $usrdata = $this->User->find("first", array("conditions" => array("mailtoken" => $usrname)));
            //$usrname = $_COOKIE["usrname"];
            $logintoken = $_COOKIE["logintoken"];
            $logintoken_hash = $usrdata["User"]["logintoken"];
            $status = $this->User->hash_check($logintoken, $logintoken_hash);

            /* cookieの */
            if($status == true){
                $this->Auth->login($usrdata['User']);
                $logintoken = $this->genRandStr(64);
                $id = $usrdata["User"]["id"];
                $HashToken = $this->User->Hash($logintoken);
                $this->User->save(array("id" => $id, "logintoken" => $HashToken));
                $cookietime = time()+60*60*24;
                setcookie("usrname", $usrname, $cookietime, "/");
                setcookie("logintoken", $logintoken, $cookietime, "/");
                $this->redirect("/members/index/");
            }else{
                $cookietime = time()-60*60*24;
                setcookie("logintoken", "", $cookietime, "/");
                setcookie("loginName", "", $cookietime, "/");
                $this->redirect($this->Auth->logout());
                $this->redirect("/members/login");
            }
        }


        if($this->request->is('post')){

            if ($this->Auth->login()){
                $usrdata = $this->request->data["User"]["mailaddress"];
                $usr = $this->User->find("first", array("conditions" => array("mailaddress" => $usrdata)));
                $id = $usr["User"]["id"];
                $usrname_token = $this->Mailtoken->find("first", array("conditions" => array("id" => $id)));
                $usrname = $usrname_token["Mailtoken"]["token"];
                $logintoken = $this->genRandStr(64);
                $HashToken = $this->User->Hash($logintoken);
                $this->User->save(array("id" => $id, "mailtoken" => $usrname, "logintoken" => $HashToken));
                $check = $this->User->hash_check($logintoken, $HashToken);
                $cookietime = time()+60*60*24;
                setcookie("usrname", $usrname, $cookietime, "/");
                setcookie("logintoken", $logintoken, $cookietime, "/");
                $this->redirect("/");
            }else{
                echo  'メールアドレス、またはパスワードが違います。';
            }
        }
    }

}
