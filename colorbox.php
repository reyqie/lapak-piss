<!DOCTYPE html>
<html>
  <head>
    <meta charset=utf-8 />
    <title>ColorBox demo</title>
    <link rel="stylesheet" href="colorbox.css" />
  </head>
  <body>
    <h1>Hello, there!</h1>
    <h2>This is some content</h2>
    <p>The popup will open in five seconds</p>

    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.colorbox.js"></script>
    <script>
		function openColorBox(){
			$.colorbox({iframe:true, width:"80%", height:"80%", href: "modal_deadline.php"});
		}
		setTimeout(openColorBox, 500);
    </script>
  </body>
</html>