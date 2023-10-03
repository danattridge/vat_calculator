# VAT Calculator Task 

## Overview

Task:

Create a VAT calculator that shows a history of calculations requested that can be exported as a CSV file.
For user provided monetary value V and VAT percentage rate R, calculate and display both sets of calculations:
Where V is treated as being ex VAT show the original value V, the value V with VAT added and the amount of VAT calculated at the rate R.
Where V is treated as being inc VAT show the original value V, the value V with VAT subtracted and the amount of VAT calculated at the rate R.
The results from each requested set of calculations should be stored, and displayed on screen as a table of historical calculations.
The history should be able to be cleared and exportable to a CSV file.
Host your final code on a public git remote (github, bitbucket, etc) that we can access and ensure you have added a README file to document your specific files for us to review.
You are free to use your preferred stack, be it WAMP/MAMP or Docker with K8s etc. You must however ensure you use PHP7.4 - 8.2 and MariaDB.

Bonus points:

Migrate or build your calculator on a Symfony project
Prevent against XSS & SQL injection

## Files Added/Edited

/assets/styles/*
/migrations/*
/src/Controller/PageController.php
/src/Controller/SalesController.php
/src/Entity/Sale.php
/src/EntitySalesForm.php
/src/Repository/SaleRepository.php

/templates/inc/*
/templates/pages/*
/templates/base.html.twig

## Implementation Details

Run this as a standard Symfony project in the usual way. You will need to run 'php bin/console make:migration' and 'php bin/console doctrine:migrations:migrate' to add the database table. You may also need to run 'npm dev run' also to add the styling.


---

## Additional Information

I have coded this on my Ubuntu LAMP stack which is currently set up to use mysql and not mariadb. I understand they're very similar so have left the database as mysql. I hope this is ok.  
