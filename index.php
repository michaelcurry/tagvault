<?php
  if ($_REQUEST && isset($_REQUEST['Body']) && isset($_REQUEST['MediaContentTypes']) && strpos($_REQUEST['MediaContentTypes'], 'image') !== false ){
    file_put_contents('bin/'.strtolower($_REQUEST['Body']).'.csv', $_REQUEST['MediaUrls'].',', FILE_APPEND);
  }elseif ($_REQUEST && isset($_REQUEST['event']) && file_exists($_REQUEST['event'].'.csv')) { ?>
<html>
  <head>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link href="./style.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <script src="./masonry.pkgd.min.js"></script>
  </head>
  <body>
    <div class="container" >
      <div class="row-fluid">
        <div class="span12">
        <h1>Event: <i><?php echo $_REQUEST['event']; ?></i></h1>
        <div id="container" class="js-masonry">
          <?php $images = str_getcsv(file_get_contents('bin/'.strtolower($_REQUEST['event']).'.csv'));?>
          <?php foreach ($images as $image) : ?>
            <?php if ($image) : ?>
              <div class="image">
                <img src="<?php echo $image ?>"/>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
        </div>
      </div>
    </div>

    <script type="text/javascript" charset="utf-8">
      $(document).ready(function(){
        var $container = $('#container');
        // initialize
        setTimeout(function() {
          $container.masonry({
            //columnWidth: 200,
            itemSelector: '.image'
          });
        }, 1000)
      });
    </script>
  </body>
</html>

<?php
  }else {
    echo 'NOPE';
  }