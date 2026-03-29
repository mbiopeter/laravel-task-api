Task Management API – Laravel (MySQL)

Overview
This project is a Task Management API built with Laravel and MySQL as part of a take-home assignment.

Features:

- Create tasks
- List tasks with filtering and sorting
- Update task status with strict progression rules
- Delete tasks only when completed
- Daily task report

Tech Stack

- Laravel
- PHP
- MySQL

Database Setup

1. Create Database (IMPORTANT)
   Before running migrations, create the database manually in MySQL:

Example using MySQL CLI:
CREATE DATABASE task_manager;

2. Configure .env
   Update your database credentials:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=your password

3. Run Migrations
   php artisan migrate

4. Seed Data
   php artisan db:seed

Run Project Locally
php artisan serve

Base URL:
http://127.0.0.1:8000

API Endpoints

- POST /api/tasks
- GET /api/tasks
- PATCH /api/tasks/{id}/status
- DELETE /api/tasks/{id}
- GET /api/tasks/report

Postman Test Cases:

CREATE TASK

Test Case 1 — Valid Creation
POST /api/tasks
{
"title": "Finish assignment",
"due_date": "2026-04-01",
"priority": "high"
}

Test Case 2 — Duplicate Task
{
"title": "Finish assignment",
"due_date": "2026-04-01",
"priority": "medium"
}

Expected:
{
"error": "Duplicate task"
}

Test Case 3 — Invalid Priority
{
"title": "Task name",
"due_date": "2026-04-01",
"priority": "urgent"
}

Test Case 4 — Past Date
{
"title": "Old Task",
"due_date": "2020-01-01",
"priority": "low"
}

LIST TASKS

Test Case 5 — Get All Tasks
GET /api/tasks

Test Case 6 — Filter by Status
GET /api/tasks?status=pending

Test Case 7 — No Tasks
Expected:
{
"message": "No tasks found"
}

UPDATE STATUS

Test Case 8 — Valid Transition
PATCH /api/tasks/1/status
{
"status": "in_progress"
}

Test Case 9 — Skip Status
{
"status": "done"
}

Expected:
{
"error": "Cannot skip status progression"
}

Test Case 10 — Revert Status
{
"status": "pending"
}

Expected:
{
"error": "Cannot revert status"
}

DELETE TASK

Test Case 11 — Delete Non-Done Task
DELETE /api/tasks/{id}

Expected:
{
"error": "Only done tasks can be deleted"
}

Test Case 12 — Delete Done Task

Expected:
{
"message": "Task deleted successfully"
}

DAILY REPORT

Test Case 13 — Valid Report
GET /api/tasks/report?date=2026-04-01

Expected:
{
"date": "2026-04-01",
"summary": {
"high": {
"pending": 0,
"in_progress": 0,
"done": 0
},
"medium": {
"pending": 0,
"in_progress": 0,
"done": 0
},
"low": {
"pending": 0,
"in_progress": 0,
"done": 1
}
}
}

Test Case 14 — Missing Date
GET /api/tasks/report

Expected:
{
"error": "Date is required"
}

Business Rules Implemented

Create Task

- Title must be unique per due_date
- Priority must be: low, medium, high
- Due date must be today or future

List Tasks

- Sorted by priority (high to low)
- Then by due_date ascending
- Optional status filter

Update Status
Allowed progression:
pending → in_progress → done

Blocked:

- Cannot skip status
- Cannot revert status
- Cannot set same status

Delete Task

- Only tasks with status "done" can be deleted

Report

- Returns grouped counts by priority and status
- Filtered by date

Author
Mbio Peter
