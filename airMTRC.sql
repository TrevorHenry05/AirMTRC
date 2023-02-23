-- Start of Sample SQL Script
-- Group: airMTRC
-- Tested and Works on phpmyadmin
-- Project Phase III
-- Group  (phpmyadmin)
-- This SQL Script was tested on
-- phpmyadmin. To run, simply
-- load this script file and run.


DROP DATABASE IF EXISTS `airmtrc`;
CREATE DATABASE IF NOT EXISTS `airmtrc`;
USE `airmtrc`;

-- ***************************
-- Part A
-- ***************************
-- TABLE Users: store data about Users

CREATE TABLE User( 
         id		 	INT         AUTO_INCREMENT, 
         Fname  		VARCHAR(100) 		NOT NULL, 
         Lname  		VARCHAR(100) 		NOT NULL, 
         email  		VARCHAR(100) 		NOT NULL, 
         password 		VARCHAR(20)		 DEFAULT 'password', 
         PRIMARY KEY(id) 
);


-- TABLE Renters: store data about Renters

CREATE TABLE Renter( 
         id 			INT     AUTO_INCREMENT, 
         user_id 		INT 		NOT NULL, 
         CHECK(user_id > 0), 
         PRIMARY KEY(id), 
         FOREIGN KEY(user_id) REFERENCES User(id) ON DELETE CASCADE 
);


-- TABLE Hosts: store data about Hosts

CREATE TABLE Host ( 
         id		 	INT         AUTO_INCREMENT, 
         user_id		 INT 		NOT NULL, 
         CHECK(user_id > 0), 
         PRIMARY KEY(id), 
         FOREIGN KEY(user_id) REFERENCES User(id) ON DELETE CASCADE 
);



-- TABLE Properties: store data about Properties

CREATE TABLE Property (  
        id 			INT        AUTO_INCREMENT,  
        title 		VARCHAR(100)		NOT  NULL,  
        description 		LONGTEXT		 	NOT NULL,  
        address 		VARCHAR(255) 		NOT NULL,  
        city 		VARCHAR(50) 		NOT NULL,  
        state 		VARCHAR(50),  
        country 		VARCHAR(50) 		NOT NULL,  
        host_id		 INT 		NOT NULL,  
        short_term_cost_per_day 		DECIMAL(10, 2) 		NOT NULL,  
        long_term_cost_per_month 		DECIMAL(10, 2) 		NOT NULL,  
        CHECK(host_id > 0),  
        CHECK (short_term_cost_per_day >= 0 AND long_term_cost_per_month >= 0),  
        PRIMARY KEY(id),  
        FOREIGN KEY(host_id) REFERENCES Host(id) ON DELETE CASCADE  
);


-- TABLE Rentals: store data about Rentals

CREATE TABLE Rental ( 
        id 			INT         AUTO_INCREMENT, 
        start_date 		DATE		 	DEFAULT CURRENT_DATE, 
        end_date 		DATE 			NOT NULL, 
        property_id		 INT		NOT NULL, 
        renter_id 		INT		 NOT NULL, 
        type 		VARCHAR(10) 		DEFAULT 'short-term', 
        CHECK (start_date < end_date), 
        CHECK(property_id > 0 AND renter_id > 0), 
        CHECK (type = 'short-term' OR type = 'long-term'), 
        PRIMARY KEY(id), 
        FOREIGN KEY(property_id) REFERENCES Property(id) ON DELETE CASCADE, 
        FOREIGN KEY(renter_id) REFERENCES Renter(id) ON DELETE CASCADE 
);


-- TABLE Invoices: store data about Invoices

CREATE TABLE Invoice ( 
        id 			INT         AUTO_INCREMENT, 
        rental_id		 INT 		NOT NULL, 
        amount 		DECIMAL(10, 2) 		NOT NULL, 
        due_date 		DATE			 DEFAULT CURRENT_DATE, 
        CHECK (amount >= 0), 
        CHECK(rental_id > 0), 
        PRIMARY KEY(id), 
        FOREIGN KEY(rental_id) REFERENCES Rental(id) ON DELETE CASCADE 
);





