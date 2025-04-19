# Drive-Sharing-Application

Application that allows users to upload, download, and manage drives (files) with distinct roles for regular users and admins.

## Tech Stack

-   Laravel (version 10).
-   MySQL.
-   HTML, Bootsrap.
-   Sanctum (Laravel Authentication for User and Amdmin Roles).

## Prerequisites

Before setting up the project, ensure you have the following installed:

-   PHP >= 8.1
-   Composer
-   MySQL (through xampp, for instance)
-   Node.js & npm (for frontend assets)

## Usage

-   User Actions:
    -   Register or Log in as a User.
    -   Upload Drives and choose visibility (Public or Private).
    -   Browse and download public drives from other Users.
-   Admin Acrions:
    -   Log in or Register as an Admin (through different routes than Users).
    -   View Drives of all Users (Public or Private).
    -   Edit or delete any Drive.
