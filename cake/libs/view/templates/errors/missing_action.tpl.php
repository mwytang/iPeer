<?php
/* SVN FILE: $Id: missing_action.tpl.php,v 1.3 2006/06/20 18:46:43 zoeshum Exp $ */

/**
 *
 *
 *
 *
 * PHP versions 4 and 5
 *
 * CakePHP :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright (c)	2006, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright (c) 2006, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP Project
 * @package			cake
 * @subpackage		cake.cake.libs.view.templates.errors
 * @since			CakePHP v 0.10.0.1076
 * @version			$Revision: 1.3 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2006/06/20 18:46:43 $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>

<h1>Missing Method in <?php echo $controller;?></h1>

<p class="error">You are seeing this error because the action <em><?php echo $action;?></em>
  is not defined in controller <em><?php echo $controller;?></em>
</p>


<p>
<span class="notice"><strong>Notice:</strong> this error is being rendered by the <strong>app/views/errors/missing_action.tpl.php</strong>
view file, a user-customizable error page for handling invalid action dispatches.</span>
</p>

<p>
<strong>Fatal</strong>: Create Method:
</p>
<p>&lt;?php<br />
&nbsp;&nbsp;&nbsp;&nbsp;class <?php echo $controller;?> extends AppController<br />
&nbsp;&nbsp;&nbsp;&nbsp;{<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;function <?php echo $action;?>()<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{<br /><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}<br />
&nbsp;&nbsp;&nbsp;&nbsp;}<br />
?&gt;<br />
</p>
<p>
in file : <?php echo "app".DS."controllers".DS.Inflector::underscore($controller).".php"; ?>
</p>

<p>
<strong>Error</strong>: Unable to execute action <em><?php echo $action;?></em> in
<em><?php echo $controller;?></em>
</p>