-- ***************************
-- ***************************
-- Part B
-- ***************************

-- Sample data for Table Users
-- Summary: store data about Users
INSERT INTO User (`id`, `Fname`, `Lname`, `email`, `password`) VALUES
(1, 'John', 'Doe', 'johndoe@example.com', 'password1'),
(2, 'Jane', 'Doe', 'janedoe@example.com', 'password2'),
(3, 'Jim', 'Smith', 'jimsmith@example.com', 'password3'),
(4, 'Amy', 'Johnson', 'amyjohnson@example.com', 'password4'),
(5, 'Bob', 'Williams', 'bobwilliams@example.com', 'password5'),
(6, 'Carol', 'Brown', 'carolbrown@example.com', 'password6'),
(7, 'David', 'Jones', 'davidjones@example.com', 'password7'),
(8, 'Emily', 'Davis', 'emilydavis@example.com', 'password8'),
(9, 'Frank', 'Wilson', 'frankwilson@example.com', 'password9'),
(10, 'Grace', 'Taylor', 'gracetaylor@example.com', 'password10'),
(11, 'Harry', 'Anderson', 'harryanderson@example.com', 'password11'),
(12, 'Ivy', 'Thomas', 'ivythomas@example.com', 'password12'),
(13, 'Jack', 'Moore', 'jackmoore@example.com', 'password13'),
(14, 'Kelly', 'Martin', 'kellymartin@example.com', 'password14'),
(15, 'Liam', 'Jackson', 'liamjackson@example.com', 'password15'),
(16, 'Tom', 'Brown', 'tombrown@example.com', 'password16'),
(17, 'Nancy', 'Green', 'nancygreen@example.com', 'password17'),
(18, 'Michael', 'White', 'michaelwhite@example.com', 'password18'),
(19, 'Sophia', 'Black', 'sophiablack@example.com', 'password19'),
(20, 'Olivia', 'Gray', 'oliviagray@example.com', 'password20'),
(21, 'Malin', 'Nani', 'malnan@example.com', 'password81'),
(22, 'Malice', 'Nale', 'MalicNal@example.com', 'password90'),
(23, 'Nina', '', 'ninham@example.com', 'password23'),
(24, 'Nina', 'Hamilton', 'ninhamil@example.com', 'password24');

