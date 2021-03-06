<table width="100%"  border="0" cellpadding="8" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td>
<?php echo $javascript->link('ricobase')?>
<?php echo $javascript->link('ricoeffects')?>
<?php echo $javascript->link('ricoanimation')?>
<?php echo $javascript->link('ricopanelcontainer')?>
<?php echo $javascript->link('ricoaccordion')?>
<?php echo empty($params['data']['Evaluation']['id']) ? null : $html->hidden('Evaluation/id'); ?>
    <!-- Render Event Info table -->
	  <?php
    $params = array('controller'=>'evaluations', 'event'=>$event);
    echo $this->renderElement('evaluations/view_event_info', $params);
    ?>

<table width="95%" border="0" align="center" cellpadding="4" cellspacing="2">
  <tr>
    <td colspan="3"><?php echo $html->image('icons/instructions.gif',array('alt'=>'instructions'));?>
      <b> Summary:</b>(
      <a href="<?php echo $this->webroot.$this->themeWeb?>evaluations/viewEvaluationResults/<?php echo $event['Event']['id']?>/<?php echo $event['group_id']?>/Basic">Basic</a>
       |
      <a href="<?php echo $this->webroot.$this->themeWeb?>evaluations/viewEvaluationResults/<?php echo $event['Event']['id']?>/<?php echo $event['group_id']?>/Detail" >Detail</a>
        )
    </td>
  </tr>
	<?php $i = 0;
  if (!$allMembersCompleted) {?>
  <tr>
    <td colspan="3">
	      <font color="red">These student(s) have yet to submit their evaluations: <br>
	         <?php foreach($inCompletedMembers as $row): $user = $row['User']; ?>
	          &nbsp;-&nbsp; <?php echo $user['last_name'].' '.$user['first_name']?> <br>
	      <?php endforeach; ?>
      </font>
    </td>
  </tr>
<?php } ?>
</table>
<div id='rubric_result'>

<?php
$numerical_index = 1;  //use numbers instead of words; get users to refer to the legend
$color = array("", "#FF3366","#ff66ff","#66ccff","#66ff66","#ff3333","#00ccff","#ffff33");
$membersAry = array();  //used to format result
$groupAve = 0;
?>

<table width="95%" border="0" align="center" cellpadding="4" cellspacing="2">
	<tr class="tableheader">
		<td valign="middle">Student Name:</td>
    <?php
    	for ($i = 1; $i <= $rubric['Rubric']["criteria"]; $i++) {
    		echo "<td>";
    		echo '<strong><font color="' . $color[ $i % sizeof($color) ] . '">' . $numerical_index . ". </font></strong>";
    		echo "(" . $rubricCriteria['criteria_weight_'.$i]. ")";
    		echo "</td>";
    		$numerical_index++;
    	}
    ?>
    <td> Total:( <?php echo number_format($rubric['Rubric']['total_marks'], 2)?>)</td>
  </tr>
    <?php
    $aveScoreSum = 0;
    //This section will display the evaluatees' name
    //as display the average scores their peers gave them
    //for various criteria
    if ($groupMembers) {
      foreach ($groupMembers as $member) {
        $membersAry[$member['User']['id']] = $member;
      	echo '<tr class="tablecell2">';
      	echo '<td width="30%">' . $member['User']['first_name'] . ' ' . $member['User']['last_name'] . '</td>' . "\n";
        //if ($allMembersCompleted) {
        if (isset($memberScoreSummary[$member['User']['id']]['received_ave_score'])) {
          $aveScoreSum += $memberScoreSummary[$member['User']['id']]['received_ave_score'];
        	foreach ($scoreRecords[$member['User']['id']]['rubric_criteria_ave'] AS $criteriaAveIndex => $criteriaAveGrade) {
          	echo '<td>' . number_format($criteriaAveGrade, 2). "</td>";
          }
        } else {
        	for ($i = 1; $i <= $rubric['Rubric']["criteria"]; $i++) {
        		echo "<td>-</td>";
        	}
        }

      	//totals section
      	echo '<td width="30%">';
      	//if ($allMembersCompleted) {
      	if (isset($memberScoreSummary[$member['User']['id']]['received_ave_score'])) {
      		echo number_format($memberScoreSummary[$member['User']['id']]['received_ave_score'], 2);
      		$receviedAvePercent = $memberScoreSummary[$member['User']['id']]['received_ave_score'] / $rubric['Rubric']['total_marks'] * 100;
      		echo ' ('.number_format($receviedAvePercent) . '%)';
      		$membersAry[$member['User']['id']]['received_ave_score'] = $memberScoreSummary[$member['User']['id']]['received_ave_score'];
      		$membersAry[$member['User']['id']]['received_ave_score_%'] = $receviedAvePercent;
      	} else {
      		echo '-';
      	}
      	echo "</td>";
      	echo "</tr>";
      	//end scores
      }

      //averages
      echo '<tr class="tablesummary">';
      echo "<td><b>";
      echo "Group Average: ";
      echo "</b></td>";
      if ( $allMembersCompleted ) {
      	foreach ($scoreRecords['group_criteria_ave'] AS $groupAveIndex => $groupAveGrade) {
        	echo '<td>' . number_format($groupAveGrade, 2). "</td>";
        }
      } else {
      	for ($i = 1; $i <= $rubric['Rubric']["criteria"]; $i++) {
      		echo "<td>-</td>";
      	}
      }
      echo "<td><b>";
      if ( $allMembersCompleted ) {
        $groupAve = number_format($aveScoreSum / count($groupMembers, 2));
      	echo $groupAve;
      	echo ' ('.number_format($groupAve / $rubric['Rubric']['total_marks'] * 100) . '%)';
      } else {
      	echo '-';
      }
      echo "</b></td>";
    }		?>
	</tr>
  <tr class="tablecell2" align="center"><td colspan="<?php echo $rubric['Rubric']["criteria"] +2; ?>">
      <form name="evalForm" id="evalForm" method="POST" action="<?php echo $html->url('markEventReviewed') ?>">
			  <input type="hidden" name="event_id" value="<?php echo $event['Event']['id']?>" />
			  <input type="hidden" name="group_id" value="<?php echo $event['group_id']?>" />
			  <input type="hidden" name="course_id" value="<?php echo $rdAuth->courseId?>" />
			  <input type="hidden" name="group_event_id" value="<?php echo $event['group_event_id']?>" />
			  <input type="hidden" name="display_format" value="Detail" />

      	<?php
				if ($event['group_event_marked'] == "reviewed") {
					echo "<input class=\"reviewed\" type=\"submit\" name=\"mark_not_reviewed\" value=\"Mark Peer Evaluations as Not Reviewed\" />";
				}
				else {
					echo "<input class=\"reviewed\" type=\"submit\" name=\"mark_reviewed\" value=\"Mark Peer Evaluations as Reviewed\" />";
				}
			?>
			</form></td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="4" cellspacing="2">
	<tr>
		<td align="center">
