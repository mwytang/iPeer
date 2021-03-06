<table width="100%"  border="0" cellpadding="8" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td>
    <form name="frm" id="frm" method="POST" action="<?php echo $html->url(empty($params['data']['SimpleEvaluation']['id'])?'add':'edit') ?>" onSubmit="return validate()">
      <?php echo empty($params['data']['SimpleEvaluation']['id']) ? null : $html->hidden('SimpleEvaluation/id'); ?>
      <input type="hidden" name="required" id="required" value="point_per_member" />
      <table width="95%" border="0" align="center" cellpadding="4" cellspacing="2">
        <tr class="tableheader">
          <td colspan="3" align="center"><?php echo empty($params['data']['SimpleEvaluation']['id'])?'Add':'Edit' ?> Simple Evaluation</td>
        </tr>
        <tr class="tablecell2">
	        <td width="254" id="newtitle_label">Evaluation Name:<font color="red">*</font></td>
	        <td width="405" align="left">
      	    <input type="text" name="newtitle" id="newtitle" class="validate required TEXT_FORMAT newtitle_msg Invalid_Name." value="<?php echo empty($params['data']['SimpleEvaluation']['name'])? '' : $params['data']['SimpleEvaluation']['name'] ?>" size="50">
            <div id='titleErr' class="error">
                <?php
                $fieldValue = isset($this->params['form']['newtitle'])? $this->params['form']['newtitle'] : '';
                $params = array('controller'=>'simpleevaluations', 'data'=>null, 'fieldvalue'=>$fieldValue);
                echo $this->renderElement('simple_evaluations/ajax_title_validate', $params);
                ?>
            </div>
          </td>
          <td width="243" id="newtitle_msg" class="error"/>
        </tr>
        <tr class="tablecell2">
        	<td id="description_label">Description:</td>
        	<td align="left"><?php echo $html->textarea('SimpleEvaluation/description', array('id'=>'description', 'cols'=>'30', 'class'=>'validate none none'))?></td>
        	<td id="description_msg" class="error"/>
        </tr>
        <tr class="tablecell2">
        	<td id="point_per_member_label">Base Point Per Member:<font color="red">*</font></td>
        	<td align="left"><?php echo $html->input('SimpleEvaluation/point_per_member', array('id'=>'point_per_member', 'size'=>'50', 'class'=>'validate required NUMERIC_FORMAT point_per_member_msg Invalid_Number_Value.')) ?>
        	</td>
        	<td id="point_per_member_msg" class="error"/>
        </tr>
        <tr class="tablecell2">
          <td colspan="3" align="center">
          <input type="button" name="Back" value="Back" onClick="javascript:(history.length > 1) ? history.back() : window.close();">
          <script>
                // Ensure that the entries are valid
                function ensureEntriesValid() {
                    var bppm = $("point_per_member");
                    if (bppm.value > 0) {
                        return true;
                    } else {
                        alert ("Base points per member *must be* at least 1 point.\nHowever, at least 10 is recommended.");
                        bppm.value = 10; bppm.focus();bppm.select();
                        return false;
                    }
                }
          </script>
          <?php echo $html->submit('Save', array('onclick' => 'return ensureEntriesValid();')); ?>

      	</td>
      </table>
      <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#E5E5E5">
        <tr>
          <td align="left"><?php echo $html->image('layout/corner_bot_left.gif',array('align'=>'middle','alt'=>'corner_bot_left'))?></td>
          <td align="right"><?php echo $html->image('layout/corner_bot_right.gif',array('align'=>'middle','alt'=>'corner_bot_right'))?></td>
        </tr>
      </table>
</form>
</td>
</tr>
</table>