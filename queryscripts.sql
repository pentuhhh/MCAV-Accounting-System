/*Order Management table query*/

SELECT      
    o.OrderID,      
    CONCAT(c.CustomerFname, ' ', c.CustomerLname) AS CustomerName,      
    p.ProductDescription,      
    P.ProductQuantity,      
    o.OrderStartDate,      
    o.OrderDeadline,      
    o.OrderStatusCode AS Status  
FROM      
    orders o     
INNER JOIN customers c ON o.customerid = c.customerID      
INNER JOIN products p ON p.productid = o.productid 
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
