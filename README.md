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
Clone the repository and update your .env file with your local credentials:<br>

DB_CONNECTION=mysql<br>
DB_HOST=127.0.0.1<br>
DB_PORT=3306<br>
DB_DATABASE=task_manager<br>
DB_USERNAME=root<br>
DB_PASSWORD=your_password<br>

## 3. Migration and Seeding
Run the following commands to set up the schema and populate initial data:<br>

php artisan migrate<br>
php artisan db:seed<br>

## 4. Local Development
Start the development server:<br><br>

php artisan serve<br>
Base URL: http://127.0.0.1:8000<br>

## Business Logic and Rules
   To ensure data integrity and process compliance, the API enforces the following constraints:<br>

   Duplicate Prevention: A task cannot be created with a title that already exists for the same due_date.<br>

   Due Date Validation: The due_date must be today or a future date.<br>

   Strict Status Progression: Tasks must follow a linear lifecycle: pending -> in_progress -> completed.<br>

   Blocked: Skipping stages (e.g., pending directly to completed) or reverting to a previous stage is strictly prohibited.<br>

   Deletion Policy: Only tasks with a status of "completed" (done) can be deleted from the system.<br>

   Automated Reporting: Generates a summary of tasks grouped by priority and status for any specific date.<br>

## API Endpoints
Method	Endpoint	                     Description<br>
POST	   /api/tasks	                  Create a new task<br>
GET	   /api/tasks	                  List all tasks (Sorted by Priority and Due Date)<br>
GET	   /api/tasks?status={val}	      List tasks filtered by status<br>
PATCH	   /api/tasks/{id}/status	      Update task status (Strict progression)<br>
DELETE	/api/tasks/{id}	            Remove a task (Completed only)<br>
GET	   /api/tasks/report	            Get daily performance report<br>

## Postman Test Suite

## 1.Task Creation and Validation
TC 01: Valid Creation - Returns 201 Created with task details.<br>
TC 02: Duplicate Task - Returns 422 if title and date exist.<br>
TC 03: Invalid Priority - Returns 422 if priority is not low, medium, or high.<br>
TC 04: Past Due Date - Returns 422 if date is earlier than today.<br><br>

## 2.Retrieval and Filtering
TC 05: List All - Returns tasks sorted by high priority first, then ascending due date.<br>
TC 06: Filter Pending - Returns only tasks with pending status.<br>
TC 07: Invalid Filter - Returns 422 with valid status options.<br>
TC 08: Empty State - Returns 200 OK with "No tasks found" message.<br><br>

## 3.Lifecycle Management
TC 09: Valid Status Update - Transitions task from pending to in_progress.<br>
TC 10: Skip Progression - Returns 422 (Cannot skip to completed).<br>
TC 11: Revert Status - Returns 422 (Cannot move back to pending).<br>
TC 12: Delete Forbidden - Returns 403 if task is not completed.
TC 13: Delete Success - Returns 200 for completed task removal.<br><br>

## 4.Lifecycle Management
TC 14: Valid Report - Returns grouped counts for a specific date.<br>
TC 15: Missing Date - Returns 422 error if date parameter is missing.<br><br>

Author<br>
Mbio Peter<br>
Laravel Engineer Intern<br>
Portfolio: https://github.com/mbiopeter/laravel-task-api<br>
Live Demo: https://laravel-task-api-production.up.railway.app<br>
