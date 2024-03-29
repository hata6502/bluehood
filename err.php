<?php
	include('/var/www/twiverse.php');
	catch_default(new Exception("TEST\nTEST2"));
	$s = [
		//'' => ['ja' => '', 'en' => '', ],
		'title' => ['ja' => 'トップページ', 'en' => 'Top Page', ],
		//'desc' => ['ja' => 'Twitterを活用したUniversalゲームコミュニティです。', 'en' => 'An universal game community on Twitter. ', ],
		'desc' => ['ja' => 'Twitter のイメージをつなげるコミュニティ。', 'en' => 'The community to link images on Twitter. ', ],
		'guide' => ['ja' => '利用ガイド', 'en' => "User's Guide", ],
		'contact' => ['ja' => '公式 Twitter', 'en' => "Admin's Twitter", ],
		'allposts' => ['ja' => 'すべての投稿', 'en' => 'All posts', ],
		'Q&A' => ['ja' => 'Ｑ＆Ａ', 'en' => 'Q &amp; A', ],
	];
?>

<!DOCTYPE html>
<html>
	<head>
		<style type="text/css">
			@media screen and (min-width: 766px){
				.header{
					text-align: center;
				}
				#header-wrapper{
					display: inline-block;
					text-align: left;
					width: 100%/*774px*/;
				}
				#header-left{
					margin-left: 5%;
				}
				#pen{
					float: right;
					width: 150px;
					margin-right: 5%;
					-webkit-filter: drop-shadow(2px 2px 2px rgba(0, 0, 0, 0.2));
				}
			}

			@media screen and (max-width: 765px){
				#header-wrapper{
					text-align: center;
				}
				#pen{
					display: none !important;
				}
				#banner{
					margin-right: auto;
					margin-left: auto;
				}
			}
		</style>
	</head>
	<?php head(); ?>
	<body>
		<h2 class="topbar"><?php l($s['title']); ?></h2>
		<div class="main">
			<div lang="ja" class="header">
				<div id="header-wrapper">
					<img id="pen" src="<?php echo ROOT_URL; ?>img/eyecatch.php" style="drop-shadow: ; ">
					<div id="header-left">
						<!--<img src="<?php echo ROOT_URL; ?>img/banner.php" alt="Twiverse" width="200px" onclick="window.amiibo.playAmiiboSE(); alert('Easter Egg! '); ">-->
						<table id="banner" onClick = "amiibo.playAmiiboSE(); amiibo.startSearchAmiibo(); alert('Your amiibo please! '); "><tr>
							<td><img src="<?php echo ROOT_URL; ?>img/twiverse.php" height="64px"></td>
							<td><img src="<?php echo ROOT_URL; ?>img/banner.php"></td>
						</tr></table>
						<p><?php l($s['desc']); ?></p>
						<a href="guide.php" class="linkbutton"><?php l($s['guide']); ?></a>
						<a href="https://peing.net/bluehood_admin" target="_blank" class="linkbutton"><?php l($s['Q&A']); ?></a>
						<a href="https://twitter.com/bluehood_admin" target="_blank" class="linkbutton"><?php l($s['contact']); ?></a>
						<div style="clear: both; "></div>
						お知らせ <a href="<?php echo ROOT_URL; ?>user/setting.php" class="linkbutton">ユーザー設定</a> の確認をお願いします。
					</div>
				</div>
			</div>
			<a href="<?php echo ROOT_URL; ?>view/" class="marginright" style="float: right; "><button><?php l($s['allposts']); ?></button></a>
			<?php if (useragent() == 'wiiu'){ ?>
				<span class="marginleft">Wii U限定！<a href="nfcbattler/">NFC Battler</a>であそぼう！</span>
			<?php } ?>
			<?php if ((useragent() == '3ds')||(useragent() == 'new3ds')){ ?>
				<span class="marginleft" style="font-size: small; ">ゲームメモを<a href="tweet/draw/gamememo/">コミック風</a>に！</span>
			<?php } ?>
			<div style="clear: both; "></div>
			<center>
<?php
				$twitter = twitter_reader();
				mysql_start();
				$collection = $twitter->get('collections/entries', ['id' => 'custom-'.ALL_POSTS, 'count' => '200']);

				$users = [];
				$show_i = 0;
				foreach($collection->response->timeline as $context){
		                        $status = $collection->objects->tweets->{$context->tweet->id};
					$status->user = $collection->objects->users->{$status->user->id};
					$status->sort_index = $context->tweet->sort_index;
					$res = mysql_fetch_assoc(mysql_query("select screen_name from tweet where id = ".$status->id));
					if (array_search($res['screen_name'], $users) === false) if (tweet($status, true, true)){
						array_push($users, $res['screen_name']);
						if (++$show_i >= MAX_TWEETS) break;
					}
				}

				echo '<div style="clear: both; "></div>';
				if (useragent() != '3ds') echo '<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';

				mysql_close();
			?>
			</center>
		</div>
		<script>
			$(window).on('AmiiboTagSearchStart', function(e){
			});
			$(window).on('AmiiboTagSearchCancel', function(e){
			});
			$(window).on('AmiiboTagDetected', function(e){
				var tag = customEvent.tag;
				//console.log(tag);
				if (tag.isRead){
					var type = ['normal', 'fire', 'water', 'electric', 'grass', 'ice', 'fighter', 'poison', 'ground', 'flight', 'esper', 'bug', 'stone', 'ghost', 'metal', 'fairy'];

					amiibo.playAmiiboSE();
					alert('This amiibo is "'+type[Number(tag.common.characterId)%type.length]+'" type(?). \n\nNFCリーダーを使った面白いゲームが作れそう！\nWii Uのブラウザでは、amiibo以外のNFCタグ (Suicaなど) も読み取ることができます。\nゲームの名前は、「NFC Battler」?' );
				}
			});
			$(window).on('AmiiboTagLost', function(e){
				amiibo.endSearchAmiibo();
				amiibo.startSearchAmiibo();
			});
		</script>
	</body>
</html>
