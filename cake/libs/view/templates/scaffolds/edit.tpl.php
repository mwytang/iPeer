<?php
/* SVN FILE: $Id: edit.tpl.php,v 1.3 2006/06/20 18:46:46 zoeshum Exp $ */

/**
 * Base controller class.
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
 * @subpackage		cake.cake.libs.view.templates.scaffolds
 * @since			CakePHP v 0.10.0.1076
 * @version			$Revision: 1.3 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2006/06/20 18:46:46 $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */

$modelName = ucwords(Inflector::singularize($this->name));
$modelKey = $modelName;
if(is_null($this->plugin))
{
	$path = '/';
}
else
{
	$path = '/'.$this->plugin.'/';
}

?>
<h1><?php echo $type.' '.Inflector::humanize($modelName);?></h1>

<?php
if($type == 'Edit')
{
	echo $html->formTag($path . Inflector::underscore($this->name) .'/update');
}
else
{
	echo $html->formTag($path. Inflector::underscore($this->name).'/create');
}
echo $form->generateFields( $fieldNames );
echo $form->generateSubmitDiv( 'Save' )
?>
</form>
<ul class='actions'>
<?php
if($type == 'Edit')
{
	echo "<li>".$html->link('Delete  '.Inflector::humanize($modelName), $path.$this->viewPath.'/delete/'.$data[$modelKey][$this->controller->{$modelName}->primaryKey])."</li>";
}
echo "<li>".$html->link('List  '.Inflector::humanize($modelName), $path.$this->viewPath.'/index')."</li>";
if($type == 'Edit')
{
	foreach($fieldNames as $field => $value)
	{
		if(isset($value['foreignKey']))
		{
			echo "<li>".$html->link( "View ".Inflector::humanize($value['controller']), $path.Inflector::underscore($value['controller'])."/show/".$data[$modelKey][$field] )."</li>";
		}
	}
}
?>
</ul>