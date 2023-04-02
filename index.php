<!DOCTYPE html>
<html lang="en">
<?php
//エラー処理
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT">
    <title>NU 理学部 To Do リスト</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="./img/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <h1>NU 理学部 To Do リスト</h1>
    </header>
    <main>
        <table>
            <tr>
                <th>チェック</th>
                <th>期日</th>
                <th>タスク</th>
                <th>詳細</th>
            </tr>
            <?php
            //url from config
            $config = file_get_contents("./config.json");
            $config = json_decode($config, true);
            try {
                $url = $config["nu-rigakubu"]["url"];
                $apiJson = file_get_contents($url);
                //json => array
                $array = json_decode($apiJson, true);
                //array => html
                for ($i = 0; $i < count($array); $i++) {
                    $a = htmlspecialchars($array[$i][0]);
                    $b = htmlspecialchars($array[$i][1]);
                    $c = htmlspecialchars($array[$i][2]);
                    echo "<tr id='row-$i'>";
                    echo "<td><input type='checkbox' id='checkbox-$i'></td>";
                    echo "<td><label for='checkbox-$i'>$a</label></td>";
                    echo "<td><label for='checkbox-$i'>$b</label></td>";
                    echo "<td><label for='checkbox-$i'>$c</label></td>";
                    echo "</tr>";
                }
            } catch (Exception $e) {
                //エラーログ生成
                $log = "[Warn] " . date("Y/m/d H:i:s") . " " . $e->getMessage() . " " . $e->getFile() . " " . $e->getLine() . " " . $e->getTraceAsString() . "\n";
                file_put_contents("./logs/error.log", $log, FILE_APPEND);
                //500.phpへ
                header("Location: ./500.php");
            }
            ?>
        </table>
        <button id="reset">リセット</button>
        <div id="desc">
            <h2>説明</h2>
            <ul>
                <li>完了した項目に、チェックを入れてください。</li>
                <li>リセットボタンを押すと、チェックが外れます。</li>
                <li>チェックなどはブラウザに保存されます。</li>
                <li>仕様上、保存されたデータが不正アクセス等を受ける可能性がないとは言い切れません。</li>
                <li>多分大丈夫ですが、自己責任でお願いします。</li>
                <li>また、キャッシュとかを削除すると多分消えます。</li>
            </ul>
            <p><b>ご質問などはgotoまで</b></p>
        </div>
        <div id="bugs">
            <h2>既知の問題</h2>
            <ul>
                <li>LINEのブラウザでは正常に動作しません。Safari,Google Chorme,Firefoxなどをお使いください。</li>
            </ul>
        </div>
        <div>
            <p>Issueにあげてくれてもok</p>
            <a href="https://github.com/coko-1836/nu_to_do_list"><img src="./img/github-mark/github-mark.svg" style="width: 25px; margin-right: 0.5em;" >Github</a>
        </div>
        <p><b>ご質問などはgotoまで</b></p>
    </main>
    <script src="./script/main.js" defer></script>
</body>

</html>