<?php
  if ($_REQUEST && isset($_REQUEST['Body']) && isset($_REQUEST['MediaContentTypes']) && strpos($_REQUEST['MediaContentTypes'], 'image') !== false ){
    $file = 'img/'.sha1(md5($_REQUEST['MediaUrls'])).'.jpg';
    file_put_contents($file, file_get_contents($_REQUEST['MediaUrls']));
    file_put_contents('bin/'.strtolower($_REQUEST['Body']).'.csv', '{"img":"'.$file.'","place":"'.$_REQUEST['FromCity'].', '.$_REQUEST['FromState'].'","time":"'.date('F jS Y h:i:s A').'"}|', FILE_APPEND);
  }elseif ($_REQUEST && isset($_REQUEST['event']) && file_exists('bin/'.$_REQUEST['event'].'.csv')) { ?>
<html>
  <head>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link href="./style.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <script src="./masonry.pkgd.min.js"></script>
    <script type="text/javascript" src="lightbox.js"></script>
  </head>
  <body>
    <div class="container" >
      <div class="row-fluid">
        <div class="span12">
        <h1>Event: <i><?php echo $_REQUEST['event']; ?></i></h1>
        <div id="container" class="js-masonry">
          <?php $mms = str_getcsv(file_get_contents('bin/'.strtolower($_REQUEST['event']).'.csv'),'|');?>
          <?php foreach (array_reverse($mms) as $message) : ?>
            <?php if ($message) : ?>
              <?php $m = json_decode($message); ?>
              <div class="image">
                <a href="<?php echo $m->img ?>" rel="lightbox" title="<?php echo $m->time?>" >
                  <img src="<?php echo $m->img ?>" />
                </a>
                <p class="place"><?php echo $m->place?></p>
                <p class="time"><?php echo $m->time?></p>
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
        }, 500)
      });
    </script>
  </body>
</html>

<?php
  }else {
    echo 'NOPE';
  }