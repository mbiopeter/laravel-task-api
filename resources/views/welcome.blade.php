<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskManage API | Documentation</title>
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
            height: 100%;
        }
        .glass-card:hover { transform: translateY(-4px); border-color: rgba(99, 102, 241, 0.3); }
        
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
<body class="bg-[#0b0f1a] text-slate-300 selection:bg-indigo-500/30 bg-mesh min-h-screen overflow-x-hidden">

    <nav class="sticky top-0 z-50 border-b border-white/5 bg-[#0b0f1a]/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-linear-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <span class="text-white font-bold text-lg tracking-tight">Task<span class="text-indigo-400">Manager</span> API</span>
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
                <span class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-xs font-mono">Laravel 13.0</span>
                <span class="px-4 py-2 rounded-full bg-white/5 border border-white/10 text-xs font-mono">MySQL 8.5</span>
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
                <div class="glass-card p-6 rounded-2xl flex justify-between items-start group" data-aos="fade-up">
                    <div>
                        <p class="text-indigo-400 font-bold mb-2">POST /api/tasks</p>
                        <p class="text-slate-400 text-sm">Create a new task.</p>
                        <p class="text-indigo-400 text-sm">Payload:</p>
<pre>
<span class="j-key">{</span>
    <span class="j-attr">"title"</span>: <span class="j-str">"Attend Training"</span>,
    <span class="j-attr">"due_date"</span>: <span class="j-str">"2026-04-02"</span>,
    <span class="j-attr">"priority"</span>: <span class="j-str">"high"</span>
<span class="j-key">}</span>
</pre>
                    </div>
                </div>
                <div class="glass-card p-6 rounded-2xl flex justify-between items-start group" data-aos="fade-up" data-aos-delay="100">
                    <div>
                        <p class="text-indigo-400 font-bold mb-2">GET /api/tasks</p>
                        <p class="text-slate-400 text-sm">List all tasks .</p>
                    </div>
                </div>
                <div class="glass-card p-6 rounded-2xl flex justify-between items-center group" data-aos="fade-up" data-aos-delay="100">
                    <div>
                        <p class="text-indigo-400 font-bold mb-2">GET /api/tasks?status={status_value}</p>
                        <p class="text-slate-400 text-sm">List all tasks filtering by status.</p>
                    </div>
                </div>
                <div class="glass-card p-6 rounded-2xl flex justify-between items-center group" data-aos="fade-up">
                    <div>
                        <p class="text-indigo-400 font-bold mb-2">PATCH /api/tasks/{id}/status</p>
                        <p class="text-slate-400 text-sm">Update task status progression.</p>
                        <p class="text-indigo-400 text-sm">Payload:</p>
<pre>
<span class="j-key">{</span>
    <span class="j-attr">"status"</span>: <span class="j-str">"done"</span>
<span class="j-key">}</span>
</pre>
                    </div>
                </div>
                <div class="glass-card p-6 rounded-2xl flex justify-between items-center group" data-aos="fade-up" data-aos-delay="100">
                    <div>
                        <p class="text-indigo-400 font-bold mb-2">DELETE /api/tasks/{id}</p>
                        <p class="text-slate-400 text-sm">Delete task (done only).</p>
                    </div>
                </div>
                <div class="glass-card p-6 rounded-2xl flex justify-between items-center group" data-aos="fade-up" data-aos-delay="100">
                    <div>
                        <p class="text-indigo-400 font-bold mb-2">GET /api/tasks/report?date=${todays_date:YYYY-MM-DD}</p>
                        <p class="text-slate-400 text-sm">Get todays report.</p>
                    </div>
                </div>
            </div>
        </section>


        <section id="endpoints" class="mb-24">
            <h2 class="text-3xl font-bold text-white mb-6" data-aos="fade-right">HTTP REQUEST</h2>
            <div class="grid md:grid-cols-1 gap-6">
                <div class="glass-card p-6 rounded-2xl flex justify-between items-start group" data-aos="fade-up">
                    <div>
                        <p class="text-indigo-400 font-bold mb-2">Headers</p>
                        <p class="text-slate-400 text-sm">Accept: application/json</p>
                        <p class="text-slate-400 text-sm">Content-Type: application/json</p>

                    </div>
                </div>

            </div>
        </section>

        <section id="test-suite" class="mb-24">
            <h2 class="text-3xl font-bold text-white mb-10" data-aos="fade-right">Postman Test Suite</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <div class="glass-card p-6 rounded-2xl overflow-x-auto" data-aos="fade-up">
                    <div class="flex justify-between mb-4"><span class="text-indigo-400 font-bold text-[10px]">TC 01</span><span class="text-emerald-400 font-bold text-[10px]">201 CREATED</span></div>
                    <h4 class="text-white font-bold text-xs uppercase mb-2">Valid Creation</h4>
                    <pre class="mono text-[11px] leading-relaxed">
