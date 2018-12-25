<?php
 echo $this->Flash->render('auth');
 echo $this->Form->create('Member');
 ?>
 <fieldset>
   <legend>
     <?php echo __('Plesse enter your mailaddress and passeord'); ?>
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
