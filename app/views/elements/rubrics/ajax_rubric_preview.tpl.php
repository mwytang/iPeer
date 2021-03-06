<!-- elements::ajax_rubric_preview start -->
<?php echo $javascript->link('calculate_marks')?>
<form name="frmList" id="frmList" action="">
    <table width="95%" border="0" align="center" cellpadding="4" cellspacing="2">
    	<tr class="tableheader" align="center">
			<td valign="top" width="23%">Rubric Preview</td>
		<?php

		//default values for a 5x5 rubric
		$LOM_des = array('1'=>'Poor','2'=>'Below Average','3'=>'Average','4'=>'Above Average','5'=>'Excellent');
		$crit = array('1'=>'Participated in Team Meetings','2'=>'Was Helpful and Co-operative','3'=>'Submitted Work on Time','4'=>'Worked Efficiently','5'=>'Contributed');

		//for loop to display the top header row with LOM comments
		for($i=1; $i<=$LOM_num; $i++){
			echo '<td align="left">LOM General Comment '.$i.'<br>'.
			$html->areaTag('Rubric/lom_comment'.$i,'',2,
                array('style'=>'width:90%;',
                'value'=>(!empty($data['Rubric']['lom_comment'.$i]) ?
                    $data['Rubric']['lom_comment'.$i] :
                    (isset($LOM_des[$i]) ?
                        $LOM_des[$i] :
                        "")
                    )
                )
            )."</td>";
		}
		echo "<td>Criteria Weight</td>";
		echo "</tr>";

		// horizontal template type
		if( $rubric_type == "horizontal" ){
			//for loop to display the criteria rows
			for($i=1; $i<=$criteria_num; $i++){
				echo '<tr class="tablecell" align="center">';
				echo '<td class="tableheader2" valign="top"><table border="0" width="95%" cellpadding="2"><tr><td align="left">Criteria '.$i.'</td></tr><tr><td>'
					  .$html->areaTag('Rubric/criteria'.$i,15,2,
                            array('value'=>( isset($data['Rubric']['criteria'.$i]) ?
                                                $data['Rubric']['criteria'.$i] :
                                                (isset($crit[$i]) ? $crit[$i] : "")),
                                                'style'=>'width:95%;'))."<br>"
					  ."</td></tr></table></td>";

				//for loop to display the criteria comment cells for each LOM
				for($j=1; $j<=$LOM_num; $j++){
					if( $zero_mark == "on" ){
						$mark_value = round( (1/($LOM_num-1)*($j-1)) , 2);
					}
					else{
						$mark_value = round( (1/$LOM_num*$j) , 2);
					}
					echo '<td align="left"><table border="0" width="95%" cellpadding="2"><tr><td align="left">Specific Comment</td></tr><tr><td align="left">'.$html->areaTag('Rubric/criteria_comment_'
						 .$i.'_'.$j,'',2, array('style'=>'width:90%;'))."</td></tr><tr><td>Mark: ".'<input type="text" name="criteria_mark_'.$i."_".$j.'" class="input" size="3" readonly value="'.$mark_value.'">'."</td></tr></table></td>";
				}

				echo '<td>';
				echo '<select name="criteria_weight_'.$i.'" id="criteria_weight_'.$i.'" style="width:50px;" onchange="calculateMarks(\''.$LOM_num.'\',\''.$criteria_num.'\',\''.$zero_mark.'\')">';
				echo '<option value="1" selected >1</option>';
				echo '<option value="2" >2</option>';
				echo '<option value="3" >3</option>';
				echo '<option value="4" >4</option>';
				echo '<option value="5" >5</option>';
				echo '<option value="6" >6</option>';
				echo '<option value="7" >7</option>';
				echo '<option value="8" >8</option>';
				echo '<option value="9" >9</option>';
				echo '<option value="10" >10</option>';
				echo '<option value="11" >11</option>';
				echo '<option value="12" >12</option>';
				echo '<option value="13" >13</option>';
				echo '<option value="14" >14</option>';
				echo '<option value="15" >15</option>';
				echo '</select>';
				echo '</td>';

				echo "</tr>";
			}
		}
		// vertical template type
		elseif ( $rubric_type == "vertical" ){
			//for loop to display the criteria rows
			for($i=1; $i<=$criteria_num; $i++){
				echo '<tr class="tablecell" align="center">';
				echo '<td class="tableheader2" valign="top"><table border="0" width="95%" cellpadding="2"><tr><td>Criteria $i</td></tr><tr><td>'
					  .$html->areaTag('Rubric/criteria'.$i,15,2, array('value'=> !empty($data['Rubric']['criteria'.$i]) ? $data['Rubric']['criteria'.$i] : $crit[$i]))."<br>"
					  ."</td></tr></table></td>";

				echo '<td colspan="'.$LOM_num.'"><table border="0" width="95%" cellpadding="4"><tr><td colspan="3">Specific Comment</td></tr>';

				//for loop to display the criteria comment rows for each LOM
				for($j=1; $j<=$LOM_num; $j++){
					if( $zero_mark == "on" ){
						$mark_value = round( (1/($LOM_num-1)*($j-1)) , 2);
					}
					else{
						$mark_value = round( (1/$LOM_num*$j) , 2);
					}
					echo '<tr>
						  	<td width="15">$j:</td><td>'.$html->areaTag('Rubric/criteria_comment_'.$i.'_'.$j,'',2, array('style'=>'width:100%;')).'
							</td>
							<td width="100">Mark: <input type="text" name="criteria_mark_'.$i.'_'.$j.' size="3" class="input" readonly value=".$mark_value.">
							</td>
						  </tr>';
				}
				echo "</table></td>";

				echo '<td>';
				echo '<select name="criteria_weight_'.$i.'" style="width:50px;" onchange="calculateMarks(\''.$LOM_num.'\',\''.$criteria_num.'\',\''.$zero_mark.'\')">';
				echo '<option value="1" selected >1</option>';
				echo '<option value="2" >2</option>';
				echo '<option value="3" >3</option>';
				echo '<option value="4" >4</option>';
				echo '<option value="5" >5</option>';
				echo '<option value="6" >6</option>';
				echo '<option value="7" >7</option>';
				echo '<option value="8" >8</option>';
				echo '<option value="9" >9</option>';
				echo '<option value="10" >10</option>';
				echo '<option value="11" >11</option>';
				echo '<option value="12" >12</option>';
				echo '<option value="13" >13</option>';
				echo '<option value="14" >14</option>';
				echo '<option value="15" >15</option>';
				echo '</select>';
				echo '</td>';

				echo "</tr>";
			}
		}
		echo '<tr class="tableheader2">';
		echo '<td colspan="'.($LOM_num+1).'" align="right">Total Marks: </td>';
		echo '<td><input type="text" name="total_marks" id="total" class="input" value='.$criteria_num.' size="5" readonly></td>';
		echo "</tr>";
		?>
  </table>
</form>
<!-- elements::ajax_rubric_preview end -->
