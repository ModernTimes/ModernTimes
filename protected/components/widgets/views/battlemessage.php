<?php 
// SKILL
if(!empty($this->msg->skill)) {
    echo "<table width='100%'><tr><td width='50%' align='center'>";
    // small button with mouseover popup
    echo CHtml::link($this->msg->skill['name'], "#", array('class'=>'btn btn-mini', 'data-title'=>$this->msg->skill['name'], 'data-content'=>$this->msg->skill['popup'], 'rel'=>'popover'));
    echo "</td><td width='50%' align='center'>";

    // RESULT
    // again a small button, whose icon and some specifics depend on the result type
    if($this->msg->getResultType() == 'damage') {
        echo "<span class='btn-group'><span class='btn btn-mini'><i class='icon-heart'></i> " . $this->msg->result['damageDone'] . "</span>" . 
                " . <span class='btn btn-mini btn-danger'>" . 
                ($this->msg->result['damageType'] != 'normal' ? ucfirst($this->msg->result['damageType']) . " " : "") . 
                "Damage</span></span>";
    } elseif ($this->msg->getResultType() == 'blocked') {
        echo "<span class='btn btn-mini'><i class='icon-remove-circle'></i> Blocked</span>";
    } elseif ($this->msg->getResultType() == 'effect') {
        echo "<span class='btn-group'><span class='btn btn-mini'>Effect</span>" . 
                CHtml::link($this->msg->result['effect']['name'], "#", array('class'=>'btn btn-mini ' . ($this->msg->result['effect']['buff'] ? 'btn-success' : 'btn-danger'), 'data-title'=>$this->msg->result['effect']['name'], 'data-content'=>$this->msg->result['effect']['popup'], 'rel'=>'popover')) .
                "</span>";
    }
    echo "</td></tr></table>";
} ?>

<?php /* MESSAGE */ ?>
<p><span style='font-size: smaller;'><?php
    echo ucfirst($this->msg->msg); ?> </span><p/>