<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/HarvestEvent.php';

$db = require __DIR__ . '/../../config/database.php';

// Samozber pre uzivatela
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'customer') {
    header('Location: index.php?page=login');
    exit();
}

$customer_id = $_SESSION['user_id'];
$harvestEventModel = new HarvestEvent($db);

// Dotaznik
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['join_harvest'])) {
        $harvest_event_id = (int)$_POST['harvest_event_id'];

        // check na to aby sme videli ci uz customer je v nejakom samozbere
        $already_joined = $harvestEventModel->isCustomerJoined($customer_id, $harvest_event_id);
        if ($already_joined) {
            header('Location: index.php?page=customer_harvests&error=Už ste prihlásený na tento samozber.');
            exit();
        }

        // check ci je harvest uz plny a ci sa do neho da este vstupit
        $can_join = $harvestEventModel->canJoinHarvestEvent($harvest_event_id);
        if (!$can_join) {
            header('Location: index.php?page=customer_harvests&error=Samozber je plný alebo uzavretý.');
            exit();
        }

        // vstupit do samozberu
        $harvestEventModel->joinHarvestEvent($customer_id, $harvest_event_id);
        header('Location: index.php?page=customer_harvests&success=Úspešne ste sa prihlásili na samozber.');
        exit();
    }

    // opt-outing    
    if (isset($_POST['leave_harvest'])) {
        $harvest_event_id = (int)$_POST['harvest_event_id'];

        // check ci je este prihlaseny
        $already_joined = $harvestEventModel->isCustomerJoined($customer_id, $harvest_event_id);
        if (!$already_joined) {
            header('Location: index.php?page=customer_harvests&error=Nie ste prihlásený na tento samozber.');
            exit();
        }

        // opt-out zo zberu
        $harvestEventModel->leaveHarvestEvent($customer_id, $harvest_event_id);
        header('Location: index.php?page=customer_harvests&success=Úspešne ste sa odhlásili zo samozberu.');
        exit();
    }
}

$joined_harvest_events = $harvestEventModel->getCustomerJoinedHarvestEvents($customer_id);

$available_harvest_events = $harvestEventModel->getAvailableHarvestEvents($customer_id);

require __DIR__ . '/../Views/customer_harvests.view.php';
