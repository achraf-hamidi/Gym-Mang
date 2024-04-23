<!DOCTYPE html>
<html dir="<?php if(session()->get('dir')): ?><?php echo e(session()->get('dir')); ?><?php else: ?> ltr <?php endif; ?>" lang="<?php if(session()->get('locale')): ?><?php echo e(session()->get('locale')); ?><?php else: ?> fr <?php endif; ?>">
    <head>
        <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
       <title>CLUBI</title>
       <link rel="icon" type="image/png" href="<?php echo e(asset('/admin/favicon32.png?v=3.1.9')); ?>">
       <meta property="url" content="https://clubi.com/" />
       <meta property="title" content="CLUBI - Logiciel de gestion des clubs de sport" />
      <meta property="description" content="CLUBI, Une solution de gestion complète de votre club" /> 

      <link rel="stylesheet" href="<?php echo e(asset('/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css?v=3.1.9')); ?>"> 
      <link rel="stylesheet" href="<?php echo e(asset('/assets/css/shared/style.css?v=3.1.9')); ?>">
      <link rel="stylesheet" href="<?php echo e(asset('/assets/css/demo_1/style.css?v=3.1.9')); ?>"> 
      <link href="<?php echo e(asset('/css/app.css?v=3.1.9')); ?>" rel="stylesheet">
      <script src="<?php echo e(asset('/js/app.js?v=3.1.9')); ?>" defer></script>
      
      <style type="text/css">
      table.datatables {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
      }
      .datatables th, .datatables td {
        text-align: left;
        padding: 8px;
      }
      .datatables tr:nth-child(even){background-color: #f2f2f2}
      </style>
  </head>
  <body>
      <div class="container-scroller" id="app" >
          <?php if(Auth::check()): ?>
          <main-component :user="<?php echo e(Auth::user()); ?>" ></main-component>
          <?php elseif(Auth::guard('adherent')->check()): ?>
          <main-component :user="<?php echo e(Auth::guard('adherent')->user()); ?>"></main-component> 
          <?php endif; ?>
      </div> 
      <script src="https://code.jquery.com/jquery-3.5.1.js?v=3.1.9"></script> 
      <script>
          window.Laravel = <?php echo json_encode([
              'csrfToken' => csrf_token(),
           ]); ?>;
      </script>
      <script>
        <?php if(auth()->guard()->check()): ?>
          window.userPermissions = <?php echo json_encode(Auth::user()->userPermissions, true); ?>;
          window.ListPermissions = <?php echo json_encode(Auth::user()->listPermissions, true); ?>; 
        <?php else: ?>
          window.userPermissions = [];
        <?php endif; ?>
      </script>
    </body>
</html><?php /**PATH /Users/achrafhamidi/Desktop/DEV/Clubi-V1.3/clubi/resources/views/welcome.blade.php ENDPATH**/ ?>