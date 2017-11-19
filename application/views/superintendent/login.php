<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>
	<title>Superintendent | KMS PT Titis Sampurna</title>
		<meta charset="utf-8">
		<link href="<?php echo base_url();?>asset/style/login.css" rel='stylesheet' type='text/css' />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="Administrator Knowledge Management Systems PT Titis Sampurna" />
	    <meta name="author" content="Ayu Zahrah Humairoh" />
        <link rel="icon" href="<?php echo base_url(); ?>asset/image/favicon.ico" />        
		<!--webfonts-->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:600italic,400,300,600,700' rel='stylesheet' type='text/css'>
		<!--//webfonts-->
</head>
<body>
	 <!-----start-main---->
	 <div class="main">
		<div class="login-form">
			<h1>Knowledge Management System<br/>PT Titis Sampurna</h1>
			<div class="head">
                <img src="<?php echo base_url(); ?>asset/image/logo_login.png" alt=""/>
			</div>
                <form action="<?php echo base_url();?>superintendent_login/login_action" method="post">
			         <input type="text" class="text" name="ktp" value="No. KTP" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'No. KTP';}" />
			         <input type="password" name="password" value="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}" />
			         <div class="submit">
			             <input type="submit" onclick="myFunction()" value="LOGIN" />
                     </div>	
                     <p>Halaman Superintendent</p>
				</form>
			</div>
			<!--//End-login-form-->
		</div>
			 <!-----//end-main---->
		 		
</body>
</html>