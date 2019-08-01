<?php
	include('/var/www/twiverse.php');
	//unset($_SESSION['collection_cursor']);
	twitter_start();

	$s = [
		'title' => ['ja' => "この画像を使う", 'en' => "Use This Image"], 
	];
?>

<!DOCTYPE html>
<html>
	<head>
	</head>
	<?php head(); ?>
	<body>
		<?php include(ROOT_PATH.'header.php'); ?>
		<h2 class="topbar"><?php l($s['title']); ?></h2>
		<div class="main" style="text-align: center; ">
			<a target="_blank" href="https://twitter.com/<?php echo htmlspecialchars($_SESSION['twitter']['account']['user']->screen_name); ?>/status/<?php echo htmlspecialchars($_GET['id']); ?>"><img src="<?php echo htmlspecialchars($_GET['img']); ?>" style="max-height: 70vh; max-width: 90%; -webkit-filter: drop-shadow(2px 2px 2px rgba(128, 128, 128, 0.4)); "></a><br>
			<a href="<?php echo ROOT_URL; ?>tweet/diary/?<?php echo http_build_query(['album' => $_GET['id'], 'entity_id' => $_GET['entity_id']]); ?>" class="a-disabled"><div class="card" style="display: inline-block; "><div class="card-article">つぶやきを投稿する</div></div></a>
			<a href="<?php echo ROOT_URL; ?>tweet/draw/?<?php echo http_build_query(['album' => $_GET['id'], 'entity_id' => $_GET['entity_id']]); ?>" class="a-disabled"><div class="card" style="display: inline-block; "><div class="card-article">お絵かきを投稿する</div></div></a>
			<a class="a-disabled" style="cursor: pointer; "><form id="addalbum" action="../addalbum.php" method="post" class="card" style="display: inline-block; ">
				<input name="id" type="hidden" value="<?php echo htmlspecialchars($_GET['id']); ?>">
				<div class="card-article" onclick="$(this).text('追加中…'); $(this).prop('onclick', ''); $('#addalbum').submit(); ">ツイートをアルバムに追加する</div>
	        </form></a>
		</div>
	</body>
</html>
