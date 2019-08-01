<?php
	include('/var/www/twiverse.php');
	include('common.php');

	$s = [
		'notfound' => ['ja' => "コミュニティが存在しません。", 'en' => "The community was not found. ", ],
		'requirement' => [
			'ja' => "コミュニティに投稿するには、スクリーンショットを添付する必要があります。",
			'en' => "To post this community, please attach screenshot. ",
		],
		//'' => ['ja' => "", 'en' => ""],
	];

	unset($_SESSION['post_image']);

	/* アルバム */
    echo '<script> var detect = undefined; </script>';
	if (isset($_GET['album'])){
		$detect = detect('', $_GET['album'], (int)$_GET['entity_id']);
		?><script>detect = JSON.parse('<?php echo json_encode($detect); ?>'); </script><?php
	}
	
	/* 下書き */
    echo '<script>var draft_draw = undefined; </script>';
	mysql_start();
    $res = mysql_fetch_assoc(mysql_query("select draft_draw from user where id=".$_SESSION['twitter']['id']));
    if (!empty($res['draft_draw'])) echo '<script>draft_draw = "'.$res['draft_draw'].'"; </script>';
    mysql_close();
?>
