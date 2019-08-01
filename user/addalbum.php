<?php
	include('/var/www/twiverse.php');

	$tmp_name = null;
	try{
		if (!ctype_digit($_POST['id'])) die('ツイートが選択されていません。');
		$id_str = (string)$_POST['id'];
	
	    $conn = twitter_start();
		if (!isset($_SESSION['twitter']['account']['album_id'])){
			// アルバム作成
			$collection = twitter_throw($conn->post('collections/create', ['name' => 'Twiverse_album']));
			$_SESSION['twitter']['account']['album_id'] = $collection->response->timeline_id;
			mysql_start();
			mysql_throw(mysql_query("update user set album_id=".str_replace('custom-', '', $_SESSION['twitter']['account']['album_id'])." where id=".$_SESSION['twitter']['id']));
			mysql_close();
		}
		twitter_throw($conn->post('collections/entries/add', ['id' => $_SESSION['twitter']['account']['album_id'], 'tweet_id' => $id_str]));
	
		header('location: '.DOMAIN.ROOT_URL.'user/album/');
	}catch(Exception $e){
		catch_default($e);
	}
?>