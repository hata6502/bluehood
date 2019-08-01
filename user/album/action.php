<?php
	include('/var/www/twiverse.php');
	//unset($_SESSION['collection_cursor']);
	twitter_start();
?>

<!DOCTYPE html>
<html>
	<head>
	</head>
	<?php head(); ?>
	<body>
		<?php include(ROOT_PATH.'header.php'); ?>
		<h2 class="topbar">アルバムを使う</h2>
		<div class="main" style="text-align: center; ">
			<a target="_blank" href="https://twitter.com/<?php echo htmlspecialchars($_SESSION['twitter']['account']['user']->screen_name); ?>/status/<?php echo htmlspecialchars($_GET['id']); ?>"><img src="<?php echo htmlspecialchars($_GET['img']); ?>" style="max-height: 70vh; max-width: 90%; -webkit-filter: drop-shadow(2px 2px 2px rgba(128, 128, 128, 0.4)); "></a><br>
			<a href="<?php echo ROOT_URL; ?>tweet/diary/?<?php echo http_build_query(['album' => $_GET['id'], 'entity_id' => $_GET['entity_id']]); ?>" class="a-disabled"><div class="card" style="display: inline-block; "><div class="card-article">つぶやきを投稿する</div></div></a>
			<a href="<?php echo ROOT_URL; ?>tweet/draw/?<?php echo http_build_query(['album' => $_GET['id'], 'entity_id' => $_GET['entity_id']]); ?>" class="a-disabled"><div class="card" style="display: inline-block; "><div class="card-article">お絵かきを投稿する</div></div></a>
			<div class="card" style="display: inline-block; cursor: pointer; " onclick="if (confirm('よろしいですか？')) window.location = 'remove.php?<?php echo http_build_query(['id' => $_GET['id']]); ?>'; "><div class="card-article">ツイートをアルバムから外す</div></div>
		</div>
	</body>
</html>
