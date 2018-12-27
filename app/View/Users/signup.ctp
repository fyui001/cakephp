

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/Users/Mystyle.css">
    <title>サインアップ</title>
</head>
<body>
    <header>
        <p id = "title">サインアップ</p>
    </header>

    <?php echo $this->Form->create('User', array('id' => 'form')); ?>
    <div id="content">
        <p>メールアドレス</p>
        <?php echo $this->Form->input('mailaddress', array('id' => 'mailaddress','autocomplete' => 'off', 'label' => false)); ?>
        <p>パスワード</p>
        <?php echo $this->Form->input('password', array('id' => 'password', 'label' => false)); ?>
        <input id="but1" type="submit" value="signup">
        <?php //echo $this->Form->end('signup', array('id' => 'but1')); ?>
    </div>
</body>
</html>
