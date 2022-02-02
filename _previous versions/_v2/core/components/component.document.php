<?php
//writes the HTML code for the document header, wrapping the body elements

class DOCUMENT extends BE_COMPONENT
{
    static function HEADER($params = NULL)
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
            <link rel="stylesheet" href="../../required/bootstrap/css/bootstrap.min.css">
            <title><?php echo $params['title']; ?></title>
          </head>
          <body>

        <?php		
    }

    static function FOOTER($params = NULL)
    {
    ?>
            <script src="../../required/bootstrap/js/bootstrap.bundle.min.js" ></script>
          </body>
        </html>
    <?php
    }
}
?>