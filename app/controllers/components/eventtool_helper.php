<?php
/* SVN FILE: $Id: evaluation_helper.php,v 1.1 2006/06/20 18:44:15 zoeshum Exp $ */
/*
 *
 *
 * @author
 * @version     0.10.5.1797
 * @license		OPPL
 *
 */
class EventtoolHelperComponent extends Object  
{
  function checkEvaluationToolInUse($evalTool=null, $templateId=null)
  {
    //Get the target event
    $this->Event = new Event;


    return $this->Event->checkEvaluationToolInUse($evalTool, $templateId);
  }

}

?>