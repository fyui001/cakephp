<?php
echo $this->Form->create('MailSent');
echo $this->Form->input('email', array(
  'id' => 'Mail',
  'autocomplete' => 'off',
  'label' => 'メールアドレス'
));
echo $this->Form->end('送信');
?>
