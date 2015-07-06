<!DOCTYPE html>
<html dir="rtl" lang="fa-IR" prefix="og: http://ogp.me/ns#">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>تشخیص دهنده ساختار فارسی نسخه 0.1</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="js/html5.js"></script>
		<![endif]-->
		<link href="css/styles.css" rel="stylesheet">

	</head>
	<body>
	<div class="container-fluid">
		<nav class="navbar navbar-default navbar-fixed-top backcolor">
		  <div class="container">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="">آرم</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
			  <ul class="nav navbar-nav navbar-right">
				<li class="active"><a href="">خانه</a></li>
				<li><a href="#about">درباره ما</a></li>
				<li><a href="#contact">تماس با ما</a></li>
			<!--<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">منوی باز شونده <span class="caret"></span></a>
					<ul class="dropdown-menu rtl" role="menu">
						<li><a href="#">نمونه!</a></li>
							<li class="divider"></li>
						<li><a href="#">همه ی دسته ها</a></li>
					</ul>
				</li>-->
			  </ul>
			</div>
		  </div>
		</nav>

	<div class="row">
		<div class="col-sm-6 col-md-6 sidebar">
			<div class="panel panel-default">
				<div class="panel-heading backcolor" data-toggle="collapse" data-target="#collapse_1" aria-expanded="false" aria-controls="collapse_1"><span class="caret"></span> راهنما </div>
				<div class="panel-body collapse in" id="collapse_1">
					به علت زیاد بودن توضیحات شفاهی شرح داده خواهد شد.
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading backcolor" data-toggle="collapse" data-target="#collapse_2" aria-expanded="false" aria-controls="collapse_2"><span class="caret"></span> نتیجه </div>
				<div class="panel-body collapse in show" id="collapse_1"></div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<!-- form -->
			<form class="form-horizontal ajax-form rtl" action="run.php">
			<fieldset>
				<legend>تشخیص دهنده ساختار فارسی نسخه 0.1</legend>
				<div class="form-group">
				  <div class="col-md-12">
					<textarea class="form-control" rows="8" id="text" name="text" placeholder="متن را وارد نمایید."></textarea>
				  </div>
				</div>
				<div class="form-group">
				  <div class="col-md-12">
					<textarea class="form-control" id="textarea" name="dic" placeholder="در صورتی که تمایل دارید لغاتی را به برنامه اضافه کنید در این کادر وارد نمایید (لغات را با فاصله از هم جدا کنید)"></textarea>
				  </div>
				</div>
				<div class="form-group">
				  <div class="col-md-12">
					<button class="btn btn-success col-md-12">شروع بررسی</button>
				  </div>
				</div>
			</fieldset>
			</form>
		</div>
	</div>
	</div>
	<footer class="footer">
		<div class="container">
			<p class="text-muted text-center rtl" style="padding-top: 20px;">کپی رایت</p>
		</div>
	</footer>
	<!-- script references -->
		<script src="js/jquery-1.11.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script>
			$(document).on("submit", ".ajax-form", function() {
			  var form = $(this),
				  action = form.attr('action'),
				  method = form.attr('method'),
				  dataSerialize = form.serialize();
			   
			  var request = $.ajax({
				type: method,
				url: action,
				data: dataSerialize
			  });
			   
			  request.done(function(data) {
				if (data == 1)
					$('.show').html('اطلاعات ارسالی ناقص است.');
				else if (data == 2)
					$('.show').html('خطای نگارشی وجود دارد!');
				else
					$('.show').html(data);
			  });
			   
			  request.fail(function() {
				$('.show').html('در هنگام ارسال اطلاعات مشکلی روی داد.');
			  });
			   
			  return false;
			});
			function show(){
				$('#show').html('درحال فراخوانی');
				$.post(siteurl+'show.php/r:',	'uid=2'
				,function(data){
					$('#show').html(data);
				}); 
			}
		</script>
	</body>
</html>