<span class="j-key">{</span>
    <span class="j-attr">"message"</span>: <span class="j-str">"Task created successfully"</span>,
    <span class="j-attr">"data"</span>: <span class="j-key">{</span>
        <span class="j-attr">"id"</span>: <span class="j-str">1</span>,
        <span class="j-attr">"title"</span>: <span class="j-str">"Attend Training"</span>,
        <span class="j-attr">"due_date"</span>: <span class="j-str">"2026-04-02"</span>
        <span class="j-attr">"priority"</span>: <span class="j-str">"high"</span>
        <span class="j-attr">"updated_at"</span>: <span class="j-str">"2026-03-30T12:02:46.000000Z"</span>
        <span class="j-attr">"created_at"</span>: <span class="j-str">"2026-03-30T12:02:46.000000Z"</span>
    <span class="j-key">}</span>
<span class="j-key">}</span></pre>
                </div>

                <div class="glass-card p-6 rounded-2xl overflow-x-auto" data-aos="fade-up">
                    <div class="flex justify-between mb-4"><span class="text-indigo-400 font-bold text-[10px]">TC 02</span><span class="text-rose-400 font-bold text-[10px]">422 ERROR</span></div>
                    <h4 class="text-white font-bold text-xs uppercase mb-2">Duplicate Task</h4>
                    <pre class="mono text-[11px] leading-relaxed">
<span class="j-key">{</span>
    <span class="j-attr">"error"</span>: <span class="j-str test-wrap">"A task with the same title and due date already exists."</span>
<span class="j-key">}</span></pre>
                </div>

                <div class="glass-card p-6 rounded-2xl overflow-x-auto" data-aos="fade-up">
                    <div class="flex justify-between mb-4"><span class="text-indigo-400 font-bold text-[10px]">TC 03</span><span class="text-rose-400 font-bold text-[10px]">422 ERROR</span></div>
                    <h4 class="text-white font-bold text-xs uppercase mb-2">Invalid Priority</h4>
                    <pre class="mono text-[11px] leading-relaxed">
<span class="j-key">{</span>
    <span class="j-attr">"error"</span>: <span class="j-str">"The selected priority is invalid."</span>
<span class="j-key">}</span></pre>
                </div>

                <div class="glass-card p-6 rounded-2xl overflow-x-auto" data-aos="fade-up">
                    <div class="flex justify-between mb-4"><span class="text-indigo-400 font-bold text-[10px]">TC 04</span><span class="text-rose-400 font-bold text-[10px]">422 ERROR</span></div>
                    <h4 class="text-white font-bold text-xs uppercase mb-2">Past Due Date</h4>
                    <pre class="mono text-[11px] leading-relaxed">
<span class="j-key">{</span>
    <span class="j-attr">"error"</span>: <span class="j-str">"Due date must be today or later"</span>
<span class="j-key">}</span></pre>
                </div>

                <div class="glass-card p-6 rounded-2xl overflow-x-auto" data-aos="fade-up">
                    <div class="flex justify-between mb-4"><span class="text-indigo-400 font-bold text-[10px]">TC 05</span><span class="text-emerald-400 font-bold text-[10px]">200 OK</span></div>
                    <h4 class="text-white font-bold text-xs uppercase mb-2">List All Tasks</h4>
