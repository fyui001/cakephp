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
                    <p>郵便番号<span class="sub">(半角)</span></p>
                    <input type= "text" class="PostNum" name="PostNum" autocomplete="off" size="25">
                </div>

                <button type="button" class="but1">住所を検索</button>

                <div id="form-address">
                    <p>住所</p>
                    <input type="text" class="address" name="address" size="30">
                </div>

            </form>

        </main>
        <footer></footer>

        <script>
        $('.but1').click(function(event){
            event.preventDefault();
            var PostNum = $('.PostNum').val();
            $.ajax({
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
                        $('.address').val("");
                        $('.address').val(data.address[0]['prefecture'] +data.address[0]['city'] + data.address[0]['town']);
                    }else{
                        console.log(data.addres);
                        $(".address").replaceWith("<select class='address' size='9'></select>");
                        $('.address').val(0);
                        $.each(data.address, function(key, value){
                            $('.address').append("<option hidden>選択してください。</option>" , "<option>"+value['prefecture']+value['city']+value['town']+"</option>");
                            $('.address').change(function(){
                                var add = $(this).val();
                                $('.address').replaceWith("<input class='address' size='30'>");
                                $('.address').val(add);
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
