/* Not formatted properly so dont run or import

just copy and paste the queries
*/

drop database MCAV;

create database MCAV;

use MCAV;

create table customers (
    CustomerID int auto_increment,
    CustomerFname varchar(32) NOT NULL,
    CustomerLname varchar(32) NOT NULL,
    CustomerEmail varchar(32) NOT NULL,
    CustomerPhone varchar(11) NOT NULL,

    primary key(CustomerID)
);


create table Permissions (
    PermissionsID int auto_increment,
    PermissionCreate bool default 0,
    PermissionDelete bool default 0,
    PermissionUpdate bool default 0,
    PermissionRemove bool default 0,
    PermissionViewLogs int default 0,
    PermissionsManageUser int default 0,

    primary key(PermissionsID)
);

create table employee_info(
    EmployeeID int auto_increment,
    ProfilePicturePath varchar(255) NOT NULL,
    EmployeeFirstname varchar(32) NOT NULL,
    EmployeeLastname varchar(32) NOT NULL,
    EmployeeHireDate varchar(32) NOT NULL,
    Gender enum('M','F') NOT NULL,
    Position varchar(32) NOT NULL,
    WebUserLevel int NOT NULL,
    IsRemoved boolean,

    primary key(EmployeeID),
    check (Gender in ('M','F'))
);

create table employee_credentials(
    EmployeeWebID int auto_increment,
    PermissionsID int NOT NULL,
    EmployeeID int NOT NULL,
    username varchar(32),
    employee_Password binary(60),
    UserLevel int default 0 NOT NULL,
    accountStatus enum('Activated','Deactivated'),
    

    primary key(EmployeeWebID),
    foreign key(PermissionsID) references Permissions(PermissionsID),
    foreign key(EmployeeID) references employee_info(EmployeeID)
);

create table orders(
    OrderID int auto_increment,
    EmployeeID int,
    CustomerID int NOT NULL,
    OrderStartDate Date NOT NULL,
    OrderDeadline Date,
    OrderStatusCode int NOT NULL,

    IsRemoved boolean,

    primary key(OrderID),
    foreign key(EmployeeID) references employee_info(EmployeeID),
    foreign key(customerID) references customers(CustomerID)
);

create table products(
    productID int auto_increment,
    OrderID int NOT NULL,
    productDescription varchar(255),
    productFilePath varchar(255),
    productDimenstions varchar(32),
    ProductQuantity int,
    ProductStatusCode int,
    ProductPrice float default 0,

    IsRemoved boolean,

    primary key(ProductID),
    foreign key(OrderID) references Orders(orderID)

);



create table payment_plans(
    PlanID int auto_increment,
    OrderID int NOT NULL,
    DueDate date,
    PaymentStatus int default 0 NOT NULL,
    PaymentMethod varchar(32),
    PaymentProcessor varchar(32),
    TotalAmount float default 0,
    AmountPaid float default 0,
    Balance float default 0,

    IsRemoved boolean,

    primary key(PlanID),
    foreign key(OrderID) references Orders(OrderID)
);

create table Payment_Receipts(
    ReceiptID int auto_increment,
    PlanID int NOT NULL,
    ReceiptImagePath varchar(255),
    HasPicture bool default 0,
    ReceiptAmountPaid float default 0,
    PaymentDate date,

    PaymentProcessor varchar(32),
    PaymentProcessorReferenceNumber float default 0,

    IsRemoved boolean,

    primary key (ReceiptID),
    foreign key (PlanID) references payment_Plans(PlanID)
);

create table Action_Logs(
    logID int auto_increment,
    EmployeeWebID int NOT NULL,
    PermissionsID int NOT NULL,
    UserAction enum('Create','Delete','Update','Remove','ManageUser') NOT NULL,
    AffectedEntityType enum('Employee_Info','Payment_Plan','Payment_Receipts','Products','Orders','Customers'),
    AffectedEntityID int NOT NULL,
    LogTimestamp Datetime,

    primary key(logID),
    foreign key(EmployeeWebID) references employee_credentials(EmployeeWebID),
    foreign key(PermissionsID) references permissions(PermissionsID),

    check(UserAction in ('Create','Delete','Update','Remove','ManageUser')),
    check(AffectedEntityType in ('Employee_Info','Payment_Plan','Payment_Receipts','Products','Orders','Customers'))
);

create table employee_info_archive (
    employeeArchiveID int auto_increment,
    employeeID int NOT NULL,
    ProfilePicturePath varchar(255) NOT NULL,
    EmployeeFirstname varchar(32) NOT NULL,
    EmployeeLastname varchar(32) NOT NULL,
    EmployeeHireDate varchar(32) NOT NULL,
    Gender enum('M','F') NOT NULL,
    Position varchar(32) NOT NULL,
    WebUserLevel int NOT NULL,

    ArchiveTimestamp DATETIME,

    primary key(employeeArchiveID),
    foreign key(employeeID) references Employee_Info(employeeID)
);

