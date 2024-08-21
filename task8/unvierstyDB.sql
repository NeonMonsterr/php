CREATE DATABASE University_Database;
USE University_Database;

CREATE TABLE Student (
    University_ID INT PRIMARY KEY,
    namee VARCHAR(50),
    phoneNumber VARCHAR(20),
    addresss VARCHAR(100),
    city VARCHAR(50),
    street VARCHAR(50),
    zip CHAR(5)
);

CREATE TABLE Course (
    ID INT PRIMARY KEY,
    namee VARCHAR(50),
    fee DECIMAL(10, 2)
);

CREATE TABLE Teacher (
    ID INT PRIMARY KEY,
    namee VARCHAR(50),
    part_time BIT,
    full_time BIT
);

CREATE TABLE Department (
    ID INT PRIMARY KEY,
    namee VARCHAR(50)
);

CREATE TABLE Chairman (
    ID INT PRIMARY KEY,
    namee VARCHAR(50)
);

CREATE TABLE Dependentt (
    ID INT PRIMARY KEY,
    namee VARCHAR(50)
);

CREATE TABLE Takes (
    Student_ID INT,
    Course_ID INT,
    PRIMARY KEY (Student_ID, Course_ID),
    FOREIGN KEY (Student_ID) REFERENCES Student(University_ID),
    FOREIGN KEY (Course_ID) REFERENCES Course(ID)
);

CREATE TABLE Teaches (
    Teacher_ID INT,
    Course_ID INT,
    PRIMARY KEY (Teacher_ID, Course_ID),
    FOREIGN KEY (Teacher_ID) REFERENCES Teacher(ID),
    FOREIGN KEY (Course_ID) REFERENCES Course(ID)
);

CREATE TABLE   
 Belongs (
    Department_ID INT,
    Teacher_ID INT,
    PRIMARY KEY (Department_ID, Teacher_ID),
    FOREIGN KEY (Department_ID) REFERENCES Department(ID),
    FOREIGN KEY (Teacher_ID) REFERENCES Teacher(ID)
);

INSERT INTO Student (University_ID, namee, phoneNumber, addresss, city, street, zip)
VALUES (1, 'John Doe', '1234567890', '123 Main St', 'New York', 'Main St', '12345');

SELECT C.namee AS course_name
FROM Course C
JOIN Teaches T ON C.ID = T.Course_ID
JOIN Teacher T2 ON T.Teacher_ID = T2.ID
WHERE C.fee > 2000;

SELECT COUNT(*) AS student_count
FROM Takes
WHERE Course_ID = [course_id];

SELECT S.namee
FROM Student S
WHERE S.namee LIKE '%med%';

UPDATE Course
SET fee = fee * 1.05
WHERE fee < 1500;

DELETE FROM Chairman
WHERE ID = 3;

