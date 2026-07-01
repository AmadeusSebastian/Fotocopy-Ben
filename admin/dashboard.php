<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Fotocopy Ben</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-black text-gray-900 dark:text-gray-200" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-gray-900/80 backdrop-blur-sm md:hidden" @click="sidebarOpen = false" style="display: none;"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-transform duration-300 md:translate-x-0 flex flex-col shadow-xl md:shadow-none">
        
        <!-- Logo Area -->
        <div class="flex items-center justify-between md:justify-center h-16 px-4 border-b border-gray-200 dark:border-gray-700">
            <a href="dashboard.php" class="text-gray-900 dark:text-gray-100 font-black text-xl tracking-widest uppercase flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Fotocopy
            </a>
            <button @click="sidebarOpen = false" class="md:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all bg-gray-900 dark:bg-gray-200 text-white dark:text-gray-900 shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="manage_admin.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Admins
            </a>
        </nav>

        <!-- User Profile (Bottom of Sidebar) -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-800 dark:text-gray-200 font-bold border border-gray-300 dark:border-gray-600">
                    <?php echo isset($_SESSION['admin_name']) ? strtoupper(substr($_SESSION['admin_name'], 0, 1)) : 'A'; ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-900 dark:text-white truncate"><?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Administrator'); ?></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate"><?php echo htmlspecialchars($_SESSION['admin_email'] ?? 'admin@fotocopyben'); ?></p>
                </div>
            </div>
            <a href="logout.php" class="mt-4 w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-bold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors rounded-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Log Out
            </a>
        </div>
    </aside>

    <!-- Top Header -->
    <header class="fixed top-0 left-0 md:left-64 right-0 h-16 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 z-30 flex items-center justify-between px-4 sm:px-6 transition-all duration-300">
        <!-- Hamburger (Mobile) -->
        <div class="flex items-center">
            <button @click="sidebarOpen = true" class="md:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h1 class="text-lg font-bold text-gray-900 dark:text-white hidden sm:block">Dashboard Overview</h1>
        </div>

        <!-- Right Side: Clock & Theme Toggle -->
        <div class="flex items-center gap-4">
            <!-- WITA Clock -->
            <div x-data="adminClock()" class="text-xs sm:text-sm font-mono font-bold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-700 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span x-text="time"></span> <span class="hidden sm:inline">WITA</span>
            </div>

            <!-- Theme Toggle -->
            <button @click="darkMode = !darkMode" class="p-2 rounded-full text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors focus:outline-none">
                <!-- Sun icon -->
                <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <!-- Moon icon -->
                <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
            </button>
        </div>
    </header>

    <main class="pt-16 md:ml-64 min-h-screen transition-all duration-300">
        <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">Queue Management</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Real-time overview of orders and payments.</p>
            </div>

            <!-- Kanban Board Flex Container -->
            <div class="flex flex-col lg:flex-row gap-6 items-stretch">
                
                <!-- Column 1: Pending Payments -->
                <div class="flex flex-col flex-1 bg-gray-100 dark:bg-gray-800/50 rounded-2xl p-4 border border-gray-200 dark:border-gray-700/50 shadow-inner h-[80vh]">
                    <div class="flex items-center justify-between mb-4 px-2">
                        <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-gray-400"></span>
                            Pending Payments
                        </h2>
                        <span id="count-pending" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-1 px-2.5 rounded-full text-xs font-bold">0</span>
                    </div>
                    
                    <div id="col-pending" class="flex-1 space-y-4 overflow-y-auto pr-2 custom-scrollbar"></div>
                </div>

                <!-- Column 2: Active Queue (Waiting & Processing) -->
                <div class="flex flex-col flex-1 bg-gray-100 dark:bg-gray-800/50 rounded-2xl p-4 border border-gray-200 dark:border-gray-700/50 shadow-inner h-[80vh]">
                    <div class="flex items-center justify-between mb-4 px-2">
                        <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                            Active Queue
                        </h2>
                        <span id="count-active" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-1 px-2.5 rounded-full text-xs font-bold">0</span>
                    </div>
                    
                    <div id="col-active" class="flex-1 space-y-4 overflow-y-auto pr-2 custom-scrollbar"></div>
                </div>

                <!-- Column 3: Completed -->
                <div class="flex flex-col flex-1 bg-gray-100 dark:bg-gray-800/50 rounded-2xl p-4 border border-gray-200 dark:border-gray-700/50 shadow-inner h-[80vh] opacity-80 hover:opacity-100 transition-opacity">
                    <div class="flex items-center justify-between mb-4 px-2">
                        <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-green-500"></span>
                            Completed
                        </h2>
                        <span id="count-completed" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-1 px-2.5 rounded-full text-xs font-bold">0</span>
                    </div>
                    
                    <div id="col-completed" class="flex-1 space-y-3 overflow-y-auto pr-2 custom-scrollbar"></div>
                </div>

            </div>
        </div>
    </main>

    <style>
        /* Custom Scrollbar for Kanban columns */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #475569; }
    </style>

    <script>
        function adminClock() {
            return {
                time: '00:00:00',
                init() {
                    this.updateTime();
                    setInterval(() => this.updateTime(), 1000);
                },
                updateTime() {
                    this.time = new Date().toLocaleTimeString('en-US', {
                        timeZone: 'Asia/Makassar',
                        hour12: false,
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    });
                }
            }
        }

        // Helper to format currency
        function fmt(n) { return new Intl.NumberFormat('id-ID').format(n || 0); }
        
        // State for Accordion Toggles
        if (!window.openStates) window.openStates = {};
        
        // Helper to format diffForHumans (simple)
        function timeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffInSeconds = Math.floor((now - date) / 1000);
            
            if (diffInSeconds < 60) return 'Just now';
            if (diffInSeconds < 3600) return Math.floor(diffInSeconds / 60) + ' minutes ago';
            if (diffInSeconds < 86400) return Math.floor(diffInSeconds / 3600) + ' hours ago';
            return Math.floor(diffInSeconds / 86400) + ' days ago';
        }

        function buildCard(order) {
            const status = order.queue_status.toLowerCase();
            const payStatus = order.payment_status.toLowerCase();
            const payMethod = order.payment_method ? order.payment_method.toUpperCase() : 'CASH';

            if (payStatus === 'pending') {
                return `
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-700 relative transition-all group">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gray-300 dark:bg-gray-700 rounded-l-xl"></div>
                    <div class="flex justify-between items-start pl-2">
                        <div>
                            <span class="text-[10px] font-bold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded uppercase tracking-wider">${payMethod} Payment</span>
                            <h3 class="text-xl font-black text-gray-900 dark:text-white mt-2">${order.queue_number}</h3>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mt-1">${order.user_name}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-900 dark:text-white">Rp ${fmt(order.total_price)}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">${timeAgo(order.created_at)}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex gap-2 pl-2">
                        <button onclick="updateStatus(${order.id}, 'payment', 'paid')" class="flex-1 bg-gray-900 hover:bg-gray-800 dark:bg-white dark:hover:bg-gray-200 text-white dark:text-gray-900 py-2.5 rounded-lg text-sm font-bold transition-colors flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Confirm Paid & Process
                        </button>
                    </div>
                </div>`;
            } else if (status === 'waiting' || status === 'processing' || status === 'pending') {
                // Active queue card
                let actionBtn = '';
                if(status === 'waiting' || status === 'pending') {
                    actionBtn = `<button onclick="updateStatus(${order.id}, 'queue', 'processing')" class="flex-1 bg-gray-900 hover:bg-black dark:bg-gray-700 dark:hover:bg-gray-600 text-white py-2.5 rounded-lg text-sm font-bold transition-colors">Process Now</button>`;
                } else {
                    if (payMethod === 'CASH' && payStatus === 'pending') {
                        actionBtn = `<button onclick="updateStatus(${order.id}, 'payment', 'paid')" class="flex-1 bg-gray-900 hover:bg-black dark:bg-gray-700 dark:hover:bg-gray-600 text-white py-2.5 rounded-lg text-sm font-bold transition-colors">Collect Cash</button>
                                     <button onclick="updateStatus(${order.id}, 'queue', 'completed')" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-900 py-2.5 rounded-lg text-sm font-bold transition-colors border border-gray-300">Mark Done</button>`;
                    } else {
                        actionBtn = `<button onclick="updateStatus(${order.id}, 'queue', 'completed')" class="flex-1 bg-gray-900 hover:bg-black dark:bg-gray-700 dark:hover:bg-gray-600 text-white py-2.5 rounded-lg text-sm font-bold transition-colors">Mark Done</button>`;
                    }
                }

                const payBadge = (payStatus === 'paid') 
                    ? `<span class="text-[10px] font-bold px-2 py-1 rounded bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 uppercase tracking-wider">PAID</span>`
                    : `<span class="text-[10px] font-bold px-2 py-1 rounded bg-yellow-100 text-yellow-800 uppercase tracking-wider">UNPAID</span>`;

                return `
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-sm hover:shadow-md border border-gray-200 dark:border-gray-700 relative transition-all group">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gray-300 dark:bg-gray-700 rounded-l-xl"></div>
                    <div class="flex justify-between items-start pl-2">
                        <div>
                            <span class="text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">${status}</span>
                            <h3 class="text-xl font-black text-gray-900 dark:text-white mt-2">${order.queue_number}</h3>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mt-1">${order.user_name} • ${order.phone}</p>
                        </div>
                        <div class="text-right">
                            ${payBadge}
                        </div>
                    </div>
                    <div class="mt-4 flex gap-2 pl-2">
                        ${actionBtn}
                    </div>
                </div>`;
            } else {
                // Completed Card
                const d = new Date(order.updated_at || order.created_at);
                const orderDate = d.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' });
                
                const isHidden = window.openStates[order.id] ? '' : 'hidden';
                const isRotated = window.openStates[order.id] ? 'rotate-180' : '';

                return `
                <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group transition-all">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gray-300 dark:bg-gray-700 rounded-l-xl"></div>
                    <div class="flex justify-between items-center pl-2">
                        <div>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">${orderDate}</p>
                            <h3 class="text-lg font-black text-gray-800 dark:text-gray-200">${order.queue_number}</h3>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400">${order.user_name}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold px-2 py-1 rounded bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 uppercase tracking-wider">Ready</span>
                            <button type="button" data-id="${order.id}" class="detail-toggle p-1 rounded text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none transition-transform">
                                <svg id="chevron-${order.id}" class="w-5 h-5 transition-transform duration-200 ${isRotated} pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                        </div>
                    </div>
                    
                    <div id="detail-${order.id}" class="${isHidden} mt-3 pt-3 border-t border-gray-100 dark:border-gray-700 text-xs text-gray-600 dark:text-gray-400 pl-2">
                        <div class="grid grid-cols-2 gap-y-2 gap-x-4">
                            <div class="col-span-2">
                                <span class="block font-bold text-gray-400 dark:text-gray-500 uppercase text-[9px] tracking-wider">Print Type / Document</span>
                                <span class="font-medium text-gray-800 dark:text-gray-200">${order.print_type || '-'}</span>
                            </div>
                            <div>
                                <span class="block font-bold text-gray-400 dark:text-gray-500 uppercase text-[9px] tracking-wider">Copies</span>
                                <span class="font-medium text-gray-800 dark:text-gray-200">${order.copies || '-'}</span>
                            </div>
                            <div>
                                <span class="block font-bold text-gray-400 dark:text-gray-500 uppercase text-[9px] tracking-wider">Pages</span>
                                <span class="font-medium text-gray-800 dark:text-gray-200">${order.pages || '-'}</span>
                            </div>
                            <div class="col-span-2">
                                <span class="block font-bold text-gray-400 dark:text-gray-500 uppercase text-[9px] tracking-wider">Add-ons Summary</span>
                                <span class="font-medium text-gray-800 dark:text-gray-200">${order.add_ons_summary || '-'}</span>
                            </div>
                        </div>
                    </div>
                </div>`;
            }
        }

        function fetchQueue() {
            fetch('../api/get_queue.php')
                .then(res => res.json())
                .then(data => {
                    let htmlPending = '', htmlActive = '';
                    let cPending = 0, cActive = 0, cCompleted = 0;
                    let completedByDate = {};

                    data.forEach(order => {
                        const qStatus = order.queue_status.toLowerCase();
                        const pStatus = order.payment_status.toLowerCase();
                        const pMethod = order.payment_method ? order.payment_method.toLowerCase() : 'cash';

                        if (pStatus === 'pending' && (pMethod === 'qr' || pMethod === 'qris')) {
                            htmlPending += buildCard(order);
                            cPending++;
                        } else if (qStatus === 'done' || qStatus === 'completed') {
                            const d = new Date(order.updated_at || order.created_at);
                            let dateLabel = d.toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
                            const today = new Date();
                            const yesterday = new Date(today); yesterday.setDate(yesterday.getDate() - 1);
                            if(d.toDateString() === today.toDateString()) dateLabel = 'Hari ini';
                            else if(d.toDateString() === yesterday.toDateString()) dateLabel = 'Kemarin';

                            if(!completedByDate[dateLabel]) completedByDate[dateLabel] = '';
                            completedByDate[dateLabel] += buildCard(order);
                            cCompleted++;
                        } else {
                            htmlActive += buildCard(order);
                            cActive++;
                        }
                    });

                    let htmlCompleted = '';
                    for(const [label, html] of Object.entries(completedByDate)) {
                        htmlCompleted += `<h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-6 mb-2 first:mt-0">${label}</h4>${html}`;
                    }

                    document.getElementById('col-pending').innerHTML = htmlPending || '<div class="text-center py-10 opacity-60 text-sm text-gray-500 font-medium">No pending payments.</div>';
                    document.getElementById('col-active').innerHTML = htmlActive || '<div class="text-center py-10 opacity-60 text-sm text-gray-500 font-medium">No active orders.</div>';
                    document.getElementById('col-completed').innerHTML = htmlCompleted || '<div class="text-center py-10 opacity-60 text-sm text-gray-500 font-medium">No completed orders yet.</div>';

                    document.getElementById('count-pending').textContent = cPending;
                    document.getElementById('count-active').textContent = cActive;
                    document.getElementById('count-completed').textContent = cCompleted;
                });
        }

        function updateStatus(id, type, status) {
            const fd = new FormData();
            fd.append('id', id);
            fd.append('type', type);
            fd.append('status', status);

            fetch('../api/update_status.php', { method: 'POST', body: fd })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // If payment is paid, we usually want to move the queue to 'waiting' right away in native UI
                        if(type === 'payment' && status === 'paid') {
                            const fd2 = new FormData();
                            fd2.append('id', id);
                            fd2.append('type', 'queue');
                            fd2.append('status', 'waiting');
                            fetch('../api/update_status.php', { method: 'POST', body: fd2 })
                                .then(() => fetchQueue());
                        } else {
                            fetchQueue();
                        }
                    } else {
                        alert('Error updating: ' + data.message);
                    }
                });
        }

        fetchQueue();
        setInterval(fetchQueue, 3000);

        // Event Delegation for Accordion Toggles
        document.addEventListener('click', function(e) {
            if (e.target.closest('.detail-toggle')) {
                const toggleBtn = e.target.closest('.detail-toggle');
                const id = toggleBtn.getAttribute('data-id');
                const detailDiv = document.getElementById('detail-' + id);
                if (detailDiv) {
                    detailDiv.classList.toggle('hidden');
                    const chevron = document.getElementById('chevron-' + id);
                    if (chevron) chevron.classList.toggle('rotate-180');
                    
                    if (!window.openStates) window.openStates = {};
                    window.openStates[id] = !detailDiv.classList.contains('hidden');
                }
            }
        });
    </script>
</body>
</html>
