<?php

// បង្កើត folder views ក្នុង /tmp មុនពេល Laravel រត់ (ដើម្បីកុំឲ្យស្ទះ permission)
if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0755, true);
}

require __DIR__ . '/../public/index.php';