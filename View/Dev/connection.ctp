<div style="padding: 20px;">
<?php
echo $this->Form->create();
echo $this->Form->input('host', array('value'=>'localhost'));
echo $this->Form->input('database', array('value'=>$this->Session->read('dbconfig.database')));
echo $this->Form->input('login', array('value'=>'root'));
echo $this->Form->input('password');
echo $this->Form->input('datasource', array('value'=>'Database/Mysql'));
echo $this->Form->input('prefix');
echo $this->Form->end('Submit');
?>
</div>