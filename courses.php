<?php
require_once 'includes/db_connect.php';
require_once 'includes/auth.php';

try {
    $stmt = $pdo->query("SELECT * FROM courses ORDER BY department, course_name");
    $courses_from_db = $stmt->fetchAll();
} catch (PDOException $e) {
    $courses_from_db = [];
}

// Map short/abbreviated database course names to full expanded forms
$course_full_names = [
    'B.Sc. Computer Science' => 'Bachelor of Science in Computer Science',
    'Bachelor of Computer Applications (BCA)' => 'Bachelor of Computer Applications',
    'B.Com. (General)' => 'Bachelor of Commerce (General)',
    'B.A. English Literature' => 'Bachelor of Arts in English Literature',
    'B.Sc. Information Technology (B.Sc. IT)' => 'Bachelor of Science in Information Technology'
];

// Details map keyed by full form and standard name
$course_details_map = [
    'Bachelor of Science in Computer Science' => [
        'icon' => 'fa-laptop-code text-primary',
        'duration' => '3 Years (6 Semesters)',
        'eligibility' => 'Higher Secondary (10+2) with Mathematics as a core subject, minimum 50% marks.',
        'curriculum' => [
            'Programming in C++ & Java',
            'Data Structures & Algorithms',
            'Database Management Systems (DBMS)',
            'Operating Systems & Networking',
            'Software Engineering & Web Basics'
        ]
    ],
    'Bachelor of Computer Applications' => [
        'icon' => 'fa-mobile-screen-button text-success',
        'duration' => '3 Years (6 Semesters)',
        'eligibility' => 'Higher Secondary (10+2) in any stream with English, minimum 45% marks.',
        'curriculum' => [
            'Web Technologies (HTML, CSS, JS)',
            'Object-Oriented Programming',
            'Mobile App Development',
            'Cloud Computing Foundations',
            'Software Testing & Projects'
        ]
    ],
    'Bachelor of Commerce (General)' => [
        'icon' => 'fa-chart-pie text-warning',
        'duration' => '3 Years (6 Semesters)',
        'eligibility' => 'Higher Secondary (10+2) in Commerce or Science stream, minimum 50% marks.',
        'curriculum' => [
            'Financial & Management Accounting',
            'Business Law & Corporate Governance',
            'Micro & Macro Economics',
            'Direct & Indirect Taxation (GST)',
            'Auditing & Financial Modeling'
        ]
    ],
    'Bachelor of Arts in English Literature' => [
        'icon' => 'fa-book-open-reader text-danger',
        'duration' => '3 Years (6 Semesters)',
        'eligibility' => 'Higher Secondary (10+2) in any stream with minimum 50% marks in English.',
        'curriculum' => [
            'History of English Literature',
            'Classical & Modern Poetry',
            'Drama & Creative Writing',
            'Linguistics & Phonetics',
            'Literary Criticism & Media Writing'
        ]
    ],
    'Bachelor of Science in Information Technology' => [
        'icon' => 'fa-shield-halved text-info',
        'duration' => '3 Years (6 Semesters)',
        'eligibility' => 'Higher Secondary (10+2) with Mathematics/IT, minimum 45% marks.',
        'curriculum' => [
            'System Administration & Linux',
            'Cybersecurity & Network Security',
            'Web Application Architecture',
            'Big Data & Analytics',
            'IT Infrastructure & DevOps'
        ]
    ]
];

$default_details = [
    'icon' => 'fa-graduation-cap text-secondary',
    'duration' => '3 Years (6 Semesters)',
    'eligibility' => 'Higher Secondary (10+2) from a recognized board with minimum 45% marks.',
    'curriculum' => [
        'Core Foundational Coursework',
        'Specialized Subject Modules',
        'Elective Modules',
        'Practical Laboratory Work'
    ]
];

$is_public_page = true;
$body_class = "courses-page-body";
$page_title = "Academic Courses & Programs";
include 'includes/header.php';
?>

<style>
.course-card-clickable {
    cursor: pointer;
    transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.22s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.2s ease;
    border: 1px solid #e2e8f0 !important;
    background: #ffffff;
    user-select: none;
}
.course-card-clickable:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08) !important;
    border-color: #3b82f6 !important;
}
.course-card-clickable:focus-visible {
    outline: 2px solid #2563eb;
    outline-offset: 2px;
}
.course-card-clickable .course-arrow-icon {
    transition: transform 0.2s ease;
}
.course-card-clickable:hover .course-arrow-icon {
    transform: translateX(4px);
}
</style>

<!-- Course Page Header Banner -->
<div class="bg-white border-bottom py-4 shadow-sm">
    <div class="container">
        <div class="row align-items-center gy-3">
            <div class="col-md-7 text-center text-md-start">
                <span class="text-primary fw-bold small text-uppercase tracking-wider d-block mb-1">
                    <i class="fa-solid fa-graduation-cap me-1"></i> Official Course Catalog
                </span>
                <h2 class="fw-extrabold text-dark mb-0">State College of Technology</h2>
            </div>
            <div class="col-md-5 text-center text-md-end">
                <h4 class="fw-bold text-primary mb-0 mt-3">
                    <i class="fa-solid fa-book-open me-2"></i>Academic Programs & Courses
                </h4>
            </div>
        </div>
    </div>
