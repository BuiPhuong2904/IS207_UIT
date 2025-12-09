

<?php $__env->startSection('content'); ?>
<div class="max-w-lg mx-auto mt-12 p-6 bg-white rounded shadow">
  <h2 class="text-2xl font-bold mb-4">Đặt lại mật khẩu</h2>

  <?php if($errors->any()): ?>
    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
      <ul class="list-disc pl-5">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="POST" action="<?php echo e(route('password.update')); ?>">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="token" value="<?php echo e($token); ?>">
    <label class="block mb-2">Email</label>
    <input name="email" type="email" value="<?php echo e(old('email', $email ?? '')); ?>" required class="w-full p-2 border rounded mb-4">

    <label class="block mb-2">Mật khẩu mới</label>
    <input name="password" type="password" required class="w-full p-2 border rounded mb-4">

    <label class="block mb-2">Xác nhận mật khẩu</label>
    <input name="password_confirmation" type="password" required class="w-full p-2 border rounded mb-4">

    <button type="submit" class="w-full bg-gradient-to-r from-[#3484d4] to-[#42A5F5] text-white py-3 rounded-full font-semibold shadow-md transition">
      ĐẶT LẠI MẬT KHẨU
    </button>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\UIT\Phat_trien_ung_dung_web\DoAnWeb\webgym\resources\views/auth/reset-password.blade.php ENDPATH**/ ?>