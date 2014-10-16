<?php include 'metadata.php'?>
<body>
<div class="testing">
<?php include 'header.php'?>
<?php include 'user.php'?>
</div>
<?php include 'nav.php'?>
<section class="content">
	<section class="widget" style="min-height:300px">
		<header>
			<span class="icon">&#59160;</span>
			<hgroup>
				<h1>Blog</h1>
				<h2>Create new blog page</h2>
			</hgroup>
		</header>
		<div class="content">
			<div class="field-wrap">
				<input type="text" name="title" placeholder="Title"/>
			</div>
			<div class="field-wrap">
				<input type="text" name="author" placeholder="Author"/>
			</div>
			<div class="field-wrap">
				<input type="text" name="tags" placeholder="Tags"/>
			</div>
			<div class="field-wrap wysiwyg-wrap">
				<textarea class="post" rows="5"></textarea>
			</div>
			<button type="submit" class="green">Post</button>
			<button type="submit" class="">Preview</button>
		</div>
	</section>
</section>
<?php include 'footer.php'?>
</body>
</html>