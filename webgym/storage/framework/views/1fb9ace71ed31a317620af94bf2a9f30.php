


<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="max-w-4xl mx-auto mt-6">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Thành công!</strong>
            <span class="block sm:inline"><?php echo e(session('success')); ?></span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" onclick="this.parentElement.parentElement.style.display='none';" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/></svg>
            </span>
        </div>
    </div>
<?php endif; ?>
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

        <!-- RIGHT REGISTER FORM -->
        <div class="w-full px-6 lg:px-10">
            <h2 class="text-3xl font-bold text-blue-600 mb-6">Đăng ký</h2>

            <!-- SOCIAL LOGIN -->
            <div class="flex gap-3 mb-5">
                <button class="w-full border border-gray-300 py-2 rounded-lg flex items-center justify-center gap-2 hover:bg-gray-50 text-gray-700">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5">
                    <span>Đăng ký với Google</span>
                </button>
                <button class="w-full border border-gray-300 py-2 rounded-lg flex items-center justify-center gap-2 hover:bg-gray-50 text-gray-700">
                    <img src="https://www.svgrepo.com/show/512317/github-142.svg" class="w-5 h-5">
                    <span>GitHub</span>
                </button>
            </div>

            <div class="text-center text-gray-500 text-sm mb-4">hoặc dùng email để đăng ký</div>

            <!-- ERRORS -->
            <?php if($errors->any()): ?>
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($err); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- FORM -->
            <form action="<?php echo e(route('register.post')); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                <?php echo csrf_field(); ?>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Username</label>
                    <input name="full_name" value="<?php echo e(old('full_name')); ?>"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none"
                        placeholder="johnndev" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none"
                        placeholder="johndoe@example.com" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none"
                            placeholder="********" required>
                        <button type="button" id="togglePassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-gray-500">
                            Hiện
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none"
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Ảnh đại diện (tùy chọn)</label>
                    <input type="file" name="image"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:rounded">
                </div>

                <!-- SUBMIT BUTTON -->
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition">
                    ĐĂNG KÝ
                </button>

                <div class="text-center text-sm text-gray-600">
                    Đã có tài khoản? 
                    <a href="<?php echo e(route('login')); ?>" class="text-blue-600 hover:underline font-medium">Đăng nhập</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS: Toggle password -->
<script>
document.getElementById('togglePassword')?.addEventListener('click', function () {
    const input = document.getElementById('password');
    const isPass = input.type === 'password';
    input.type = isPass ? 'text' : 'password';
    this.textContent = isPass ? 'Ẩn' : 'Hiện';
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\UIT\Phat_trien_ung_dung_web\DoAnWeb\webgym\resources\views/auth/register.blade.php ENDPATH**/ ?>