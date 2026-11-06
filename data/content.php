<?php
return [

    // MENU AND SECTION ORDER

    'sections' =>
    [
        ['id' => 'home',           'label' => 'HOME'],
        ['id' => 'skillset',       'label' => 'SKILLSET'],
        ['id' => 'projects',       'label' => 'PROJECTS'],
        ['id' => 'visual-content', 'label' => 'VISUAL CONTENT'],
        ['id' => 'certificates',   'label' => 'CERTIFICATIONS'],
        ['id' => 'contact',        'label' => 'CONTACT'],
    ],

    // SKILLSET

    'skills' =>
    [
        'familiar' => [
            'label'  => 'Familiar',
            'blurb'  => 'Comfortable with the fundamentals and still growing in depth.',
            'skills' => [
                'Python',
                'JavaScript',
                'C#',
                'C++',
                'C',
                'Git',
                'Java',
                'Photo Manipulation',
                'Digital Image Editing',
                'Visual Design',
                'Adobe Photoshop',
                'Microsoft Excel',
                'Microsoft PowerPoint'
            ],
        ],

        'proficient' => [
            'label'  => 'Proficient',
            'blurb'  => 'Skills and technologies I’ve grown confident and experienced in through consistent practice and application.',
            'skills' => [
                'HTML',
                'Microsoft Word',
                'CSS',
                'PHP',
                'SQL',
                
                'Photography',
                'Figma',
            ],
        ],
    ],

    'projects' =>
    [
        [
            'title'   => 'Kahit-Saan Restaurant',
            'summary' => 'Kahit-Saan Restaurant System is a self-service kiosk application designed to streamline restaurant ordering. It enables customers to browse and filter menu items, place orders, calculate bills automatically, and split expenses. It also includes an administrative dashboard for menu management and order history monitoring.',
            'overview' => [
                'Kahit-Saan is a self-service ordering system for a Filipino restaurant. Customers browse the menu on their own, build a cart, enter how many people are eating, and get an order ticket with an automatically computed bill. Payment is made at the counter, where the cashier verifies any discount ID.',
                'The system is built around how Philippine restaurants actually bill: it applies the Senior Citizen and PWD discount (20% plus VAT exemption) only to the ID holder’s share and splits the rest evenly among diners. Behind the kiosk, a staff dashboard lets the admin manage dishes, bundles and orders. It is built with PHP, SQL, JavaScript, HTML and CSS.',
            ],
            'users' => [
                ['role' => 'Admin (Staff)', 'desc' => 'Signs in through the staff area to run the restaurant: monitors sales and orders, manages dishes and bundles, confirms payments and cancels orders, and reads customer messages.'],
                ['role' => 'Customer', 'desc' => 'Uses the kiosk without needing an account: browses and filters the menu, adds items and bundles to a cart, checks out, and receives an order ticket to pay at the counter.'],
            ],
            'features' => [
                ['group' => 'Menu browsing and ordering', 'items' => [
                    'Interactive menu with search, category tabs (Bundles, Main Course, Appetizers, Rice & Sides, Dessert and Beverages), price filtering and sorting.',
                    'Bundles and combo meals offered at fixed discounted prices, with the amount saved displayed for each bundle.',
                    'Shopping cart with quantity controls, order confirmations and a floating cart bar displaying the item count and running total.',
                    'Cart management for updating item quantities, removing products and reviewing the order subtotal.',
                    'Checkout form for entering customer details, number of diners and optional Senior Citizen or PWD discount information.',
                ]],
                ['group' => 'Billing and payment', 'items' => [
                    'Automatic bill calculation covering subtotal, VAT exemption, 20% discount and final amount due, with discounts applied only to eligible ID holders.',
                    'Bill-splitting feature that calculates and displays the individual share of regular diners and Senior Citizen or PWD customers.',
                    'Generated order ticket containing a unique ticket number, order date, itemized purchases and a print option.',
                    'Counter-based payment process with order status tracking and payment confirmation.',
                ]],
                ['group' => 'Menu and order management', 'items' => [
                    'Centralized menu management for adding, searching, editing and deleting dishes.',
                    'Bundle management for creating, editing, hiding and deleting meal combinations, including their individual contents and pricing.',
                    'Order monitoring with search by customer name or order number and filters for Waiting for Payment, Paid and Cancelled orders.',
                    'Order details displaying purchased items, complete billing information, discount ID records and individual bill allocations.',
                    'Payment status management for confirming completed payments and cancelling orders.',
                ]],
                ['group' => 'Sales and system monitoring', 'items' => [
                    'Dashboard overview displaying total sales (excluding cancelled orders), total orders, pending payments, discounts given and available menu items.',
                    'Best-selling items report based on the quantity of dishes sold.',
                    'Customer messages inbox for viewing submitted inquiries and messages.',
                    'Direct access to the customer-facing kiosk interface through a View Site link.',
                ]],
            ],
            'images' => [
                ['file' => 'KahitSaan/LandingPage.png', 'label' => 'Customer: landing page', 'caption' => 'Welcome screen with featured bundles and discounts.'],
                ['file' => 'KahitSaan/MenuPage.png', 'label' => 'Customer: menu', 'caption' => 'Searchable menu with categories, filters, and bundle savings.'],
                ['file' => 'KahitSaan/CartAdding.png', 'label' => 'Customer: adding to cart', 'caption' => 'Menu selection with cart updates and order confirmations.'],
                ['file' => 'KahitSaan/CartPage.png', 'label' => 'Customer: cart', 'caption' => 'Order summary with adjustable quantities and item removal.'],
                ['file' => 'KahitSaan/Payment.png', 'label' => 'Customer: checkout', 'caption' => 'Checkout with discounts and automatic bill splitting.'],
                ['file' => 'KahitSaan/Receipt.png', 'label' => 'Customer: order ticket', 'caption' => 'Printable order ticket with itemized totals and discounts.'],
                ['file' => 'KahitSaan/AdminDashboard.png', 'label' => 'Admin: dashboard', 'caption' => 'Sales overview and menu management dashboard.'],
                ['file' => 'KahitSaan/Bundledashboard.png', 'label' => 'Admin: bundles', 'caption' => 'Bundle creation and management with pricing and savings.'],
                ['file' => 'KahitSaan/OrderDashboard.png', 'label' => 'Admin: orders', 'caption' => 'Order records with search, filters, and payment statuses.'],
                ['file' => 'KahitSaan/OrderConfirmation.png', 'label' => 'Admin: order detail', 'caption' => 'Order details with payment confirmation and cancellation controls.'],
            ],
            'code' => ['file' => 'style.css.txt', 'lang' => 'CSS', 'name' => 'style.css']
        ],
        [
            'title'   => 'Zannie\'s Rice Store Website',
            'summary' => 'Zannie’s Rice Store is a clean, modern multi-page website for a small family-owned rice business. It showcases premium rice varieties with photos and clear pricing, tells the store’s story, collects customer feedback, and provides easy ways to get in contact.',
            'overview' => [
                'Zannie’s Rice Store is a static, multi-page website built for a small family-owned rice business. It replaces word-of-mouth price checking with a single place where customers can see every rice variety on offer, compare per-kilo and per-sack prices, read about the family behind the store, and reach out.',
                'The site is built with plain HTML and CSS only: five linked pages (Home, About, Gallery, Feedback, Community) that share one header, navigation and green colour theme so the whole site feels consistent on desktop and mobile.',
            ],
            'users' => [
                ['role' => 'Customer / Visitor', 'desc' => 'Anyone browsing the store. No account or login is needed: they can look through the rice varieties, check prices, read the store’s story, send feedback and find the store’s contact details.'],
            ],
            'features' => [
                ['group' => 'Browsing and pricing', 'items' => [
                    'Landing hero with “Browse Varieties” and “Contact Us” buttons, plus three highlights: farm-fresh quality, fair everyday prices, family-run service.',
                    'Popular Varieties preview on the home page with a “View All” link to the full gallery.',
                    'Gallery of 12 rice varieties, each shown with a photo of its sack and its name.',
                    'Price list table with the price per kilogram and the price per full 25 kg sack for every variety.',
                    'Bulk-buy note: a ₱50 discount when buying a full 25 kg sack.',
                ]],
                ['group' => 'About the store', 'items' => [
                    'Store story (founded August 2024), core values (quality, sustainability, customer first) and a “Meet the Team” section.',
                    'Our Commitment section: handpicked varieties, transparent pricing with bulk savings, friendly local service.',
                ]],
                ['group' => 'Customer interaction', 'items' => [
                    'Feedback form with name, email or phone, and a message box.',
                    'Community page with phone, email, a YouTube link and Facebook, Instagram and Telegram links.',
                    'Shared navigation bar that highlights the page the visitor is on.',
                ]],
            ],
            'images' => [
                ['file' => 'ZannieRiceStore/Landing.png', 'label' => 'Landing page', 'caption' => 'A section featuring the store and key highlights.'],
                ['file' => 'ZannieRiceStore/Home.png', 'label' => 'Home: popular varieties', 'caption' => 'The featured rice varieties and store commitments.'],
                ['file' => 'ZannieRiceStore/AboutPage.png', 'label' => 'About page', 'caption' => 'Store background, values, and team introduction.'],
                ['file' => 'ZannieRiceStore/GalleryPage.png', 'label' => 'Rice gallery', 'caption' => 'Gallery showcasing all available rice varieties.'],
                ['file' => 'ZannieRiceStore/GalleryPricing.png', 'label' => 'Price list', 'caption' => 'Rice pricing per kilogram and 25 kg sack.'],
                ['file' => 'ZannieRiceStore/FeedbackPage.png', 'label' => 'Feedback form', 'caption' => 'Customer feedback submission form.'],
                ['file' => 'ZannieRiceStore/CommunityPage.png', 'label' => 'Community and contact', 'caption' => 'Store contact information and social media links.'],
            ],
            'code'    => ['file' => 'index.html.txt', 'lang' => 'html', 'name' => 'index.html']
        ],
        [
            'title'   => 'University Locker System',
            'summary' => 'This system is a web-based platform designed to organize and manage campus locker reservations. It replaces the manual process of checking availability, submitting requests, and tracking assignments with a centralized online application.',
            'overview' => [
                'The University Locker Management System is a web application that handles the whole life of a campus locker rental: finding an available locker, reserving it, paying for it, getting it assigned, and tracking it until the rental ends. It replaces the manual process of asking around for free lockers and keeping assignments on paper.',
                'It is role-based. After signing in, each user lands on their own portal with only the menu items their role needs: students manage their own locker, registrars verify payments and assignments, and the superadmin controls users, lockers, pricing and records. It is built with PHP, SQL, JavaScript, HTML and CSS.',
            ],
            'users' => [
                ['role' => 'Superadmin', 'desc' => 'The system administrator. Oversees the whole system: user accounts, the locker and building inventory, reservation pricing, and the full transaction and audit history.'],
                ['role' => 'Registrar', 'desc' => 'Campus office staff. Handle day-to-day operations: reviewing reservation applications, verifying payments made at the office, assigning lockers, approving location changes, and viewing reports.'],
                ['role' => 'Student', 'desc' => 'The locker renter. Browses available lockers, applies for one, follows the application status, views their assigned locker and days remaining, and can request a location change.'],
            ],
            'features' => [
                ['group' => 'Locker browsing and reservations', 'items' => [
                    'Locker directory covering 6 buildings and 6 floors per building, with 25 lockers per floor.',
                    'Browse lockers by building and floor, search by locker number, and view each locker’s location and availability status (Available, Held or Occupied).',
                    'Locker reservation system that allows students to reserve available lockers, with a 7-day hold while payment is pending.',
                    'Reservation application tracking with submission status, payment status, assigned locker details and reservation history.',
                    'Locker rental options: Half Semester (2 months), Whole Semester (4 months) and Full Year (8 months).',
                    'Location Change request feature for requesting a different locker location.',
                ]],
                ['group' => 'Locker administration and management', 'items' => [
                    'Centralized locker inventory management for creating, editing, deactivating and deleting lockers.',
                    'Building and floor organization with editable building names and descriptions.',
                    'Locker occupancy overview displaying available, held, occupied and inactive lockers, with building and floor filters.',
                    'Reservation management for reviewing applications, updating statuses, cancelling reservations and recording remarks.',
                    'Payment verification feature for confirming payments made at the registrar’s office before assigning lockers.',
                    'Location Change request management for reviewing and processing relocation requests.',
                ]],
                ['group' => 'Accounts and system access', 'items' => [
                    'Account management for creating and maintaining student and registrar accounts.',
                    'User directory with search and filters for student ID, name and account role.',
                    'Account access control with options to revoke or reactivate accounts.',
                    'Separate authentication and dashboard interfaces for students, registrars and system administrators.',
                ]],
                ['group' => 'Transactions and monitoring', 'items' => [
                    'Transaction History containing a permanent record of reservation submissions, payment claims, locker assignments, cancellations and approved location changes.',
                    'Transaction filtering by student and payment type for easier record retrieval.',
                    'Operational Reports providing an overview of locker reservations and system activity.',
                    'Audit Logs recording administrative activities for accountability and monitoring.',
                    'Dashboard statistics displaying student and registrar accounts, total lockers, locker availability, occupancy and pending applications.',
                ],
            ],
            ],
            'images' => [
                ['file' => 'LockerSystem/LoginPage.png', 'label' => 'Login page', 'caption' => 'Role-based login for students, registrars, and superadmins.'],
                ['file' => 'LockerSystem/StudentDashboard.png', 'label' => 'Student: dashboard', 'caption' => 'Student overview of applications, locker assignments, and notifications.'],
                ['file' => 'LockerSystem/StudentBrowseLockers.png', 'label' => 'Student: browse lockers', 'caption' => 'Locker listings by building and floor with availability status.'],
                ['file' => 'LockerSystem/StudentBrowseLockersFiltered.png', 'label' => 'Student: search a locker', 'caption' => 'Filtered locker listings based on locker number.'],
                ['file' => 'LockerSystem/StudentLockerProfile.png', 'label' => 'Student: my locker', 'caption' => 'Assigned locker details, rental period, and current status.'],
                ['file' => 'LockerSystem/RegistrarAppBoard.png', 'label' => 'Registrar: applications board', 'caption' => 'Reservation applications with search, filters, and status management.'],
                ['file' => 'LockerSystem/RegistrarAssignmentBoard.png', 'label' => 'Registrar: assignments board', 'caption' => 'Locker assignments with rental periods and status tracking.'],
                ['file' => 'LockerSystem/SuperadminDashboard.png', 'label' => 'Superadmin: dashboard', 'caption' => 'System overview with user statistics and locker occupancy.'],
                ['file' => 'LockerSystem/SuperadminUserManagement.png', 'label' => 'Superadmin: user management', 'caption' => 'Account management with role filters and access controls.'],
                ['file' => 'LockerSystem/SuperadminLockerInventory.png', 'label' => 'Superadmin: locker inventory', 'caption' => 'Locker inventory management with creation, editing, and status controls.'],
                ['file' => 'LockerSystem/SuperadminHistory.png', 'label' => 'Superadmin: transaction history', 'caption' => 'Searchable transaction records and activity history.'],
            ],
            'code'    => ['file' => 'browse.php.txt', 'lang' => 'PHP', 'name' => 'browse.php']
        ],
        [
            'title'   => 'DigiLearn',
            'summary' => 'DigiLearn is a structured tutorial website for learning Adobe Photoshop. Students learn the purpose and use of each tool, gain a clear understanding of the fundamentals and theoretical principles of image editing, and develop actual hands-on skills through progressive lessons, quizzes, and practical exercises.',
            'overview' => [
                'DigiLearn is a gamified learning website for Adobe Photoshop. Instead of a flat list of tutorials, learners progress through Easy, Medium and Hard lessons, test themselves with quizzes, complete hands-on tasks, earn XP and badges, and climb four ranks toward “Supreme” while competing on a leaderboard.',
                'Learning is split into two kinds of progress: knowledge (lessons and quizzes, scored automatically) and skills (practical work that a professor or admin reviews and approves). The site is built with PHP, SQL, JavaScript, HTML and CSS and uses a dark, glowing interface.',
            ],
            'users' => [
                ['role' => 'Admin', 'desc' => 'Controls the whole platform: toolbox content, lessons and quizzes, user accounts and roles, student progress, approvals of professor submissions, skill approvals and the bulletin board.'],
                ['role' => 'Professor', 'desc' => 'Guides a cohort: views the student roster, exports performance, proposes lessons, and approves or rejects students’ skill-based submissions.'],
                ['role' => 'Student', 'desc' => 'The learner. Studies the tools, takes lessons and quizzes, submits practical work, earns XP, badges and ranks, and tracks their own progress.'],
            ],
            'features' => [
                ['group' => 'Learning', 'items' => [
                    'Toolbox: a searchable library of Photoshop tools (Move, Marquee, Brush, Layers panel and more) that explains what each tool does.',
                    'Lessons grouped into Easy, Medium and Hard, each showing whether it has been attempted.',
                    'Lesson pages with explanatory content, a “Start Quiz!” button and an “Expand your skills!” hands-on task.',
                    'Quizzes that score knowledge; results sort each lesson into Mastered, Proficient, Basic Understanding or Needs Improvement.',
                    'Skill-based tasks: students upload an image or video of their work, optionally share it to the bulletin board, and it is reviewed before skill progress counts.',
                ]],
                ['group' => 'Gamification', 'items' => [
                    'XP system with four ranks: Awakened, Ascended, Transcendent and Supreme.',
                    'Badges with clear requirements (such as First Step or Medium Challenger) that unlock with a pop-up and an earned date.',
                    'Leaderboard and a “welcome back” greeting that shows the learner’s rank.',
                    'Bulletin Board Gallery on the home page that shows approved student works.',
                ]],
                ['group' => 'Student dashboard', 'items' => [
                    'Overall progress bar, progress by difficulty (knowledge and skills), and mastery level for every lesson.',
                ]],
                ['group' => 'Professor tools', 'items' => [
                    'Student roster, management panel and pending skill approvals.',
                    'Export learner performance and propose new lessons.',
                ]],
                ['group' => 'Admin control panel', 'items' => [
                    'Full create, read, update and delete for toolbox icons, lessons and quizzes.',
                    'User management: activate or deactivate accounts and change roles.',
                    'Student progress overview by difficulty, including pending work.',
                    'Approve or reject professor submissions and skill submissions.',
                    'Manage the shared bulletin board.',
                ]],
            ],
            'images' => [
                ['file' => 'DigiLearn/LandingPage.png', 'label' => 'Landing page', 'caption' => 'Platform introduction, ranking system, and bulletin board preview.'],
                ['file' => 'DigiLearn/GreetingPage.png', 'label' => 'Welcome-back greeting', 'caption' => 'Personalized welcome message based on the learner’s rank.'],
                ['file' => 'DigiLearn/LessonPage.png', 'label' => 'Toolbox and lessons', 'caption' => 'Searchable Photoshop toolbox and structured lessons.'],
                ['file' => 'DigiLearn/Quizzes.png', 'label' => 'Lesson and quiz entry', 'caption' => 'Lesson materials with quizzes and practical exercises.'],
                ['file' => 'DigiLearn/SkillBased.png', 'label' => 'Skill-based task', 'caption' => 'Practical exercises with submission and review features.'],
                ['file' => 'DigiLearn/Badges.png', 'label' => 'Badge unlocked', 'caption' => 'Achievement notification for completed badge requirements.'],
                ['file' => 'DigiLearn/StudentDashboard.png', 'label' => 'Student: progress dashboard', 'caption' => 'Learning progress, quiz performance, and lesson mastery tracking.'],
                ['file' => 'DigiLearn/AchievementPage.png', 'label' => 'Badges and achievements', 'caption' => 'Achievement collection with badges.'],
                ['file' => 'DigiLearn/AdminDashboard.png', 'label' => 'Professor dashboard', 'caption' => 'Professor overview of student progress and management tools.'],
                ['file' => 'DigiLearn/AdminPanel.png', 'label' => 'Admin control panel', 'caption' => 'Centralized management of lessons, quizzes, users, and submissions.'],
                ['file' => 'DigiLearn/Approved.png', 'label' => 'Skill approvals', 'caption' => 'Student submission review'],
            ],
            'code'    => ['file' => 'ui.js.txt', 'lang' => 'JavaScript', 'name' => 'ui.js']
        ],
    ],

    // VISUAL CONTENT 

    'photography' =>
    [
        ['file' => 'AWalkHome.jpeg', 'title' => 'A Walk Home', 'category' => 'Photography'],
        ['file' => 'MockupSocmedIG.png', 'title' => 'TEA-RRIFIC! Mockup Instagram Post', 'category' => 'Edited Work'],
        ['file' => 'MuseumOfNationalHistory.jpg', 'title' => 'Museum Of National History', 'category' => 'Photography'],
        ['file' => 'MockupBanner.png', 'title' => 'Kalbo-rgers Mockup Flyers', 'category' => 'Edited Work'],
        ['file' => 'RacingHeritage.jpg', 'title' => 'Racing Heritage', 'category' => 'Photography'],
        ['file' => 'PromotionBanner.png', 'title' => 'Kalbo-rgers Promotional Banner', 'category' => 'Edited Work'],
        ['file' => 'WingedAngel.jpg', 'title' => 'Winged Angel', 'category' => 'Photography'],
        ['file' => 'Brandboard.png', 'title' => 'TEA-RRIFIC! Brandboard', 'category' => 'Edited Work'],
        ['file' => 'AfterANighout.jpg', 'title' => 'After a Nighout', 'category' => 'Photography'],
        ['file' => 'MockupSocmedFB.png', 'title' => 'Kalbo-rgers Mockup Facebook Post', 'category' => 'Edited Work'],
        ['file' => 'GoldenAlley.jpeg', 'title' => 'Golden Alley', 'category' => 'Photography'],
        ['file' => 'Banner.png', 'title' => 'TEA-RRIFIC! Banner', 'category' => 'Edited Work'],
        ['file' => 'SculptedTree.jpg', 'title' => 'Sculpted Tree', 'category' => 'Photography'],
        ['file' => 'MockupPlastic.png', 'title' => 'TEA-RRIFIC! Plastic Mockup', 'category' => 'Edited Work'],
        ['file' => 'CrispyCutlet.jpeg', 'title' => 'Crispy Cutlet', 'category' => 'Photography'],
        ['file' => 'PinkZinnia.jpg', 'title' => 'Pink Zinnia', 'category' => 'Photography'],
        ['file' => 'LotusTemple.jpg', 'title' => 'Lotus Temple', 'category' => 'Photography'],
        ['file' => 'VintageAutomotive.jpg', 'title' => 'Vintage Automotive', 'category' => 'Photography'],
    ],

    // CERTIFICATIONS

    'certificates' =>
    [
        [
            'name'   => 'Using HTML and CSS to Design a Website',
            'issuer' => 'IDepartment of Information and Communications Technology',
            'date'   => 'November 2026',
            'image'  => 'HTMLAndCSS.png',
        ],
        [
            'name'   => 'Fraud & Scam Prevention',
            'issuer' => 'Department of Information and Communications Technology',
            'date'   => 'November 2026',
            'image'  => 'ScamsAndFrauds.png',
        ],
        [
            'name'   => 'Essential Computer Operation and Maintenance Tips',
            'issuer' => 'Department of Information and Communications Technology',
            'date'   => 'Novermber 2026',
            'image'  => 'ComputerTips.png',
        ],
        [
            'name'   => 'Principles of Web Development and Introduction to HTML',
            'issuer' => 'Department of Information and Communications Technology',
            'date'   => 'Novermber 2026',
            'image'  => 'PrinciplesOfWebDev.png',
        ],
    ],

    // CONTACT

    'contact' =>
    [
        'intro'      => "Have a project, an opportunity, or just want to say hello? Pick what fits, add a few details, and send it.",
        'blurb'      => 'Your message opens in your own email app or Gmail, ready to send. You can also reach me through any of these platforms.',
        'reply'      => 'I usually reply within 1 to 2 business days.',

        'email'      => 'marcuxcauagas@gmail.com',     // replace with your real address
        'showEmail' => true,

        'intents' => [
            ['id' => 'inquiry',   'label' => 'Inquiry',          'subject' => 'Inquiry from your portfolio',
             'placeholder' => 'What would you like to know? Project contexts, links, photos, works I do etc...',
             'starter'     => 'Hi, I have an inquiry.'],
            ['id' => 'fullCode', 'label' => 'Full Code Access', 'subject' => 'Full code access request',
             'placeholder' => 'Which project, and what would you like to do with the code?',
             'starter'     => 'Hi, I would like to request access to the full code.'],
            ['id' => 'hireMe',    'label' => 'Hire Me',   'subject' => 'Hello, I would like to have you to work on my project.',
             'placeholder' => 'Do you have some work for me?',
             'starter'     => 'Hello, I\'m looking for'],
        ],

        'socials' => [
            ['label' => 'GitHub',    'url' => 'https://github.com/MarcuxAndreiMallari',      'icon' => 'github'],
            ['label' => 'LinkedIn',  'url' => 'https://www.linkedin.com/in/marcux-andrei-mallari', 'icon' => 'linkedin'],
            ['label' => 'Facebook',  'url' => 'https://www.facebook.com/share/1Kk4Y9tWWB/',    'icon' => 'facebook'],
            ['label' => 'Instagram', 'url' => 'https://www.instagram.com/n0t.mrx?exln=d29hOXB6MmF2eTN3',   'icon' => 'instagram'],
        ],
    ],
];
