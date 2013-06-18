<!DOCTYPE html>
<html>
<head>
<?php
  echo $this->Html->meta('icon');
  echo $this->fetch('meta');

  echo $this->Html->script('jquery-1.9.1');

  echo $this->fetch('css');
  echo $this->fetch('script');
?>
<script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function() {
    
    jQuery('.accordion .head').click(function() {
        jQuery(this).next().toggle('fast');
        return false;
    }).next().hide();
   
    jQuery('.accordion .head1').click(function() {
        jQuery(this).next().toggle('fast');
        return false;
    });
    
  });
</script>
<style>
label{
  display: block;
  padding-top: 5px;
  clear: left;
  font-weight: bold;
}  

a{
  text-decoration: none;
  color: #000;
  display: block;
  width: 100%;
}

.body{
  border: 1px solid #ccc;
  padding: 5px;
  margin-top: -1px;
}

.head{
  margin-top: 5px;
  border: 1px solid #ccc;
  padding: 2px 10px;
  font-weight: bold;
}

.body1{
  border: 1px solid #ccc;
  padding: 5px;
  margin-top: -1px;
}

.head1{
  margin-top: 5px;
  border: 1px solid #ccc;
  padding: 2px 10px;
  background: #f8f8f8;
}

textarea{
  width: 99%;
  height: 200px; 
}
</style>
</head>
<body>
  <?php echo $this->fetch('content'); ?>
</body>
</html>
