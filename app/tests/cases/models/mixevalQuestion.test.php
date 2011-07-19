<?php
App::import('Model', 'MixevalsQuestion');
App::import('Component', 'Auth');

class FakeController extends Controller {
  var $name = 'FakeController';
  var $components = array('Auth');
  var $uses = null;
  var $params = array('action' => 'test');
}

class MixevalsQuestionTestCase extends CakeTestCase {
  var $name = 'MixevalsQuestion';
  var $fixtures = array('app.course', 'app.role', 'app.user', 'app.group', 
                        'app.roles_user', 'app.event', 'app.event_template_type',
                        'app.group_event', 'app.evaluation_submission',
                        'app.survey_group_set', 'app.survey_group',
                        'app.survey_group_member', 'app.question', 
                        'app.response', 'app.survey_question', 'app.user_course',
                        'app.user_enrol', 'app.groups_member', 'app.mixeval', 'app.mixevals_question',
  						'app.mixevals_question_desc'
                       );
  var $MixevalsQuestion = null;

  function startCase() {
	$this->MixevalsQuestion = ClassRegistry::init('MixevalsQuestion');
    $admin = array('User' => array('username' => 'root',
                                   'password' => 'ipeer'));
    $this->controller = new FakeController();
    $this->controller->constructClasses();
    $this->controller->startupProcess();
    $this->controller->Component->startup($this->controller);
    $this->controller->Auth->startup($this->controller);
    ClassRegistry::addObject('view', new View($this->Controller));
    ClassRegistry::addObject('auth_component', $this->controller->Auth);

    $this->controller->Auth->login($admin);
  }

  function endCase() {
    $this->controller->Component->shutdown($this->controller);
    $this->controller->shutdownProcess();
  }

  //Run before EVERY test.
  function startTest($method) {
  // extra setup stuff here
  }
	
  function endTest($method) {
  }

  function testMixevalsQuestionInstance() {
    $this->assertTrue(is_a($this->MixevalsQuestion, 'MixevalsQuestion'));
  }
  
  function testInsertQuestion() {
  	// set up test input
  	$input = $this->setUpInserQuestionTestData();
	// set up test data
	$result = $this->MixevalsQuestion->insertQuestion(55, $input);
	// Assert the data was saved in database
	$searched = $this->MixevalsQuestion->find('all', array('conditions' => array('mixeval_id' => 55)));
	$this->assertEqual($searched[0]['MixevalsQuestion']['mixeval_id'], 55);
	$this->assertEqual($searched[1]['MixevalsQuestion']['mixeval_id'], 55);
	$this->assertEqual($searched[0]['MixevalsQuestion']['title'], 'Licket Q1');
	$this->assertEqual($searched[1]['MixevalsQuestion']['title'], 'Comment Q2');
	
	// Test for incorrect inputs
	$incorrectResult1 = $this->MixevalsQuestion->insertQuestion(null, $input);
	$incorrectResult2 = $this->MixevalsQuestion->insertQuestion(55, null);
	$incorrectResult3 = $this->MixevalsQuestion->insertQuestion(null, null);
	$this->assertFalse($incorrectResult1);
	$this->assertFalse($incorrectResult2);
	$this->assertFalse($incorrectResult3);
  }
  
  function testGetQuestion() {
  	$result = $this->MixevalsQuestion->getQuestion(2);
  	$this->assertEqual($result[0]['MixevalsQuestion']['id'], 1);
  	$this->assertEqual($result[1]['MixevalsQuestion']['id'], 2);
  	$this->assertEqual($result[2]['MixevalsQuestion']['id'], 3);
  	$this->assertEqual($result[0]['MixevalsQuestion']['title'], '1st Question');
  	$this->assertEqual($result[1]['MixevalsQuestion']['title'], '2nd Question');
  	$this->assertEqual($result[2]['MixevalsQuestion']['title'], '3rd Question');
  }
  
  function setUpInserQuestionTestData() {
    $tmp = array(
    '0' => array(
            'id' => '',
            'question_type' => 'S',
            'question_num' => 0,
            'title' => 'Licket Q1',
            'multiplier' => 15,
            'Description' => array(
                    '0' => array(
                            'id' => '',
                            'descriptor' => 'Des1'
                        ),
                    '1' => array(
                            'id' => '',
                            'descriptor' => 'Des2'
                        )
                )
        ),
    '1' => array(
            'id' => '',
            'question_type' => 'T',
            'question_num' => 1,
            'title' => 'Comment Q2',
            'instructions' => 'Comment',
            'response_type' => 'L'
        )
	);
	return $tmp;
  	}
}
?>