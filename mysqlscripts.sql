/* Not formatted properly so dont run or import

just copy and paste the queries
*/
create database MCAV;

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

create table employees(
    EmployeeID int auto_increment,
    PermissionsID int NOT NULL,
    ProfilePicturePath varchar(255) NOT NULL,
    EmployeeFirstname varchar(32) NOT NULL,
    EmployeeLastname varchar(32) NOT NULL,
    EmployeeHireDate varchar(32) NOT NULL,
    Gender enum('M','F') NOT NULL,
    Position varchar(32) NOT NULL,
    WebUserLevel int NOT NULL,

    primary key(EmployeeID),
    foreign key(PermissionsID) references Permissions(PermissionsID),
    check (Gender in ('M','F'))
);

create table products(
    productID int auto_increment,
    productDescription varchar(255),
    productFilePath varchar(255),
    productDimenstions varchar(32),
    ProductQuantity int,
    ProductStatusCode int,

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

    primary key(OrderID),
    foreign key(EmployeeID) references employees(EmployeeID),
    foreign key(customerID) references customers(CustomerID),
    foreign key(ProductID) references products(productID)
);

create table paymentPlans(
    PlanID int auto_increment,
    OrderID int NOT NULL,
    DueDate date,
    PaymentStatus int default 0 NOT NULL,
    PaymentMethod varchar(32),
    PaymentProcessor varchar(32),
    AmountPaid float default 0,

    primary key(PlanID),
    foreign key(OrderID) references Orders(OrderID)
);

create table Receipts(
    ReceiptID int auto_increment,
    PlanID int NOT NULL,
    ReceiptImagePath varchar(255),
    HasPicture bool default 0,
    ReceiptAmountPaid float default 0,


    PaymentProcessor varchar(32),
    PaymentProcessorReferenceNumber float default 0,

    primary key (ReceiptID),
    foreign key (PlanID) references paymentPlans(PlanID)
);