<?php
	include('/var/www/twiverse.php');

	try{
		if (!ctype_digit($_GET['id'])) die('ツイートが選択されていません。');
		$id_str = (string)$_GET['id'];
		
		$twitter = twitter_start();
		twitter_throw($twitter->post('collections/entries/remove', ['id' => $_SESSION['twitter']['account']['album_id'], 'tweet_id' => $id_str]));
		header('location: '.DOMAIN.ROOT_URL.'/user/album/');
	}catch(Exception $e){
		catch_default($e);
	}
?>

