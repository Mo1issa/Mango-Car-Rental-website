<?php
require 'db.inc.php';

class Rental {
    private $id;
    private $customer_id;
    private $car_id;
    private $start_date;
    private $end_date;
    private $pickup_location;
    private $return_location;
    private $special_requirements;
    private $total_amount;
    private $invoice_id;
    private $invoice_date;
    private $state;
    private $pickup_location_id;
    private $return_location_id;
    private $car_make;
    private $car_model;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->customer_id = $data['customer_id'];
        $this->car_id = $data['car_id'];
        $this->start_date = $data['start_date'];
        $this->end_date = $data['end_date'];
        $this->pickup_location = $data['pickup_location'];
        $this->return_location = $data['return_location'];
        $this->special_requirements = $data['special_requirements'];
        $this->total_amount = $data['total_amount'];
        $this->invoice_id = $data['invoice_id'];
        $this->invoice_date = $data['invoice_date'];
        $this->state = $data['state'];
        $this->pickup_location_id = $data['pickup_location_id'];
        $this->return_location_id = $data['return_location_id'];
        $this->car_make = $data['make'];
        $this->car_model = $data['model'];
    }

    public static function getAllRentals() {
        $pdo = db_connect();
        $stmt = $pdo->query("SELECT rentals.*, cars.make, cars.model FROM rentals JOIN cars ON rentals.car_id = cars.id ORDER BY rentals.invoice_date DESC");
        $rentals = [];
        while ($row = $stmt->fetch()) {
            $rentals[] = new self($row);
        }
        return $rentals;
    }

    public function getStatus() {
        if ($this->state == 'available' || $this->state == 'repair') {
            return 'past';
        } elseif ($this->state == 'active') {
            $today = date('Y-m-d');
            if ($this->start_date > $today) {
                return 'future';
            } elseif ($this->start_date <= $today && ($this->end_date === null || $this->end_date >= $today)) {
                return 'current';
            } else {
                return 'past';
            }
        } else {
            return 'current';
        }
    }

    public function display() {
        $status = $this->getStatus();
        echo "<tr class='$status'>";
        echo "<td>{$this->invoice_id}</td>";
        echo "<td>{$this->invoice_date}</td>";
        echo "<td>{$this->car_make}</td>";
        echo "<td>{$this->car_model}</td>";
        echo "<td>{$this->start_date}</td>";
        echo "<td>{$this->pickup_location}</td>";
        echo "<td>{$this->end_date}</td>";
        echo "<td>{$this->return_location}</td>";
        echo "<td>{$status}</td>";
        echo "</tr>";
    }
}
?>
