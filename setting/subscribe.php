<?php

$config["subscribe"] =  array (
  'validate' => 
  array (
    'do' => 
    array (
      'mail' => true,
      'sms' => false,
    ),
    'undo' => 
    array (
      'mail' => false,
      'sms' => false,
    ),
  ),
);
?>