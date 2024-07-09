<?php
require 'db.inc.php';

class Car {
    private $id;
    private $model;
    private $make;
    private $type;
    private $registration_year;
    private $description;
    private $price_per_day;
    private $capacity_people;
    private $capacity_suitcases;
    private $color;
    private $fuel_type;
    private $avg_consumption;
    private $horsepower;
    private $length;
    private $width;
    private $gear_type;
    private $conditions;
    private $photo1;
    private $photo2;
    private $photo3;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->model = $data['model'];
        $this->make = $data['make'];
        $this->type = $data['type'];
        $this->registration_year = $data['registration_year'];
        $this->description = $data['description'];
        $this->price_per_day = $data['price_per_day'];
        $this->capacity_people = $data['capacity_people'];
        $this->capacity_suitcases = $data['capacity_suitcases'];
        $this->color = $data['color'];
        $this->fuel_type = $data['fuel_type'];
        $this->avg_consumption = $data['avg_consumption'];
        $this->horsepower = $data['horsepower'];
        $this->length = $data['length'];
        $this->width = $data['width'];
        $this->gear_type = $data['gear_type'];
        $this->conditions = $data['conditions'];
        $this->photo1 = explode(',', $data['photo1']);
        $this->photo2 = explode(',', $data['photo2']);
        $this->photo3 = explode(',', $data['photo3']);

    }

      // Getter methods
      public function getId() {
        return $this->id;
    }

    public function getModel() {
        return $this->model;
    }

    public function getMake() {
        return $this->make;
    }

    public function getType() {
        return $this->type;
    }

    public function getRegistrationYear() {
        return $this->registration_year;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPricePerDay() {
        return $this->price_per_day;
    }

    public function getColor() {
        return $this->color;
    }

    public function getFuelType() {
        return $this->fuel_type;
    }

    public function getAvgConsumption() {
        return $this->avg_consumption;
    }

    public function getHorsepower() {
        return $this->horsepower;
    }

    public function getLength() {
        return $this->length;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getGearType() {
        return $this->gear_type;
    }

    public function getConditions() {
        return $this->conditions;
    }

    public function getPhoto1() {
        return $this->photo1;
    }

    public function getPhoto2() {
        return $this->photo2;
    }

    public function getPhoto3() {
        return $this->photo3;
    }

    public static function getAllCars() {
        $pdo = db_connect();
        $stmt = $pdo->query("SELECT * FROM cars");
        $cars = [];
        while ($row = $stmt->fetch()) {
            $cars[] = new self($row);
        }
        return $cars;
    }
    public function display() {
        $photo11 = "carsImages/{$this->photo1[0]}";
        echo "<div class='car'>";
        echo "<div class='car-photos'>";
        foreach ($this->photo1 as $photo11) {
            echo "<img src='carsImages/{$photo11}' alt='{$this->model}'>";
        }
        echo "</div>";
        echo "<div class='car-info'>";
        echo "<ul>";
        $this->displayDetails();
        echo "</ul>";
        echo "<form action='rent_car.php' method='POST'>";
        echo "<input type='hidden' name='car_id' value='{$this->id}'>";
        echo "<button type='submit' class='rent-button'>Rent-a-Car</button>";
        echo "</form>";
        echo "</div>";
        echo "<div class='car-marketing'>";
        echo "<h3>Why this car?</h3>";
        echo "<p>This car is enjoyable to drive and offers excellent fuel efficiency.</p>";
        echo "<p>Special discounts available for long-term rentals.</p>";
        echo "</div>";
        echo "</div>";
    }
    public static function getById($id) {
      $pdo = db_connect();
      $stmt = $pdo->prepare("SELECT * FROM cars WHERE id = :id");
      $stmt->execute(['id' => $id]);
      $car = $stmt->fetch();
      return $car ? new self($car) : null;
  }

 
  public function displayDetails() {
      $details = [
          'Reference Number' => $this->id,
          'Model' => $this->model,
          'Type' => $this->type,
          'Make' => $this->make,
          'Registration Year' => $this->registration_year,
          'Color' => $this->color,
          'Description' => $this->description,
          'Price per Day' => $this->price_per_day,
          'Capacity (People)' => $this->capacity_people,
          'Capacity (Suitcases)' => $this->capacity_suitcases,
          'Fuel Type' => $this->fuel_type,
          'Average Consumption' => $this->avg_consumption . ' liters/100km',
          'Horsepower' => $this->horsepower,
          'Length' => $this->length . ' meters',
          'Width' => $this->width . ' meters',
          'Gear Type' => $this->gear_type,
          'Conditions' => $this->conditions,
      ];

      foreach ($details as $label => $value) {
          echo "<li>{$label}: " . htmlspecialchars($value) . "</li>";
      }
  }
  
  
}
?>
