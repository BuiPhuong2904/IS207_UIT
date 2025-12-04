<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'GRYND'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/chatbot.js', 'resources/js/app.js']); ?>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-open-sans bg-[#F5F7FA] text-[#333333]">

    <?php if ($__env->exists('user.layouts.header')) echo $__env->make('user.layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="h-16"></div>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php if ($__env->exists('user.layouts.footer')) echo $__env->make('user.layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>
</html>
<?php /**PATH D:\UIT\Phat_trien_ung_dung_web\DoAnWeb\webgym\resources\views/layouts/app.blade.php ENDPATH**/ ?>