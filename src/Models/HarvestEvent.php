<?php

class HarvestEvent
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    
    // samozber pocet a samotny zakaznici
    public function getFarmerHarvestEvents($farmer_id)
    {
        $stmt = $this->db->prepare("
            SELECT he.*, COUNT(shc.id) AS participant_count
            FROM harvest_events he
            LEFT JOIN self_harvest_customers shc ON he.id = shc.harvest_event_id
            WHERE he.farmer_id = ?
            GROUP BY he.id
            ORDER BY he.start_date DESC
        ");
        $stmt->execute([$farmer_id]);
        $harvest_events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // iba mena zakaznikov
        foreach ($harvest_events as &$event) {
            $event['participants'] = $this->getParticipants($event['id']);
        }

        return $harvest_events;
    }

    // Mena zakaznikov query
    private function getParticipants($harvest_event_id)
    {
        $stmt = $this->db->prepare("
            SELECT u.name
            FROM self_harvest_customers shc
            JOIN users u ON shc.customer_id = u.id
            WHERE shc.harvest_event_id = ?
        ");
        $stmt->execute([$harvest_event_id]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
