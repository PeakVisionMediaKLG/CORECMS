<?php
namespace CORE;
class DOCUMENT extends COMPONENT
{
  static function HEADER($attributes = NULL)
  {
    $DB = $attributes['DB'];
    $CORE = $attributes['CORE'];
    ?>
    <!doctype html>
      <html lang="<?php echo isset($attributes['lang']) ? $attributes['lang']: "EN_US" ; ?>">
      <head>
          <title><?php echo $attributes['title']; ?></title>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <?php
                echo LOADER::EXT_RESOURCES("head", $attributes['resources']);
                $CORE->JS_SESSION();
          ?>
      </head>
      <body>  
      <?php    
  }
  
  static function FOOTER($attributes = NULL)
  {
      $DB = $attributes['DB'];
      echo LOADER::EXT_RESOURCES("body", $attributes['resources']);
      ?>
      </body>
    </html>
  <?php
  }
}
?>