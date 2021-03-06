<?php
/* SVN FILE: $Id: home.tpl.php,v 1.3 2006/06/20 18:46:45 zoeshum Exp $ */

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
 * @subpackage		cake.cake.libs.view.templates.pages
 * @since			CakePHP v 0.10.0.1076
 * @version			$Revision: 1.3 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2006/06/20 18:46:45 $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<p style="background:#DBA941;padding:4px;font-size: 16px;">Your database configuration file is <?php echo  file_exists(CONFIGS.'database.php') ?' present.' . $filePresent = ' ' : ' not present.'; ?></p>
<?php if (!empty($filePresent)):?>
<?php $db = ConnectionManager::getInstance(); ?>
<?php $connected = $db->getDataSource('default'); ?>
<p style="background:#DBA941;padding:4px;font-size: 16px;">Cake<?php echo $connected->isConnected() ? ' is able to' : ' is not able to';?> connect to the database.</p>
<br />
<?php endif; ?>     
<h2>CakePHP release information is on CakeForge</h2>
<a href="http://cakeforge.org/projects/cakephp">Read the release notes and get the latest version</a>

<h2>Editing this Page</h2>
<p>
To change the content of this page, create: /app/views/pages/home.tpl.php.<br />
To change its layout, create: /app/views/layouts/default.tpl.php.<br />
<a href="http://wiki.cakephp.org/tutorials:sample_layout">See the wiki for more info</a><br />
You can also add some CSS styles for your pages at: app/webroot/css/.
</p>
<h2>More about Cake</h2>
<p>
CakePHP is a rapid development framework for PHP which uses commonly known design patterns like
Active Record, Association Data Mapping, Front Controller and MVC.
</p>
<p>
Our primary goal is to provide a structured framework that enables PHP users at all levels
to rapidly develop robust web applications, without any loss to flexibility.
</p>
<ul>
	<li><a href="http://www.cakefoundation.org/">Cake Software Foundation</a>
	<ul><li>Promoting development related to CakePHP</li></ul></li>
	<li><a href="http://www.cafepress.com/cakefoundation">CakeSchwag</a>
	<ul><li>Get your own CakePHP gear - Doughnate to Cake</li></ul></li>
	<li><a href="http://www.cakephp.org">CakePHP</a>
	<ul><li>The Rapid Development Framework</li></ul></li>
	<li><a href="http://manual.cakephp.org">CakePHP Manual</a>
	<ul><li>Your Rapid Development Cookbook</li></ul></li>
	<li><a href="http://wiki.cakephp.org">CakePHP Wiki</a>
	<ul><li>The Community for CakePHP</li></ul></li>
	<li><a href="http://api.cakephp.org">CakePHP API</a>
	<ul><li>Docblock Your Best Friend</li></ul></li>
	<li><a href="http://www.cakeforge.org">CakeForge</a>
	<ul><li>Open Development for CakePHP</li></ul></li>
	<li><a href="https://trac.cakephp.org/">CakePHP Trac</a>
	<ul><li>For the Development of CakePHP (Tickets, SVN browser, Roadmap, Changelogs)</li></ul></li>
	<li><a href="http://groups-beta.google.com/group/cake-php">CakePHP Google Group</a>
	<ul><li>Community mailing list</li></ul></li>
	<li><a href="irc://irc.freenode.net/cakephp">irc.freenode.net #cakephp</a>
	<ul><li>Live chat about CakePHP</li></ul></li>
</ul>