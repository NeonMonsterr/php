<?php
class Author{
    private string $name;
    private string $email;
    public function __construct(string $name, string $email){
        $this->name = $name;
        $this->email = $email;
    }
    public function getName(): string{
        return $this->name;
    }
    public function getEmail(): string{
        return $this->email;
    }
    public function SetEmail(string $email){
        $this->email = $email;
    }
    public function ____toString() : string{
        return "Name: $this->name  Email: $this->email";
}
}
class Book{
    private string $isbn;
    private string $name;
    private Author $author;
    private float $price;
    private int $qty;
    public function __construct(string $isbn,string $name,Author $author,float $price, int $qty){
        $this->isbn = $isbn;
        $this->name = $name;
        $this->author = $author;
        $this->price = $price;
        $this->qty = $qty;
    }
    public function getISBN(): string{
        return $this->isbn;
    }
    public function getName(): string{
        return $this->name;
    }
    public function getAuthor(): Author{
        return $this->author;
    }
    public function getPrice():float{
        return $this->price;
    }
    public function getQty(): int{
        return $this->qty;
    }
    public function setIsbn(string $isbn): void{
        $this->isbn = $isbn;
    }
    public function setName(string $name): void{
        $this->name = $name;
    }
    public function setAuthor(Author $author): void{
        $this->author = $author;
    }
    public function setPrice(float $price): void{
        $this->price = $price;
    }
    public function setQty(int $qty): void{
        $this->qty = $qty;
    }
    public function getAuthorName(): string{
        return $this->author->getName();
    }
    public function ____toString():string{
        return "ISBN:$this->isbn Name:$this->name Author[".$this->author->____toString()."] Price: $this->price Quantity:$this->qty"; 
    }
}
$authorTest=new Author("ahmed","ahmed@gmail.com");
// one of one book :D
$bookTest=new Book("1234","physics",$authorTest,99.9,1);
echo $bookTest->____toString();
//--------------------------------------------------------------------
trait Circle {
    private float $radius = 1.0;
    private string $color = "red";
    public function getRadius(): float {
        return $this->radius;
    }
    public function setRadius(float $radius): void {
        $this->radius = $radius;
    }
    public function getColor(): string {
        return $this->color;
    }
    public function setColor(string $color): void {
        $this->color = $color;
    }
    public function getArea(): float {
        return pi() * pow($this->radius, 2);
    }
    public function ____toString(): string {
        return "Circle[radius={$this->radius}, color={$this->color}]";
    }
}
class Cylinder {
    use Circle;

    private float $height = 1.0;

    public function __construct(float $radius = 1.0, float $height = 1.0, string $color = "red") {
        $this->setRadius($radius);
        $this->setHeight($height);
        $this->setColor($color);
    }

    public function getHeight(): float {
        return $this->height;
    }

    public function setHeight(float $height): void {
        $this->height = $height;
    }

    public function getVolume(): float {
        return $this->getArea() * $this->height;
    }

    public function ____toString(): string {
        return "Cylinder[radius={$this->getRadius()}, height={$this->height}, color={$this->getColor()}]";
    }
}
echo"<br>";
$cylinder = new Cylinder(5.0, 10.0, "blue");
echo $cylinder->getVolume();
echo $cylinder->____toString();
echo "<br>";
//----------------------------------------------
echo "<br>";
abstract class Person {
    protected string $name;
    protected string $address;

    public function __construct(string $name, string $address) {
        $this->name = $name;
        $this->address = $address;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function setAddress(string $address): void {
        $this->address = $address;
    }

    abstract public function __toString(): string;
}
class Student extends Person {
    private string $program;
    private int $year;
    private float $fee;

    public function __construct(string $name, string $address, string $program, int $year, float $fee) {
        parent::__construct($name, $address);
        $this->program = $program;
        $this->year = $year;
        $this->fee = $fee;
    }

    public function getProgram(): string {
        return $this->program;
    }

    public function setProgram(string $program): void {
        $this->program = $program;
    }

    public function getYear(): int {
        return $this->year;
    }

    public function setYear(int $year): void {
        $this->year = $year;
    }

    public function getFee(): float {
        return $this->fee;
    }

    public function setFee(float $fee): void {
        $this->fee = $fee;
    }

