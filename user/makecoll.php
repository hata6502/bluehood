<?php
	include('/var/www/twiverse.php');

	try{
	    $conn = twitter_start();
		$collection = $conn->post('collections/create', ['name' => 'Twiverse']);
		$_SESSION['twitter']['account']['collection_id'] = $collection->response->timeline_id;
		mysql_start();
		mysql_throw(mysql_query("update user set collection_id=".str_replace('custom-', '', $_SESSION['twitter']['account']['collection_id'])." where id=".$_SESSION['twitter']['id']));
		mysql_close();
		header('Location: '.DOMAIN.ROOT_URL.'user/');
	}catch(Exception $e){
		catch_default($e);
	}
?>