<div id="accordion">
	<?php $i = 0;
	foreach($groupMembers as $row): $user = $row['User']; ?>
		<div id="panel<?php echo $user['id']?>">
		  <div id="panel<?php echo $user['id']?>Header" class="panelheader">
		  	<?php echo 'Evaluatee: '.$user['last_name'].' '.$user['first_name']?>
		  </div>
		  <div style="height: 200px;" id="panel1Content" class="panelContent">
			 <br><b>Total: <?php if (isset($membersAry[$user['id']]['received_ave_score'])) {
			                    $memberAve = number_format($membersAry[$user['id']]['received_ave_score'], 2);
			                    $memberAvePercent = number_format($membersAry[$user['id']]['received_ave_score_%']);
			                  }else {
			                    $memberAve = '-';
			                    $memberAvePercent = '-';
			                  }
			                  echo $memberAve;
			                  echo '('.$memberAvePercent.'%)';
			                  if ($memberAve == $groupAve) {
			                    echo "&nbsp;&nbsp;<< Same Mark as Group Average >>";
			                  } else if ($memberAve < $groupAve) {
			                    echo "&nbsp;&nbsp;<font color='#cc0033'><< Below Group Average >></font>";
			                  } else if ($memberAve > $groupAve) {
			                    echo "&nbsp;&nbsp;<font color='#000099'><< Above Group Average >></font>";
			                  }
			                ?> </b>
			        <br><br>
        <table width="95%" border="0" align="center" cellpadding="4" cellspacing="2">
        	<tr class="tableheader" align="center">
            <td width="100" valign="top">Evaluator</td>
            <?php
              for ($i=1; $i<=$rubric['Rubric']["criteria"]; $i++) {
            		echo "<td><strong><font color=" . $color[ $i % sizeof($color) ] . ">" . ($i) . ". "  . "</font></strong>";
            		echo $rubricCriteria['criteria'.$i];
            		echo "</td>";
            	}
            ?>
            <!--td>Release Status</td-->
          </tr>
       <?php
         //Retrieve the individual rubric detail
         if (isset($evalResult[$user['id']])) {

           $memberResult = $evalResult[$user['id']];

           foreach ($memberResult AS $row): $memberRubric = $row['EvaluationRubric'];
             $evalutor = $membersAry[$memberRubric['evaluator']];
             echo "<tr class=\"tablecell2\">";
             echo "<td width='15%'>".$evalutor['User']['last_name'].' '.$evalutor['User']['first_name']."</td>";

             $resultDetails = $memberRubric['details'];
             foreach ($resultDetails AS $detail) : $rubDet = $detail['EvaluationRubricDetail'];
                echo '<td valign="middle">';
                echo "<br />";
                //Points Detail
                echo "<strong>Points: </strong>";
                if (isset($rubDet)) {
                		$lom = $rubDet["selected_lom"];
                	$empty = $rubric["Rubric"]["lom_max"];
                	for ($v = 0; $v < $lom; $v++) {
                		echo $html->image('evaluations/circle.gif', array('align'=>'middle', 'vspace'=>'1', 'hspace'=>'1','alt'=>'circle'));
                		$empty--;
                	}
                	for ($t=0; $t < $empty; $t++) {
                		echo $html->image('evaluations/circle_empty.gif', array('align'=>'middle', 'vspace'=>'1', 'hspace'=>'1','alt'=>'circle_empty'));
                	}
                	echo "<br />";
                } else {
                	echo "n/a<br />";
                }

                //Grade Detail
                echo "<strong>Grade: </strong>";
                if (isset($rubDet)) {
                  echo $rubDet["grade"] . " / " . $rubricCriteria['criteria_weight_'.$rubDet['criteria_number']] . "<br />";
                } else {
                	echo "n/a<br />";
                }
                //Comments
                echo "<br/><strong>Comment: </strong>";
                if (isset($rubDet)) {
                	echo $rubDet["criteria_comment"];
                } else {
                	echo "n/a<br />";
                }

                echo "</td>";
             endforeach;
             //echo "<td>";
             //echo "</td>";
             echo "</tr>";
         //General Comment
         echo "<tr class=\"tablecell2\">";
         echo "<td></td>";
         $col = $rubric['Rubric']['criteria'] + 1;
         echo "<td colspan=".$col.">";
         echo "<strong>General Comment: </strong><br>";
         echo $memberRubric['general_comment'];
         echo "<br><br></td>";
         echo "</tr>";
         endforeach;
       }
       ?>
        </table>
       <?php
       echo "<br>";
       //Grade Released
       if (isset($scoreRecords[$user['id']]['grade_released']) && $scoreRecords[$user['id']]['grade_released']) {?>

        <input type="button" name="UnreleaseGrades" value="Unrelease Grades" onClick="location.href='<?php echo $this->webroot.$this->themeWeb.'evaluations/markGradeRelease/'.$event['Event']['id'].';'.$event['group_id'].';'.$user['id'].';'.$event['group_event_id'].';0'; ?>'">
       <?php } else {?>
        <input type="button" name="ReleaseGrades" value="Release Grades" onClick="location.href='<?php echo $this->webroot.$this->themeWeb.'evaluations/markGradeRelease/'.$event['Event']['id'].';'.$event['group_id'].';'.$user['id'].';'.$event['group_event_id'].';1'; ?>'">
       <?php }

       //Comment Released
       if (isset($scoreRecords[$user['id']]['comment_released']) && $scoreRecords[$user['id']]['comment_released']) {?>
        <input type="button" name="UnreleaseComments" value="Unrelease Comments" onClick="location.href='<?php echo $this->webroot.$this->themeWeb.'evaluations/markCommentRelease/'.$event['Event']['id'].';'.$event['group_id'].';'.$user['id'].';'.$event['group_event_id'].';0'; ?>'">
       <?php } else { ?>
        <input type="button" name="ReleaseComments" value="Release Comments" onClick="location.href='<?php echo $this->webroot.$this->themeWeb.'evaluations/markCommentRelease/'.$event['Event']['id'].';'.$event['group_id'].';'.$user['id'].';'.$event['group_event_id'].';1'; ?>'">
       <?php }
       ?>
		  </div>
		</div>

	<?php $i++;?>
	<?php endforeach; ?>
</div>
		</td>
	</tr>

</table>
	<script type="text/javascript"> new Rico.Accordion( 'accordion',
								{panelHeight:500,
								 hoverClass: 'mdHover',
								 selectedClass: 'mdSelected',
								 clickedClass: 'mdClicked',
								 unselectedClass: 'panelheader'});

	</script>
</div>

<table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#E5E5E5">
  <tr>
    <td align="left"><?php echo $html->image('layout/corner_bot_left.gif',array('align'=>'middle','alt'=>'corner_bot_left'))?></td>
    <td align="right"><?php echo $html->image('layout/corner_bot_right.gif',array('align'=>'middle','alt'=>'corner_bot_right'))?></td>
  </tr>
</table>
	</td>
  </tr>
</table>
