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
        <h1 class='title'>画像文字起こし</h1>
    </header>
    <main>
        <div id = "content">

            <form id = "form" action="/scans/add" method="post" enctype = "multipart/form-data">
                <input id = "image" type="file" name="image">
                <input id = "but" type="button" value="アップロード">
            </form>
            <textarea class = "text" name="text" rows="25" cols="130"></textarea>
        </div>
    </main>
    <footer></footer>
    <script>

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
            dataType :'json',
        }).done(function(data){
            $('#text').val(data.Text);
            if(data.Status === false){
                //alert(data.Message);
                alert(data.Message);
            }else if(data.Status === true){
                $('.text').val("");
                $('.text').val(data.Text);
            }
        }).fail(function(XMLHttpRequest, textStatus, errorThrown){
            console.log(textStatus);
            alert('んなぁ。。。残酷だなぁ');
        });
    })
    </script>
</body>
</html>
