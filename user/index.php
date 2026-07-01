<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fotocopy Ben - Quick Service</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #f9fafb; }
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-stone-50 min-h-screen flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="sm:mx-auto sm:w-full sm:max-w-3xl mb-8 text-center">
        <h1 class="text-3xl font-black tracking-tight text-gray-900">FOTOCOPY BEN</h1>
        <p class="text-gray-500 font-medium mt-2">Professional Printing & Stationeries</p>
    </div>

    <div class="sm:mx-auto w-full sm:max-w-3xl">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-stone-200">
            
            <!-- Progress Bar -->
            <div class="bg-stone-50 border-b border-stone-200 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2" id="progress-indicator">
                    <div id="circ-1" class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors bg-gray-900 text-white shadow-sm">1</div>
                    <div id="line-1" class="h-1 w-6 sm:w-12 rounded-full transition-colors bg-gray-200"></div>
                    <div id="circ-2" class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors bg-gray-200 text-gray-500">2</div>
                    <div id="line-2" class="h-1 w-6 sm:w-12 rounded-full transition-colors bg-gray-200"></div>
                    <div id="circ-3" class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors bg-gray-200 text-gray-500">3</div>
                </div>
                <div class="text-sm font-semibold text-gray-500">
                    Step <span id="step-count">1</span> of 3
                </div>
            </div>

            <!-- Error Banner -->
            <div id="error-banner" class="hidden bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mx-6 mt-6 rounded-r-lg shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800" id="error-message">Error</h3>
                    </div>
                </div>
            </div>

            <form id="order-form">
                <!-- STEP 1: Customer Details -->
                <div id="step-1" class="p-6 sm:p-8 space-y-6 min-h-[300px] transition-opacity duration-300">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Customer Details</h2>
                    <p class="text-gray-500 text-sm mb-6">Please enter your information so we can notify you when it's ready.</p>
                    
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" id="user_name" class="block w-full rounded-xl border border-gray-300 shadow-sm focus:border-gray-900 focus:ring-gray-900 transition-colors py-3 px-4" placeholder="e.g. John Doe" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="phone" class="block w-full rounded-xl border border-gray-300 shadow-sm focus:border-gray-900 focus:ring-gray-900 transition-colors py-3 px-4" placeholder="08123456789" required>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                        <button type="button" onclick="goToStep(2)" class="px-6 py-3 rounded-xl bg-gray-900 hover:bg-black text-white font-bold shadow-md transition-all flex items-center justify-center gap-2 group w-full sm:w-auto">
                            Next Step
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- STEP 2: Print Configuration -->
                <div id="step-2" class="hidden p-6 sm:p-8 space-y-6 bg-stone-50 min-h-[300px] transition-opacity duration-300">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Print Configuration</h2>
                    <p class="text-gray-500 text-sm mb-6">Upload your file and specify how you want it printed.</p>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload File (PDF/Image only)</label>
                            <div class="flex flex-col items-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl bg-white relative transition-colors hover:border-gray-500">
                                <input type="file" id="file" name="file" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-900 hover:file:bg-gray-200 cursor-pointer" required>
                                <p class="text-xs text-gray-500 mt-2">Max file size: 10MB</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Service Type</label>
                                <select id="service_type" name="service_type" onchange="togglePaperOption()" class="block w-full rounded-xl border border-gray-300 shadow-sm focus:border-gray-900 focus:ring-gray-900 py-3 px-4 bg-white">
                                    <option value="document">Document Print (Rp 500/pg)</option>
                                    <option value="photo">Photo Print (Rp 2000/copy)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity (Pages/Copies)</label>
                                <input type="number" id="quantity" name="quantity" min="1" value="1" class="block w-full rounded-xl border border-gray-300 shadow-sm focus:border-gray-900 focus:ring-gray-900 py-3 px-4">
                            </div>
                        </div>

                        <div id="paper-option-container" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Paper Option</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm focus:outline-none transition-all bg-white border-gray-300 hover:border-gray-400 paper-label">
                                    <input type="radio" name="paper_option" value="glossy" class="sr-only" onchange="updatePaperSelection(this)">
                                    <span class="flex flex-1 flex-col">
                                        <span class="block text-sm font-bold text-gray-900">Glossy</span>
                                        <span class="mt-1 block text-xs text-gray-500">Shiny and vibrant.</span>
                                    </span>
                                </label>
                                <label class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm focus:outline-none transition-all bg-white border-gray-300 hover:border-gray-400 paper-label">
                                    <input type="radio" name="paper_option" value="matte" class="sr-only" onchange="updatePaperSelection(this)">
                                    <span class="flex flex-1 flex-col">
                                        <span class="block text-sm font-bold text-gray-900">Matte</span>
                                        <span class="mt-1 block text-xs text-gray-500">Smooth, no glare.</span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col-reverse sm:flex-row justify-between gap-4">
                        <button type="button" onclick="goToStep(1)" class="px-6 py-3 rounded-xl bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold shadow-sm transition-colors flex items-center justify-center gap-2 w-full sm:w-auto">
                            Back
                        </button>
                        <button type="button" onclick="goToStep(3)" class="px-6 py-3 rounded-xl bg-gray-900 hover:bg-black text-white font-bold shadow-md transition-all flex items-center justify-center gap-2 group w-full sm:w-auto">
                            Next Step
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- STEP 3: Payment -->
                <div id="step-3" class="hidden p-6 sm:p-8 space-y-6 transition-opacity duration-300">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Payment</h2>
                    <p class="text-gray-500 text-sm mb-6">Choose your payment method to finalize the order.</p>

                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200 mb-6">
                        <h3 class="font-bold text-gray-900 mb-4">Add-ons (Optional)</h3>
                        <div class="flex flex-col">
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-900">Pencil</span>
                                    <span class="text-xs font-medium text-gray-500">Rp 2.000 / ea</span>
                                </div>
                                <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden bg-white">
                                    <button type="button" onclick="updateAddonQty('pencil', -1)" class="minus-btn px-3 py-1 hover:bg-gray-100 font-bold transition-colors focus:outline-none">-</button>
                                    <input type="number" id="addon-pencil" name="addons[pencil]" value="0" min="0" data-price="2000" class="addon-qty w-12 text-center border-x border-gray-200 py-1 focus:outline-none" readonly>
                                    <button type="button" onclick="updateAddonQty('pencil', 1)" class="plus-btn px-3 py-1 hover:bg-gray-100 font-bold transition-colors focus:outline-none">+</button>
                                </div>
                            </div>
                            <div class="flex items-center justify-between py-3">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-900">Plastic Folder</span>
                                    <span class="text-xs font-medium text-gray-500">Rp 3.000 / ea</span>
                                </div>
                                <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden bg-white">
                                    <button type="button" onclick="updateAddonQty('folder', -1)" class="minus-btn px-3 py-1 hover:bg-gray-100 font-bold transition-colors focus:outline-none">-</button>
                                    <input type="number" id="addon-folder" name="addons[folder]" value="0" min="0" data-price="3000" class="addon-qty w-12 text-center border-x border-gray-200 py-1 focus:outline-none" readonly>
                                    <button type="button" onclick="updateAddonQty('folder', 1)" class="plus-btn px-3 py-1 hover:bg-gray-100 font-bold transition-colors focus:outline-none">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200 mb-6">
                        <h3 class="font-bold text-gray-900 mb-4">Payment Method</h3>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <label class="flex-1 relative flex cursor-pointer rounded-xl border p-4 shadow-sm focus:outline-none transition-all border-gray-900 ring-2 ring-gray-900 bg-white pay-label">
                                <input type="radio" name="payment_method" value="cash" class="sr-only" checked onchange="updatePaySelection(this)">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-gray-900 text-white rounded-full transition-colors pay-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-bold text-gray-900">Cash on Site</span>
                                    </div>
                                </div>
                            </label>
                            <label class="flex-1 relative flex cursor-pointer rounded-xl border p-4 shadow-sm focus:outline-none transition-all border-gray-200 hover:border-gray-400 bg-white pay-label">
                                <input type="radio" name="payment_method" value="qr" class="sr-only" onchange="updatePaySelection(this)">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-gray-100 text-gray-500 rounded-full transition-colors pay-icon">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-bold text-gray-900">QR Payment</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="bg-black rounded-2xl p-6 text-white shadow-xl relative overflow-hidden">
                        <!-- Decoration -->
                        <div class="absolute top-0 right-0 -mr-10 -mt-10 w-32 h-32 rounded-full bg-white opacity-5"></div>
                        <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-32 h-32 rounded-full bg-gray-500 opacity-10"></div>
                        
                        <div class="relative z-10 flex flex-col sm:flex-row justify-between items-center gap-6">
                            <div class="text-center sm:text-left">
                                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Estimated Total</p>
                                <p class="text-3xl font-black tracking-tight" id="estimated-total">Rp 0</p>
                            </div>
                            
                            <button type="submit" id="submit-btn" class="w-full sm:w-auto px-8 py-4 bg-white hover:bg-gray-100 text-gray-900 text-base font-bold rounded-xl shadow-lg transition-all focus:outline-none focus:ring-4 focus:ring-gray-100/50 flex items-center justify-center gap-2 group">
                                <span id="submit-text">Submit Order</span>
                                <svg id="submit-icon" class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-start">
                        <button type="button" onclick="goToStep(2)" class="px-6 py-2 text-sm text-gray-500 hover:text-gray-700 font-bold transition-colors flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            Back to Print Config
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentStep = 1;

        function goToStep(step) {
            // Validation before proceeding
            if(step === 2 && currentStep === 1) {
                if(!document.getElementById('user_name').value || !document.getElementById('phone').value) {
                    showError("Please fill in your name and phone number.");
                    return;
                }
                hideError();
            }
            if(step === 3 && currentStep === 2) {
                if(!document.getElementById('file').files.length) {
                    showError("Please select a file to print.");
                    return;
                }
                const qty = parseInt(document.getElementById('quantity').value);
                if(qty < 1 || isNaN(qty)) {
                    showError("Please enter a valid quantity.");
                    return;
                }
                hideError();
                calculateTotal();
            }

            // Hide all steps
            document.getElementById('step-1').classList.add('hidden');
            document.getElementById('step-2').classList.add('hidden');
            document.getElementById('step-3').classList.add('hidden');
            
            // Show target step
            document.getElementById('step-' + step).classList.remove('hidden');
            
            // Update UI State
            currentStep = step;
            document.getElementById('step-count').innerText = step;
            
            // Update circles and lines
            for(let i=1; i<=3; i++) {
                const circ = document.getElementById('circ-' + i);
                if(i <= step) {
                    circ.className = "w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors bg-gray-900 text-white shadow-sm";
                } else {
                    circ.className = "w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors bg-gray-200 text-gray-500";
                }
                
                if(i < 3) {
                    const line = document.getElementById('line-' + i);
                    if(i < step) {
                        line.className = "h-1 w-6 sm:w-12 rounded-full transition-colors bg-gray-900";
                    } else {
                        line.className = "h-1 w-6 sm:w-12 rounded-full transition-colors bg-gray-200";
                    }
                }
            }
        }

        function togglePaperOption() {
            const st = document.getElementById('service_type').value;
            if(st === 'photo') {
                document.getElementById('paper-option-container').classList.remove('hidden');
            } else {
                document.getElementById('paper-option-container').classList.add('hidden');
            }
        }

        function updatePaperSelection(radio) {
            const labels = document.querySelectorAll('.paper-label');
            labels.forEach(l => {
                l.classList.remove('bg-stone-50', 'border-gray-900', 'ring-2', 'ring-gray-900');
                l.classList.add('bg-white', 'border-gray-300', 'hover:border-gray-400');
            });
            const selectedLabel = radio.closest('label');
            selectedLabel.classList.remove('bg-white', 'border-gray-300', 'hover:border-gray-400');
            selectedLabel.classList.add('bg-stone-50', 'border-gray-900', 'ring-2', 'ring-gray-900');
        }

        function updatePaySelection(radio) {
            const labels = document.querySelectorAll('.pay-label');
            labels.forEach(l => {
                l.classList.remove('border-gray-900', 'ring-2', 'ring-gray-900');
                l.classList.add('border-gray-200', 'hover:border-gray-400');
                const icon = l.querySelector('.pay-icon');
                icon.classList.remove('bg-gray-900', 'text-white');
                icon.classList.add('bg-gray-100', 'text-gray-500');
            });
            const selectedLabel = radio.closest('label');
            selectedLabel.classList.remove('border-gray-200', 'hover:border-gray-400');
            selectedLabel.classList.add('border-gray-900', 'ring-2', 'ring-gray-900');
            const selectedIcon = selectedLabel.querySelector('.pay-icon');
            selectedIcon.classList.remove('bg-gray-100', 'text-gray-500');
            selectedIcon.classList.add('bg-gray-900', 'text-white');
        }

        function showError(msg) {
            document.getElementById('error-message').innerText = msg;
            document.getElementById('error-banner').classList.remove('hidden');
        }

        function hideError() {
            document.getElementById('error-banner').classList.add('hidden');
        }

        function updateAddonQty(id, delta) {
            const input = document.getElementById('addon-' + id);
            let val = parseInt(input.value) || 0;
            val += delta;
            if(val < 0) val = 0;
            input.value = val;
            calculateTotal();
        }

        function calculateTotal() {
            const st = document.getElementById('service_type').value;
            const qty = parseInt(document.getElementById('quantity').value) || 0;
            const price = st === 'photo' ? 2000 : 500;
            let total = qty * price;
            
            const addons = document.querySelectorAll('.addon-qty');
            addons.forEach(input => {
                const addQty = parseInt(input.value) || 0;
                const addPrice = parseInt(input.dataset.price) || 0;
                total += (addQty * addPrice);
            });
            
            document.getElementById('estimated-total').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }

        // Form submission via AJAX to mimic previous Livewire behavior
        document.getElementById('order-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submit-btn');
            const submitText = document.getElementById('submit-text');
            const submitIcon = document.getElementById('submit-icon');
            
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            submitText.innerText = 'Processing...';
            submitIcon.classList.add('hidden');

            const formData = new FormData();
            formData.append('user_name', document.getElementById('user_name').value);
            formData.append('phone', document.getElementById('phone').value);
            formData.append('file', document.getElementById('file').files[0]);
            formData.append('service_type', document.getElementById('service_type').value);
            formData.append('quantity', document.getElementById('quantity').value);
            
            const paperSelected = document.querySelector('input[name="paper_option"]:checked');
            if(paperSelected) formData.append('paper_option', paperSelected.value);
            
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            formData.append('payment_method', paymentMethod);

            const addons = document.querySelectorAll('.addon-qty');
            addons.forEach(input => {
                const addQty = parseInt(input.value) || 0;
                if(addQty > 0) {
                    const key = input.name.match(/\[(.*?)\]/)[1];
                    formData.append('addons[' + key + ']', addQty);
                }
            });

            // Re-use api/process_order.php
            fetch('../api/process_order.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    window.location.href = `queue.php?id=${data.order_id}`;
                } else {
                    showError(data.message || 'An error occurred while processing your order.');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    submitText.innerText = 'Submit Order';
                    submitIcon.classList.remove('hidden');
                }
            })
            .catch(err => {
                console.error('Error:', err);
                showError('Network error occurred.');
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                submitText.innerText = 'Submit Order';
                submitIcon.classList.remove('hidden');
            });
        });
    </script>
</body>
</html>
