<!-- <?php
// ファイルに書き込み (名前・メール登録)
$name = $_POST['name'];
$mail = $_POST['mail'];
// $age = $_POST['age'];
// $hobby = $_POST['hobby'];
// $gender = $_POST['gender'];

//文字作成 (日付)
$str = date("Y-m-d H:i:s");
// $str = $name .' '.$mail;
// $str = $age. ' ' .$gender;
$str = $str . ' ' .$name . ' ' .$mail;


//File書き込み( ※フォルダは先に用意する ) (日付・名前・メール)
$file = fopen("./test/test.txt", "a");    // ファイル読み込み
fwrite($file, $str . "\n");
fclose($file);
?>


<html>

<head>
    <meta charset="utf-8">
    <title>File書き込み</title>
</head>

<body>

    <h1>書き込みしました。</h1>
    <h2>書き込み内容 : <?= $str ?></h2>
    <h2>./data/data.txt を確認しましょう！</h2>

    <ul>
        <li><a href="input.php">戻る</a></li>
    </ul>
</body>

</html> -->

<?php
//入力値に不正なデータがないかなどをチェックする関数
function checkInput($str){
  if(is_array($str)){
    //$str が配列の場合、checkInput()関数をそれぞれの要素について呼び出す
    return array_map('checkInput', $str);
  }else{
    //php.iniでmagic_quotes_gpcが「on」の場合の対策
    // if(get_magic_quotes_gpc()){  
    //   $str = stripslashes($str);
    // }
    //NULLバイト攻撃対策
    // if(preg_match('/\0/', $str)){  
    //   die('不正な入力（NULLバイト）です。');
    // }
    //文字エンコードのチェック
    if(!mb_check_encoding($str, 'UTF-8')){ 
      die('不正な文字エンコードです。');
    }
    //数値かどうかのチェック (文字が入力されている場合は、エラーが出る)
    // if(!ctype_digit($str)) {  
    //   die('不正な入力です。');
    // }
    return (int)$str;
  }
}
 
//POSTされたデータをチェック
$_POST = checkInput($_POST);
 
$error = 0;  //変数の初期化
 
//性別の入力の検証
if(isset($_POST['gender'])) {
  $gender = $_POST['gender'];
  if($gender == 1) {
    $gendername = '男性';
  }elseif($gender == 2) {
    $gendername = '女性';
  }else{
    $error = 1;  //入力エラー（値が 1 または 2 以外）
  }
}else{
  $error = 1;  //入力エラー（値が未定義）
}
 
//年齢の入力の検証
if(isset($_POST['age'])) {
  $age = $_POST['age'];
  if($age < 1 || $age > 8 ) {
    $error = 1;  //入力エラー（値が1-8以外）
  }
}else{
   $error = 1;  //入力エラー（値が未定義）
}
 
//趣味の入力の検証
if(isset($_POST['hobby'])) {
  $hobby = $_POST['hobby'];
  if(is_array($hobby)) {
    foreach($hobby as $value ) {
      if($value < 0 || $value > 7) {
        $error = 1;  //入力エラー（値が0-7以外）
      }
    }
  }else{
    $error = 1;  //入力エラー（値が配列ではない）
  }
}else{
  $error = 1;  //入力エラー（値が未定義）
}
 
//エラーがない場合の処理（結果の表示）
if($error == 0) {
  // echo '<dl>';
  echo '<dt>性別：</dt><dd>' . $gendername . '</dd>';  
  
  //年齢の値で分岐
  if($age != 8) {
    echo '<dt>年齢：</dt><dd>' . $age . '0代</dd>';
  }else{
    echo '<dt>年齢：</dt><dd>80代以上</dd>';
  }
  
  //foreach で配列の数だけ繰り返し処理
  echo '<dt>趣味：</dt>';
  echo '<dd>';
  foreach($hobby as $value) {
    switch($value) {
      case 0:
        echo '音楽<br>';
        break;
      case 1:
        echo 'スポーツ<br>';
        break;
      case 2:
        echo '車<br>';
        break;
      case 3:
        echo 'アート<br>';
        break;
      case 4:
        echo '旅行<br>';
        break;
      case 5:
        echo 'カメラ<br>';
        break;
      case 6:
        echo '読書<br>';
        break;
      case 7:
        echo 'その他<br>';
        break;
    }
  }
  echo '</dd></dl>';
  
  //アンケート結果を保存するテキストファイルを指定 
  $file = './data/data.txt';
  
  //読み込み／書き出し用にオープン (r+) 'b' フラグを指定
  $fp = fopen($file, 'r+b');
  if(!$fp) {
    exit('ファイルが存在しないか異常があります');
  }
  // if(!flock($fp, LOCK_EX)){
  //   exit('ファイルをロックできませんでした');
  // }
  // EOF（最後） に達するまで fgets() で各行を読み出す 
  while(!feof($fp)) {
    $results[] = trim(fgets($fp));
  }
  
  if($gender == 1) $results[0] ++  ;  
  if($gender == 2) $results[1] ++  ;  
  
  $results[$age + 1] ++ ;  
  
  foreach($hobby as $value) {
    $results[$value + 10] ++ ;  
  }
  
  $results[18]  ++;  
  
  rewind($fp);
 
  foreach($results as $value) {
    fwrite($fp, $value . "\n");
  }
  
  fclose($fp);
  
  echo '<p class="message sucess">以上の内容を保存しました。<br>アンケートにご協力いただきありがとうございました！</p>';
  echo '<p class="message"><a href="read.php">集計結果ページへ</a></p>';
}else{
  echo '<p class="message error">恐れ入りますが<a href="input.php">アンケート入力ページ</a>に戻り、アンケートの項目全てにお答えください。</p>';
}
 
?>
