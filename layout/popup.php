<!DOCTYPE HTML>

<head>
<title>mkKanban</title>
<link rel="stylesheet" type="text/css" href="css/main.css?v=1" media="screen" />
<script src="js/main.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<style>
.main .content{
border:0px;
}
body,.tb_edit,form{
background:<?php echo $this->color?>;
}
.input input,.input textarea{
width:200px;
}
</style>
</head>
<body>

<div class="main"  style="width:100%;margin:0px;padding:0px;">
	<div style="width:100%;margin:0px;padding:0px;" class="content">
		<?php echo $this->load('main') ?>
	</div>
</div>

</body>
</html>
