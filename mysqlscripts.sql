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

create table products(
    productID int auto_increment,
    productDescription varchar(255),
    productFilePath varchar(255),
    productDimenstions varchar(32),
    ProductQuantity int,
    ProductStatusCode int,

    IsRemoved boolean,

    primary key(ProductID)

);

create table orders(
    OrderID int auto_increment,
    EmployeeID int NOT NULL,
    CustomerID int NOT NULL,
    ProductID int NOT NULL,
    OrderStartDate Date NOT NULL,
    OrderDeadline Date,
    OrderStatusCode int NOT NULL,

    IsRemoved boolean,

    primary key(OrderID),
    foreign key(EmployeeID) references employee_info(EmployeeID),
    foreign key(customerID) references customers(CustomerID),
    foreign key(ProductID) references products(productID)
);

create table payment_plans(
    PlanID int auto_increment,
    OrderID int NOT NULL,
    DueDate date,
    PaymentStatus int default 0 NOT NULL,
    PaymentMethod varchar(32),
    PaymentProcessor varchar(32),
    AmountPaid float default 0,

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
    ProductID int NOT NULL,
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
    productDescription varchar(255),
    productFilePath varchar(255),
    productDimenstions varchar(32),
    ProductQuantity int,
    ProductStatusCode int,

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
    AmountPaid float default 0,

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


    PaymentProcessor varchar(32),
    PaymentProcessorReferenceNumber float default 0,

    primary key(ReceiptArchiveID),
    foreign key(ReceiptID) references Payment_Receipts(ReceiptID)
);


