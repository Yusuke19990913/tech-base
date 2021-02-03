<?php
$dsn = 'データベース名';
$user = 'ユーザ名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

$sql = "CREATE TABLE IF NOT EXISTS tbtest"
    . " ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "pass TEXT"
    . ");";
$stmt = $pdo->query($sql);


if ($_POST["edit"]) {
    $id = $_POST["number"]; //変更する投稿番号
    $sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row) {
        if ($row['id'] == $id) {
            if ($row['pass'] == $_POST["pass3"]) {
                $namee = $row['name'];
                $commentt = $row['comment'];
                $passs = $row['pass'];
            }
        }
    }
}



if (($_POST["submit1"])) {
    if (empty($_POST['edit_n'])) {
        $sql = $pdo->prepare("INSERT INTO tbtest (name, comment , pass) VALUES (:name, :comment, :pass)");
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql->bindParam(':pass', $pass, PDO::PARAM_STR);
        $name = $_POST['namae'];
        $comment = $_POST['comment'];
        $pass = $_POST['pass1'];
        $sql->execute();
    } else {
        $id = $_POST["edit_n"];
        $name = $_POST['namae'];
        $comment = $_POST['comment'];
        $pass = $_POST['pass1'];
        $sql = 'UPDATE tbtest SET name=:name,comment=:comment, pass=:pass WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}


if ($_POST["submit2"]) {
    $id = $_POST["delete"];
    $pass = $_POST["pass2"];
    $sql = 'delete from tbtest where id=:id AND pass=:pass';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
    $stmt->execute();
    }







?>
<html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>mission_5-1</title>
</head>

<body>
    <fieldset>

        <form method="post">

            新規投稿フォーム<br>
            名前 <input type="text" name="namae" value="<?php echo $namee; ?>"><br>
            コメント<input type="text" name="comment" value="<?php echo $commentt; ?>"><br>
            パスワード<input type="text" name="pass1" value="<?php echo $passs; ?>">
            <input type="submit" name="submit1" value="送信"><br>
            <input type="hidden" name="edit_n" value="<?php echo $_POST["number"]; ?>">
        </form>

        <form method="post">
            削除フォーム<br>
            <input type="number" name="delete" placeholder="削除したい番号を記入してください">
            パスワード<input type="text" name="pass2">
            <input type="submit" name="submit2" value="削除">
        </form>



        <form action="" method="POST">
            編集フォーム<br>
            <input type="number" name="number" value="" placeholder="編集したい番号を入力">
            パスワード<input type="text" name="pass3">
            <input type="submit" name="edit" value="送信">

        </form>
    </fieldset>
</body>

</html>

<?php
$sql = 'SELECT * FROM tbtest';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row) {
    //$rowの中にはテーブルのカラム名が入る
    echo $row['id'] . ',';
    echo $row['name'] . ',';
    echo $row['comment'] . '<br>';
    echo "<hr>";
}
?>