create table customer_info_archive (
    customerArchiveID int auto_increment,
    CustomerID int NOT NULL,
    CustomerFname varchar(32) NOT NULL,
    CustomerLname varchar(32) NOT NULL,
    CustomerEmail varchar(32) NOT NULL,
    CustomerPhone varchar(11) NOT NULL,

    ArchiveTimestamp DATETIME,

    primary key(customerArchiveID),
    foreign key(CustomerID) references customers(customerID)
);

create table order_archive (
    orderArchiveID int auto_increment,

    OrderID int NOT NULL,
    EmployeeID int NOT NULL,
    CustomerID int NOT NULL,
    OrderStartDate Date NOT NULL,
    OrderDeadline Date,
    OrderStatusCode int NOT NULL,

    ArchiveTimestamp DATETIME,

    primary key(OrderArchiveID),
    foreign key(OrderID) references orders(orderID)
);

create table product_archive(
    productArchiveID int auto_increment,

    productID int NOT NULL,
    OrderID int NOT NULL,
    productDescription varchar(255),
    productFilePath varchar(255),
    productDimenstions varchar(32),
    ProductQuantity int,
    ProductStatusCode int,
    ProductPrice float default 0,

    primary key(productArchiveID),
    foreign key(ProductID) references products(ProductID)
);

create table payment_plans_Archive (
    planArchiveID int auto_increment,

    PlanID int NOT NULL,
    OrderID int NOT NULL,
    DueDate date,
    PaymentStatus int default 0 NOT NULL,
    PaymentMethod varchar(32),
    PaymentProcessor varchar(32),
    TotalAmount float default 0,
    AmountPaid float default 0,
    Balance float default 0,

    primary key(planArchiveID),
    foreign key(planID) references payment_plans(planID)
);

create table Payment_Receipt_Archive(
    ReceiptArchiveID int auto_increment,

    ReceiptID int NOT NULL,
    PlanID int NOT NULL,
    ReceiptImagePath varchar(255),
    HasPicture bool default 0,
    ReceiptAmountPaid float default 0,
    PaymentDate date,


    PaymentProcessor varchar(32),
    PaymentProcessorReferenceNumber float default 0,

    primary key(ReceiptArchiveID),
    foreign key(ReceiptID) references Payment_Receipts(ReceiptID)
);




INSERT INTO customers (CustomerFname, CustomerLname, CustomerEmail, CustomerPhone) VALUES
('John', 'Doe', 'john.doe@example.com', '1234567890'),
('Jane', 'Smith', 'jane.smith@example.com', '0987654321'),
('Alice', 'Johnson', 'alice.johnson@example.com', '1122334455'),
('Bob', 'Brown', 'bob.brown@example.com', '2233445566'),
('Charlie', 'Davis', 'charlie.davis@example.com', '3344556677'),
('Diana', 'Evans', 'diana.evans@example.com', '4455667788'),
('Ethan', 'Garcia', 'ethan.garcia@example.com', '5566778899'),
('Fiona', 'Harris', 'fiona.harris@example.com', '6677889900'),
('George', 'Iglesias', 'george.iglesias@example.com', '7788990011'),
('Hannah', 'Jones', 'hannah.jones@example.com', '8899001122'),
('Isaac', 'King', 'isaac.king@example.com', '9900112233'),
('Julia', 'Lee', 'julia.lee@example.com', '0011223344'),
('Kevin', 'Martinez', 'kevin.martinez@example.com', '1122334456'),
('Laura', 'Nelson', 'laura.nelson@example.com', '2233445567'),
('Michael', 'Owen', 'michael.owen@example.com', '3344556678'),
('Nancy', 'Perez', 'nancy.perez@example.com', '4455667789'),
('Oliver', 'Quinn', 'oliver.quinn@example.com', '5566778890'),
('Paula', 'Robinson', 'paula.robinson@example.com', '6677889901'),
('Quincy', 'Scott', 'quincy.scott@example.com', '7788990012'),
('Rachel', 'Taylor', 'rachel.taylor@example.com', '8899001123'),
('Steve', 'Underwood', 'steve.underwood@example.com', '9900112234'),
('Tina', 'Vargas', 'tina.vargas@example.com', '0011223345'),
('Umar', 'White', 'umar.white@example.com', '1122334457'),
('Vera', 'Xavier', 'vera.xavier@example.com', '2233445568'),
('Will', 'Young', 'will.young@example.com', '3344556679'),
('Xena', 'Zimmerman', 'xena.zimmerman@example.com', '4455667780'),
('Yusuf', 'Adams', 'yusuf.adams@example.com', '5566778891'),
('Zara', 'Baker', 'zara.baker@example.com', '6677889902'),
('Alex', 'Carter', 'alex.carter@example.com', '7788990013'),
('Brittany', 'Diaz', 'brittany.diaz@example.com', '8899001124');

