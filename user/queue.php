<?php
require_once '../config/koneksi.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Order ID is required.");
}
$order_id = $conn->real_escape_string($_GET['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Ticket - Fotocopy Ben</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #f9fafb; } /* Light gray/cream fallback */
    </style>
</head>
<body class="font-sans antialiased flex flex-col justify-center items-center min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-4xl" id="ticket-container">
        <!-- Ticket content will be rendered here by JS -->
    </div>

    <script>
        const orderId = '<?php echo htmlspecialchars($order_id); ?>';

        function fetchStatus() {
            fetch(`../api/check_status.php?id=${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        document.getElementById('ticket-container').innerHTML = `<div class="text-center text-red-500 font-bold">${data.error}</div>`;
                        return;
                    }

                    // Format numbers
                    const formattedPrice = new Intl.NumberFormat('id-ID').format(data.total_price || 0);
                    
                    // Render UI
                    let statusBadge = '';
                    let etaDisplay = '';
                    let paymentBlock = '';
                    let actionButton = '';

                    const status = data.queue_status.toLowerCase();
                    const payStatus = data.payment_status.toLowerCase();
                    const payMethod = data.payment_method ? data.payment_method.toUpperCase() : 'CASH';

                    // Determine Status Badge
                    if (status === 'waiting' && payStatus === 'pending') {
                        statusBadge = `<span class="w-3 h-3 rounded-full bg-gray-400 animate-pulse shadow-[0_0_8px_rgba(156,163,175,0.8)]"></span>
                                       <span class="font-bold text-white tracking-wide">AWAITING PAYMENT</span>`;
                    } else if (status === 'waiting') {
                        statusBadge = `<span class="w-3 h-3 rounded-full bg-yellow-400 animate-pulse shadow-[0_0_8px_rgba(250,204,21,0.8)]"></span>
                                       <span class="font-bold text-white tracking-wide">WAITING</span>`;
                    } else if (status === 'processing') {
                        statusBadge = `<span class="w-3 h-3 rounded-full bg-gray-300 animate-pulse shadow-[0_0_8px_rgba(209,213,219,0.8)]"></span>
                                       <span class="font-bold text-white tracking-wide">PROCESSING</span>`;
                    } else if (status === 'completed' || status === 'done') {
                        statusBadge = `<span class="w-3 h-3 rounded-full bg-green-400 shadow-[0_0_8px_rgba(74,222,128,0.8)]"></span>
                                       <span class="font-bold text-white tracking-wide">READY</span>`;
                    } else {
                        statusBadge = `<span class="w-3 h-3 rounded-full bg-red-400 shadow-[0_0_8px_rgba(248,113,113,0.8)]"></span>
                                       <span class="font-bold text-white tracking-wide">CANCELLED</span>`;
                    }

                    // ETA Display
                    if(['done', 'completed'].includes(status)) {
                        etaDisplay = `<p class="text-2xl font-bold text-green-500 uppercase tracking-widest">Done</p>`;
                    } else if (status === 'waiting') {
                        etaDisplay = `
                            <p class="text-2xl font-bold mb-1">--:--</p>
                            <p class="text-[10px] font-bold text-yellow-600 uppercase tracking-widest">Menunggu konfirmasi admin...</p>
                        `;
                    } else if (status === 'processing' && data.processing_start_time) {
                        etaDisplay = `<p class="text-4xl font-black flex items-baseline gap-1 animate-pulse" id="wait-time">--:--</p>`;
                    } else {
                        etaDisplay = `<p class="text-2xl font-bold">--:--</p>`;
                    }

                    // Payment/Action Block
                    if(payStatus === 'pending') {
                        if(payMethod === 'QR' || payMethod === 'QRIS' || payMethod === 'qr') {
                            paymentBlock = `
                                <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-xl flex flex-col items-center">
                                    <p class="text-sm font-bold text-gray-700 mb-3">Scan to Pay via QRIS</p>
                                    <img src="../images/qris-static.jpg" alt="QRIS" class="w-48 h-48 mx-auto rounded-lg mb-2 border border-gray-200">
                                    <a href="../images/qris-static.jpg" download="QRIS-Fotocopy-Ben.jpg" class="inline-flex items-center justify-center gap-2 bg-gray-900 hover:bg-black dark:bg-gray-200 dark:hover:bg-white text-white dark:text-gray-900 text-sm font-bold py-2 px-4 rounded-lg transition-colors mt-1 w-48 mx-auto">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Download QR
                                    </a>
                                    <div class="mt-5 p-4 bg-gray-100 border border-gray-200 text-gray-800 rounded-xl text-center w-full shadow-inner">
                                        <p class="text-xs font-black uppercase tracking-widest text-gray-900 opacity-80 mb-1">PENTING</p>
                                        <p class="text-sm font-medium">Menunggu Pembayaran. Silakan scan QRIS di atas dan masukkan nominal <span class="font-extrabold text-lg block mt-1">Rp ${formattedPrice}</span> admin akan mengonfirmasi sesaat lagi.</p>
                                    </div>
                                </div>`;
                        } else if (payMethod === 'cash' || payMethod === 'CASH') {
                            paymentBlock = `
                                <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-xl">
                                    <div class="flex gap-3">
                                        <svg class="w-6 h-6 text-gray-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-800">Menunggu Pembayaran</h4>
                                            <p class="text-xs text-gray-700 mt-1 font-medium leading-relaxed">Pesanan Sedang Diproses. Silakan menuju kasir untuk melakukan pembayaran dan mengambil dokumen Anda.</p>
                                        </div>
                                    </div>
                                </div>`;
                        }
                    }

                    if(status === 'done' || status === 'completed') {
                        actionButton = `<p class="text-green-600 font-bold text-center w-full py-2 bg-green-50 rounded-lg border border-green-200">Your order is ready! Please proceed to the counter.</p>`;
                    } else {
                        actionButton = `<a href="../user/index.php" class="text-gray-900 hover:text-black font-bold text-sm transition-colors text-center w-full py-2 block">&larr; Back to Home</a>`;
                    }

                    const html = `
                        <div class="bg-white overflow-hidden flex flex-col md:flex-row min-h-[400px] rounded-2xl shadow-xl border border-gray-200">
                            <!-- Left Side -->
                            <div class="bg-black text-white p-8 md:w-2/5 flex flex-col justify-between relative">
                                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white opacity-5"></div>
                                <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-32 h-32 rounded-full bg-gray-500 opacity-10"></div>
                                
                                <div class="relative z-10">
                                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">Queue Ticket</p>
                                    <h2 class="text-5xl font-black tracking-tighter">${data.queue_number || orderId}</h2>
                                </div>
                                
                                <div class="relative z-10 mt-8">
                                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">Status</p>
                                    <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-lg border border-white/20">
                                        ${statusBadge}
                                    </div>
                                </div>

                                <div class="relative z-10 mt-8">
                                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">Est. Wait Time</p>
                                    ${etaDisplay}
                                </div>
                            </div>

                            <!-- Right Side -->
                            <div class="p-8 md:w-3/5 flex flex-col justify-between border-t md:border-t-0 md:border-l border-dashed border-gray-300 relative">
                                <!-- Cutout circles for realism -->
                                <div class="hidden md:block absolute -left-3 top-[-10px] w-6 h-6 rounded-full bg-gray-50 border-b border-gray-200"></div>
                                <div class="hidden md:block absolute -left-3 bottom-[-10px] w-6 h-6 rounded-full bg-gray-50 border-t border-gray-200"></div>

                                <div>
                                    <div class="flex justify-between items-start mb-6 pb-6 border-b border-gray-100">
                                        <div>
                                            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">Passenger / Customer</p>
                                            <h3 class="text-xl font-bold text-gray-900">${data.user_name || 'Guest'}</h3>
                                            <p class="text-sm text-gray-500">${data.phone || ''}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">Payment</p>
                                            <span class="inline-block px-3 py-1 rounded text-xs font-bold ${payStatus === 'paid' ? 'bg-green-100 text-green-700 border-green-200' : 'bg-yellow-100 text-yellow-700 border-yellow-200'} uppercase border">
                                                ${payMethod} • ${payStatus}
                                            </span>
                                        </div>
                                    </div>

                                    ${paymentBlock}
                                </div>

                                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-end">
                                    <div>
                                        <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">Total</p>
                                        <p class="text-2xl font-black text-gray-900">Rp ${formattedPrice}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-center rounded-b-2xl -mt-2 relative z-0">
                            ${actionButton}
                        </div>
                    `;

                    document.getElementById('ticket-container').innerHTML = html;

                    if (status === 'processing' && data.processing_start_time) {
                        console.log("Order Data:", data);
                        console.log("Processing Start:", data.processing_start_time);
                        
                        if (window.countdownInterval) clearInterval(window.countdownInterval);
                        
                        const startTime = new Date(data.processing_start_time.replace(' ', 'T')).getTime();
                        const estMinutes = parseInt(data.estimated_minutes) || 15;
                        const endTime = startTime + (estMinutes * 60000);
                        
                        const updateTimer = () => {
                            const waitTimeEl = document.getElementById('wait-time');
                            if (!waitTimeEl) return;
                            
                            const now = new Date().getTime();
                            const distance = endTime - now;
                            
                            if (distance < 0) {
                                waitTimeEl.innerHTML = `<span class="text-sm font-bold text-red-500 bg-red-50 p-3 rounded-lg border border-red-200">Your order is slightly delayed due to high queue volume. We apologize for the inconvenience.</span>`;
                                waitTimeEl.classList.remove('text-4xl', 'font-black');
                            } else {
                                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                waitTimeEl.innerText = String(minutes).padStart(2, '0') + ":" + String(seconds).padStart(2, '0');
                            }
                        };
                        updateTimer();
                        window.countdownInterval = setInterval(updateTimer, 1000);
                    }
                })
                .catch(err => console.error('Error fetching status:', err));
        }

        fetchStatus();
        setInterval(fetchStatus, 3000);
    </script>
</body>
</html>
