<?php
// Simulate POST to User_Login_Check.php
$_POST['val_01'] = 'admin@neosolution.com';
$_POST['val_02'] = 'admin123';

ob_start();
include __DIR__ . '/../../View-List/Main/User_Login_Check.php';
$out = ob_get_clean();

echo "--- ADMIN LOGIN OUTPUT ---\n";
echo $out . "\n";

// Now test employee login
$_POST['val_01'] = 'rathugedn@gmail.com';
$_POST['val_02'] = 'emp123';

ob_start();
include __DIR__ . '/../../View-List/Main/User_Login_Check.php';
$out2 = ob_get_clean();

echo "--- EMPLOYEE LOGIN OUTPUT ---\n";
echo $out2 . "\n";
