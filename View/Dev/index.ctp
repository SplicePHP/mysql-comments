<div style="padding: 10px 20px;">
<h1>Database: <?php echo $this->Session->read('dbconfig.database'); ?></h1>
<?php
  echo $this->Html->link('Select DB', array('action'=>'connection'));
  echo '<br>';  
  echo $this->Form->create();
  foreach($schema as $table => $fields){
    echo "<div class=\"accordion\">";
    echo "<div class=\"head\"><a href=\"#\">$table</a></div><div class=\"body\">";
    foreach($fields as $field){
      echo "<div class=\"head1\"><a href=\"#\">[&nbsp;<b>{$field->Field}</b>&nbsp;]&nbsp;&nbsp;&nbsp; [ {$field->Type} {$field->Collation} {$field->Extra} ]</a></div><div class=\"body1\">";
      echo $this->Form->textarea("$table.{$field->Field}", array('value'=>$field->Comment));
      echo "</div>";
    }
    echo "</div>";
    echo "</div>";
  }
  echo '<br>';
  echo $this->Form->end('Submit');
?>
</div>