</div>

<!-- Search & Filter Controls -->
<div class="container my-4">
    <div class="row align-items-center gy-3 bg-white p-3 rounded-4 border">
        <div class="col-12 col-lg-7 mt-0">
            <div class="d-flex align-items-center gap-2 flex-wrap" id="deptFilters">
                <button class="btn btn-primary btn-sm fw-bold px-3 filter-btn active" data-dept="all">All Courses</button>
                <button class="btn btn-outline-secondary btn-sm fw-semibold px-3 filter-btn" data-dept="Science & IT">Science & IT</button>
                <button class="btn btn-outline-secondary btn-sm fw-semibold px-3 filter-btn" data-dept="Commerce">Commerce</button>
                <button class="btn btn-outline-secondary btn-sm fw-semibold px-3 filter-btn" data-dept="Arts & Humanities">Arts & Humanities</button>
            </div>
        </div>
        <div class="col-12 col-lg-5 mt-3 mt-lg-0">
            <div class="input-group">
                <span class="input-group-text bg-white rounded-start-4 border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                <input type="text" id="courseSearch" class="form-control rounded-end-4 border-start-0" placeholder="Search course name or subject...">
            </div>
        </div>
    </div>
</div>

<!-- Course Cards List -->
<div class="container mb-5">
    <?php if (empty($courses_from_db)): ?>
        <div class="alert alert-info text-center shadow-sm py-4">
            <i class="fa-solid fa-circle-info fs-3 mb-2 text-info"></i>
            <h5>No Active Courses Found</h5>
            <p class="mb-0 text-muted">Course database is currently empty. Please check back later or contact admin.</p>
        </div>
    <?php else: ?>
        <div class="row g-4" id="courseCardList">
            <?php foreach ($courses_from_db as $index => $course):
                $c_name = $course['course_name'];
                $full_name = $course_full_names[$c_name] ?? $c_name;
                $details = $course_details_map[$full_name] ?? $course_details_map[$c_name] ?? $default_details;
                $modal_id = !empty($course['course_id']) ? $course['course_id'] : ($index + 1);
            ?>
                <div class="col-md-6 col-lg-4 course-item"
                    data-dept="<?php echo e($course['department']); ?>"
                    data-search="<?php echo e(strtolower($full_name . ' ' . $c_name . ' ' . $course['department'] . ' ' . implode(' ', $details['curriculum']))); ?>">
                    <div class="card h-100 border-0 shadow-sm rounded-4 course-card-clickable p-4 d-flex flex-column justify-content-between"
                        data-bs-toggle="modal"
                        data-bs-target="#courseModal_<?php echo $modal_id; ?>"
                        role="button"
                        tabindex="0"
                        aria-haspopup="dialog"
                        aria-label="<?php echo e($full_name); ?> - Click to view details">
                        <div>
                            <h4 class="card-title fw-bold text-dark mb-3 fs-5"><?php echo e($full_name); ?></h4>
                            <div class="text-muted small d-flex align-items-center">
                                <i class="fa-regular fa-clock me-2 text-primary fs-6"></i>
                                <span><strong>Duration:</strong> <?php echo e($details['duration']); ?></span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-top d-flex align-items-center justify-content-between text-primary small fw-semibold course-view-link">
                            <span>View Details</span>
                            <i class="fa-solid fa-arrow-right course-arrow-icon"></i>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Course Details Dialog Modals -->
        <div id="courseModalsContainer">
            <?php foreach ($courses_from_db as $index => $course):
                $c_name = $course['course_name'];
                $full_name = $course_full_names[$c_name] ?? $c_name;
                $details = $course_details_map[$full_name] ?? $course_details_map[$c_name] ?? $default_details;
                $modal_id = !empty($course['course_id']) ? $course['course_id'] : ($index + 1);
            ?>
                <div class="modal fade" id="courseModal_<?php echo $modal_id; ?>" tabindex="-1" aria-labelledby="courseModalLabel_<?php echo $modal_id; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content rounded-4 border-0 shadow">
                            <div class="modal-header border-bottom px-4 py-3 bg-light rounded-top-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; font-size: 18px;">
                                        <i class="fa-solid <?php echo e($details['icon']); ?>"></i>
                                    </div>
                                    <div>
                                        <h5 class="modal-title fw-bold text-dark mb-0" id="courseModalLabel_<?php echo $modal_id; ?>"><?php echo e($full_name); ?></h5>
                                        <?php if ($c_name !== $full_name): ?>
                                            <small class="text-muted"><?php echo e($c_name); ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <!-- Course Meta Badges / Cards -->
                                <div class="row g-3 mb-4">
                                    <div class="col-6 col-md-3">
                                        <div class="p-3 rounded-3 bg-light text-center h-100 border border-light-subtle">
                                            <span class="text-muted small d-block mb-1"><i class="fa-solid fa-building-columns text-primary me-1"></i>Department</span>
                                            <strong class="text-dark small d-block"><?php echo e($course['department']); ?></strong>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="p-3 rounded-3 bg-light text-center h-100 border border-light-subtle">
                                            <span class="text-muted small d-block mb-1"><i class="fa-regular fa-clock text-primary me-1"></i>Duration</span>
                                            <strong class="text-dark small d-block"><?php echo e($details['duration']); ?></strong>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="p-3 rounded-3 bg-light text-center h-100 border border-light-subtle">
                                            <span class="text-muted small d-block mb-1"><i class="fa-solid fa-users text-success me-1"></i>Total Intake</span>
                                            <strong class="text-dark small d-block"><?php echo e($course['total_seats'] ?? 60); ?> Seats</strong>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="p-3 rounded-3 bg-light text-center h-100 border border-light-subtle">
                                            <span class="text-muted small d-block mb-1"><i class="fa-solid fa-calendar-check text-info me-1"></i>Intake Term</span>
                                            <strong class="text-dark small d-block"><?php echo e($course['semester'] ?? 'Semester I'); ?></strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- Eligibility Criteria -->
                                <div class="mb-4">
                                    <h6 class="fw-bold text-dark d-flex align-items-center gap-2 mb-2">
                                        <i class="fa-solid fa-graduation-cap text-secondary"></i>
                                        <span>Eligibility Criteria</span>
                                    </h6>
                                    <div class="p-3 rounded-3 bg-light border border-light-subtle">
                                        <p class="text-muted small mb-0" style="line-height: 1.6;"><?php echo e($details['eligibility']); ?></p>
                                    </div>
                                </div>

                                <!-- Key Subjects & Curriculum -->
                                <div>
                                    <h6 class="fw-bold text-dark d-flex align-items-center gap-2 mb-2">
                                        <i class="fa-solid fa-list-check text-success"></i>
                                        <span>Key Subjects & Curriculum Modules</span>
                                    </h6>
                                    <div class="row g-2">
                                        <?php foreach ($details['curriculum'] as $item): ?>
                                            <div class="col-12 col-sm-6">
                                                <div class="d-flex align-items-center gap-2 p-2.5 rounded-2 bg-light border border-light-subtle small text-dark">
                                                    <i class="fa-solid fa-circle-check text-success flex-shrink-0"></i>
                                                    <span><?php echo e($item); ?></span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4 d-flex justify-content-between align-items-center">
                                <button type="button" class="btn btn-outline-secondary px-4 fw-semibold" data-bs-dismiss="modal">Close</button>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'student'): ?>
                                    <a href="<?php echo app_url('student/apply.php'); ?>" class="btn btn-primary px-4 fw-bold d-inline-flex align-items-center gap-2">
                                        <i class="fa-solid fa-paper-plane"></i> Apply for Course
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo app_url('student_register.php'); ?>" class="btn btn-primary px-4 fw-bold d-inline-flex align-items-center gap-2">
                                        <i class="fa-solid fa-user-plus"></i> Apply for Admission
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Clean Bottom Call-to-Action -->
    <div class="text-center mt-5 p-4 bg-white rounded shadow-sm border">
        <h4 class="fw-bold text-dark mb-2">Ready to apply for admission?</h4>
        <p class="text-muted mb-3 mx-auto" style="max-width: 550px;">Create your account, fill in your marks, upload required documents, and track your status online.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="student_register.php" class="btn btn-primary fw-bold px-4 py-2"><i class="fa-solid fa-user-plus me-1"></i>Register Account</a>
            <a href="login.php?role=student" class="btn btn-outline-secondary fw-bold px-4 py-2"><i class="fa-solid fa-right-to-bracket me-1"></i>Student Login</a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const searchInput = document.getElementById('courseSearch');
        const cards = document.querySelectorAll('.course-item');

        let activeDept = 'all';
        let searchQuery = '';

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => {
                    b.classList.remove('btn-primary', 'active');
                    b.classList.add('btn-outline-secondary');
                });
                this.classList.remove('btn-outline-secondary');
                this.classList.add('btn-primary', 'active');
                activeDept = this.getAttribute('data-dept');
                filterCards();
            });
        });

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                searchQuery = this.value.toLowerCase().trim();
                filterCards();
            });
        }

        function filterCards() {
            cards.forEach(card => {
                const dept = card.getAttribute('data-dept');
                const searchData = card.getAttribute('data-search');

                const matchesDept = (activeDept === 'all' || dept === activeDept);
                const matchesSearch = (!searchQuery || searchData.includes(searchQuery));

                if (matchesDept && matchesSearch) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Enable keyboard activation (Enter or Space key) for accessible clickable course cards
        document.querySelectorAll('.course-card-clickable').forEach(card => {
            card.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });
    });
</script>

<?php include 'includes/footer.php'; ?>