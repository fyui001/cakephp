<?php
 App::uses('AppController', 'Controller');
 App::uses('ShellmailsController', 'Controller');
 class MailShell extends AppShell{
   public function main(){
     $hoge = new ShellmailsController();
     $mail = array('MailSent' => array('email' => $this->args[0]));
     $hoge->index($mail);
   }
 }
