<?php
 if ($userPersonalize->getPersonalizeValue('Course.SubMenu.EvalEvents.Show')== 'true') : ?>
<table width="100%" border="0" cellspacing="2" cellpadding="4">
  <tr>
    <td width="10" bgcolor="#FFB66F">&nbsp;</td>
    <td width="96%" class="tablecell">
    <A HREF="<?php echo $this->webroot.$this->themeWeb;?>events/add/">
    <?php echo $html->image('layout/yellow_arrow.gif',
    array('align'=>'middle', 'border'=>'0','alt'=>'yellow_arrow'))?> &nbsp;Add Event
      </a></td>
  </tr>
  <tr>
    <td bgcolor="#FFB66F">&nbsp;</td>
    <td class="tablecell">
    <A HREF="<?php echo $this->webroot.$this->themeWeb;?>events/goToClassList/<?php echo $this->controller->rdAuth->courseId;?>">
    <?php echo $html->image('layout/yellow_arrow.gif',
    array('align'=>'middle', 'border'=>'0','alt'=>'yellow_arrow'))?> &nbsp;List Evaluation Events / Results
      </a></td></tr>
    <td bgcolor="#FFB66F">&nbsp;</td>
    <td class="tablecell"><A HREF="<?php echo $this->webroot.$this->themeWeb;?>evaluations/export/"><?php echo $html->image('layout/yellow_arrow.gif',array('align'=>'middle', 'border'=>'0', 'alt'=>'yellow_arrow'))?> &nbsp;Export Evaluation Results
    </a></td>
  </tr>
</table>
<?php endif; ?>