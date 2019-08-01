<?php
	include('/var/www/twiverse.php');
	//unset($_SESSION['collection_cursor']);
	twitter_start();

	$s = [
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
		<h2 class="topbar">アルバム</h2>
		<div class="main">
			<div class="header">
				アルバムに登録した画像を使用します。アルバムに画像を登録するには、「あとから投稿」より画像を選択し「ツイートをアルバムに追加する」をタップ！
			</div>
			<center><?php try{
        		if (isset($_SESSION['twitter']['account']['album_id'])){
				$twitter = twitter_start();
				$query = ['id' => $_SESSION['twitter']['account']['album_id'], 'count' => MAX_TWEETS];
				if (isset($_GET['i'])) $query['max_position'] = $_GET['i'];
				$collection = twitter_throw($twitter->get('collections/entries', $query));
        			if (!empty($collection->response->timeline)){
				        $show_i = 0;
						?> <div> <?php
	        	        	foreach($collection->response->timeline as $context){
        	        			if ($show_i>=MAX_TWEETS) break;
	        	        		$status = $collection->objects->tweets->{$context->tweet->id};
	        	        		foreach ($status->extended_entities->media as $j => $media){
	        	        			if ($show_i>=MAX_TWEETS) break;
									echo '<div style="display: inline-block; width: 240px; text-align: center; margin: 0 0.5em; "><a href="action.php?'.http_build_query(['id' => $status->id_str, 'entity_id' => $j, 'img' => $media->media_url_https]).'"><img src="'.$media->media_url_https.':small" class="card" style="max-width: 240px; vertical-align: top; "></a></div>';
									$show_i++;
	        	        		}
								$sort_index = $context->tweet->sort_index;
	        	        	}
						?> </div> <?php
								// 次ページでは前ページの最後のツイートを先頭に含める。
	        	        		if ($show_i >= MAX_TWEETS){ ?>
							<a href="?<?php echo http_build_query([i => $sort_index]); ?>"><button><?php l($s['more']); ?></button></a>
						<?php }
					}else{
						echo 'アルバムにツイートが登録されていません。';
					}
        		}else{
        			echo 'アルバムがありません。';
        		}
		}catch(Exception $e){ catch_default($e); } ?></center>
		</div>
	</body>
</html>