<pre><span class="j-key">{</span>
    <span class="j-attr">"data"</span>: <span class="j-key">[</span>
        <span class="j-key">{</span>
            <span class="j-attr">"id"</span>: 9,
            <span class="j-attr">"title"</span>: <span class="j-str">"Attend Training"</span>,
            <span class="j-attr">"due_date"</span>: <span class="j-str">"2026-04-02"</span>,
            <span class="j-attr">"priority"</span>: <span class="j-str">"high"</span>,
            <span class="j-attr">"status"</span>: <span class="j-str">"pending"</span>,
            <span class="j-attr">"created_at"</span>: <span class="j-str">"2026-03-30T12:02:46.000000Z"</span>,
            <span class="j-attr">"updated_at"</span>: <span class="j-str">"2026-03-30T12:02:46.000000Z"</span>
        <span class="j-key">}</span>
    <span class="j-key">]</span>
<span class="j-key">}</span></pre>
                </div>

                <div class="glass-card p-6 rounded-2xl overflow-x-auto" data-aos="fade-up">
                    <div class="flex justify-between mb-4"><span class="text-indigo-400 font-bold text-[10px]">TC 06</span><span class="text-emerald-400 font-bold text-[10px]">200 OK</span></div>
                    <h4 class="text-white font-bold text-xs uppercase mb-2">Filter Pending</h4>
<pre><span class="j-key">{</span>
    <span class="j-attr">"data"</span>: <span class="j-key">[</span>
        <span class="j-key">{</span>
            <span class="j-attr">"id"</span>: 9,
            <span class="j-attr">"title"</span>: <span class="j-str">"Attend Training"</span>,
            <span class="j-attr">"due_date"</span>: <span class="j-str">"2026-04-02"</span>,
            <span class="j-attr">"priority"</span>: <span class="j-str">"high"</span>,
            <span class="j-attr">"status"</span>: <span class="j-str">"pending"</span>,
            <span class="j-attr">"created_at"</span>: <span class="j-str">"2026-03-30T12:02:46.000000Z"</span>,
            <span class="j-attr">"updated_at"</span>: <span class="j-str">"2026-03-30T12:02:46.000000Z"</span>
        <span class="j-key">}</span>
    <span class="j-key">]</span>
<span class="j-key">}</span></pre>
                </div>


                <div class="glass-card p-6 rounded-2xl overflow-x-auto" data-aos="fade-up">
                    <div class="flex justify-between mb-4"><span class="text-indigo-400 font-bold text-[10px]">TC 07</span><span class="text-rose-400 font-bold text-[10px]">422 ERROR</span></div>
                    <h4 class="text-white font-bold text-xs uppercase mb-2">Inavalid Filter</h4>
<pre><span class="j-key">{</span>
    <span class="j-attr">"error"</span>: <span class="j-str">"Invalid Filter"</span>,
    <span class="j-attr">"valid_options"</span>: <span class="j-key">[</span>
        <span class="j-str">"pending"</span>,
        <span class="j-str">"in_progress"</span>,
        <span class="j-str">"completed"</span>
    <span class="j-key">]</span>
<span class="j-key">}</span></pre>
                </div>

                <div class="glass-card p-6 rounded-2xl overflow-x-auto" data-aos="fade-up">
                    <div class="flex justify-between mb-4"><span class="text-indigo-400 font-bold text-[10px]">TC 08</span><span class="text-emerald-400 font-bold text-[10px]">200 OK</span></div>
                    <h4 class="text-white font-bold text-xs uppercase mb-2">No Tasks Found</h4>
                    <pre class="mono text-[11px] leading-relaxed">
<span class="j-key">{</span>
    <span class="j-attr">"message"</span>: <span class="j-str">"No tasks found"</span>,
    <span class="j-attr">"data"</span>: <span class="j-key">[]</span>
<span class="j-key">}</span></pre>
                </div>

                <div class="glass-card p-6 rounded-2xl overflow-x-auto" data-aos="fade-up">
                    <div class="flex justify-between mb-4"><span class="text-indigo-400 font-bold text-[10px]">TC 09</span><span class="text-emerald-400 font-bold text-[10px]">200 OK</span></div>
                    <h4 class="text-white font-bold text-xs uppercase mb-2">Valid Status Update</h4>
<pre><span class="j-key">{</span>
    <span class="j-attr">"message"</span>: <span class="j-str">"Task status updated successfully"</span>,
    <span class="j-attr">"data"</span>: <span class="j-key">{</span>
        <span class="j-attr">"id"</span>: 11,
        <span class="j-attr">"title"</span>: <span class="j-str">"Tasking"</span>,
        <span class="j-attr">"due_date"</span>: <span class="j-str">"2026-04-01"</span>,
        <span class="j-attr">"priority"</span>: <span class="j-str">"high"</span>,
        <span class="j-attr">"status"</span>: <span class="j-str">"in_progress"</span>,
        <span class="j-attr">"created_at"</span>: <span class="j-str">"2026-03-30T13:29:21.000000Z"</span>,
        <span class="j-attr">"updated_at"</span>: <span class="j-str">"2026-03-30T13:56:55.000000Z"</span>
    <span class="j-key">}</span>
<span class="j-key">}</span></pre>
                </div>

                <div class="glass-card p-6 rounded-2xl overflow-x-auto" data-aos="fade-up">
                    <div class="flex justify-between mb-4"><span class="text-indigo-400 font-bold text-[10px]">TC 10</span><span class="text-rose-400 font-bold text-[10px]">422 ERROR</span></div>
                    <h4 class="text-white font-bold text-xs uppercase mb-2">Skip Progression</h4>
                    <pre class="mono text-[11px] leading-relaxed">