-- Sample data for Table Hosts
-- Summary: store data about Hosts
INSERT INTO Host (`id`, `user_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 21),
(12, 22),
(13, 23),
(14, 24);

-- Sample data for Table Renters
-- Summary: store data about Renters
INSERT INTO Renter (`id`, `user_id`) VALUES
(15, 1),
(1, 11),
(2, 12),
(3, 13),
(4, 14),
(5, 15),
(6, 16),
(7, 17),
(8, 18),
(9, 19),
(10, 20),
(11, 21),
(12, 22),
(13, 23),
(14, 24);


-- Sample data for Table Properties
-- Summary: store data about Properties
INSERT INTO Property (`id`, `title`, `description`, `address`, `city`, `state`, `country`, `host_id`, `short_term_cost_per_day`, `long_term_cost_per_month`) VALUES
(1, 'Luxury Villa', 'Stunning 5-bedroom villa with private pool and breathtaking views', '123 Main St', 'Miami', 'Florida', 'USA', 1, 500.00, 1500.00),
(2, 'Cosy Cottage', 'Charming 2-bedroom cottage in the heart of the countryside', '456 Oak Ave', 'Seattle', 'Washington', 'USA', 2, 200.00, 800.00),
(3, 'Modern Studio', 'Stylish studio apartment with city views', '789 Broadway', 'New York', 'New York', 'USA', 3, 150.00, 600.00),
(4, 'Beach House', 'Beautiful 3-bedroom house steps away from the beach', '246 Ocean Dr', 'Los Angeles', 'California', 'USA', 4, 400.00, 1200.00),
(5, 'City Centre Apartment', 'Spacious 2-bedroom apartment in the heart of the city', '369 Elm St', 'London', '', 'UK', 5, 300.00, 1000.00),
(6, 'Mountain Retreat', 'Rustic 1-bedroom cabin surrounded by nature', '159 River Rd', 'Paris', '', 'France', 6, 200.00, 700.00),
(7, 'Lakeside Villa', 'Luxurious 4-bedroom villa with private lake access', '753 Lake Ave', 'Rome', '', 'Italy', 7, 500.00, 1500.00),
(8, 'Countryside Farmhouse', 'Charming 3-bedroom farmhouse surrounded by rolling hills', '948 Farm Rd', 'Berlin', '', 'Germany', 8, 300.00, 900.00),
(9, 'Beautiful Ocean View Condo', 'Enjoy the stunning views of the ocean from this spacious two-bedroom condo. Perfect for a romantic getaway or a family vacation.', '1234 Ocean Drive', 'Miami', 'Florida', 'USA', 8, 150.00, 1200.00),
(10, 'Charming Countryside Cottage', 'Escape to the countryside with this charming cottage. Relax in peace and quiet while surrounded by beautiful nature.', '567 Country Road', 'Oxford', NULL, 'UK', 9, 75.00, 800.00),
(11, 'Luxury Downtown Loft', 'Experience the best of city living with this luxurious downtown loft. Modern amenities and prime location make this a perfect choice for the urban traveler.', '901 Main Street', 'New York', NULL, 'USA', 10, 250.00, 2500.00);

-- Sample data for Table Rentals
-- Summary: store data about Rentals
INSERT INTO Rental (`id`, `start_date`, `end_date`, `property_id`, `renter_id`, `type`) VALUES
(1, '2023-03-01', '2023-03-05', 1, 1, 'short-term'),
(2, '2023-04-01', '2023-04-10', 2, 2, 'short-term'),
(3, '2023-05-01', '2023-08-01', 3, 3, 'long-term'),
(4, '2023-06-01', '2023-06-05', 4, 4, 'short-term'),
(5, '2023-07-01', '2023-09-01', 5, 5, 'long-term'),
(6, '2023-08-01', '2023-08-03', 6, 6, 'short-term'),
(7, '2023-09-01', '2023-09-05', 7, 7, 'short-term'),
(8, '2023-10-01', '2023-12-01', 8, 8, 'long-term'),
(9, '2023-11-01', '2023-11-05', 9, 9, 'short-term'),
(10, '2023-12-01', '2023-12-05', 10, 10, 'short-term'),
(12, '2022-03-01', '2022-03-05', 2, 15, 'short-term');

-- Sample data for Table Invoices
-- Summary: store data about Invoices
INSERT INTO Invoice (`id`, `rental_id`, `amount`, `due_date`) VALUES
(1, 1, 2500.00, '2023-03-05'),
(2, 2, 2000.00, '2023-02-22'),
(3, 3, 1800.00, '2023-08-01'),
(4, 4, 1600.00, '2023-02-22'),
(5, 5, 2000.00, '2023-09-01'),
(6, 6, 600.00, '2023-02-22'),
(7, 7, 2500.00, '2023-09-05'),
(8, 8, 1800.00, '2023-02-22'),
(9, 9, 750.00, '2023-11-05'),
(10, 10, 375.00, '2023-02-22'),
(11, 12, 1000.00, '2022-03-05');




-- ***************************
-- ***************************
-- Part C
-- ***************************

-- SQL QUERY 1
-- Purpose: Displays Invoices related to a specific User and the Title of the Property

-- Expected: A table containing details on invoices for a user and the Property title for each invoice
SELECT Property.title, Rental.start_date, Rental.end_date, Invoice.amount, Invoice.due_date 
FROM User
INNER JOIN Renter
ON User.id = Renter.user_id
INNER JOIN Rental
ON Renter.id = Rental.renter_id
INNER JOIN Property
ON Property.id = Rental.property_id
INNER JOIN Invoice
ON Rental.id = Invoice.rental_id
WHERE User.id = 11;

-- SQL QUERY 2
-- Purpose: A table displaying all rentals information within the USA.

-- Expected: Display users ID, rental_id, Fname, Lname, AND the title, state, country and cost per day of the properties.
SELECT
    A.ID,
    A.renter_id AS "RENTAL_ID",
    A.FName,
    A.LName,
    A.Email,
    A.Title AS "PROPERTY_TITLE",
    A.State,
    A.Country,
    A.Short_term_cost_per_day AS "COST_PER_DAY"
    FROM (
        SELECT
        U.id,
        U.FName,
        U.LName,
        U.Email,
        RT.renter_id,
        PROP.Title,
        PROP.State,
        PROP.Country,
        PROP.Short_term_cost_per_day
        FROM User U
            JOIN Renter R ON U.id = R.user_id
            JOIN Rental RT ON R.id = RT.renter_id
            JOIN Property PROP ON RT.property_id = PROP.id
    ) A
WHERE Country IN ('USA')
GROUP BY A.ID,A.renter_id, A.FName, A.LName, A.Email, A.Title, A.State, A.Country, A.Short_term_cost_per_day
ORDER BY ID ASC;

-- SQL QUERY 3
-- Purpose: A table displaying users and their rentals that costed greater than the average of the cost per month.

-- Expected: Display all Users Fname, Lname, Email, and the title, country and cost per month of properties.
SELECT
    A.FName,
    A.LName,
    A.Email,
    A.Title AS "PROPERTY_TITLE",
    A.Country,
    A.long_term_cost_per_month AS "LOWER_AVG_MONTHLY"
    FROM (
        SELECT
        U.FName,
        U.LName,
        U.Email,
        PROP.Title,
        PROP.Country,
        PROP.long_term_cost_per_month
        FROM User U
            JOIN Renter R ON U.id = R.user_id
            JOIN Rental RT ON R.id = RT.renter_id
            JOIN Property PROP ON RT.property_id = PROP.id
    ) A
WHERE 
    A.Long_term_cost_per_month > (
        SELECT AVG(Property.long_term_cost_per_month) FROM Property
    )
GROUP BY A.FName, A.LName, A.Email, A.Title, A.Country, A.Long_term_cost_per_month
ORDER BY long_term_cost_per_month DESC;

-- SQL QUERY 4
-- Purpose: A table displaying all Users renter_id and host_id.

-- Expected: Display all Users renter_id and host_id or null if they dont have one, user_id, First and Last Name, and Email.
SELECT User.id, User.Fname, User.Lname, User.email, Renter.id as Renter_id, Host.id as Host_id
FROM User
LEFT OUTER JOIN Renter ON User.id = Renter.user_id
LEFT OUTER JOIN Host ON User.id = Host.user_id
UNION
SELECT User.id, User.Fname, User.Lname, User.email, Renter.id as Renter_id, Host.id as Host_id
FROM Renter
RIGHT OUTER JOIN User ON Renter.user_id = User.id
LEFT OUTER JOIN Host ON User.id = Host.user_id
WHERE User.id IS NULL
UNION
SELECT User.id, User.Fname, User.Lname, User.email, Renter.id as Renter_id, Host.id as Host_id
FROM Host
RIGHT OUTER JOIN User ON Host.user_id = User.id
LEFT OUTER JOIN Renter ON User.id = Renter.user_id
WHERE User.id IS NULL;

-- SQL QUERY 5
-- Purpose: A table displaying only HOST information

-- Expected: Display all USERS that are also HOSTS and their HOST_ID, FName, Lname and email
SELECT
    A.id AS "HOST_ID",
    A.Fname,
    A.Lname,
    A.Email
    FROM (
        SELECT
            U.Fname,
            U.Lname,
            U.id,
            U.email
            FROM User U 
            JOIN Host H ON H.id = U.id
        INTERSECT
        SELECT
            U.Fname,
            U.Lname,
            U.id,
            U.email
            FROM User U
            JOIN Renter R ON R.id = U.id
    ) A
    GROUP BY A.ID, A.Fname, A.Lname, A.email
    ORDER BY ID ASC;

-- SQL QUERY 6
-- purpose: Get properties that have been rented long term in the current year

-- Expected: A table wiht title addreess city country and long_term_cost_per_month for properties that have been rented long term in the current year.

SELECT title, address, city, country, long_term_cost_per_month
FROM Property p 
JOIN Rental r ON p.id = r.property_id
WHERE r.type = 'long-term' 
AND EXTRACT(YEAR FROM r.start_date) = EXTRACT(YEAR FROM CURRENT_DATE);

-- SQL QUERY 7
-- purpose: Gives you users who have rented a property in paris with in the given time frame

-- Expected: A table that contains a users firsth name, last name, and email if they rented a property in paris and with in the date range given.
SELECT U.Fname, U.Lname, U.email 
FROM Renter R 
JOIN Rental L ON R.id = L.renter_id 
JOIN Property P ON L.property_id = P.id 
JOIN User U ON R.user_id = U.id 
WHERE P.city = 'Paris' AND L.start_date >= '2023-01-01' AND L.end_date <= '2023-12-31';

-- SQL QUERY 8
-- Purpose: Gives renters who have made at least 1 short-term rentals in a given date range

-- Expected: Returns the first and last names of renters, the title of the properties they rented, the start and end dates of their rentals, who rented at least 1 short-term properties in the year 2022, and ordered by the end date of the rental in descending order.

SELECT u.Fname, u.Lname, p.title, t.start_date, t.end_date
FROM User u
JOIN Renter r ON u.id = r.user_id
JOIN Rental t ON r.id = t.renter_id
JOIN Property p ON t.property_id = p.id
WHERE t.type = 'short-term' AND t.end_date BETWEEN '2023-01-01' AND '2023-12-31'
GROUP BY u.Fname, u.Lname, p.title, t.start_date, t.end_date
HAVING COUNT(*) >= 1
ORDER BY t.end_date DESC;

-- SQL QUERY 9
-- Purpose:Gives you rentals in a given city in descending order of cost per day

-- Expected: Returns the id, title, short-term cost per day, long-term cost per month, first name, last name, and email of all properties in the city of Paris, ordered by their short-term cost per day in descending order.
SELECT p.id, p.title, p.short_term_cost_per_day, p.long_term_cost_per_month, 
       u.Fname, u.Lname, u.email 
FROM Property p 
JOIN Host h ON p.host_id = h.id 
JOIN User u ON h.user_id = u.id 
WHERE p.city = 'Paris' 
ORDER BY p.short_term_cost_per_day DESC;



-- SQL QUERY 10
-- Purpose: Gives the names of all people who have made rentals

-- Expected: A table containing First and Last Name, property title, start and end date of rental, the type of rental, and the short and long-term rental amounts for each person with a rental including duplicates for people with multiple rentals.
SELECT U.Fname AS User_FirstName, 
             U.Lname AS User_LastName, 
             P.title AS Property_Title,
       	     RT.start_date, 
             RT.end_date, 
             RT.type,
             P.short_term_cost_per_day AS ShortTerm_Cost_PerDay, 
             P.long_term_cost_per_month AS LongTerm_Cost_PerMonth
FROM User U
JOIN Renter R ON U.id = R.user_id
JOIN Rental RT ON R.id = RT.renter_id
JOIN Property P ON RT.property_id = P.id;

