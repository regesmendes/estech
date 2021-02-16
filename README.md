# estech
## Test code for ESTech Group

As a solution for the test, I wrote a small application using Laravel 8 with some Vue basics.

I applied a number of features and resources that I thought were important after reading the requirements.
So, I started by building two MySQL Stored Procedures: importPrices, to import the cvs file into the DB; and getPrices, to query the lowest price on the DB.
I also created a few indexes to optimize the price search on DB, as the query cost without them was concerning.

For the app itself, I created a simple architecture with a web-router to redirect all public incoming requests to the Vue application, which will interact with the backend through an API. I made a diagram for an overview.

<p align="center">
    <img src="https://lh3.googleusercontent.com/pw/ACtC-3eVidTBzHIWHjSuyi-Y00FQRZCgzBE4q1A5LK8rDPxqjaii8F0IMGcvG3S48Kyy9zSquVRPFzTDkVn9Jxp0IA7Ra9qmDIz8yXBWi8VRQRiYK1aLP62RO-ZJYOcLPtz2HSAOUdj3As2jIVkSlJjZyTVQYw=w845-h534-no?authuser=0" alt="Basic Architecture"><br>
    <small>The app and DB are placed on separated containers, providing scalability.</small>
</p>

The Vue app loads the live-prices when started, and stores it on the client memory.

The UI allows the user to input one or more product codes (sku) separated by commas, and one optional account code.

Once a query is submitted, the app will search the params on the live-feed considering the following rules:
- user informed an account: then price for each product can be public (no account assigned) or private (assinged to the informed account);
- user left account field empty: then price needs to be public (no account assigned);
For both cases, if it finds more than one price, it will take the lowest one.

Since the UI allows more than one product to be queried at once, the app will take care of those that were not found on the live feed and check DB, applying the same rules regarding the informed account.

### To create DB entities:
```bash
php artisan migrate
```

### To import the csv file:
```bash
php artisan import:prices <file_name>
```

## Author
Feel free to [reach out](mailto:reges.mendes@gmail.com).
