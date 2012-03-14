<?php
/**
 * Question
 *
 * @uses AppModel
 * @package   CTLT.iPeer
 * @author    Pan Luo <pan.luo@ubc.ca>
 * @copyright 2012 All rights reserved.
 * @license   MIT {@link http://www.opensource.org/licenses/MIT}
 */
class Question extends AppModel
{
    public $name = 'Question';
    public $displayField = 'prompt';

    public $hasMany = array('Response' =>
        array('className' => 'Response',
            'foreignKey' => 'question_id',
            'dependent' => true)
        );

    public $hasAndBelongsToMany = array('Survey' =>
        array('className'    =>  'Survey',
            'joinTable'    =>  'survey_questions',
            'foreignKey'   =>  'question_id',
            'associationForeignKey'    =>  'survey_id',
            'conditions'   =>  '',
            'order'        =>  '',
            'limit'        => '',
            'unique'       => true,
            'finderQuery'  => '',
            'deleteQuery'  => '',
            'dependent'    => false,
        ),
    );

    public $actsAs = array('ExtendAssociations', 'Containable', 'Habtamable');

    // prepares the data by moving varibles in the form to the data question sub array
  /*function prepData($data)
  {
    $data['data']['Question']['master'] = $data['form']['master'];
    $data['data']['Question']['type'] = $data['form']['type'];
    $data['data']['Question']['count'] = $data['form']['data']['Question']['count'];

    return $data;
  }*/

    /**
     * sets the data variable up with proper formating in the array for display
     *
     * @param array $data : $data obtained as return value from
     * 					  SurveyQuestion::getQuestionsID($survey_id);
     *
     * @access public
     * @return void
     */
    function fillQuestion($data)
    {
        for ($i=0; $i<count($data); $i++) {
            $data[$i]['Question'] = $this->find('all', array('conditions' => array('id' => $data[$i]['SurveyQuestion']['question_id']),
                'fields' => array('prompt', 'type')));
            $data[$i]['Question'] = $data[$i]['Question'][0]['Question'];
            $data[$i]['Question']['number'] = $data[$i]['SurveyQuestion']['number'];
            $data[$i]['Question']['id'] = $data[$i]['SurveyQuestion']['question_id'];
            $data[$i]['Question']['sq_id'] = $data[$i]['SurveyQuestion']['id'];
            unset($data[$i]['SurveyQuestion']);
        }
        return $data;
    }


    //  // delete old question references in each table
    //  function editCleanUp($question_id)
    //  {
    //  		$this->query('DELETE FROM questions WHERE id='.$question_id);
    //		$this->query('DELETE FROM responses WHERE question_id='.$question_id);
    //		$this->query('DELETE FROM survey_questions WHERE question_id='.$question_id);
    //  }

    /**
     * getTypeById
     *
     * @param bool $id
     *
     * @access public
     * @return string question type, null if id = null
     */
    function getTypeById($id = null)
    {
        if (null == $id) {
            return null;
        }

        $type = $this->find('first', array(
            'conditions' => array('Question.id' => $id),
            'fields' => array('type')
        ));
        return $type['Question']['type'];
    }

}
