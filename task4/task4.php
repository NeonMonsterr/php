<?php
class Circle{
    private float $radius=1.0;
    private string $color="red";
    public function __construct(float $radius, string $color= ""){
        $this->radius=$radius;
        $this->color=$color;
    }
    public function getRadius():float{
        return $this->radius;
    }
    public function getColor():string{
        return $this->color;
    }
    public function setRadius($radius):void{
        $this->radius=$radius;
    }
    public function setColor($color):void{
        $this->color=$color;
    }
    public function toString():string{
        return "Radius: $this->radius"+" Color: $this->color";
    }
    public function getArea():float{
        return $this->radius*$this->radius*pi();
    }
}

class Employee {
    private int $id;
    private string $firstName;
    private string $lastName;
    private float $salary;

    public function __construct(int $id, string $firstName,string $lastName,float $salary) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->salary = $salary;
    }

    public function getId():int {
        return $this->id;
    }

    public function getFirstName() :string {
        return $this->firstName;
    }

    public function getLastName():string {
        return $this->lastName;
    }

    public function getName():string {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getSalary():String {
        return $this->salary;
    }

    public function setSalary($salary):void {
        $this->salary = $salary;
    }

    public function getAnnualSalary():float {
        return $this->salary * 12;
    }

    public function raiseSalary($percent):float {
        $this->salary += $this->salary * ($percent / 100);
        return $this->salary;
    }

    public function __toString() {
        return "Employee[id={$this->id}, name={$this->getName()}, salary={$this->salary}]";
    }
}

class Rectangle {
    private float $length;
    private float $width;

    public function __construct(float $length = 1.0, float $width = 1.0) {
        $this->length = $length;
        $this->width = $width;
    }

    public function getLength(): float {
        return $this->length;
    }

    public function setLength(float $length): void {
        $this->length = $length;
    }

    public function getWidth(): float {
        return $this->width;
    }

    public function setWidth(float $width): void {
        $this->width = $width;
    }

    public function getArea(): float {
        return $this->length * $this->width;
    }

    public function getPerimeter(): float {
        return 2 * ($this->length + $this->width);
    }

    public function __toString(): string {
        return "Rectangle[length={$this->length}, width={$this->width}]";
    }
}

class InvoiceItem {
    private int $id;
    private string $desc;
    private int $qty;
    private float $unitPrice;

    public function __construct(int $id, string $desc, int $qty, float $unitPrice) {
        $this->id = $id;
        $this->desc = $desc;
        $this->qty = $qty;
        $this->unitPrice = $unitPrice;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getDesc(): string {
        return $this->desc;
    }

    public function getQty(): int {
        return $this->qty;
    }

    public function setQty(int $qty): void {
        $this->qty = $qty;
    }

    public function getUnitPrice(): float {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): void {
        $this->unitPrice = $unitPrice;
    }

    public function getTotal(): float {
        return $this->unitPrice * $this->qty;
    }

    public function __toString(): string {
        return "InvoiceItem[id=$this->id, desc=$this->desc, qty=$this->qty, unitPrice=$this->unitPrice]";
    }
}

class Account {
    private string $id;
    private string $name;
    private int $balance = 0;

    public function __construct(string $id, string $name, int $balance) {
        $this->id = $id;
        $this->name = $name;
        $this->balance = $balance;
    }

    public function getId(): string {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getBalance(): int {
        return $this->balance;
    }

    public function credit(int $amount): int {
        $this->balance += $amount;
        return $this->balance;
    }

    public function debit(int $amount): int {
        if ($amount <= $this->balance) {
            $this->balance -= $amount;
        } else {
            echo "Amount exceeded balance\n";
        }
        return $this->balance;
    }

    public function transferTo(Account $anotherAccount, int $amount): int {
        if ($amount <= $this->balance) {
            $this->balance -= $amount;
            $anotherAccount->credit($amount);
        } else {
            echo "Amount exceeded balance\n";
        }
        return $this->balance;
    }

    public function __toString(): string {
        return "Account[id=$this->id, name=$this->name, balance=$this->balance]";
    }
}

class Ball {
    private float $x;
    private float $y;
    private int $radius;
    private float $xDelta;
    private float $yDelta;

    public function __construct(float $x, float $y, int $radius, float $xDelta, float $yDelta) {
        $this->x = $x;
        $this->y = $y;
        $this->radius = $radius;
        $this->xDelta = $xDelta;
        $this->yDelta = $yDelta;
    }

    public function getX(): float {
        return $this->x;
    }

    public function setX(float $x): void {
        $this->x = $x;
    }

    public function getY(): float {
        return $this->y;
    }

    public function setY(float $y): void {
        $this->y = $y;
    }

    public function getRadius(): int {
        return $this->radius;
    }

    public function setRadius(int $radius): void {
        $this->radius = $radius;
    }

    public function getXDelta(): float {
        return $this->xDelta;
    }

    public function setXDelta(float $xDelta): void {
        $this->xDelta = $xDelta;
    }

    public function getYDelta(): float {
        return $this->yDelta;
    }

    public function setYDelta(float $yDelta): void {
        $this->yDelta = $yDelta;
    }

    public function move(): void {
        $this->x += $this->xDelta;
        $this->y += $this->yDelta;
    }

    public function reflectHorizontal(): void {
        $this->xDelta = -$this->xDelta;
    }

    public function reflectVertical(): void {
        $this->yDelta = -$this->yDelta;
    }

    public function __toString(): string {
        return "Ball[(x, y), speed=($this->xDelta, $this->yDelta)]";
    }
}




?>