<?php
	$initcnt = 10;
?>
<html>
	<head>
		<script
		  src="https://code.jquery.com/jquery-3.3.1.min.js"
		  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		  crossorigin="anonymous"></script>
		<script>
$(() => {
	var cnt = <?php echo $initcnt; ?>;
	setInterval(() => {
		$("#counter").html(cnt.toString());
		cnt++;
	}, 1000);
});
		</script>
	</head>
	<body>
		<span id="counter"></span>
	</body>
</html>
