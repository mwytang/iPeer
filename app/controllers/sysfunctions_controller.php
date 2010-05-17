<?php
/* SVN FILE: $Id: sysfunctions_controller.php,v 1.3 2006/08/22 17:31:26 davychiu Exp $ */

/**
 * Enter description here ....
 *
 * @filesource
 * @copyright    Copyright (c) 2006, .
 * @link
 * @package
 * @subpackage
 * @since
 * @version      $Revision: 1.3 $
 * @modifiedby   $LastChangedBy$
 * @lastmodified $Date: 2006/08/22 17:31:26 $
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Controller :: Sysfunctions
 *
 * Enter description here...
 *
 * @package
 * @subpackage
 * @since
 */
uses('neat_string');
class SysFunctionsController extends AppController
{
  var $name = 'SysFunctions';
	var $show;
	var $sortBy;
	var $direction;
	var $page;
	var $order;
	var $helpers = array('Html','Ajax','Javascript','Time','Pagination');
	var $NeatString;
	var $Sanitize;

	function __construct()
	{
		$this->Sanitize = new Sanitize;
		$this->NeatString = new NeatString;
		$this->show = empty($_GET['show'])? 'null': $this->Sanitize->paranoid($_GET['show']);
		if ($this->show == 'all') $this->show = 99999999;
		$this->sortBy = empty($_GET['sort'])? 'id': $_GET['sort'];
		$this->direction = empty($_GET['direction'])? 'asc': $this->Sanitize->paranoid($_GET['direction']);
		$this->page = empty($_GET['page'])? '1': $this->Sanitize->paranoid($_GET['page']);
		$this->order = $this->sortBy.' '.strtoupper($this->direction);
 		$this->pageTitle = 'Sys Functions';
		parent::__construct();
	}

	function index($message='')
	{
  	$data = $this->SysFunction->findAll($conditions=null, $fields=null, $this->order, $this->show, $this->page);

  	$paging['style'] = 'ajax';
  	$paging['link'] = '/sysfunctions/search/?show='.$this->show.'&sort='.$this->sortBy.'&direction='.$this->direction.'&page=';

  	$paging['count'] = $this->SysFunction->findCount($conditions=null);
  	$paging['show'] = array('10','25','50','all');
  	$paging['page'] = $this->page;
  	$paging['limit'] = $this->show;
  	$paging['direction'] = $this->direction;

    if (isset($message)) {
      $this->set('message', $message);
    }

  	$this->set('paging',$paging);
  	$this->set('data',$data);
	}

	function view($id)
	{
		$this->set('data', $this->SysFunction->read());
	}

	function add()
	{
		if (empty($this->params['data']))
		{
			$this->render();
		}
		else
		{
			if ($this->SysFunction->save($this->params['data']))
			{
				$message = 'The record is saved successfully';
				$this->redirect('sysfunctions/index/'.$message);
			}
			else
			{
				$this->set('data', $this->params['data']);
				$this->render('edit');
			}
		}
	}

	function edit($id=null)
	{
		if (empty($this->params['data']))
		{
			$this->SysFunction->setId($id);
			$this->params['data'] = $this->SysFunction->read();
			$this->render();
		}
		else
		{
			if ( $this->SysFunction->save($this->params['data']))
			{
				$message = 'The record is edited successfully';
				$this->redirect('sysfunctions/index/'.$message);
			}
			else
			{
				$this->set('data', $this->params['data']);
				$this->render();
			}
		}
	}

  function delete($id = null)
  {
    if (isset($this->params['form']['id']))
    {
      $id = intval(substr($this->params['form']['id'], 5));
    }   //end if
    if ($this->SysFunction->del($id)) {
				$message = 'The record is deleted successfully';
				$this->redirect('sysfunctions/index/'.$message);
    }
  }

  function search()
  {
    $this->layout = 'ajax';
    $pagination->loadingId = 'loading';

    $conditions = null;

    if (isset($this->params['form']['livesearch'])){
      $searchField=$this->params['form']['searchIndex'];
      $searchValue=$this->params['form']['livesearch'];

      $conditions = $searchField." LIKE '%".mysql_real_escape_string($searchValue)."%'";

    }
    $this->set('conditions',$conditions);
  }
}

?>