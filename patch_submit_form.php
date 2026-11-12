<?php
$file = __DIR__ . '/UxUi-Back/Employee/forms/submit_employee_form.php';
$c = file_get_contents($file);

// Default department and job title
$c = str_replace(
    "\$department = isset(\$_POST['department']) && trim(\$_POST['department']) !== '' ? trim(\$_POST['department']) : 'Engineering';",
    "\$department = isset(\$_POST['department']) && trim(\$_POST['department']) !== '' ? trim(\$_POST['department']) : 'Unassigned';",
    $c
);

// Email subject and title
$c = str_replace(
    "\$mail_subject = \"[Action Required] New Employee Registration Form Submitted - {\$full_name}\";",
    "\$mail_subject = \"[Action Required] New Staff Registration Submitted - {\$full_name}\";",
    $c
);
$c = str_replace(
    "<h2 style='margin: 0 0 6px; font-size: 20px;'>New Employee Registration Form Submitted</h2>",
    "<h2 style='margin: 0 0 6px; font-size: 20px;'>New Staff Registration Submitted</h2>",
    $c
);
$c = str_replace(
    "<p style='margin: 0; font-size: 13.5px; opacity: 0.9;'>Pending Administrator Review &amp; Approval</p>",
    "<p style='margin: 0; font-size: 13.5px; opacity: 0.9;'>Pending Super Administrator Review &amp; Role/Department Assignment</p>",
    $c
);

file_put_contents($file, $c);
echo "SUBMIT_FORM_PATCHED\n";

