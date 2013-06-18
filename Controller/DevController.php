<?php
App::uses('AppController', 'Controller');
App::uses('Model', 'Model');

class DevController extends AppController {
  
  public function index(){
    $dbconf = $this->Session->read('dbconfig.database');
    $db = ConnectionManager::getDataSource($dbconf);
    $tables = $db->listSources();
    if($this->request->is('post')||$this->request->is('put')){
      $data = $this->request->data;
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
    foreach($tables as $table){
      $cols = $db->execute('SHOW FULL COLUMNS FROM ' . $table);
      while($column = $cols->fetch(PDO::FETCH_OBJ)){
        $schema[$table][$column->Field] = $column;  
      }      
    }
    $this->set(compact('schema'));
  }
  
  public function connection(){
    $this->useTable = false;
    if($this->request->is('post') || $this->request->is('put')){
      $this->Session->write('dbconfig', $this->request->data['Dev']);
      $this->redirect(array('action'=>'index'));
    }
  }
  
}
