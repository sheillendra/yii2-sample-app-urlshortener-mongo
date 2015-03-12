<!DOCTYPE html>
<html>
<head>
    <meta HTTP-EQUIV="Refresh" CONTENT="0; URL=<?= $this->params['url']?>">
</head>
<body>
    <?php header('Location:'.$this->params['url']);?>
</body>    
</html>
