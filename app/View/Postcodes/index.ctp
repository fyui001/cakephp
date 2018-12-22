<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/css/Postcodes/Mystyle.css">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <title>住所検索フォーム</title>
</head>
<body>
  <header>
    <p class="title">住所検索フォーム</p>
  </header>
  <main>

    <form id="form" action="sent.php" method="post">
      <div id="form-item">

        <div id="form-PostNum">
          <p>郵便番号<span id="sub">(半角)</span></p>
          <input type="text" id="PostNum" name="PostNum" autocomplete="off">
        </div>
        <button type="button" id="but1">住所を検索</button>

        <div id="form-address">
          <p>住所</p>
          <input type="text" id="address" name="address">
        </div>


      </form>

    </main>
    <footer></footer>

    <script>
    $('#but1').click(function(event){
      event.preventDefault();
      var PostNum = $('#PostNum').val();

      $.ajax({
        async: false,
        type: 'POST',
        url: '/postcodes/add',
        dataType:'json',
        data: {PostNum:PostNum}
      })
      .done(function(data){
        if(data.Status === false){
          alert(data.Message);
        }else if(data.Status === true){
          if(data.address.length === 1){
            $('#address').val("");
            $('#address').val(data.address[0]['Prefecture'] +data.address[0]['City'] + data.address[0]['Town']);
          }else{
            console.log(data.addres);
            $("#address").replaceWith("<select id='address' size='9'></select>");
            $('#address').val(0);
            $.each(data.address, function(key, value){
              $('#address').append("<option hidden>選択してください。</option>" , "<option>"+value['Prefecture']+value['City']+value['Town']+"</option>");
              $('#address').change(function(){
                var add = $(this).val();
                $('#address').replaceWith("<input id='address'>");
                $('#address').val(add);
              });
            });
          }
        }
      }).fail(function(XMLHttpRequest, textStatus, errorThrown){
        console.log(textStatus)
        alert('error');
      });
    })

  </script>


</body>
</html>
