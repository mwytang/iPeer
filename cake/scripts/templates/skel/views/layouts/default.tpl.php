<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>CakePHP : <?php echo $title_for_layout;?></title>
<link rel="shortcut icon" href="<?php echo $html->url('/favicon.ico')?>" type="image/x-icon" />
<?php echo $html->css('generic.basic');?>
<?php echo $html->css('generic.forms');?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1>CakePHP Rapid Development</h1>
		</div>
		<div id="content">
			<?php if ($this->controller->Session->check('Message.flash'))
					{
						$this->controller->Session->flash();
					}
					echo $content_for_layout;
			?>
		</div>
		<div id="footer">
			&nbsp;
			<a href="http://www.cakephp.org/" target="_new">
				<?php echo $html->image('cake.power.png', array('alt'=>"CakePHP : Rapid Development Framework", 'border'=>"0"));?>
			</a>
		</div>
	</div>
</body>
</html>