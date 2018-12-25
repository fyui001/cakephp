<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="css/Scans/Mystyle.css">
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <title></title>
</head>
<body>
  <header>
    <h1>画像文字起こし</h1>
  </header>
  <main>
    <form id = "form" action="/scans/add" method="post" enctype = "multipart/form-data">
      <input id = "image" type="file" name="image">
      <input id = "but" type="button" value="アップロード">
    </form>
    <textarea id = "text" name="text" rows="20" cols="80"></textarea>
  </main>
  <footer></footer>
  <script>
  /*
  inputにファイルが選択された時にアップロードする。
  アップロードをクリックした時に動作させるためにはchangeをclickにする。
  $(document).onはあとから追加した要素にも対応させるため。
  */

  $('#but').click(function(event){
    event.preventDefault();
    var form = new FormData($('#form').get(0));;
    $.ajax({
      async : false,
      url : "/scans/add",
      type : "POST",
      data : form,
      cache : false,
      contentType : false,
      processData : false,
      datatype :'json',
    }).done(function(data){
      $('#text').val(data);
      if(data.Status === false){
        alert(data.Message);
      }else if(data.Status === true){
        $('#text').val("");
        alert(data.Text);
      }
    }).fail(function(XMLHttpRequest, textStatus, errorThrown){
      console.log(textStatus);
      alert('んなぁ。。。残酷だなぁ');
    });
  })
  </script>
</body>
</html>
