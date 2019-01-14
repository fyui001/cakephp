<?php echo $this->Flash->render('auth'); ?>

 <!DOCTYPE html>
 <html lang="ja">
 <head>
     <meta charset="utf-8">
     <link rel="stylesheet" href="/css/Users/Mystyle.css">
     <title>ログイン</title>
 </head>
 <body>
     <header>
         <p id = "title">ログイン</p>
     </header>

     <?php echo $this->Form->create('User', array('id' => 'form')); ?>
     <div id="content">
         <p>メールアドレス</p>
         <?php echo $this->Form->input('mailaddress', array('id' => 'mailaddress','autocomplete' => 'off', 'label' => false)); ?>
         <p>パスワード</p>
         <?php echo $this->Form->input('password', array('id' => 'password', 'label' => false)); ?>
            <input class="but0" type="submit" value="ログイン">
     </div>
 </body>
 </html>
