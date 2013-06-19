<?php
App::uses('AppController', 'Controller');
App::uses('Model', 'Model');

class DevController extends AppController {
  
  public function index(){
    $database = $this->Session->read('dbconfig.database');
    $db = ConnectionManager::getDataSource($database);
    $tables = $db->listSources();
    if($this->request->is('post')||$this->request->is('put')){
      $data = $this->request->data;
      $tblComments = $data['__TABLES__'];
      unset($data['__TABLES__']);
      foreach($tblComments as $table => $comment){
        $tc = $db->execute("SELECT table_comment FROM INFORMATION_SCHEMA.TABLES WHERE table_schema='".$database."' AND table_name='$table'");
        $result = $tc->fetch(PDO::FETCH_OBJ);
        $tc = $result->table_comment;
        if(!empty($comment) || !empty($tc)){
          $comment = str_replace(array("\'", '\"', '"', "'"), array("'", '"', '\"', "\'"), $comment);
          $comment = preg_replace('~\R~u', "\r\n", $comment);
          $db->execute("ALTER TABLE $table COMMENT '$comment'");
        }
      }
      foreach($data as $table => $columns){
        $cols = $db->execute('SHOW FULL COLUMNS FROM ' . $table);
        while($column = $cols->fetch(PDO::FETCH_OBJ)){
          $comment = str_replace(array("\'", '\"', '"', "'"), array("'", '"', '\"', "\'"), $columns[$column->Field]);
          $comment = preg_replace('~\R~u', "\r\n", $comment);
          $def = (string)$column->Field.' ';
          $def .= (string)$column->Type.' ';
          switch($column->Null){
            case 'NO': $def.='NOT NULL ';break;
            case 'YES': $def.='';break;
          }
          if($column->Collation){ $def .= 'COLLATE '.(string)$column->Collation.' '; }
          if($column->Extra){ $def .= (string)$column->Extra.' '; }
          if($column->Default){ $def .= 'DEFAULT '.(string)$column->Default; } else { $def .= 'DEFAULT NULL '; }
          if(!empty($column->Comment) || !empty($comment)){
            $db->execute('ALTER TABLE '.$table.' MODIFY '.$def.' COMMENT \''.$comment.'\';');
          }
        }     
      }
      $this->Session->setFlash('Comments Updated');
    }
    $schema = array();
    $tblComments = array();
    foreach($tables as $table){
      $tblComment = $db->execute("SELECT table_comment FROM INFORMATION_SCHEMA.TABLES WHERE table_schema='".$database."' AND table_name='$table'");
      $result = $tblComment->fetch(PDO::FETCH_OBJ);
      $tblComments[$table] = $result->table_comment;
      
      $cols = $db->execute('SHOW FULL COLUMNS FROM ' . $table);
      while($column = $cols->fetch(PDO::FETCH_OBJ)){
        $schema[$table][$column->Field] = $column;  
      }      
    }
    $this->set(compact('schema'));
    $this->set(compact('tblComments'));
  }
  
  public function connection(){
    $this->useTable = false;
    if($this->request->is('post') || $this->request->is('put')){
      $this->Session->write('dbconfig', $this->request->data['Dev']);
      $this->redirect(array('action'=>'index'));
    }
  }
  
}
