<?php
//writes the HTML code for the document header, wrapping the body elements
require_once(ROOT."core/classes/class.assetloader.php");
class DOCUMENT extends CORE\COMPONENT
{
  static function HEADER($params = NULL)
  {
    $DB = $params['DB'];
    $CORE = $params['CORE'];
    ?>
    <!doctype html>
      <html lang="<?php echo isset($params['lang']) ? $params['lang']: "EN_US" ; ?>">
      <head>
          <title><?php echo $params['title']; ?></title>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <?php
                CORE\ASSETLOADER::GET($params['assets'],$DB);
                $CORE->JS_SESSION();
          ?>
      </head>
      <body>  
      <?php    
  }
  
  static function FOOTER($params = NULL)
  {
      $DB = $params['DB'];
      CORE\ASSETLOADER::GET($params['assets'],$DB);
      ?>
      </body>
    </html>
  <?php
  }

  /*static function HEADER($params = NULL)
    {
      // Parameters: Language, Title,
        ?>

        <!doctype html>
        <html lang="<?php echo isset($params['Language']) ? $params['Language']: "EN_US" ; ?>">
          <head>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <!-- Bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

            <title><?php echo $params['title']; ?></title>
          </head>
          <body>

        <?php		
    }*/

    /*static function FOOTER($params = NULL)
    {
    ?>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
          </body>
        </html>
    <?php
    }*/



}
?>