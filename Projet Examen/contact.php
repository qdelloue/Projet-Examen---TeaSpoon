<?php

require __DIR__ . '/autoload.php';

use App\Controller\ContactController;
use App\Manager\ContactManager;

require __DIR__ . '/src/db.php';

$contactManager = new ContactManager($conn);

$contactController = new ContactController($contactManager);
$contactController->index();