<span class="j-key">{</span>
    <span class="j-attr">"error"</span>: <span class="j-str">"Cannot skip status progression"</span>
<span class="j-key">}</span></pre>
                </div>

                <div class="glass-card p-6 rounded-2xl" data-aos="fade-up">
                    <div class="flex justify-between mb-4"><span class="text-indigo-400 font-bold text-[10px]">TC 11</span><span class="text-rose-400 font-bold text-[10px]">422 ERROR</span></div>
                    <h4 class="text-white font-bold text-xs uppercase mb-2">Revert Status</h4>
                    <pre class="mono text-[11px] leading-relaxed">
<span class="j-key">{</span>
    <span class="j-attr">"error"</span>: <span class="j-str">"Cannot revert status"</span>
<span class="j-key">}</span></pre>
                </div>

                <div class="glass-card p-6 rounded-2xl" data-aos="fade-up">
                    <div class="flex justify-between mb-4"><span class="text-indigo-400 font-bold text-[10px]">TC 12</span><span class="text-rose-400 font-bold text-[10px]">403 FORBIDDEN</span></div>
                    <h4 class="text-white font-bold text-xs uppercase mb-2">Delete Forbidden</h4>
                    <pre class="mono text-[11px] leading-relaxed">
<span class="j-key">{</span>
    <span class="j-attr">"error"</span>: <span class="j-str">"Only done tasks can be deleted"</span>
<span class="j-key">}</span></pre>
                </div>

                <div class="glass-card p-6 rounded-2xl" data-aos="fade-up">
                    <div class="flex justify-between mb-4"><span class="text-indigo-400 font-bold text-[10px]">TC 13</span><span class="text-emerald-400 font-bold text-[10px]">200 OK</span></div>
                    <h4 class="text-white font-bold text-xs uppercase mb-2">Delete Success</h4>
                    <pre class="mono text-[11px] leading-relaxed">
<span class="j-key">{</span>
    <span class="j-attr">"message"</span>: <span class="j-str">"Task deleted successfully"</span>
<span class="j-key">}</span></pre>
                </div>

                <div class="glass-card p-6 rounded-2xl" data-aos="fade-up">
                    <div class="flex justify-between mb-4"><span class="text-indigo-400 font-bold text-[10px]">TC 14</span><span class="text-emerald-400 font-bold text-[10px]">200 OK</span></div>
                    <h4 class="text-white font-bold text-xs uppercase mb-2">Valid Report</h4>
                    <pre class="mono text-[11px] leading-relaxed">
<span class="j-key">{</span>
    <span class="j-attr">"date"</span>: <span class="j-str">"2026-04-01"</span>,
    <span class="j-attr">"summary"</span>: <span class="j-key">{</span> <span class="j-attr">"high"</span>: <span class="j-key">{</span> <span class="j-attr">"done"</span>: <span class="j-num">3</span> <span class="j-key">}</span> <span class="j-key">}</span>
<span class="j-key">}</span></pre>
                </div>

                <div class="glass-card p-6 rounded-2xl" data-aos="fade-up">
                    <div class="flex justify-between mb-4"><span class="text-indigo-400 font-bold text-[10px]">TC 15</span><span class="text-rose-400 font-bold text-[10px]">422 ERROR</span></div>
                    <h4 class="text-white font-bold text-xs uppercase mb-2">Missing Date</h4>
                    <pre class="mono text-[11px] leading-relaxed">
<span class="j-key">{</span>
    <span class="j-attr">"error"</span>: <span class="j-str">"Date is required"</span>
<span class="j-key">}</span></pre>
                </div>

            </div>
        </section>

        <footer class="pt-6 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6 pb-4">
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
    <script>AOS.init({ duration: 800, once: true, offset: 50 });</script>
</body>
</html>