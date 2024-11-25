<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/HarvestEvent.php';

$db = require __DIR__ . '/../../config/database.php';

// Iba uzivatelia v roli farmara
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'farmer') {
    header('Location: index.php?page=login');
    exit();
}

$farmer_id = $_SESSION['user_id'];
$harvestEventModel = new HarvestEvent($db);

// Farmarove harvest events
$harvest_events = $harvestEventModel->getFarmerHarvestEvents($farmer_id);

require __DIR__ . '/../Views/harvest_events.view.php';
