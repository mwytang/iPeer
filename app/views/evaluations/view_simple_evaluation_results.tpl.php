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
<?php if (!$allMembersCompleted) { $incompletedMembersArr = array();?>
<table width="95%" border="0" align="center" cellpadding="4" cellspacing="2">
  <tr>
    <td colspan="3">
	      <font color="red">These student(s) have yet to submit their evaluations: <br>
	         <?php foreach($inCompletedMembers as $row): $user = $row['User']; array_push($incompletedMembersArr, $user['first_name'].' '.$user['last_name']);?>
	          &nbsp;-&nbsp; <?php echo $user['first_name'].' '.$user['last_name']?> <br>
	      <?php endforeach; ?>
      </font>
    </td>
  </tr>
</table>
<?php } ?>

<table width="95%" border="0" align="center" cellpadding="4" cellspacing="2">
  <tr class="tableheader">
    <td width="10" height="32" align="center" colspan="<?php echo count($groupMembers) +1; ?>">Evaluation Results:</td>
  </tr>
  <tr class="tablecell2">
  	<td rowspan="2">Evaluator</td>
  	<td colspan="<?php echo count($groupMembers); ?>">Members Evaluated</td>
  </tr>
  <tr class="tablecell2">
  <?php if ($groupMembers) {
        	foreach ($groupMembers as $member) {
        		echo '<td>' . $member['User']['first_name'] . ' ' . $member['User']['last_name'] . '</td>' . "\n";
        	}  ?>
  </tr>
  <?php
  foreach ($groupMembers as $member_row) {
          echo '<tr class="tablecell2">';
    	  	echo '<td>' . $member_row['User']['first_name'] . ' ' . $member_row['User']['last_name']  . '</td>' . "\n\t\t";
    		  foreach ($groupMembers as $member_col) {
    		    //Blank the disgonal for not self-evaluation
    		    if (($member_row['User']['id'] == $member_col['User']['id']) && !$event['Event']['self_eval']) {
    		       echo '<td> - </td>' . "\n\t\t";
        		}else {
      		    if (isset($scoreRecords[$member_row['User']['id']][$member_col['User']['id']])) {
                $score = $scoreRecords[$member_row['User']['id']][$member_col['User']['id']];
        		    echo '<td>'.(is_numeric($score) ? number_format($score, 2) : $score).'</td>' . "\n\t\t";
        		  } else {
        		     echo '<td>0.00</td>' . "\n\t\t";
        		  }

        		}
    		  }
    		  echo '</tr>';
    	  }   ?>
  <tr class="tablesummary">
    	<td>Average Received</td>
      <?php

      $memberEvaluatedCount = ($event['Event']['self_eval'])? count($scoreRecords) : count($scoreRecords) - 1;
       foreach ($groupMembers as $member_col) {
         if (isset($memberScoreSummary[$member_col['User']['id']]) && $memberEvaluatedCount > count($inCompletedMembers)) {
             if ($event['Event']['self_eval']) {
                 echo '<td>'.number_format($memberScoreSummary[$member_col['User']['id']]['received_total_score'] / ($memberEvaluatedCount-count($inCompletedMembers)), 2).'</td>' . "\n\t\t";
             } else {
           if (!empty($incompletedMembersArr) && in_array($member_col['User']['first_name'].' '.$member_col['User']['last_name'], $incompletedMembersArr)) {
            if ($memberEvaluatedCount > count($inCompletedMembers)) {
              echo '<td>'.number_format($memberScoreSummary[$member_col['User']['id']]['received_total_score'] / ($memberEvaluatedCount-(count($inCompletedMembers))+1), 2).'</td>' . "\n\t\t";
            } else {
              echo '<td>'.number_format($memberScoreSummary[$member_col['User']['id']]['received_total_score']) . "\n\t\t";
            }
           } else {
            if ($memberEvaluatedCount > count($inCompletedMembers)) {
              echo '<td>'.number_format($memberScoreSummary[$member_col['User']['id']]['received_total_score'] / ($memberEvaluatedCount-count($inCompletedMembers)), 2).'</td>' . "\n\t\t";
            } else {
              echo '<td>'.number_format($memberScoreSummary[$member_col['User']['id']]['received_total_score']) . "\n\t\t";
            }
           }
             }
         } else {
             echo '<td> - </td>';
         }
       }?>
	</tr>
	<tr class="tablesummary2">
	    <td>Grade Released</td>
      <?php
       for ($m=0;$m < count($groupMembers); $m++) {
         if(array_key_exists($groupMembers[$m]['User']['id'], $gradeReleaseStatus)){
           $gradeRelease = $gradeReleaseStatus[$groupMembers[$m]['User']['id']];
           echo '<td>';
           if (isset($gradeRelease['grade_release']) && $gradeRelease['grade_release']) {?>
            <input type="button" name="Unrelease" value="Unrelease" onclick="location.href='<?php echo $this->webroot.$this->themeWeb.'evaluations/markGradeRelease/'.$event['Event']['id'].';'.$event['group_id'].';'.$groupMembers[$m]['User']['id'].';'.$event['group_event_id'].';0'; ?>'">
           <?php } else { ?>
            <input type="button" name="Release" value="Release" onclick="location.href='<?php echo $this->webroot.$this->themeWeb.'evaluations/markGradeRelease/'.$event['Event']['id'].';'.$event['group_id'].';'.$groupMembers[$m]['User']['id'].';'.$event['group_event_id'].';1'; ?>'">
           <?php }
           echo '</td>' . "\n\t\t";
        } else
          echo '<td><input type="button" value="marks n/a" disabled /></td>';
  		 }?>
 </tr>
<?php  }
else { // if no members are present
?>
<tr class="tablecell2">
	<td colspan="4"><em>No group members</em></td>
</tr>
<?php }?>
<tr class="tablecell2" align="center">
	<td colspan="<?php echo count($groupMembers) +1; ?>">
