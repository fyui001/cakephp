<?php
App::uses('AppController', 'Controller');
class ScansController extends AppController{

    public function index(){

    }

    public function add(){

        $apiKey = 'AIzaSyCxnD_g3X1fpUwQCH0rsEFDOb3d0vF9774'; /* Google Cloud API のAPIキーを入れる */
        $FileName = $_FILES['image']['name']; /* ファイル名を変数に格納 */
        $CheckPath = "/var/www/html/cakephp/app/tmp/ScanCheck/{$FileName}"; /* アップロードされた画像を保存するディレクトリパス */
        $Status = true; /* バリデーションのステータスを入れる変数、 初期値にtrueをセット */
        $Message = ''; /* エラーメッセージを入れる変数 */
        /* アップロードされたファイルをブラウザから見えないディレクトリに保存する */
        if(move_uploaded_file($_FILES['image']['tmp_name'], $CheckPath)){
            try{
                /* Imagickを使ってアップロードされたファイルのバリデーション */
                if($image = new Imagick($CheckPath)){

                    $json = json_encode([
                        "requests" => [
                            [ "image"   => [ "content" => base64_encode(file_get_contents($CheckPath)), ], /* ファイルをbase64エンコードしたものを指定。 */
                            "features" => [ [ "type" => "TEXT_DETECTION", "maxResults" => 10, ], ], /* OCRを指定 */
                        ],
                    ],
                ]);

                    /* 各種オプションを設定 */
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, "https://vision.googleapis.com/v1/images:annotate?key=" . $apiKey);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
                    curl_setopt($curl, CURLOPT_TIMEOUT, 15); /* タイムアウト時間の設定（秒) */
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);

                    $res = curl_exec($curl); /* curlの実行 */
                    $data = json_decode($res, true); /* 取得データの配列化 */
                    curl_close($curl); /* curlクローズ */

                     if(!empty($data["responses"][0])){
                         $Text = $data["responses"][0]["fullTextAnnotation"]["text"]; /* 取得した文字列の配列を変数に入れる */
                         $result = array('Status' => $Status, 'Text' => $Text); /* バリデーションのステータスと */
                         echo json_encode($result);
                         exit;
                     }else if(empty($data["responses"][0])){
                         $Status = false;
                         $Message = "文字の読み込みに失敗";
                         $result = array("Status" => $Status, "Message" => $Message);
                         throw new Exception;
                     }

                }else{
                    $Status = false;
                    $Message = 'これは画像ではありません';
                    $result = array('Status' => $Status, 'Message' => $Message);
                    throw new Exception;
                }
            }catch(Exception $e) {
                echo json_encode($result);
                exit;
            }

        }else{
            $Status = false;
            $Message = 'アップロードに失敗';
            $result = array('Status' => $Status, 'Message' => $Message);
            echo json_encode($result);
            exit;
        }

    }

}
