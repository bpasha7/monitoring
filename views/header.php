<html>
<head>
    <meta charset="UTF-8">
    <title>
        Monitoring devices
    </title>
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/menu.css">
    <script type="text/javascript" src="<?php echo URL; ?>public/scripts/jquery-2.2.4.js">
    </script>
    <script type="text/javascript" src="<?php echo URL; ?>public/scripts/jquery.form.js">
    </script>
    <script type="text/javascript" src="<?php echo URL; ?>public/scripts/jquery-ui.js">
    </script>
   <!--  <script src="<?php echo URL; ?>public/scripts/general.js">
    </script>
    <script src="<?php echo URL; ?>public/scripts/dashboard.js">
    </script>
       <script src="<?php echo URL; ?>views/dashboard/scripts/default.js"></script>-->
    <!--<?php
    /* if(isset($this->js)) {
    foreach($this->js as $js) {
    echo '<script src="'.URL.'views/'.$js.'"></script>';
    }
    }*/
    ?>-->
    <base href="http://monitoring.dev/">
</head>
<body>
<div id="menu">
<ul >
  <li ><a href="monitor/on">Moninor</a></li>
  <li ><a href="Plans">Plans</a></li>
  <li ><a href="">Devices</a>
  				<ul>
					<li><a href="device/create">New</a></li>
					<li><a href="device/edit">Edit</a></li>
				</ul>
  </li>
  <li><a href="#about">About</a></li>
</ul>
</div>

