# TaskManager API
A robust Laravel-based RESTful API designed for strict task lifecycle management. This project implements advanced validation, duplicate prevention, and automated daily reporting.

---

## Tech Stack

* Framework: Laravel 13.0
* Database: MySQL 8.5
* Architectural Style: REST API
* Deployment Platform: Railway

---

## Setup and Installation

## 1. Database Initialization
Before running the application, manually create the database in your MySQL environment:

## sql
CREATE DATABASE task_manager;


## 2. Environment Configuration
Clone the repository and update your .env file with your local credentials:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=your_password

## 3. Migration and Seeding
Run the following commands to set up the schema and populate initial data:

php artisan migrate
php artisan db:seed

## 4. Local Development
Start the development server:

php artisan serve
Base URL: http://127.0.0.1:8000

## Business Logic and Rules
   To ensure data integrity and process compliance, the API enforces the following constraints:

   Duplicate Prevention: A task cannot be created with a title that already exists for the same due_date.

   Due Date Validation: The due_date must be today or a future date.

   Strict Status Progression: Tasks must follow a linear lifecycle: pending -> in_progress -> completed.

   Blocked: Skipping stages (e.g., pending directly to completed) or reverting to a previous stage is strictly prohibited.

   Deletion Policy: Only tasks with a status of "completed" (done) can be deleted from the system.

   Automated Reporting: Generates a summary of tasks grouped by priority and status for any specific date.

## API Endpoints
Method	Endpoint	                     Description
POST	   /api/tasks	                  Create a new task
GET	   /api/tasks	                  List all tasks (Sorted by Priority and Due Date)
GET	   /api/tasks?status={val}	      List tasks filtered by status
PATCH	   /api/tasks/{id}/status	      Update task status (Strict progression)
DELETE	/api/tasks/{id}	            Remove a task (Completed only)
GET	   /api/tasks/report	            Get daily performance report

## Postman Test Suite

## 1.Task Creation and Validation
TC 01: Valid Creation - Returns 201 Created with task details.
TC 02: Duplicate Task - Returns 422 if title and date exist.
TC 03: Invalid Priority - Returns 422 if priority is not low, medium, or high.
TC 04: Past Due Date - Returns 422 if date is earlier than today.

## 2.Retrieval and Filtering
TC 05: List All - Returns tasks sorted by high priority first, then ascending due date.
TC 06: Filter Pending - Returns only tasks with pending status.
TC 07: Invalid Filter - Returns 422 with valid status options.
TC 08: Empty State - Returns 200 OK with "No tasks found" message.

## 3.Lifecycle Management
TC 09: Valid Status Update - Transitions task from pending to in_progress.
TC 10: Skip Progression - Returns 422 (Cannot skip to completed).
TC 11: Revert Status - Returns 422 (Cannot move back to pending).
TC 12: Delete Forbidden - Returns 403 if task is not completed.
TC 13: Delete Success - Returns 200 for completed task removal.

## 4.Lifecycle Management
TC 14: Valid Report - Returns grouped counts for a specific date.
TC 15: Missing Date - Returns 422 error if date parameter is missing.

Author
Mbio Peter
Laravel Engineer Intern
Portfolio: https://github.com/mbiopeter/laravel-task-api
Live Demo: https://laravel-task-api-production.up.railway.app