INSERT INTO Permissions (PermissionCreate, PermissionDelete, PermissionUpdate, PermissionRemove, PermissionViewLogs, PermissionsManageUser) VALUES
(1, 0, 1, 0, 1, 1),
(0, 1, 0, 1, 0, 1),
(1, 1, 1, 0, 1, 0),
(0, 0, 1, 1, 0, 0),
(1, 0, 0, 1, 1, 1),
(0, 1, 1, 0, 1, 0),
(1, 1, 0, 0, 0, 1),
(0, 0, 1, 1, 1, 0),
(1, 0, 0, 0, 1, 0),
(0, 1, 1, 0, 0, 1),
(1, 0, 1, 1, 1, 0),
(0, 1, 0, 1, 0, 0),
(1, 1, 1, 0, 1, 1),
(0, 0, 0, 1, 1, 0),
(1, 0, 1, 0, 0, 1),
(0, 1, 1, 1, 0, 1),
(1, 1, 0, 0, 1, 0),
(0, 0, 1, 0, 1, 0),
(1, 0, 0, 1, 0, 1),
(0, 1, 1, 1, 1, 0),
(1, 1, 0, 0, 0, 0),
(0, 0, 1, 1, 1, 1),
(1, 0, 1, 0, 0, 0),
(0, 1, 0, 1, 1, 0),
(1, 1, 1, 0, 0, 1),
(0, 0, 0, 1, 1, 1),
(1, 0, 1, 1, 0, 0),
(0, 1, 0, 0, 1, 1),
(1, 1, 1, 1, 0, 0),
(0, 0, 0, 0, 1, 1);

INSERT INTO employee_info (ProfilePicturePath, EmployeeFirstname, EmployeeLastname, EmployeeHireDate, Gender, Position, WebUserLevel, IsRemoved) VALUES
('/images/employees/jdoe.jpg', 'John', 'Doe', '2021-01-15', 'M', 'Manager', 5, 0),
('/images/employees/jsmith.jpg', 'Jane', 'Smith', '2020-03-22', 'F', 'Sales', 3, 0),
('/images/employees/ajohnson.jpg', 'Alice', 'Johnson', '2019-07-10', 'F', 'Engineer', 4, 0),
('/images/employees/bbrown.jpg', 'Bob', 'Brown', '2018-12-05', 'M', 'Technician', 2, 0),
('/images/employees/cdavis.jpg', 'Charlie', 'Davis', '2022-05-18', 'M', 'Support', 1, 0),
('/images/employees/devans.jpg', 'Diana', 'Evans', '2023-09-29', 'F', 'HR', 5, 0),
('/images/employees/egarcia.jpg', 'Ethan', 'Garcia', '2021-04-13', 'M', 'Marketing', 3, 0),
('/images/employees/fharris.jpg', 'Fiona', 'Harris', '2020-08-19', 'F', 'Design', 4, 0),
('/images/employees/giglesias.jpg', 'George', 'Iglesias', '2019-02-25', 'M', 'Finance', 5, 0),
('/images/employees/hjones.jpg', 'Hannah', 'Jones', '2018-11-03', 'F', 'Admin', 1, 0),
('/images/employees/iking.jpg', 'Isaac', 'King', '2022-06-30', 'M', 'Engineer', 4, 0),
('/images/employees/jlee.jpg', 'Julia', 'Lee', '2023-10-12', 'F', 'Sales', 3, 0),
('/images/employees/kmartinez.jpg', 'Kevin', 'Martinez', '2021-01-28', 'M', 'Support', 2, 0),
('/images/employees/lnelson.jpg', 'Laura', 'Nelson', '2020-03-17', 'F', 'Technician', 2, 0),
('/images/employees/mowen.jpg', 'Michael', 'Owen', '2019-07-05', 'M', 'Marketing', 3, 0),
('/images/employees/nperez.jpg', 'Nancy', 'Perez', '2018-12-19', 'F', 'HR', 5, 0),
('/images/employees/oquinn.jpg', 'Oliver', 'Quinn', '2022-05-02', 'M', 'Finance', 5, 0),
('/images/employees/probinson.jpg', 'Paula', 'Robinson', '2023-09-08', 'F', 'Design', 4, 0),
('/images/employees/qscott.jpg', 'Quincy', 'Scott', '2021-04-22', 'M', 'Admin', 1, 0),
('/images/employees/rtaylor.jpg', 'Rachel', 'Taylor', '2020-08-29', 'F', 'Sales', 3, 0),
('/images/employees/sunderwood.jpg', 'Steve', 'Underwood', '2019-02-14', 'M', 'Engineer', 4, 0),
('/images/employees/tvargas.jpg', 'Tina', 'Vargas', '2018-11-25', 'F', 'Support', 2, 0),
('/images/employees/uwhite.jpg', 'Umar', 'White', '2022-07-15', 'M', 'Technician', 2, 0),
('/images/employees/vxavier.jpg', 'Vera', 'Xavier', '2023-11-20', 'F', 'HR', 5, 0),
('/images/employees/wyoung.jpg', 'Will', 'Young', '2021-02-06', 'M', 'Finance', 5, 0),
('/images/employees/xzimmerman.jpg', 'Xena', 'Zimmerman', '2020-04-11', 'F', 'Admin', 1, 0),
('/images/employees/yadams.jpg', 'Yusuf', 'Adams', '2019-08-24', 'M', 'Marketing', 3, 0),
('/images/employees/zbaker.jpg', 'Zara', 'Baker', '2018-12-09', 'F', 'Support', 2, 0),
('/images/employees/acarter.jpg', 'Alex', 'Carter', '2022-06-05', 'M', 'Engineer', 4, 0),
('/images/employees/bdiaz.jpg', 'Brittany', 'Diaz', '2023-10-21', 'F', 'Design', 4, 0);

