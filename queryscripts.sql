/*Order Management table query*/

SELECT      
    o.OrderID,      
    CONCAT(c.CustomerFname, ' ', c.CustomerLname) AS CustomerName,           
    o.OrderStartDate,      
    o.OrderDeadline,      
    o.OrderStatusCode AS Status  
FROM      
    orders o     
INNER JOIN customers c ON o.customerid = c.customerID      
where o.isremoved = 0 order by o.orderId asc;

/*Payment Receipts Table*/

SELECT
    r.ReceiptID,
    p.OrderID,
    p.PaymentMethod,
    r.ReceiptAmountPaid,
    r.PaymentDate
From
    Payment_Receipts r
INNER JOIN payment_plans p on r.PlanID = p.planID
where r.isremoved = 0 order by r.ReceiptID asc;

/* Order Details Page */

/* Customer Information */

select 
    concat(customerFname, ' ', CustomerLname) as 'Customer Name',
    CustomerEmail as 'Email',
    CustomerPhone as 'Phone Number'
from customers where
    customerID = 1;

/* Order Information */

select
    OrderStartDate as 'Order Date',
    OrderDeadline as 'Deadline',
    OrderStatusCode as 'Status'
from orders where
    orderID = 1;

/* Ordered Products */

select 
    ProductID,
    productDescription,
    productDimenstions,
    ProductQuantity,
    ProductPrice,
    ProductStatusCode
from products where
    orderID = 1 and isremoved = 0;

/* payment Plan */

select
    PaymentMethod,
    DueDate,
    PaymentStatus,
    TotalAmount,
    AmountPaid,
    Balance
from payment_Plans where
    orderID = 1 and isremoved = 0;

/* Related Receipts Table */

select
    ReceiptID,
    ReceiptAmountPaid,
    PaymentDate
from Payment_Receipts where
    planID = 1 AND isremoved = 0;



/* Dashboard */

/* Analytics */

SELECT 
    SUM(ReceiptAmountPaid) AS 'Monthly Sales'
FROM 
    Payment_Receipts
WHERE 
    PaymentDate >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
    AND PaymentDate <= CURDATE();

/* Total Orders */

SELECT
    count(OrderID) as 'Total Orders'
FROM
    orders where
    isremoved = 0;

/* Total Sales */

SELECT
    SUM(ReceiptAmountPaid) As 'Total Sales'
From
    Payment_Receipts
where
    isremoved = 0;

/* Recent Orders */

select
    o.orderID as 'Order ID',
    concat(c.customerFname, ' ', c.customerLname) as 'Customer Name',
    o.orderStartDate as 'Order Date',
    pp.TotalAmount as 'Amount',
    o.OrderDeadline as 'Deadline',
    o.OrderStatusCode as 'Status'
From 
    orders o
INNER JOIN payment_Plans pp on pp.orderID = o.orderID
INNER JOIN customers c on o.customerID = c.customerID

Order by o.OrderDeadline asc Limit 5;


insert into payment_receipts (
    PlanID, 
    ReceiptImagePath, 
    Haspicture, 
    ReceiptAmountpaid, 
    paymentDate, 
    PaymentProcessor, 
    PaymentProcessorReferenceNumber, 
    Isremoved) 
values (
    1,
    'sadsdas',
    1,
    100,
    CURDATE(),
    'processor1',
    23131,
    0
);

