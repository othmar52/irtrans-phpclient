<?php

require_once('class.remotecontrol.php');

$remotecontrol = new remotecontrol();

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>HiFi Control</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet">
    
    <!-- TODO: only local requests -->
    <!-- http://fortawesome.github.io/Font-Awesome/icons/#web-application -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    

	<link href="vendor/bootstrap-notify/css/bootstrap-notify.css" rel="stylesheet">


    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">HiFi</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
        <?php
		echo $remotecontrol->renderNavigation();
        
		
		?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

      <div class="starter-template">
        <!--h1>Bootstrap starter template</h1>
        <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p-->
        
        <?php

			echo $remotecontrol->renderDeviceButtons();
		?>
        
        
      </div>

    </div><!-- /.container -->
    
    
    <div class='notifications bottom-left'></div>
    
    


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- TODO: only local requests -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/1.4.3/jquery.scrollTo.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="vendor/bootstrap-notify/js/bootstrap-notify.js"></script>
    
    <script type="text/javascript">
    	$(document).ready(function(){
    		$('.scrollto').on('click', function(){
    			// TODO: hide nav only in mobile view
    			$(".navbar-toggle").click();
    			$.scrollTo($($(this).attr('href')).offset().top-50, 200);
    		});
    		$('.fire').on('click', function(){
    			fireCmd($(this).attr('data-remote'), $(this).attr('data-cmd'), $(this).attr('data-type'));
    			return false;
    		})
    	});
    	
    	function fireCmd(device, cmd, type) {
    		$.ajax({
				url: 'ajax.php',
				data: {
					remote: device,
					cmd: cmd,
					type: type
				}
			}).done(function(response){
				//$('#status').text(response);
	    		$('.bottom-left').notify({
				    message: { text: 'OK: ' + response},
					fadeOut: { enabled: true, delay: 500 }
				}).show();
			}).fail(function(){
				//$('#status').text('FAILED');
	    		$('.bottom-left').notify({
				    message: { text: 'FAILED: ' + response}
				}).show();
			});
			return false;
			
			

    		
    	}
    	
    </script>
  </body>
</html>