INSERT INTO employee_credentials (PermissionsID, EmployeeID, username, employee_Password, UserLevel, accountStatus) VALUES
(1, 1, 'jdoe', '$2b$12$Q9//aJr.f8Z5G4EzgThY2O2KJ0dF4k9L4UKZ/0S21i0gOKUJiyCXS', 5, 'Activated'),
(2, 2, 'jsmith', '$2b$12$7zJ/C9mQG0khloX4V6zQMeYaF3Tw/W6T1Hh.e5RW59zEFoRmgUjNe', 3, 'Activated'),
(3, 3, 'ajohnson', '$2b$12$z67yg3tUxe5/GQoJ0f8Ae.jGQ6FTYGRrcU3YJZOTQ.6F4bkQKUISe', 4, 'Activated'),
(4, 4, 'bbrown', '$2b$12$V5w.1YrBaKnVLEk5qVnGmeFQsTE8yEGOdSxl/jw3J.6CRjei9.xKy', 2, 'Activated'),
(5, 5, 'cdavis', '$2b$12$GphTAfF9NZTtF/7IdYy6qeF5St6U6zYI4D8vF.HseTJp.Kt4O0LiG', 1, 'Activated'),
(6, 6, 'devans', '$2b$12$xAWz1Y2Js/W7L3dj5aKfOeQ1w/wtyAVk4LBkLs8TjkN13Q0UGFNQe', 5, 'Activated'),
(7, 7, 'egarcia', '$2b$12$QixOgLK5e6y6/p5bykWJeODCjEp/J4L5vW7eNGw6J2wG4B1vYTP9S', 3, 'Activated'),
(8, 8, 'fharris', '$2b$12$g1FhFBNtZBb9J7Vt5fd05er.gwT.e1bwkBoD3wT4LHRAXeZQFOZjG', 4, 'Activated'),
(9, 9, 'giglesias', '$2b$12$QqT1hf.GZ1dJ8/SQzXRAbeZ9tvB9e2JpPDtM5fIB8zN2B.1JpU8/i', 5, 'Activated'),
(10, 10, 'hjones', '$2b$12$UytkFxzW/FHfR.Lp.L1q0uoyk6f/NyXkKr3Fh19BN0VJQzO5EIHle', 1, 'Activated'),
(11, 11, 'iking', '$2b$12$pWhc/SHntvGg.yT3nGmsyu0CkPeYO/nV3EgeZ.O3XZsN.2XkI1gK2', 4, 'Activated'),
(12, 12, 'jlee', '$2b$12$1F9JjViwv3mZp.Nm/G2Yxu5O8C4nfsw7rQn3Mfiqk2yN3OfpD8KlG', 3, 'Activated'),
(13, 13, 'kmartinez', '$2b$12$Za8/v9BtH.cFsZroMyW69erK/yfZG/JIdrGhTXR7rVxtpF3Gc1v0G', 2, 'Activated'),
(14, 14, 'lnelson', '$2b$12$hU8wsUtQSmJ5M8gUJasI.u1gF6GyT8qKXvwbYGp7n1fPr7.y2Zo6O', 2, 'Activated'),
(15, 15, 'mowen', '$2b$12$Ge.D3PTbbUAKDyEmO9HISOn4rN5N9yZr/j.lHRqQkdfBoJ/oxr1e2', 3, 'Activated'),
(16, 16, 'nperez', '$2b$12$EqvOa5dD7GMyg6vTTdFF7u4S7c3X63ewNLm8HR/Zo8G9I6GvqRpeO', 5, 'Activated'),
(17, 17, 'oquinn', '$2b$12$3Ofw8/1oJlo0PKS5yXQDsOgW4X77.mU5MmXrUymdphPLSRAuCmP32', 5, 'Activated'),
(18, 18, 'probinson', '$2b$12$YvY2f5TQ5s8yCevv08pDqOe/A1y1e7/peQQQ9tB1JRuIiy/N8JBe6', 4, 'Activated'),
(19, 19, 'qscott', '$2b$12$PLR1oy4TxwUgV84aB1ACw.fHnN4F5e3CilbP8jzgS8No9t23D1uQa', 1, 'Activated'),
(20, 20, 'rtaylor', '$2b$12$UxUxsmyGz1xX9DPjM7LXmeFMKn5lZ1PaY0/LpY5G4QMbMoN0t11N2', 3, 'Activated'),
(21, 21, 'sunderwood', '$2b$12$D4wK5zL5OSKxEKDr8f9ZVuOgS1O3OWi0Iu39WAp2q5F5uM8qmeX3C', 4, 'Activated'),
(22, 22, 'tvargas', '$2b$12$TnQL98REhtzFqQvS54u0k.2n7GZY6B4uHPG.fOeGcEJ0XX7X8r1X2', 2, 'Activated'),
(23, 23, 'uwhite', '$2b$12$osAKr5z8kWIo.E4SyP9b9e97F.CyFRmCVDqLB.jXqu1/jCN/XgeDm', 2, 'Activated'),
(24, 24, 'vxavier', '$2b$12$dzRy.g2Yy3u7UnI4LOHbOeX1b9W9FNuHv3zvEad1/Q1QMcVvYb6W6', 5, 'Activated'),
(25, 25, 'wyoung', '$2b$12$7H4q5VO5zYqFlXntBUgbb.GNwzh1N8jQ.7xL5EXg3m5H4Tbr1dWtG', 5, 'Activated'),
(26, 26, 'xzimmerman', '$2b$12$EDv4Eh8tD7NQ9D1kCfe0UO.zU7hJWnMLzj7PRfg6mLLFYJz.RuWuG', 1, 'Activated'),
(27, 27, 'yadams', '$2b$12$wnE6QfClHcGLQ1dQmXjoNO3POfn9UQ58SL9qR8OyxWv0Xcl.zrU0W', 3, 'Activated'),
(28, 28, 'zbaker', '$2b$12$GUPD9CJ1QkGrf/6Z6xlfa.kLRBRQhszNP5BRTrTjB3s5K4s12yde6', 2, 'Activated'),
(29, 29, 'acarter', '$2b$12$1MZrNYpKfjTXtF9b6jJg6OtRho3PdcMNz5AX8Pd8DZPkp7O.ytrPC', 4, 'Activated'),
(30, 30, 'bdiaz', '$2b$12$8VV.a1bPR2Q.3GkeNHdDiubZeugX8I02YHzZzEbSt9RyxTHmrW2y6', 4, 'Activated');

