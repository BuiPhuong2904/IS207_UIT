


<?php $__env->startSection('content'); ?>
<div class="w-full min-h-screen bg-white py-10">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

        <!-- LEFT IMAGE -->
        <div class="hidden lg:block">
            <div class="rounded-xl overflow-hidden shadow-lg">
                <img src="<?php echo e(asset('images/login/welcome.png')); ?>" 
                     class="w-full h-[500px] object-cover"
                     alt="Welcome Banner">
            </div>
        </div>

        <!-- RIGHT FORGET PASSWORD FORM -->
        <div class="w-full px-6 lg:px-10">
            <h2 class="text-3xl font-bold text-[#0D47A1] mb-2">Quên mật khẩu</h2>
            <p class="text-gray-500 mb-6">Nhập email bạn đã đăng ký. Chúng tôi sẽ gửi mã xác minh gồm 6 số để đặt lại mật khẩu.</p>

            <?php if(session('error')): ?>
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 text-sm"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <form action="<?php echo e(route('forget-password.send')); ?>" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-[#1976D2] focus:outline-none"
                        placeholder="johndoe@email.com" required>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-[#3484d4] to-[#42A5F5] text-white py-3 rounded-full font-semibold shadow-md transition">NHẬN MÃ NGAY</button>

                <div class="text-center text-sm text-gray-600">
                    Bạn đã có tài khoản? <a href="<?php echo e(route('login')); ?>" class="text-[#1976D2] hover:underline font-medium">ĐĂNG NHẬP</a>
                </div>
            </form>
        </div>
    </div>
    
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\UIT\Phat_trien_ung_dung_web\DoAnWeb\webgym\resources\views/auth/forget-password.blade.php ENDPATH**/ ?>