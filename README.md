## Download your project

## Change your config .env


## Follow this steps

1 - Copy all files inside clubi/public/js and clubi/public/css
2 - Past them all on your folder js and css 


## Remove comment /** */ from file club/bootstrap/app.php

make code like this : 

$app->bind('path.public', function() {
      return __DIR__ . '/../../';
});
