<?php
	include('/var/www/twiverse.php');
	//unset($_SESSION['collection_cursor']);
	twitter_start();

	$s = [
		'title' => ['ja' => "あとから投稿", 'en' => "Past Images"], 
		'more' => ['ja' => "もっとみる", 'en' => "More"], 
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
		<div class="main">
		<div class="header">
			Twitter に投稿した画像を使用します。
		</div>
		<center>
		<?php try{
			$twitter = twitter_start();
			$query = ['user_id' => $_SESSION['twitter']['id'], 'count' => '200', 'trim_user' => 'true', 'exclude_replies' => 'false', 'include_rts' => 'false'];
			if (isset($_GET['i'])) $query['max_id'] = $_GET['i'];
			$statuses = twitter_throw($twitter->get('statuses/user_timeline', $query));
			$i = 0;
			$max_id = null;
			?><div><?php
				foreach($statuses as $status){
					if ($i>=MAX_TWEETS) break;
					foreach ($status->extended_entities->media as $j => $media){
						if ($i>=MAX_TWEETS) break;
						?><div style="display: inline-block; width: 240px; text-align: center; margin: 0 0.5em; "><?php
							echo '<a href="action.php?'.http_build_query(['id' => $status->id_str, 'entity_id' => $j, 'img' => $media->media_url_https]).'"><img src="'.$media->media_url_https.':small"class="card" style="max-width: 240px; vertical-align: top; "></a>';
						?></div><?php
						$i++;
					}
					$max_id = $status->id_str;
				}
			?></div><?php
			if ($max_id){
				// 次ページでは前ページの最後のツイートを先頭に含める。
				?><a href="?<?php echo http_build_query([i => $max_id]); ?>"><button><?php l($s['more']); ?></button></a><?php
			}
		}catch(Exception $e){ catch_default($e); } ?>
		</center>
		</div>
	</body>
</html>