INSERT INTO products (productDescription, productFilePath, productDimenstions, ProductQuantity, ProductStatusCode, IsRemoved) VALUES
('Wireless Mouse', '/products/mouse.jpg', '4x2x1 inches', 100, 1, 0),
('Mechanical Keyboard', '/products/keyboard.jpg', '18x6x2 inches', 50, 1, 0),
('27" Monitor', '/products/monitor.jpg', '24x18x8 inches', 30, 1, 0),
('Gaming Chair', '/products/chair.jpg', '30x30x50 inches', 20, 1, 0),
('Laptop Stand', '/products/laptop_stand.jpg', '10x8x4 inches', 150, 1, 0),
('USB-C Hub', '/products/usb_hub.jpg', '3x2x1 inches', 200, 1, 0),
('External Hard Drive', '/products/hard_drive.jpg', '5x3x1 inches', 80, 1, 0),
('Noise Cancelling Headphones', '/products/headphones.jpg', '8x6x4 inches', 60, 1, 0),
('Webcam', '/products/webcam.jpg', '3x3x3 inches', 100, 1, 0),
('Desk Lamp', '/products/desk_lamp.jpg', '12x6x6 inches', 70, 1, 0),
('Office Desk', '/products/desk.jpg', '60x30x30 inches', 15, 1, 0),
('Ergonomic Mouse Pad', '/products/mouse_pad.jpg', '10x8x1 inches', 120, 1, 0),
('Smartphone Stand', '/products/phone_stand.jpg', '6x4x2 inches', 200, 1, 0),
('Portable Charger', '/products/portable_charger.jpg', '4x2x1 inches', 100, 1, 0),
('Bluetooth Speaker', '/products/speaker.jpg', '6x4x4 inches', 75, 1, 0),
('Graphic Tablet', '/products/tablet.jpg', '12x8x0.5 inches', 40, 1, 0),
('Laptop Backpack', '/products/backpack.jpg', '18x12x6 inches', 50, 1, 0),
('Smartwatch', '/products/smartwatch.jpg', '2x2x1 inches', 90, 1, 0),
('Fitness Tracker', '/products/fitness_tracker.jpg', '2x1x0.5 inches', 110, 1, 0),
('VR Headset', '/products/vr_headset.jpg', '10x8x6 inches', 20, 1, 0),
('Drone', '/products/drone.jpg', '12x12x4 inches', 30, 1, 0),
('Action Camera', '/products/action_camera.jpg', '4x3x2 inches', 60, 1, 0),
('Wireless Charger', '/products/wireless_charger.jpg', '5x5x1 inches', 80, 1, 0),
('Smart Light Bulb', '/products/smart_bulb.jpg', '5x3x3 inches', 150, 1, 0),
('Electric Scooter', '/products/scooter.jpg', '36x12x40 inches', 10, 1, 0),
('Robot Vacuum', '/products/vacuum.jpg', '14x14x3 inches', 25, 1, 0),
('Air Purifier', '/products/air_purifier.jpg', '20x12x10 inches', 35, 1, 0),
('Smart Thermostat', '/products/thermostat.jpg', '4x4x1 inches', 45, 1, 0),
('Home Security Camera', '/products/security_camera.jpg', '6x4x4 inches', 70, 1, 0),
('Wireless Earbuds', '/products/earbuds.jpg', '2x2x1 inches', 200, 1, 0);

