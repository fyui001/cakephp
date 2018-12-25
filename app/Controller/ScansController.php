<?php
App::uses('AppController', 'Controller');
class ScansController extends AppController{

  public function index(){
  //  if($this->requests->is('post')){
    //  debug($_FILES);
    //}
  }
  public function add(){
    $File = $_FILES;
    var_dump($File);
    $FileName = $_FILES['image']['name']; /* ファイル名を変数に格納 */
    $CheckPath = "/var/www/html/cakephp/app/tmp/ScanCheck/"; /* アップロードされた画像を保存するディレクトリパス */
    $FilePath = "/var/www/html/cakephp/app/webroot/Scans/'{$FileName}'";
    $Status = true; /* バリデーションのステータスを入れる変数、 初期値にtrueをセット */
    $Message = ''; /* エラーメッセージを入れる変数 */
    //$hoge = array("Status" => $Status, "Text" => "ok");
    //echo json_encode($hoge);
    $apiKey = 'AIzaSyCxnD_g3X1fpUwQCH0rsEFDOb3d0vF9774';
    $file = "'{$CheckPath}'.'{$FileName}'";
    //APIに送りつけるパラメータの設定
    move_uploaded_file($File['image']['tmp_name'], $CheckPath);

    $json = json_encode([
      "requests" => [
        [ "image"   => [ "content" => base64_encode(file_get_contents($file)), ], // ファイルをbase64エンコードしたものを指定。
          "features" => [ [ "type" => "TEXT_DETECTION", "maxResults" => 10, ], ], //OCRを指定
        ],
      ],
    ]);

    // 各種オプションを設定
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://vision.googleapis.com/v1/images:annotate?key=" . $apiKey);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    curl_setopt($curl, CURLOPT_TIMEOUT, 15); // タイムアウト時間の設定（秒）
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);

    //curlの実行
    $res = curl_exec($curl);
    //取得データの配列化

    $data = json_decode($res, true);
    curl_close($curl);
    //echo $res['responses'][0]['description'];
    echo $data["responses"][0]["fullTextAnnotation"]["text"];
    exit;


  }
}