    public function __toString(): string {
        return "Student[Person[name={$this->name}, address={$this->address}], program={$this->program}, year={$this->year}, fee={$this->fee}]";
    }
}
class Staff extends Person {
    private string $school;
    private float $pay;

    public function __construct(string $name, string $address, string $school, float $pay) {
        parent::__construct($name, $address);
        $this->school = $school;
        $this->pay = $pay;
    }

    public function getSchool(): string {
        return $this->school;
    }

    public function setSchool(string $school): void {
        $this->school = $school;
    }

    public function getPay(): float {
        return $this->pay;
    }

    public function setPay(float $pay): void {
        $this->pay = $pay;
    }

    public function __toString(): string {
        return "Staff[Person[name={$this->name}, address={$this->address}], school={$this->school}, pay={$this->pay}]";
    }
}
$student = new Student("John Doe", "123 Main St", "Computer Science", 2, 15000.0);
echo $student->__toString();

$staff = new Staff("Jane Smith", "456 Elm St", "Engineering", 50000.0);
echo $staff->__toString();
//-----------------------------------------
echo"<br>";
interface Shape {
    public function getColor(): string;
    public function setColor(string $color): void;
    public function isFilled(): bool;
    public function setFilled(bool $filled): void;
    public function __toString(): string;
}
class Circle2 implements Shape {
    private float $radius = 1.0;
    private string $color = "red";
    private bool $filled = true;

    public function __construct(float $radius = 1.0, string $color = "red", bool $filled = true) {
        $this->radius = $radius;
        $this->color = $color;
        $this->filled = $filled;
    }
    public function getRadius(): float {
        return $this->radius;
    }
    public function setRadius(float $radius): void {
        $this->radius = $radius;
    }
    public function getArea(): float {
        return pi() * pow($this->radius, 2);
    }
    public function getPerimeter(): float {
        return 2 * pi() * $this->radius;
    }
    public function getColor(): string {
        return $this->color;
    }
    public function setColor(string $color): void {
        $this->color = $color;
    }
    public function isFilled(): bool {
        return $this->filled;
    }
    public function setFilled(bool $filled): void {
        $this->filled = $filled;
    }
    public function __toString(): string {
        return "Circle2[Shape[color={$this->color}, filled={$this->filled}], radius={$this->radius}]";
    }
}
class Rectangle implements Shape {
    private float $width = 1.0;
    private float $length = 1.0;
    private string $color = "red";
    private bool $filled = true;

    public function __construct(float $width = 1.0, float $length = 1.0, string $color = "red", bool $filled = true) {
        $this->width = $width;
        $this->length = $length;
        $this->color = $color;
        $this->filled = $filled;
    }
    public function getWidth(): float {
        return $this->width;
    }
    public function setWidth(float $width): void {
        $this->width = $width;
    }
    public function getLength(): float {
        return $this->length;
    }
    public function setLength(float $length): void {
        $this->length = $length;
    }

    public function getArea(): float {
        return $this->width * $this->length;
    }

    public function getPerimeter(): float {
        return 2 * ($this->width + $this->length);
    }

    public function getColor(): string {
        return $this->color;
    }

    public function setColor(string $color): void {
        $this->color = $color;
    }

    public function isFilled(): bool {
        return $this->filled;
    }

    public function setFilled(bool $filled): void {
        $this->filled = $filled;
    }

    public function __toString(): string {
        return "Rectangle[Shape[color={$this->color}, filled={$this->filled}], width={$this->width}, length={$this->length}]";
    }
}
class Square extends Rectangle {
    public function __construct(float $side = 1.0, string $color = "red", bool $filled = true) {
        parent::__construct($side, $side, $color, $filled);
    }

    public function getSide(): float {
        return $this->getWidth();
    }

    public function setSide(float $side): void {
        $this->setWidth($side);
        $this->setLength($side);
    }

    public function setWidth(float $width): void {
        parent::setWidth($width);
        parent::setLength($width);
    }

    public function setLength(float $length): void {
        parent::setLength($length);
        parent::setWidth($length);
    }

    public function __toString(): string {
        return "Square[Rectangle[Shape[color={$this->getColor()}, filled={$this->isFilled()}], width={$this->getWidth()}, length={$this->getLength()}]]";
    }
}
