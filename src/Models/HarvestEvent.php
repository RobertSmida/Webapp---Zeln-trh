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

    public function getCustomerJoinedHarvestEvents($customer_id)
    {
        $stmt = $this->db->prepare("
            SELECT he.*
            FROM harvest_events he
            JOIN self_harvest_customers shc ON he.id = shc.harvest_event_id
            WHERE shc.customer_id = ?
        ");
        $stmt->execute([$customer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableHarvestEvents($customer_id)
    {
        $stmt = $this->db->prepare("
            SELECT he.*, COUNT(shc2.id) AS participant_count
            FROM harvest_events he
            LEFT JOIN self_harvest_customers shc2 ON he.id = shc2.harvest_event_id
            WHERE he.end_date > NOW()
            AND he.status = 'open'
            AND he.id NOT IN (
                SELECT shc.harvest_event_id
                FROM self_harvest_customers shc
                WHERE shc.customer_id = ?
            )
            GROUP BY he.id
            HAVING participant_count < he.max_capacity
        ");
        $stmt->execute([$customer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isCustomerJoined($customer_id, $harvest_event_id)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM self_harvest_customers
            WHERE customer_id = ? AND harvest_event_id = ?
        ");
        $stmt->execute([$customer_id, $harvest_event_id]);
        return $stmt->fetchColumn() > 0;
    }

    public function canJoinHarvestEvent($harvest_event_id)
    {
        $stmt = $this->db->prepare("
            SELECT he.*, COUNT(shc.id) AS participant_count
            FROM harvest_events he
            LEFT JOIN self_harvest_customers shc ON he.id = shc.harvest_event_id
            WHERE he.id = ?
            GROUP BY he.id
        ");
        $stmt->execute([$harvest_event_id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$event) {
            return false;
        }

        if ($event['status'] !== 'open' || $event['end_date'] <= date('Y-m-d H:i:s')) {
            return false;
        }

        if ($event['participant_count'] >= $event['max_capacity']) {
            return false;
        }

        return true;
    }

    public function joinHarvestEvent($customer_id, $harvest_event_id)
    {
        $stmt = $this->db->prepare("
            INSERT INTO self_harvest_customers (customer_id, harvest_event_id)
            VALUES (?, ?)
        ");
        $stmt->execute([$customer_id, $harvest_event_id]);
    }

    public function leaveHarvestEvent($customer_id, $harvest_event_id)
    {
        $stmt =  $this->db->prepare("
            DELETE FROM self_harvest_customers
            WHERE customer_id = ? AND harvest_event_id = ?
        ");
        $stmt->execute([$customer_id, $harvest_event_id]);
    }

}
