<?php
 echo $this->Flash->render('auth');
 echo $this->Form->create('User');
 ?>
 <fieldset>
   <legend>
     <?php echo __('Please enter your mailaddress and password'); ?>
   </legend>
   <?php
    echo $this->Form->input('mailaddress', array(
      'id' => 'Mailaddress',
      'autocomplete' => 'off',
      'label' => 'メールアドレス'
    ));
    echo $this->Form->input('password', array(
      'id' => 'password',
      'label' => 'パスワード'
    ));
    ?>
 </fieldset>
 <?php echo $this->Form->end('login'); ?>
 <a href="/mail_sents/add">登録はこちら</a>
