# MCAV-Accounting-System

Checklist of Features:

Core Functionalities:
    CRUD for users,
    
    Three User Levels:
        For Accountants or Authorized Users-
            Can Create Entries
            Can Update Existing Records in the form of a Branch
                Defn: Existing Records Cannot be Deleted, but Branched off. If an
                Authorized User Makes a change to a record then that new Version of the record will
                replace the old one and the old one is Archived

                Updated / Deleted Records are marked as Updated/Removes but still kept

        For Technicians and Support-
            
            Manually Create Accounts for Employees
            Cannot Make Entries no Delete Old entries
            Can manage permissions and other functionalities but cannot tamper with the Data

        For the Owner

            All permissions Allowed

    Efficient Data Modeling
        Atomize data structures and eliminate large tables with many fields
        
        AMAP we should use conditional tables

Technical Functionalities:

Network Topology:

    2 Minimal Cost Servers Will be Used. Since we are only making a webapp for the 
    employees of a business the size of 20~ employees, any modern comptuer with a recent
    generation cpu will do, ~12,000-15,000 php EACH

    We are doing a 2 Server setup as we need

        Security - Hacking into one computer is hard, hacking into two is harder
            The two computers exist has their own isolated network in which only one computer, the webserver
            is connected to the Office network that is connected to the internet and the other computer, the database server
            is not connected to the internet and is only connected to the other one

            this is standard practice as it does not allow for direct attacks over the internet and adds layers of protection

            The WebServer will be the one doing the processing and that is where the code is stored, the operating system for this device
            will be designed for speed and optimization

            The database server will bethe one storing data. It will not process any data nor run any code. This device will be specced to have
            a larger storage capacity and will be optimized for efficiency and redundancy

    We will need 2 network cards and a switch

Authentication and Authorization

    User passowrds are Encrypted in the database via BCrypt
    Session feature Via PHP

    Unauthorized users cannot access pages that they are forbidden
        Prevent URL manipulation

    Double Authorization Layers
        
        The database will be encrypted, particularly the transactional records, its decryption hash will be separate from the rest.
        On the end of the webserver, for it to be able to retrieve any form of Data from the database, it must first need to retrieve
        the separate decryption hash that is stored. This separate decryption hash is only accessible if and only if there is a user login wherein there is
        a successful exchange of secret. from there the server will use the separate hash and be able to decrpyt the data and display

    Input Sanitaion

        Sanitize inputs for SQL injections and whatnot

    Firewalls between the Server and Database

    Secure Shell Layer and Transport Layer Security

Performance Optimizations

    Serverside Caching

Logging and Tracking

    Users will be tracked as this is a company tool. Must have a live log for the owner to view and other authorized users
    Logging will only happen for specified triggers such as when an entry is created and removed, a report is generated or something is downloaded

    Error handling may be done similarly to logging in which the server will log successful executions of functions



Documentation

    Ensure that the codebase is understandable and not ambiguos, as such we will follow a naming convention

    if you are naming a button and you want CSS for it, label it as such

    -all caps
    -use underscore
    -no numbers if possible

    PARENTPAGE_LOCATIONINPAGE_ACTION_ELEMENTTYPE

    or

    PARENTPAGE_PARENTDIV_ACTION_ELEMENTTYPE

    so if i want to make a login button located in the navbar, i do this

    HOMEPAGE_NAVBAR_LOGIN_BUTTON

    or

    HOMEPAGE_LOGINBOX_LOGIN_BUTTON

    **assuming I have a login Box DIV and my LOG IN button is located inside it**

    We will have multiple CSS files.
    each page will have 1 css file in which CSS code for unique elements is stored there

    there will be 1 global CSS file as well in which common elements such as .body, .nav and fonts are stored

    same goes for PHP and Javascript


    for the love of god please do not use Button1, Button2 and etc





Code Stack : 

- HTML
- CSS
- PHP
- JAVASCRIPT

