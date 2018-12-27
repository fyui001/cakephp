<?php
echo $this->Form->create('User');
echo $this->Form->input('mailaddress', array(
  'id' => 'mailaddress',
  'autocomplete' => 'off',
  'label' => 'メールアドレス'
));

echo $this->Form->input('password', array(
  'id' => 'passwd',
  'label' => 'パスワード'
));
echo $this->Form->end('signup');



?>
