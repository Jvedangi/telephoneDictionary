### **Project Development Plan: Telephone Dictionary System**

This document outlines the architecture, database design, features, and step-by-step implementation strategy for the Telephone Dictionary System.

#### **1. Project Architecture**

We will adopt a clean, service-oriented architecture built on the standard Laravel MVC pattern. This ensures a strong separation of concerns and promotes code that is easy to manage, test, and scale.

*   **Model-View-Controller (MVC):**
    *   **Models:** Eloquent models (`User`, `Contact`, `ContactGroup`) will define the application's data structure and relationships, providing a powerful interface to the database.
    *   **Views:** Blade templates will be used for rendering the user interface. A master layout (`layouts/app.blade.php`) will ensure a consistent UI, with child templates for specific pages.
    *   **Controllers:** Controllers will be responsible for handling HTTP requests and orchestrating the response. To maintain clean controllers, all significant business logic will be delegated to a dedicated service layer.

*   **Service Layer:**
    *   We will create a `app/Services` directory to house classes that encapsulate complex business logic. For example, a `CsvImportService` will handle the logic for parsing and importing contacts from a CSV file, keeping the `ImportExportController` lean and focused on its primary role.

*   **Form Requests:**
    *   All form validation logic will be encapsulated within dedicated Form Request classes (e.g., `StoreContactRequest`). This removes validation clutter from controllers and makes the validation rules reusable and easy to locate.

*   **API Design:**
    *   The REST API will be developed following standard best practices, using `routes/api.php` for definitions. API resources will be used to transform Eloquent models into standardized JSON responses, ensuring a consistent and predictable API structure.

#### **2. Database Design**

The database schema is designed to be normalized and efficient. To support a multi-user environment, I've added a `user_id` foreign key to both the `contacts` and `contact_groups` tables. This is a critical security measure to ensure users can only access and manage their own data.

*   **`users` Table (Standard Laravel)**
    *   `id`, `name`, `email`, `password`, `timestamps`

*   **`contact_groups` Table**
    *   `id` (Primary Key)
    *   `user_id` (Foreign Key to `users.id`) - *Ensures groups are user-specific.*
    *   `group_name` (VARCHAR)
    *   `description` (TEXT, Nullable)
    *   `timestamps`

*   **`contacts` Table**
    *   `id` (Primary Key)
    *   `user_id` (Foreign Key to `users.id`) - *Ensures contacts are user-specific.*
    *   `group_id` (Foreign Key to `contact_groups.id`)
    *   `name` (VARCHAR)
    *   `phone_number` (VARCHAR)
    *   `alternate_number` (VARCHAR, Nullable)
    *   `email` (VARCHAR, Nullable)
    *   `company` (VARCHAR, Nullable)
    *   `address` (TEXT, Nullable)
    *   `notes` (TEXT, Nullable)
    *   `favorite` (BOOLEAN, default: `false`)
    *   `timestamps`

**Relationships:**
*   A `User` has many `Contacts` and many `ContactGroups`.
*   A `Contact` belongs to one `User` and one `ContactGroup`.
*   A `ContactGroup` belongs to one `User` and has many `Contacts`.

#### **3. Folder Structure**

The project will adhere to Laravel's standard directory structure, with the addition of the following key files and directories:

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   └── ContactController.php
│   │   ├── ContactController.php
│   │   ├── ContactGroupController.php
│   │   ├── DashboardController.php
│   │   └── ImportExportController.php
│   └── Requests/
│       ├── StoreContactRequest.php
│       ├── UpdateContactRequest.php
│       ├── StoreContactGroupRequest.php
│       └── UpdateContactGroupRequest.php
├── Models/
│   ├── Contact.php
│   ├── ContactGroup.php
│   └── User.php
└── Services/
    └── CsvService.php
database/
├── factories/
│   ├── ContactFactory.php
│   └── ContactGroupFactory.php
├── migrations/
│   ├── ..._create_contact_groups_table.php
│   └── ..._create_contacts_table.php
└── seeders/
    ├── ContactSeeder.php
    └── DatabaseSeeder.php
resources/
└── views/
    ├── auth/
    ├── contacts/
    ├── dashboard.blade.php
    ├── groups/
    └── layouts/
        └── app.blade.php
routes/
├── web.php
└── api.php
```

#### **4. Development Steps**

I will proceed with the implementation in the following logical order, ensuring a solid foundation at each stage.

1.  **Project Initialization:**
    *   Install a fresh Laravel project.
    *   Configure the `.env` file for the database connection.
    *   Scaffold the complete authentication system (login, registration, etc.) using `laravel/breeze`.

2.  **Database & Models:**
    *   Generate the migrations for the `contact_groups` and `contacts` tables.
    *   Create the `Contact` and `ContactGroup` models and define their Eloquent relationships.
    *   Run the migrations to build the database schema.

3.  **Group Management (CRUD):**
    *   Create the `ContactGroupController` with full CRUD functionality.
    *   Define the necessary routes in `web.php`.
    *   Build the Blade views for listing, creating, and editing groups.
    *   Implement validation using `StoreContactGroupRequest` and `UpdateContactGroupRequest`.

4.  **Contact Management (CRUD):**
    *   Create the `ContactController` with full CRUD functionality.
    *   Define routes and build the corresponding Blade views.
    *   Implement validation using `StoreContactRequest` and `UpdateContactRequest`.
    *   Ensure all database queries are scoped to the authenticated user.

5.  **Dashboard Implementation:**
    *   Create the `DashboardController`.
    *   Implement the logic to fetch and display statistics: Total Contacts, Total Groups, and Favorite Contacts for the logged-in user.

6.  **Advanced Features:**
    *   **Favorites:** Implement the logic to toggle a contact's "favorite" status and create a dedicated page to list all favorite contacts.
    *   **Live Search:** Add a search bar to the contacts list. Use AJAX to send requests to a new search endpoint and dynamically update the contact list in real-time without a page refresh.

7.  **Import/Export Functionality:**
    *   Create the `ImportExportController` and a `CsvService`.
    *   Implement the logic to export contacts (all or or by group) to a CSV file.
    *   Implement the logic to upload and parse a CSV file for bulk contact creation.

8.  **REST API Development:**
    *   Create the `Api/ContactController` for API-specific logic.
    *   Define the resource routes in `api.php` for full CRUD functionality on contacts.
    *   Use API Resources to format the JSON output.
    *   Secure the API endpoints, for example, using Laravel Sanctum for token-based authentication.

9.  **Finalization and Seeding:**
    *   Create factories and a `ContactSeeder` to populate the database with sample data for testing and demonstration.
    *   Refine the UI/UX, add flash messages for user feedback, and ensure the entire application is mobile-responsive.
    *   Create the `PROJECT_PLAN.md` and `README.md` files as requested.

#### **5. API Structure**

The REST API will provide a clear and stateless interface for managing contacts.

*   `GET /api/contacts`: Retrieve a paginated list of contacts.
*   `GET /api/contacts/{id}`: Retrieve a single contact.
*   `POST /api/contacts`: Create a new contact.
*   `PUT /api/contacts/{id}`: Update an existing contact.
*   `DELETE /api/contacts/{id}`: Delete a contact.
