

<?php $__env->startSection('content'); ?>
<div class="container" style="padding: 40px 0; background: #f8f9fa; min-height: calc(100vh - 80px);">
    <!-- Profile Header -->
    <div style="background: linear-gradient(135deg, #E8F0FE 0%, #FFFFFF 100%); border-radius: 16px; padding: 30px; margin-bottom: 20px; box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 20px;">
                <img src="<?php echo e(user_avatar($user, 'lg')); ?>" alt="<?php echo e($user->name); ?>" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid rgba(255, 255, 255, 0.8); box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                <div>
                    <h1 style="color: #4a90e2; font-size: 24px; font-weight: 600; margin: 0 0 4px 0;">Welcome, <?php echo e($user->first_name ?? explode(' ', $user->name)[0]); ?></h1>
                    <div style="color: #6b7280; font-size: 14px; margin-bottom: 16px;"><?php echo e($user->city ?? 'Dhaka'); ?>, <?php echo e($user->country ?? 'Bangladesh'); ?></div>
                    
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px;">
                        <div>
                            <div style="color: #1f2937; font-size: 20px; font-weight: 600; margin: 0 0 2px 0;"><?php echo e($user->name); ?></div>
                            <div style="color: #6b7280; font-size: 14px; margin: 0;"><?php echo e($user->email); ?></div>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="display: flex; gap: 2px;">
                            <span style="color: #fbbf24; font-size: 16px;">★</span>
                            <span style="color: #fbbf24; font-size: 16px;">★</span>
                            <span style="color: #fbbf24; font-size: 16px;">★</span>
                            <span style="color: #fbbf24; font-size: 16px;">★</span>
                            <span style="background: linear-gradient(90deg, #fbbf24 50%, #d1d5db 50%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 16px;">★</span>
                        </div>
                        <span style="color: #1f2937; font-size: 16px; font-weight: 600;">4.5/5</span>
                        <span style="color: #8A9BAD; font-size: 13px; font-weight: 500;">1,230 User Reviews</span>
                    </div>
                </div>
            </div>
            <a href="<?php echo e(route('profile.show')); ?>" style="background: #4182F9; color: white; border: none; border-radius: 8px; padding: 10px 20px; font-size: 14px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(65, 130, 249, 0.3);">
                Edit
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div style="background: white; border-radius: 16px; padding: 30px; box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);">
        <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #374151; font-size: 14px; font-weight: 500; margin-bottom: 6px;" for="first_name">First Name</label>
                    <input 
                        type="text" 
                        style="width: 100%; height: 44px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 0 14px; font-size: 15px; color: #374151; box-sizing: border-box;" 
                        id="first_name" 
                        name="first_name" 
                        value="<?php echo e(old('first_name', $user->first_name)); ?>"
                        placeholder="Your First Name"
                    >
                    <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #374151; font-size: 14px; font-weight: 500; margin-bottom: 6px;" for="last_name">Last Name</label>
                    <input 
                        type="text" 
                        style="width: 100%; height: 44px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 0 14px; font-size: 15px; color: #374151; box-sizing: border-box;" 
                        id="last_name" 
                        name="last_name" 
                        value="<?php echo e(old('last_name', $user->last_name)); ?>"
                        placeholder="Your Last Name"
                    >
                    <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #374151; font-size: 14px; font-weight: 500; margin-bottom: 6px;" for="gender">Gender</label>
                    <select style="width: 100%; height: 44px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 0 14px; font-size: 15px; color: #374151; box-sizing: border-box;" id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="male" <?php echo e(old('gender', $user->gender) == 'male' ? 'selected' : ''); ?>>Male</option>
                        <option value="female" <?php echo e(old('gender', $user->gender) == 'female' ? 'selected' : ''); ?>>Female</option>
                        <option value="other" <?php echo e(old('gender', $user->gender) == 'other' ? 'selected' : ''); ?>>Other</option>
                    </select>
                    <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #374151; font-size: 14px; font-weight: 500; margin-bottom: 6px;" for="country">Country</label>
                    <select style="width: 100%; height: 44px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 0 14px; font-size: 15px; color: #374151; box-sizing: border-box;" id="country" name="country">
                        <option value="">Select Country</option>
                        <option value="Bangladesh" <?php echo e(old('country', $user->country) == 'Bangladesh' ? 'selected' : ''); ?>>Bangladesh</option>
                        <option value="India" <?php echo e(old('country', $user->country) == 'India' ? 'selected' : ''); ?>>India</option>
                        <option value="Pakistan" <?php echo e(old('country', $user->country) == 'Pakistan' ? 'selected' : ''); ?>>Pakistan</option>
                        <option value="Nepal" <?php echo e(old('country', $user->country) == 'Nepal' ? 'selected' : ''); ?>>Nepal</option>
                        <option value="Sri Lanka" <?php echo e(old('country', $user->country) == 'Sri Lanka' ? 'selected' : ''); ?>>Sri Lanka</option>
                    </select>
                    <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #374151; font-size: 14px; font-weight: 500; margin-bottom: 6px;" for="email">Email</label>
                    <input 
                        type="email" 
                        style="width: 100%; height: 44px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 0 14px; font-size: 15px; color: #374151; box-sizing: border-box;" 
                        id="email" 
                        name="email" 
                        value="<?php echo e(old('email', $user->email)); ?>"
                        placeholder="Your Email"
                    >
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #374151; font-size: 14px; font-weight: 500; margin-bottom: 6px;" for="phone">Phone</label>
                    <input 
                        type="tel" 
                        style="width: 100%; height: 44px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 0 14px; font-size: 15px; color: #374151; box-sizing: border-box;" 
                        id="phone" 
                        name="phone" 
                        value="<?php echo e(old('phone', $user->phone)); ?>"
                        placeholder="Your Phone Number"
                    >
                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #374151; font-size: 14px; font-weight: 500; margin-bottom: 6px;" for="city">City</label>
                    <input 
                        type="text" 
                        style="width: 100%; height: 44px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 0 14px; font-size: 15px; color: #374151; box-sizing: border-box;" 
                        id="city" 
                        name="city" 
                        value="<?php echo e(old('city', $user->city)); ?>"
                        placeholder="Your City"
                    >
                    <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #374151; font-size: 14px; font-weight: 500; margin-bottom: 6px;" for="post_code">Post Code</label>
                    <input 
                        type="text" 
                        style="width: 100%; height: 44px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 0 14px; font-size: 15px; color: #374151; box-sizing: border-box;" 
                        id="post_code" 
                        name="post_code" 
                        value="<?php echo e(old('post_code', $user->post_code)); ?>"
                        placeholder="Your Post Code"
                    >
                    <?php $__errorArgs = ['post_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="grid-column: 1 / -1; margin-bottom: 20px;">
                    <label style="display: block; color: #374151; font-size: 14px; font-weight: 500; margin-bottom: 6px;" for="address">Address</label>
                    <textarea 
                        style="width: 100%; height: 100px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 14px; font-size: 15px; color: #374151; resize: vertical; box-sizing: border-box; font-family: inherit;" 
                        id="address" 
                        name="address" 
                        placeholder="Your Full Address"
                    ><?php echo e(old('address', $user->address)); ?></textarea>
                    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                <a href="<?php echo e(route('profile.show')); ?>" style="padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; background: transparent; color: #6b7280; border: 1px solid #d1d5db;">
                    Cancel
                </a>
                <button type="submit" style="padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; border: none; background: #4182F9; color: white; box-shadow: 0 2px 8px rgba(65, 130, 249, 0.3);">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\neighbournet-laravel-backup\resources\views/profile/edit.blade.php ENDPATH**/ ?>