INSERT INTO orders (EmployeeID, CustomerID, ProductID, OrderStartDate, OrderDeadline, OrderStatusCode, IsRemoved) VALUES
(1, 1, 1, '2023-01-10', '2023-01-20', 1, 0),
(2, 2, 2, '2023-01-15', '2023-01-25', 1, 0),
(3, 3, 3, '2023-01-20', '2023-01-30', 1, 0),
(4, 4, 4, '2023-01-25', '2023-02-04', 1, 0),
(5, 5, 5, '2023-02-01', '2023-02-11', 1, 0),
(6, 6, 6, '2023-02-05', '2023-02-15', 1, 0),
(7, 7, 7, '2023-02-10', '2023-02-20', 1, 0),
(8, 8, 8, '2023-02-15', '2023-02-25', 1, 0),
(9, 9, 9, '2023-02-20', '2023-03-02', 1, 0),
(10, 10, 10, '2023-02-25', '2023-03-07', 1, 0),
(11, 11, 11, '2023-03-01', '2023-03-11', 1, 0),
(12, 12, 12, '2023-03-05', '2023-03-15', 1, 0),
(13, 13, 13, '2023-03-10', '2023-03-20', 1, 0),
(14, 14, 14, '2023-03-15', '2023-03-25', 1, 0),
(15, 15, 15, '2023-03-20', '2023-03-30', 1, 0),
(16, 16, 16, '2023-03-25', '2023-04-04', 1, 0),
(17, 17, 17, '2023-04-01', '2023-04-11', 1, 0),
(18, 18, 18, '2023-04-05', '2023-04-15', 1, 0),
(19, 19, 19, '2023-04-10', '2023-04-20', 1, 0),
(20, 20, 20, '2023-04-15', '2023-04-25', 1, 0),
(21, 21, 21, '2023-04-20', '2023-04-30', 1, 0),
(22, 22, 22, '2023-04-25', '2023-05-05', 1, 0),
(23, 23, 23, '2023-05-01', '2023-05-11', 1, 0),
(24, 24, 24, '2023-05-05', '2023-05-15', 1, 0),
(25, 25, 25, '2023-05-10', '2023-05-20', 1, 0),
(26, 26, 26, '2023-05-15', '2023-05-25', 1, 0),
(27, 27, 27, '2023-05-20', '2023-05-30', 1, 0),
(28, 28, 28, '2023-05-25', '2023-06-04', 1, 0),
(29, 29, 29, '2023-06-01', '2023-06-11', 1, 0),
(30, 30, 30, '2023-06-05', '2023-06-15', 1, 0);

