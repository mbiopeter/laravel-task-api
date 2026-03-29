<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskMaster API | Documentation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .mono { font-family: 'Fira Code', monospace; }
        .glass-card { 
            background: rgba(23, 23, 23, 0.6); 
            backdrop-filter: blur(20px); 
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }
        .glass-card:hover { transform: translateY(-4px); border-color: rgba(99, 102, 241, 0.3); }
        
        /* 3. JSON Syntax Highlighting */
        .j-key { color: #94a3b8; } 
        .j-str { color: #10b981; } 
        .j-num { color: #fbbf24; }
        .j-attr { color: #818cf8; }

        .bg-mesh {
            background-image: radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                              radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                              radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
        }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        .copy-btn:active { transform: scale(0.9); transition: 0.1s; }
    </style>
</head>
<body class="bg-[#0b0f1a] text-slate-300 selection:bg-indigo-500/30 bg-mesh min-h-screen">

    <nav class="sticky top-0 z-50 border-b border-white/5 bg-[#0b0f1a]/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <span class="text-white font-bold text-lg tracking-tight">Task<span class="text-indigo-400">Master</span> API</span>
            </div>
            <div class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="#setup" class="hover:text-white transition-colors">Setup</a>
                <a href="#endpoints" class="hover:text-white transition-colors">Endpoints</a>
                <a href="#test-suite" class="hover:text-white transition-colors">Test Cases</a>
                <a href="https://laravel-task-api-production.up.railway.app" target="_blank" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg transition-all shadow-lg shadow-indigo-600/20">Live Demo</a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-12">

        <section class="mb-24 text-center max-w-3xl mx-auto" data-aos="fade-up">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 tracking-tight leading-[1.1]">Task Management API</h1>
            <p class="text-lg text-slate-400 mb-10 leading-relaxed">Laravel backend with strict task lifecycle management, duplicate prevention, and daily reporting.</p>
            <div class="flex flex-wrap justify-center gap-3">
                <span class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-xs font-mono">Laravel 10+</span>
                <span class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-xs font-mono">MySQL 8+</span>
                <span class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-xs font-mono">REST API</span>
            </div>
        </section>

        <section id="setup" class="mb-24">
            <h2 class="text-3xl font-bold text-white mb-6" data-aos="fade-right">Setup Instructions</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="glass-card p-6 rounded-2xl" data-aos="zoom-in">
                    <h3 class="text-indigo-400 font-bold mb-3 uppercase text-sm">1. Create Database</h3>
                    <pre class="mono text-slate-300 text-sm">CREATE DATABASE task_manager;</pre>
                </div>
                <div class="glass-card p-6 rounded-2xl" data-aos="zoom-in" data-aos-delay="100">
                    <h3 class="text-purple-400 font-bold mb-3 uppercase text-sm">2. Configure .env</h3>
                    <pre class="mono text-slate-300 text-sm">DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=your_password</pre>
                </div>
                <div class="glass-card p-6 rounded-2xl" data-aos="zoom-in">
                    <h3 class="text-emerald-400 font-bold mb-3 uppercase text-sm">3. Run Migrations</h3>
                    <pre class="mono text-slate-300 text-sm">php artisan migrate</pre>
                </div>
                <div class="glass-card p-6 rounded-2xl" data-aos="zoom-in" data-aos-delay="100">
                    <h3 class="text-amber-400 font-bold mb-3 uppercase text-sm">4. Seed Database</h3>
                    <pre class="mono text-slate-300 text-sm">php artisan db:seed</pre>
                </div>
                <div class="glass-card p-6 rounded-2xl md:col-span-2" data-aos="zoom-in">
                    <h3 class="text-rose-400 font-bold mb-3 uppercase text-sm">5. Run Locally</h3>
                    <pre class="mono text-slate-300 text-sm">php artisan serve</pre>
                </div>
            </div>
        </section>

        <section id="hosting" class="mb-24">
            <h2 class="text-3xl font-bold text-white mb-6" data-aos="fade-right">Hosting on Railway</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="glass-card p-6 rounded-2xl" data-aos="fade-up">
                    <h3 class="text-indigo-400 font-bold mb-3 uppercase text-sm">MySQL Service</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        - Create MySQL database on Railway.<br>
                        - Copy host, database, username, and password.<br>
                        - Connect with MySQL Workbench if needed.
                    </p>
                </div>
                <div class="glass-card p-6 rounded-2xl" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-purple-400 font-bold mb-3 uppercase text-sm">Laravel App</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        - Deploy Laravel project on Railway.<br>
                        - Set environment variables in .env with Railway MySQL credentials.<br>
                        - Run migrations: <code class="text-indigo-300">php artisan migrate</code><br>
                        - (Optional) Seed database: <code class="text-indigo-300">php artisan db:seed</code>
                    </p>
                </div>
            </div>
        </section>

        <section id="endpoints" class="mb-24">
            <h2 class="text-3xl font-bold text-white mb-6" data-aos="fade-right">API Endpoints</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="glass-card p-6 rounded-2xl flex justify-between items-center group" data-aos="fade-up">
                    <div>
                        <p class="text-indigo-400 font-bold mb-2">POST /api/tasks</p>
                        <p class="text-slate-400 text-sm">Create a new task.</p>
                    </div>
                    <button onclick="copyRaw('/api/tasks')" class="text-slate-500 hover:text-white copy-btn opacity-0 group-hover:opacity-100 transition-opacity"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg></button>
                </div>
                <div class="glass-card p-6 rounded-2xl flex justify-between items-center group" data-aos="fade-up" data-aos-delay="100">
                    <div>
                        <p class="text-indigo-400 font-bold mb-2">GET /api/tasks</p>
                        <p class="text-slate-400 text-sm">List all tasks with optional filtering by status.</p>
                    </div>
                    <button onclick="copyRaw('/api/tasks')" class="text-slate-500 hover:text-white copy-btn opacity-0 group-hover:opacity-100 transition-opacity"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg></button>
                </div>
                <div class="glass-card p-6 rounded-2xl flex justify-between items-center group" data-aos="fade-up">
                    <div>
                        <p class="text-indigo-400 font-bold mb-2">PATCH /api/tasks/{id}/status</p>
                        <p class="text-slate-400 text-sm">Update task status (pending → in_progress → done).</p>
                    </div>
                    <button onclick="copyRaw('/api/tasks/{id}/status')" class="text-slate-500 hover:text-white copy-btn opacity-0 group-hover:opacity-100 transition-opacity"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg></button>
                </div>
                <div class="glass-card p-6 rounded-2xl flex justify-between items-center group" data-aos="fade-up" data-aos-delay="100">
                    <div>
                        <p class="text-indigo-400 font-bold mb-2">DELETE /api/tasks/{id}</p>
                        <p class="text-slate-400 text-sm">Delete task (only done tasks).</p>
                    </div>
                    <button onclick="copyRaw('/api/tasks/{id}')" class="text-slate-500 hover:text-white copy-btn opacity-0 group-hover:opacity-100 transition-opacity"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg></button>
                </div>
                <div class="glass-card p-6 rounded-2xl md:col-span-2 flex justify-between items-center group" data-aos="fade-up">
                    <div>
                        <p class="text-indigo-400 font-bold mb-2">GET /api/tasks/report</p>
                        <p class="text-slate-400 text-sm">Daily task report by priority and status.</p>
                    </div>
                    <button onclick="copyRaw('/api/tasks/report')" class="text-slate-500 hover:text-white copy-btn opacity-0 group-hover:opacity-100 transition-opacity"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path></svg></button>
                </div>
            </div>
        </section>

        <section id="test-suite" class="mb-24">
            <h2 class="text-3xl font-bold text-white mb-6" data-aos="fade-right">Postman Test Cases</h2>
            <div class="space-y-6">

                <div class="glass-card p-6 rounded-2xl" data-aos="fade-up">
                    <h3 class="text-indigo-400 font-bold mb-3 uppercase text-sm">TC 01-04: Task Creation & Validation</h3>
                    <pre class="mono text-slate-300 text-sm overflow-x-auto">
TC 01: Valid Creation
POST /api/tasks
<span class="j-key">{</span>
    <span class="j-attr">"title"</span>: <span class="j-str">"Finish assignment"</span>,
    <span class="j-attr">"due_date"</span>: <span class="j-str">"2026-04-01"</span>,
    <span class="j-attr">"priority"</span>: <span class="j-str">"high"</span>
<span class="j-key">}</span>

TC 02: Duplicate Task
POST /api/tasks
<span class="j-key">{</span>
    <span class="j-attr">"title"</span>: <span class="j-str">"Finish assignment"</span>,
    <span class="j-attr">"due_date"</span>: <span class="j-str">"2026-04-01"</span>,
    <span class="j-attr">"priority"</span>: <span class="j-str">"medium"</span>
<span class="j-key">}</span>
Expected:
<span class="j-key">{</span> <span class="j-attr">"error"</span>: <span class="j-str">"Duplicate task"</span> <span class="j-key">}</span>

TC 03: Invalid Priority
POST /api/tasks
<span class="j-key">{</span>
    <span class="j-attr">"title"</span>: <span class="j-str">"Task name"</span>,
    <span class="j-attr">"due_date"</span>: <span class="j-str">"2026-04-01"</span>,
    <span class="j-attr">"priority"</span>: <span class="j-str">"urgent"</span>
<span class="j-key">}</span>
Expected:
<span class="j-key">{</span> <span class="j-attr">"error"</span>: <span class="j-str">"Invalid priority"</span> <span class="j-key">}</span>

TC 04: Past Date
POST /api/tasks
<span class="j-key">{</span>
    <span class="j-attr">"title"</span>: <span class="j-str">"Old Task"</span>,
    <span class="j-attr">"due_date"</span>: <span class="j-str">"2020-01-01"</span>,
    <span class="j-attr">"priority"</span>: <span class="j-str">"low"</span>
<span class="j-key">}</span>
Expected:
<span class="j-key">{</span> <span class="j-attr">"error"</span>: <span class="j-str">"Due date must be today or later"</span> <span class="j-key">}</span>
                    </pre>
                </div>

                <div class="glass-card p-6 rounded-2xl" data-aos="fade-up">
                    <h3 class="text-emerald-400 font-bold mb-3 uppercase text-sm">TC 05-07: List Tasks</h3>
                    <pre class="mono text-slate-300 text-sm overflow-x-auto">
TC 05: GET /api/tasks → returns all tasks
TC 06: GET /api/tasks?status=pending → returns pending tasks
TC 07: GET /api/tasks?status=completed → returns
<span class="j-key">{</span>
    <span class="j-attr">"message"</span>: <span class="j-str">"No tasks found"</span>
<span class="j-key">}</span>
                    </pre>
                </div>

                <div class="glass-card p-6 rounded-2xl" data-aos="fade-up">
                    <h3 class="text-amber-400 font-bold mb-3 uppercase text-sm">TC 08-10: Update Status</h3>
                    <pre class="mono text-slate-300 text-sm overflow-x-auto">
TC 08: Valid Transition
PATCH /api/tasks/1/status
<span class="j-key">{</span> <span class="j-attr">"status"</span>: <span class="j-str">"in_progress"</span> <span class="j-key">}</span>
✓ Success

TC 09: Skip Status
PATCH /api/tasks/1/status
<span class="j-key">{</span> <span class="j-attr">"status"</span>: <span class="j-str">"done"</span> <span class="j-key">}</span>
Expected:
<span class="j-key">{</span> <span class="j-attr">"error"</span>: <span class="j-str">"Cannot skip status progression"</span> <span class="j-key">}</span>

TC 10: Revert Status
PATCH /api/tasks/1/status
<span class="j-key">{</span> <span class="j-attr">"status"</span>: <span class="j-str">"pending"</span> <span class="j-key">}</span>
Expected:
<span class="j-key">{</span> <span class="j-attr">"error"</span>: <span class="j-str">"Cannot revert status"</span> <span class="j-key">}</span>
                    </pre>
                </div>

                <div class="glass-card p-6 rounded-2xl" data-aos="fade-up">
                    <h3 class="text-rose-400 font-bold mb-3 uppercase text-sm">TC 11-12: Delete Tasks</h3>
                    <pre class="mono text-slate-300 text-sm overflow-x-auto">
TC 11: Delete Non-Done
DELETE /api/tasks/1
Expected:
<span class="j-key">{</span> <span class="j-attr">"error"</span>: <span class="j-str">"Only done tasks can be deleted"</span> <span class="j-key">}</span>

TC 12: Delete Done
DELETE /api/tasks/2
Expected:
<span class="j-key">{</span> <span class="j-attr">"message"</span>: <span class="j-str">"Task deleted successfully"</span> <span class="j-key">}</span>
                    </pre>
                </div>

                <div class="glass-card p-6 rounded-2xl" data-aos="fade-up">
                    <h3 class="text-indigo-400 font-bold mb-3 uppercase text-sm">TC 13-14: Daily Report</h3>
                    <pre class="mono text-slate-300 text-sm overflow-x-auto">
TC 13: Valid Report
GET /api/tasks/report?date=2026-04-01
Expected:
<span class="j-key">{</span>
    <span class="j-attr">"date"</span>: <span class="j-str">"2026-04-01"</span>,
    <span class="j-attr">"summary"</span>: {
        <span class="j-attr">"high"</span>: { <span class="j-attr">"pending"</span>: <span class="j-num">0</span>, <span class="j-attr">"in_progress"</span>: <span class="j-num">0</span>, <span class="j-attr">"done"</span>: <span class="j-num">0</span> },
        <span class="j-attr">"low"</span>: { <span class="j-attr">"pending"</span>: <span class="j-num">0</span>, <span class="j-attr">"in_progress"</span>: <span class="j-num">0</span>, <span class="j-attr">"done"</span>: <span class="j-num">1</span> }
    }
<span class="j-key">}</span>

TC 14: Missing Date
GET /api/tasks/report
Expected:
<span class="j-key">{</span> <span class="j-attr">"error"</span>: <span class="j-str">"Date is required"</span> <span class="j-key">}</span>
                    </pre>
                </div>
            </div>
        </section>

        <section id="rules" class="mb-24">
            <h2 class="text-3xl font-bold text-white mb-6" data-aos="fade-right">Business Rules</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="glass-card p-6 rounded-2xl" data-aos="fade-up">
                    <h3 class="text-indigo-400 font-bold mb-2">Task Creation</h3>
                    <ul class="text-slate-400 text-sm list-disc pl-5 space-y-1">
                        <li>Title must be unique per due_date</li>
                        <li>Priority: low, medium, high</li>
                        <li>Due date must be today or future</li>
                    </ul>
                </div>
                <div class="glass-card p-6 rounded-2xl" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-emerald-400 font-bold mb-2">List Tasks</h3>
                    <ul class="text-slate-400 text-sm list-disc pl-5 space-y-1">
                        <li>Sorted by priority (high → low)</li>
                        <li>Then by due_date ascending</li>
                        <li>Optional status filter</li>
                    </ul>
                </div>
                <div class="glass-card p-6 rounded-2xl" data-aos="fade-up">
                    <h3 class="text-amber-400 font-bold mb-2">Update Status</h3>
                    <ul class="text-slate-400 text-sm list-disc pl-5 space-y-1">
                        <li>Allowed progression: pending → in_progress → done</li>
                        <li>Cannot skip or revert status</li>
                    </ul>
                </div>
                <div class="glass-card p-6 rounded-2xl" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="text-rose-400 font-bold mb-2">Delete Task</h3>
                    <ul class="text-slate-400 text-sm list-disc pl-5 space-y-1">
                        <li>Only tasks with status "done" can be deleted</li>
                    </ul>
                </div>
            </div>
        </section>

        <footer class="pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6 pb-8">
            <div class="text-center md:text-left" data-aos="fade-right">
                <h3 class="text-lg font-bold text-white">Mbio Peter</h3>
                <p class="text-indigo-400 text-xs font-medium uppercase tracking-widest">Laravel Engineer Intern</p>
            </div>
            <div class="flex items-center gap-8 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]" data-aos="fade-left">
                <span>March 2026</span>
                <span class="px-2 py-1 bg-white/5 rounded border border-white/10">v1.0.0 Production</span>
            </div>
        </footer>

    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true, offset: 50 });

        function copyRaw(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Endpoint copied to clipboard');
            });
        }
    </script>
</body>
</html>