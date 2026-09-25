<?php
require_once __DIR__ . '/auth.php';

$current_page = basename($_SERVER['PHP_SELF']);
$role = current_role() ?: '';
$user_name = $_SESSION['name'] ?? 'Guest';

$student_info = null;
$has_form = false;
$has_docs = false;
$is_paid = false;
$is_final_submitted = false;

if ($role === 'student' && isset($_SESSION['user_id'])) {
    if (!isset($pdo)) {
        require_once __DIR__ . '/db_connect.php';
    }
    try {
        $stmt = $pdo->prepare("SELECT s.*, d.photo, d.marksheet10, d.marksheet12, d.leaving_certificate, d.aadhaar 
                               FROM students s 
                               LEFT JOIN documents d ON s.student_id = d.student_id 
                               WHERE s.user_id = :user_id");
        $stmt->execute(['user_id' => $_SESSION['user_id']]);
        $student_info = $stmt->fetch();

        if ($student_info) {
            $has_form = true;
            $has_docs = (!empty($student_info['photo']) &&
                         !empty($student_info['marksheet10']) &&
                         !empty($student_info['marksheet12']) &&
                         !empty($student_info['leaving_certificate']) &&
                         !empty($student_info['aadhaar']));
            $is_paid = ($student_info['payment_status'] === 'Paid');
            $is_final_submitted = ((int)$student_info['is_submitted'] === 1);
        }
    } catch (PDOException $e) {
    }
}

$nav_items = [
    'admin' => [
        ['href' => 'admin/dashboard.php', 'icon' => 'fa-gauge', 'label' => 'Dashboard', 'pages' => ['dashboard.php']],
        ['href' => 'admin/manage_courses.php', 'icon' => 'fa-book', 'label' => 'Courses', 'pages' => ['manage_courses.php']],
        ['href' => 'admin/manage_staff.php', 'icon' => 'fa-user-tie', 'label' => 'Staff', 'pages' => ['manage_staff.php']],
        ['href' => 'admin/manage_students.php', 'icon' => 'fa-users', 'label' => 'Students', 'pages' => ['manage_students.php', 'add_student.php', 'edit_student.php', 'view_students.php']],
    ],
    'staff' => [
        ['href' => 'staff/dashboard.php', 'icon' => 'fa-gauge', 'label' => 'Dashboard', 'pages' => ['dashboard.php']],
        ['href' => 'staff/reports.php', 'icon' => 'fa-chart-line', 'label' => 'Reports', 'pages' => ['reports.php']],
    ],
    'student' => [
        ['href' => 'student/dashboard.php', 'icon' => 'fa-gauge', 'label' => 'Dashboard', 'pages' => ['dashboard.php'], 'step' => 'dashboard'],
        ['href' => 'student/apply.php', 'icon' => 'fa-file-signature', 'label' => 'Admission Form', 'pages' => ['apply.php'], 'step' => 'apply'],
        ['href' => 'student/upload.php', 'icon' => 'fa-file-arrow-up', 'label' => 'Documents', 'pages' => ['upload.php'], 'step' => 'upload'],
        ['href' => 'student/payment.php', 'icon' => 'fa-credit-card', 'label' => 'Payment', 'pages' => ['payment.php'], 'step' => 'payment'],
        ['href' => 'student/status.php', 'icon' => 'fa-clock-rotate-left', 'label' => 'Status', 'pages' => ['status.php'], 'step' => 'status'],
    ],
];

$items = $nav_items[$role] ?? [];
?>
<nav id="sidebar">
    <div class="sidebar-header">
        <h4><i class="fa-solid fa-graduation-cap me-2"></i>College Portal</h4>
        <small>Welcome, <?php echo e($user_name); ?></small>
    </div>

    <ul class="list-unstyled components">
        <?php foreach ($items as $item):
            $is_locked = false;
            $is_disabled = false;
            $status_icon = '';
            $tooltip = '';
            $step = $item['step'] ?? '';

            if ($role === 'student') {
                if ($step === 'apply') {
                    if ($is_final_submitted) {
                        $is_disabled = true;
                        $status_icon = '<i class="fa-solid fa-circle-check text-success" title="Completed"></i>';
                        $tooltip = 'Application submitted & finalized';
                    } elseif ($has_form) {
                        $status_icon = '<i class="fa-solid fa-circle-check text-success" title="Completed"></i>';
                        $tooltip = 'Admission Form submitted successfully';
                    } else {
                        $tooltip = 'Fill your admission details';
                    }
                } elseif ($step === 'upload') {
                    if (!$has_form) {
                        $is_locked = true;
                        $is_disabled = true;
                        $status_icon = '<i class="fa-solid fa-lock text-muted" title="Locked"></i>';
                        $tooltip = 'Locked: Please submit Admission Form first';
                    } elseif ($is_final_submitted) {
                        $is_disabled = true;
                        $status_icon = '<i class="fa-solid fa-circle-check text-success" title="Completed"></i>';
                        $tooltip = 'Documents uploaded & finalized';
                    } elseif ($has_docs) {
                        $status_icon = '<i class="fa-solid fa-circle-check text-success" title="Completed"></i>';
                        $tooltip = 'Documents uploaded successfully';
                    } else {
                        $tooltip = 'Upload required certificates';
                    }
                } elseif ($step === 'payment') {
                    if (!$has_form || !$has_docs) {
                        $is_locked = true;
                        $is_disabled = true;
                        $status_icon = '<i class="fa-solid fa-lock text-muted" title="Locked"></i>';
                        $tooltip = 'Locked: Upload all required documents first';
                    } elseif ($is_final_submitted) {
                        $is_disabled = true;
                        $status_icon = '<i class="fa-solid fa-circle-check text-success" title="Completed"></i>';
                        $tooltip = 'Application fee paid & finalized';
                    } elseif ($is_paid) {
                        $status_icon = '<i class="fa-solid fa-circle-check text-success" title="Completed"></i>';
                        $tooltip = 'Application fee paid';
                    } else {
                        $tooltip = 'Pay application processing fee';
                    }
                } elseif ($step === 'status') {
                    if ($is_final_submitted) {
                        $status_icon = '<i class="fa-solid fa-circle-check text-success" title="Completed"></i>';
                        $tooltip = 'Application submitted - Track live status';
                    }
                }
            }

            $li_classes = [];
            if (in_array($current_page, $item['pages'], true)) {
                $li_classes[] = 'active';
            }
            if ($is_disabled) {
                $li_classes[] = 'disabled';
            }
            if ($is_locked) {
                $li_classes[] = 'locked';
            }
        ?>
            <li class="<?php echo implode(' ', $li_classes); ?>">
                <?php if ($is_locked): ?>
                    <a href="javascript:void(0);" onclick="event.preventDefault(); return false;" class="disabled-nav-link text-muted" <?php echo !empty($tooltip) ? 'title="' . e($tooltip) . '"' : ''; ?>>
                        <i class="fa-solid <?php echo e($item['icon']); ?> sidebar-left-icon"></i>
                        <span class="sidebar-item-label"><?php echo e($item['label']); ?></span>
                        <?php if ($status_icon): ?>
                            <span class="sidebar-status-icon ms-auto"><?php echo $status_icon; ?></span>
                        <?php endif; ?>
                    </a>
                <?php elseif ($is_disabled): ?>
                    <a href="javascript:void(0);" onclick="event.preventDefault(); return false;" class="disabled-nav-link" <?php echo !empty($tooltip) ? 'title="' . e($tooltip) . '"' : ''; ?>>
                        <i class="fa-solid <?php echo e($item['icon']); ?> sidebar-left-icon"></i>
                        <span class="sidebar-item-label"><?php echo e($item['label']); ?></span>
                        <?php if ($status_icon): ?>
                            <span class="sidebar-status-icon ms-auto"><?php echo $status_icon; ?></span>
                        <?php endif; ?>
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(app_url($item['href'])); ?>" <?php echo !empty($tooltip) ? 'title="' . e($tooltip) . '"' : ''; ?>>
                        <i class="fa-solid <?php echo e($item['icon']); ?> sidebar-left-icon"></i>
                        <span class="sidebar-item-label"><?php echo e($item['label']); ?></span>
                        <?php if ($status_icon): ?>
                            <span class="sidebar-status-icon ms-auto"><?php echo $status_icon; ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>

        <?php if (!empty($items)): ?>
            <li class="nav-divider" aria-hidden="true"></li>
        <?php endif; ?>

        <li class="<?php echo ($current_page === 'profile.php') ? 'active' : ''; ?>">
            <a href="<?php echo e(app_url('profile.php')); ?>"><i class="fa-solid fa-user-gear sidebar-left-icon"></i> <span class="sidebar-item-label">My Profile</span></a>
        </li>
        <li>
            <a href="<?php echo e(app_url('logout.php')); ?>" class="logout-link"><i class="fa-solid fa-right-from-bracket sidebar-left-icon"></i> <span class="sidebar-item-label">Logout</span></a>
        </li>
    </ul>
</nav>