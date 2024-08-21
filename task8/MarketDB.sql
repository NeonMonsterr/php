CREATE DATABASE MarketDB;

USE MarketDB;


CREATE TABLE Users (
    id INT IDENTITY PRIMARY KEY,
    firstName VARCHAR(50),
    lastName VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(50),
    createdAt DATETIME
);

CREATE TABLE Categories (
    id INT IDENTITY PRIMARY KEY,
    categoryName VARCHAR(50),
    createdAt DATETIME
);
 
 CREATE TABLE Products (
    id INT IDENTITY PRIMARY KEY,
    categoryId INT FOREIGN KEY REFERENCES Categories(id),
    productName VARCHAR(100),
    price float,
    quantity INT,
    createdAt DATETIME
);

CREATE TABLE Orders (
    id INT IDENTITY PRIMARY KEY,
    userId INT FOREIGN KEY REFERENCES Users(id),
    totalPrice float
);

CREATE TABLE OrderProducts (
    id INT IDENTITY PRIMARY KEY,
    orderId INT FOREIGN KEY REFERENCES Orders(id),
    productId INT FOREIGN KEY REFERENCES Products(id),   
    amount INT,
    price float,
    createdAt DATETIME
);

INSERT INTO Users (firstName, lastName, email, password)
VALUES
('John', 'Doe', 'johndoe@example.com', 'password123'),
('Jane', 'Smith', 'janesmith@example.com', 'password456'),
('Alice', 'Johnson', 'alicejohnson@example.com', 'password789');

INSERT INTO Categories (categoryName)
VALUES
('Electronics'),
('Clothing'),
('Books');


INSERT INTO Products (categoryId, productName, price, quantity)
VALUES
(1, 'Smartphone', 599.99, 10),
(1, 'Laptop', 999.99, 5),
(2, 'T-Shirt', 19.99, 20),
(3, 'Novel', 14.99, 15);

INSERT INTO Orders (userId, totalPrice)
VALUES
(1, 1200.98),
(2, 39.98),
(3, 299.97);

INSERT INTO OrderProducts (orderId, productId, amount, price)
VALUES
(1, 1, 2, 599.99),
(1, 2, 1, 999.99),
(2, 3, 2, 19.99),
(3, 1, 1, 599.99),
(3, 4, 2, 14.99);

SELECT o.id AS OrderID, p.productName, op.amount, op.price
FROM Orders o
INNER JOIN OrderProducts op ON o.id = op.orderId
INNER JOIN Products p ON op.productId = p.id
WHERE o.userId = 1;

SELECT u.id AS UserID, COUNT(o.id) AS OrderCount
FROM Users u
LEFT JOIN Orders o ON u.id = o.userId
GROUP BY u.id;

SELECT u.id AS UserID, SUM(o.totalPrice) AS TotalOrderPrice
FROM Users u
LEFT JOIN Orders o ON u.id = o.userId
GROUP BY u.id;

SELECT u.id AS UserID, MAX(o.id) AS LastOrderID
FROM Users u
LEFT JOIN Orders o ON u.id = o.userId
GROUP BY u.id;

SELECT TOP 1 u.id AS UserID
FROM Users u
INNER JOIN Orders o ON u.id = o.userId
GROUP BY u.id
ORDER BY SUM(o.totalPrice) DESC;


ALTER TABLE orders
ADD createdAt DATETIME;

SELECT DISTINCT u.id AS UserID
FROM Users u
INNER JOIN Orders o ON u.id = o.userId
WHERE MONTH(o.createdAt) = MONTH(GETDATE()) AND YEAR(o.createdAt) = YEAR(GETDATE());

SELECT u.id AS UserID
FROM Users u
LEFT JOIN Orders o ON u.id = o.userId AND o.createdAt >= DATEADD(MONTH, -2, GETDATE())
WHERE o.id IS NULL
GROUP BY u.id;

SELECT TOP 1 MONTH(o.createdAt) AS Month, COUNT(o.id) AS OrderCount
FROM Orders o
GROUP BY MONTH(o.createdAt)
ORDER BY OrderCount DESC;SELECT TOP 1 MONTH(o.createdAt) AS Month, COUNT(o.id) AS OrderCount
FROM Orders o
GROUP BY MONTH(o.createdAt)
ORDER BY OrderCount DESC;

SELECT TOP 1 MONTH(o.createdAt) AS Month, SUM(o.totalPrice) AS TotalOrderPrice
FROM Orders o
GROUP BY MONTH(o.createdAt)
ORDER BY TotalOrderPrice DESC;

SELECT TOP 1 u.id AS UserID
FROM Users u
INNER JOIN Orders o ON u.id = o.userId
WHERE o.createdAt >= DATEADD(MONTH, -1, GETDATE())
GROUP BY u.id
ORDER BY SUM(o.totalPrice) DESC;SELECT TOP 1 u.id AS UserID
FROM Users u
INNER JOIN Orders o ON u.id = o.userId
WHERE o.createdAt >= DATEADD(MONTH, -1, GETDATE())
GROUP BY u.id
ORDER BY SUM(o.totalPrice) DESC;