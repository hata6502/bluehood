<?php
	include('/var/www/twiverse.php');
	$conn = twitter_start();

	include('../front.php');
?>
<!DOCTYPE html>
<html lang = "ja">
	<?php head(); ?>
	<head>
		<link rel = "stylesheet" type = "text/css" href = "diary.css">
		<?php if (useragent() != '3ds'){ ?><script src="<?php echo ROOT_URL; ?>twitter-text-2.0.2.min.js"></script><?php } ?>
	</head>
	<body>
		<div id="title" class="topbar">つぶやきの投稿</div>
		<div class="main paddingleft paddingright" style="text-align: center; "><div id="main-wrapper" style="display: inline-block; text-align: left;">
                        <div style="float: left;">
				<div style="font-size: small; ">スクリーンショットはコミュニティのバナーになります。</div>
				<br>
				<div id="reply"></div>
				<form id="imgform" action="../thumbup.php" method="post" enctype="multipart/form-data" target="imgform_send">
					<input id="selimg" name="selimg" type="file" accept="image/*">
				</form>
                        </div>
                        <img id="thumb" height="96px" src="../noimage.jpg">
			<div style="clear: both; "></div>
			<form id="sendform" action="send.php" method="post">
				<input type="text" name="dummy" style="position:absolute;visibility:hidden">
				<center>
				<div id="suggest" style="width: 100%; text-align: left; "></div>
				<textarea id="text" name="text" rows="4" placeholder="#ハッシュタグ @返信先" style="width: 100%; "></textarea>
				<div style="width: 100%; ">
					<input id="send" type="button" value="ツイート" style="float: left; ">
					<?php if (useragent() != '3ds'){ ?><span id="count" style="float: right; ">0 / 280</span><?php } ?>
				</div>
				</center>
			</form>
		</div></div>
		<script>$('#main-wrapper').width($('.main').width()*0.8);</script>
		<iframe name="imgform_send" style="width:0px;height:0px;border:0px;"></iframe>
		<script type="text/javascript" src="../common.js"></script>
		<script type="text/javascript" src="diary.js"></script>
	</body>
</html>
