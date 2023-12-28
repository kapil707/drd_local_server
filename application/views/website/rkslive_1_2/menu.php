<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <style>
  .cut-text1 {
    display: inline-block;
    width: 100%;
    white-space: nowrap;
    overflow: hidden !important;
    text-overflow: ellipsis;
}
body{
	background-color: #000 !important;
}
a{
	color: #ffffff !important;
}
a:hover{
	color: #ffc107 !important;
}
.list-group li a{
	color: #111 !important;
}
  </style>
</head>
<body>
    <div class="container" style="margin-top:20px;">
		<ul class="list-group list-group-horizontal">
			<li class="list-group-item">
				<a href="<?= base_url();?>rkslive_1_2/home/<?=$android_id; ?>">Live Tv</a>
			</li>
			<li class="list-group-item">
				<a href="<?= base_url();?>rkslive_1_2/movies/<?=$android_id; ?>">Movies</a>
			</li>
			<li class="list-group-item">
				<a href="<?= base_url();?>rkslive_1_2/home/<?=$android_id; ?>">Web Series</a>
			</li>
		</ul>