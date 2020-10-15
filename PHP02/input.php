<html>
<head>
    <meta charset="utf-8">
    <title>PHP課題（アンケート）</title>
</head>
<h3>記入項目</h3>
<body>
    <form action="write.php" method="post">
        お名前: <input type="text" name="name">
        EMAIL: <input type="text" name="mail">
        <div>
<p>性別</p>
  <input type="radio" name="gender" id="male" value="1">
    <label for="male"> 男性 </label>  
  <input type="radio" name="gender" id="female"  value="2">
    <label for="female"> 女性 </label>  
</div>
<div>
<label for="age"> 年齢 </label>
<select name="age" id="age">
<option value="0" selected>選択してください。</option>
<?php
for($num = 1; $num <= 7; $num++) {
  echo '<option value="' . $num . '">' . $num . '0代</option>' . "\n";
}
?>
<option value="8">80代以上</option>
</select>
</div>
<div>
<p>趣味</p>
<?php
$hobby = array(0 => "音楽",
               1 => "スポーツ",
               2 => "車",
               3 => "アート",
               4 => "旅行",
               5 => "カメラ",
               6 => "読書",
               7 => "その他");
$ids = array('music', 'sport', 'car', 'art', 'travel', 'camera', 'book', 'other');
foreach($hobby as $key => $value) {
  echo '<label for="' . $ids[$key] .'"><input type="checkbox" name="hobby[]" value="' 
  .$key . '" id="' . $ids[$key] . '">' . $value . '</label>' . "\n";
}
 
?>
</div>
<div>
<input type="submit" >
</div>
</form>
</html>