<form name="evalForm" id="evalForm" method="POST" action="<?php echo $html->url('markEventReviewed') ?>">
  <input type="hidden" name="event_id" value="<?php echo $event['Event']['id']?>" />
  <input type="hidden" name="group_id" value="<?php echo $event['group_id']?>" />
  <input type="hidden" name="course_id" value="<?php echo $rdAuth->courseId?>" />
  <input type="hidden" name="group_event_id" value="<?php echo $event['group_event_id']?>" /><?php
	if ($event['group_event_marked'] == "reviewed") {
		echo "<input class=\"reviewed\" type=\"submit\" name=\"mark_not_reviewed\" value=\"Mark Peer Evaluations as Not Reviewed\" />";
	}
	else {
		echo "<input class=\"reviewed\" type=\"submit\" name=\"mark_reviewed\" value=\"Mark Peer Evaluations as Reviewed\" />";
	}
?>
</form></td>
</tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<form name="evalForm2" id="evalForm2" method="POST" action="<?php echo $html->url('markCommentRelease') ?>">

<table width="95%" border="0" align="center" cellpadding="4" cellspacing="2">
  <tr class="tableheader">
    <td width="10" height="32" align="center">Comment Sections</td>
  </tr>
	<tr>
	<td width="100%" height="32"><?php echo $html->image('/icons/instructions.gif',array('alt'=>'instructions'));?>
		<b> Instructions:</b><br>
		1. Click evaluator's name to view his/her evaluation on group members.<br>
		2. Check the "Released" checkbox and click "Save Changes" to release individual comments , or
		   Click "Release All" or "Unrelease All" buttons to release or unrelease all comments.<br>
	</td>
	</tr>
	<tr>
		<td>
<div id="accordion">
	<?php $i = 0;
	foreach($groupMembers as $row): $user = $row['User']; ?>
		<div id="panel<?php echo $user['id']?>">
			<div id="panel<?php echo $user['id']?>Header" class="panelheader">
				<?php echo 'Evaluator: '.$user['last_name'].' '.$user['first_name']?>
			</div>
			<div style="height: 200px;" id="panel1Content" class="panelContent">
<table width="100%" border="0" align="center" cellpadding="4" cellspacing="2">
<tr class="tablecell2">
	<td>Evaluatee</td>
	<td>Comment</td>
	<td colspan="2">Released</td>
</tr>
	<?php
$i = 0;
foreach($evalResult[$user['id']] AS $row ) {
    // We need to skip self-evaluation results properl:
    if (($groupMembers[$i]['User']['id']==$user['id']) && (!$event['Event']['self_eval'])) {
        $i++;
    }

    $evaluatee = $groupMembers[$i++]['User'];
    $evalMark = isset($row['EvaluationSimple'])? $row['EvaluationSimple']: null;
    echo '<tr class="tablecell2">';
    if (isset($evalMark)) {
        echo '<td width="30%">'.$evaluatee['last_name'].' '.$evaluatee['first_name'].'</td>' . "\n";
        echo '<td width="60%">';
        echo (isset($evalMark['eval_comment']))? $evalMark['eval_comment'] : 'No Comments';
        echo '</td>' ;
        if ($evalMark['release_status'] == 1) { // made explicit comparison with 1
            echo '<td colspan="2" width="10%">' . '<input type="checkbox" name="release' .  $evalMark['evaluator']  . '[]" value="' . $evalMark['evaluatee'] . '" checked />';
        } else {
            echo '<td colspan="2" width="10%">' . '<input type="checkbox" name="release' .  $evalMark['evaluator']  . '[]" value="' . $evalMark['evaluatee'] . '" />';
        }
        echo '<input type="hidden" name="evaluator_ids[]" value="' .  $evalMark['evaluator']  . '" /></td>';
    } else {
        echo 'ss';
        echo '<td colspan="4">n/a</td>';
    }
    echo '</tr>';
}
			 ?>
			</table>
			</div>
		</div>
	<?php endforeach; ?>
</div>
		</td>
	</tr>
<tr class="tablecell2" align="center">
	<td colspan="4">
  <input type="hidden" name="event_id" value="<?php echo $event['Event']['id']?>" />
  <input type="hidden" name="group_id" value="<?php echo $event['group_id']?>" />
  <input type="hidden" name="course_id" value="<?php echo $rdAuth->courseId?>" />
  <input type="hidden" name="group_event_id" value="<?php echo $event['group_event_id']?>" />
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Save Changes" />
	&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Release All" />
	&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Unrelease All" />
</td>
</tr>
</table>
</form>
	<script type="text/javascript"> new Rico.Accordion( 'accordion',
								{panelHeight:300,
								 hoverClass: 'mdHover',
								 selectedClass: 'mdSelected',
								 clickedClass: 'mdClicked',
								 unselectedClass: 'panelheader'});
	</script>
      <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#E5E5E5">
        <tr>
          <td align="left"><?php echo $html->image('layout/corner_bot_left.gif',array('align'=>'middle','alt'=>'corner_bot_left'))?></td>
          <td align="right"><?php echo $html->image('layout/corner_bot_right.gif',array('align'=>'middle','alt'=>'corner_bot_right'))?></td>
        </tr>
      </table>

	</td>
  </tr>
</table>