INSERT INTO payment_plans (OrderID, DueDate, PaymentStatus, PaymentMethod, PaymentProcessor, AmountPaid, IsRemoved) VALUES
(1, '2023-01-20', 0, 'Credit Card', 'Visa', 50.00, 0),
(2, '2023-01-25', 0, 'PayPal', 'PayPal', 75.00, 0),
(3, '2023-01-30', 0, 'Bank Transfer', 'Bank of America', 100.00, 0),
(4, '2023-02-04', 0, 'Credit Card', 'MasterCard', 125.00, 0),
(5, '2023-02-11', 0, 'PayPal', 'PayPal', 150.00, 0),
(6, '2023-02-15', 0, 'Bank Transfer', 'Chase Bank', 175.00, 0),
(7, '2023-02-20', 0, 'Credit Card', 'American Express', 200.00, 0),
(8, '2023-02-25', 0, 'PayPal', 'PayPal', 225.00, 0),
(9, '2023-03-02', 0, 'Bank Transfer', 'Wells Fargo', 250.00, 0),
(10, '2023-03-07', 0, 'Credit Card', 'Visa', 275.00, 0),
(11, '2023-03-11', 0, 'PayPal', 'PayPal', 300.00, 0),
(12, '2023-03-15', 0, 'Bank Transfer', 'Bank of America', 325.00, 0),
(13, '2023-03-20', 0, 'Credit Card', 'MasterCard', 350.00, 0),
(14, '2023-03-25', 0, 'PayPal', 'PayPal', 375.00, 0),
(15, '2023-03-30', 0, 'Bank Transfer', 'Chase Bank', 400.00, 0),
(16, '2023-04-04', 0, 'Credit Card', 'American Express', 425.00, 0),
(17, '2023-04-11', 0, 'PayPal', 'PayPal', 450.00, 0),
(18, '2023-04-15', 0, 'Bank Transfer', 'Wells Fargo', 475.00, 0),
(19, '2023-04-20', 0, 'Credit Card', 'Visa', 500.00, 0),
(20, '2023-04-25', 0, 'PayPal', 'PayPal', 525.00, 0),
(21, '2023-04-30', 0, 'Bank Transfer', 'Bank of America', 550.00, 0),
(22, '2023-05-05', 0, 'Credit Card', 'MasterCard', 575.00, 0),
(23, '2023-05-11', 0, 'PayPal', 'PayPal', 600.00, 0),
(24, '2023-05-15', 0, 'Bank Transfer', 'Chase Bank', 625.00, 0),
(25, '2023-05-20', 0, 'Credit Card', 'American Express', 650.00, 0),
(26, '2023-05-25', 0, 'PayPal', 'PayPal', 675.00, 0),
(27, '2023-05-30', 0, 'Bank Transfer', 'Wells Fargo', 700.00, 0),
(28, '2023-06-04', 0, 'Credit Card', 'Visa', 725.00, 0),
(29, '2023-06-11', 0, 'PayPal', 'PayPal', 750.00, 0),
(30, '2023-06-15', 0, 'Bank Transfer', 'Bank of America', 775.00, 0);

INSERT INTO Payment_Receipts (PlanID, ReceiptImagePath, HasPicture, ReceiptAmountPaid, PaymentProcessor, PaymentProcessorReferenceNumber, IsRemoved) VALUES
(1, '/receipts/receipt1.jpg', 1, 50.00, 'Visa', 123456789, 0),
(2, '/receipts/receipt2.jpg', 1, 75.00, 'PayPal', 987654321, 0),
(3, '/receipts/receipt3.jpg', 1, 100.00, 'Bank of America', 246813579, 0),
(4, '/receipts/receipt4.jpg', 1, 125.00, 'MasterCard', 135792468, 0),
(5, '/receipts/receipt5.jpg', 1, 150.00, 'PayPal', 864209753, 0),
(6, '/receipts/receipt6.jpg', 1, 175.00, 'Chase Bank', 579318624, 0),
(7, '/receipts/receipt7.jpg', 1, 200.00, 'American Express', 792468135, 0),
(8, '/receipts/receipt8.jpg', 1, 225.00, 'PayPal', 480937261, 0),
(9, '/receipts/receipt9.jpg', 1, 250.00, 'Wells Fargo', 937261480, 0),
(10, '/receipts/receipt10.jpg', 1, 275.00, 'Visa', 261480937, 0),
(11, '/receipts/receipt11.jpg', 1, 300.00, 'PayPal', 618724935, 0),
(12, '/receipts/receipt12.jpg', 1, 325.00, 'Bank of America', 724935618, 0),
(13, '/receipts/receipt13.jpg', 1, 350.00, 'MasterCard', 935618724, 0),
(14, '/receipts/receipt14.jpg', 1, 375.00, 'PayPal', 509372846, 0),
(15, '/receipts/receipt15.jpg', 1, 400.00, 'Chase Bank', 846209753, 0),
(16, '/receipts/receipt16.jpg', 1, 425.00, 'American Express', 209753846, 0),
(17, '/receipts/receipt17.jpg', 1, 450.00, 'PayPal', 753846209, 0),
(18, '/receipts/receipt18.jpg', 1, 475.00, 'Wells Fargo', 468135792, 0),
(19, '/receipts/receipt19.jpg', 1, 500.00, 'Visa', 135792468, 0),
(20, '/receipts/receipt20.jpg', 1, 525.00, 'PayPal', 246813579, 0),
(21, '/receipts/receipt21.jpg', 1, 550.00, 'Bank of America', 935724618, 0),
(22, '/receipts/receipt22.jpg', 1, 575.00, 'MasterCard', 724618935, 0),
(23, '/receipts/receipt23.jpg', 1, 600.00, 'PayPal', 618935724, 0),
(24, '/receipts/receipt24.jpg', 1, 625.00, 'Chase Bank', 935724618, 0),
(25, '/receipts/receipt25.jpg', 1, 650.00, 'American Express', 724618935, 0),
(26, '/receipts/receipt26.jpg', 1, 675.00, 'PayPal', 246813579, 0),
(27, '/receipts/receipt27.jpg', 1, 700.00, 'Wells Fargo', 135792468, 0),
(28, '/receipts/receipt28.jpg', 1, 725.00, 'Visa', 480937261, 0),
(29, '/receipts/receipt29.jpg', 1, 750.00, 'PayPal', 937261480, 0),
(30, '/receipts/receipt30.jpg', 1, 775.00, 'Bank of America', 261480937, 0);

