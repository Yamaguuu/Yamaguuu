<html>
	<head>
    	<meta charset="utf-8">
	</head>

	<body>

【 みんなの掲示板 】<br>
自由に書き込んでください。<br>
※投稿時に設定するパスワードは削除・編集時に使います。<br>
<br>

<?php
// 編集フォームが空欄のとき(定義づけ)
	$edit_name = "名前";
	$edit_comment = "コメント";
	$edit_number = "";

//【編集機能 (mission3-4) <第一段階>】
	if(!empty($_POST["edit"]) && !empty($_POST["edit_pass"])){ //編集,パスワードのフォームが空欄ではないとき
	$filename = "mission_3-5.txt";
	$lines = file( $filename );
	$fp = fopen( $filename , "r+" ); //読み込み/書き込みモード
		foreach( $lines as $data ){
		$foo = explode( "<>" , $data );
			if($_POST["edit"] !== $foo[0]){ //編集フォームの番号と行番号が不一致
			}
				elseif($_POST["edit"] == $foo[0] && $_POST["edit_pass"] == $foo[4]){ //編集番号と行番号が一致,かつパスワードが一致したら変数取得
				$edit_name = $foo[1];
				$edit_comment = $foo[2];
				$edit_number = $foo[0]; 
				}
		}
	fclose($fp);
	}
?>


		<form action="mission_3-5.php" method="POST">

			<input type="text" name="name" placeholder="<?php echo $edit_name; ?>"><br>
			<input type="text" name="comment" placeholder="<?php echo $edit_comment; ?>"><br>
			<input type="text" name="pass" placeholder="パスワード"><br>

			<input type="hidden" name="edit_number" value="<?php echo $edit_number; ?>">

			<input type="submit" value="送信"><br>

		 <p><input type="text" name="delate" placeholder="削除対象番号"><br>
			<input type="text" name="delate_pass" placeholder="パスワード"><br>
			<input type="submit" value="削除">

			<p><input type="text" name="edit" placeholder="編集対象番号"><br>
			<input type="text" name="edit_pass" placeholder="パスワード"><br>
			<input type="submit" value="編集">

		</form>

	</body>
</html>

<?php

//【 投稿機能 (mission3-1.2) 】
	if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass"]) && empty($_POST["edit_number"])){  //名前,コメント,パスワードのフォームが空欄ではないとき
	// 投稿番号取得コード
	$filename = "mission_3-5.txt";
	$fp = fopen($filename , "a+");  //txtファイルの書き込み準備、追記/作成モード
	$hairetu = array();
		if( $fp ){
			while ($moji = fgets( $fp )){
			array_push( $hairetu , $moji );
			}
		}
	$num = end( $hairetu );
	$num = explode( "<>" , $num );
	$num = (int)$num[0] + 1;
	// ここまで投稿番号取得コード
	$data = $num . "<>" . $_POST["name"] . "<>" . $_POST["comment"] . "<>" . date("Y/m/d H:i:s") . "<>" . $_POST["pass"] . "<>" .  "\n"; 
	fwrite( $fp , $data );  //行内容をファイルに書き込む
	fclose( $fp );  //ファイルを閉じる
	}elseif(!empty($_POST["name"]) && !empty($_POST["comment"]) && empty($_POST["pass"]) && empty($_POST["edit_number"])){ //パスワードが未入力のとき
	echo 'パスワードが入力されていません。<br>';
	}


//【編集機能 (mission3-4) <第二段階>】
	if(!empty($_POST["edit_number"])){ //編集フォームが空欄ではないとき
	$filename = "mission_3-5.txt";
	$lines = file( $filename );  
	$fp = fopen( $filename , "w" );
		foreach( $lines as $data ){ 
		$foo = explode( "<>" , $data );
			if($_POST["edit_number"]  == $foo[0]){ //編集番号と行番号が一致したとき→編集フォームから送信された値と差し替えて上書き
				$edit_number = $_POST["edit_number"];
				fwrite( $fp , $edit_number . "<>" . $_POST["name"] . "<>" . $_POST["comment"] . "<>" . date("Y/m/d H:i:s") . "<>" . $_POST["pass"] . " <>" . "\n" );
			}else{
				fwrite( $fp , $data ); //それ以外の時はそのまま書き込む
			}
		}
	fclose( $fp );
	$foo = $edit_number;
	}

	if(!empty($_POST["edit"]) && empty($_POST["edit_pass"])){ //パスワードが未入力のとき
	echo '編集するにはパスワードが必要です。<br>';
	}


//【 削除機能 (mission3-3) 】
	if(!empty($_POST["delate"]) && !empty($_POST["delate_pass"])){  //削除,パスワードのフォームが空欄ではないとき
	$filename = "mission_3-5.txt";
	$lines = file( $filename );  //txtファイルの中身を読み込む
	$fp = fopen( $filename , "w" );  //ファイルの書き込み準備、ファイルの中身を空に
		foreach( $lines as $data ){  //ループ開始 : txtファイルの中身を1行ずつ走査
		$foo = explode( "<>", $data );  //行を<>で区切る
			if($_POST["delate"] !== $foo[0]){  //削除番号と行番号が不一致のとき
			fwrite( $fp , $data );  
			}elseif($_POST["delate_pass"] !== $foo[4]){ //パスワードが不一致のとき
			fwrite( $fp , $data ); //書き込む
			echo 'パスワードが違います。<br>';
			}
		}  //ループ終了
	fclose( $fp ); 
	}elseif(!empty($_POST["delate"]) && empty($_POST["delate_pass"])){ //パスワードが未入力のとき
	echo '削除するにはパスワードが必要です。<br>';
	}


//【 表示機能 】
	$filename = "mission_3-5.txt";
	$lines = file( $filename );
		foreach( $lines as $data ){
		$foo = explode( "<>" , $data ); 
		echo "$foo[0] $foo[1] $foo[2] $foo[3]<br>";
		}


?>