INSERT INTO Action_Logs (EmployeeWebID, PermissionsID, UserAction, AffectedEntityType, AffectedEntityID, LogTimestamp) VALUES
(1, 1, 'Create', 'Employee_Info', 1, '2023-01-01 08:00:00'),
(2, 2, 'Update', 'Products', 2, '2023-01-02 09:15:00'),
(3, 3, 'Delete', 'Orders', 3, '2023-01-03 10:30:00'),
(4, 4, 'Remove', 'Customers', 4, '2023-01-04 11:45:00'),
(5, 5, 'ManageUser', 'Payment_Plan', 5, '2023-01-05 13:00:00'),
(6, 6, 'Create', 'Employee_Info', 6, '2023-01-06 14:15:00'),
(7, 7, 'Update', 'Products', 7, '2023-01-07 15:30:00'),
(8, 8, 'Delete', 'Orders', 8, '2023-01-08 16:45:00'),
(9, 9, 'Remove', 'Customers', 9, '2023-01-09 18:00:00'),
(10, 10, 'ManageUser', 'Payment_Plan', 10, '2023-01-10 19:15:00'),
(11, 11, 'Create', 'Employee_Info', 11, '2023-01-11 20:30:00'),
(12, 12, 'Update', 'Products', 12, '2023-01-12 21:45:00'),
(13, 13, 'Delete', 'Orders', 13, '2023-01-13 22:00:00'),
(14, 14, 'Remove', 'Customers', 14, '2023-01-14 23:15:00'),
(15, 15, 'ManageUser', 'Payment_Plan', 15, '2023-01-15 00:30:00'),
(16, 16, 'Create', 'Employee_Info', 16, '2023-01-16 01:45:00'),
(17, 17, 'Update', 'Products', 17, '2023-01-17 02:00:00'),
(18, 18, 'Delete', 'Orders', 18, '2023-01-18 03:15:00'),
(19, 19, 'Remove', 'Customers', 19, '2023-01-19 04:30:00'),
(20, 20, 'ManageUser', 'Payment_Plan', 20, '2023-01-20 05:45:00'),
(21, 21, 'Create', 'Employee_Info', 21, '2023-01-21 06:00:00'),
(22, 22, 'Update', 'Products', 22, '2023-01-22 07:15:00'),
(23, 23, 'Delete', 'Orders', 23, '2023-01-23 08:30:00'),
(24, 24, 'Remove', 'Customers', 24, '2023-01-24 09:45:00'),
(25, 25, 'ManageUser', 'Payment_Plan', 25, '2023-01-25 11:00:00'),
(26, 26, 'Create', 'Employee_Info', 26, '2023-01-26 12:15:00'),
(27, 27, 'Update', 'Products', 27, '2023-01-27 13:30:00'),
(28, 28, 'Delete', 'Orders', 28, '2023-01-28 14:45:00'),
(29, 29, 'Remove', 'Customers', 29, '2023-01-29 16:00:00'),
(30, 30, 'ManageUser', 'Payment_Plan', 30, '2023-01-30 17:15:00');

