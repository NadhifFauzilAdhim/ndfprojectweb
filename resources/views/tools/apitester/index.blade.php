<x-layout>
    <x-slot:title>REST API Tester</x-slot:title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />

    <style>
        :root {
            --api-primary: #f97316; /* Orange Postman-ish */
            --api-dark: #c2410c;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #ea580c 0%, #f97316 100%);
            padding: 3rem 0 5rem;
            color: white;
            border-bottom-left-radius: 2.5rem;
            border-bottom-right-radius: 2.5rem;
            margin-bottom: -3rem;
            position: relative;
        }

        .card-panel {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            background: white;
            overflow: hidden;
        }

        /* Method Selector Styling (DIPERKECIL) */
        .method-select {
            font-weight: 800;
            text-transform: uppercase;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            width: 105px; /* UPDATE: Diperkecil agar URL lebih lebar */
            font-size: 0.9rem;
        }

        .url-input {
            border: 1px solid #e2e8f0;
            font-family: 'Nunito', sans-serif;
        }
        
        .url-input:focus, .method-select:focus {
            border-color: var(--api-primary);
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
            z-index: 5; /* Agar shadow tampil diatas elemen lain */
        }

        /* Tabs */
        .nav-tabs .nav-link {
            color: #64748b;
            font-weight: 600;
            border: none;
            border-bottom: 3px solid transparent;
        }
        .nav-tabs .nav-link.active {
            color: var(--api-primary);
            border-bottom-color: var(--api-primary);
            background: transparent;
        }

        /* Editor Areas */
        .code-editor {
            background-color: #1e1e1e;
            color: #d4d4d4;
            font-family: 'Consolas', 'Monaco', monospace;
            border: 1px solid #333;
            border-radius: 0.5rem;
            min-height: 200px;
            font-size: 0.9rem;
        }

        /* Response Area */
        .response-status {
            font-size: 0.85rem;
            font-weight: 700;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
        }
        .status-success { background-color: #dcfce7; color: #166534; }
        .status-error { background-color: #fee2e2; color: #991b1b; }

        pre[class*="language-"] {
            border-radius: 0.5rem;
            margin: 0;
            height: 400px;
            overflow: auto;
        }

        .method-select {
            max-width: 120px;   /* atur sesuai kebutuhan */
            flex: 0 0 120px;    /* kunci ukuran agar tidak melebar */
        }

        .url-input {
            flex: 1 1 auto;    /* biarkan input URL mengisi sisa ruang */
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>

    <div class="hero-section">
        <div class="container position-relative z-2 text-center">
            <div class="mb-4">
                <i class="bi bi-send-check-fill fs-1 mb-2 d-block"></i>
                <h1 class="fw-bold">REST API Tester</h1>
                <p class="opacity-90">Uji endpoint API langsung dari browser (Client-Side).</p>
            </div>
        </div>
    </div>

    <div class="container pb-5" style="margin-top: 1rem;">
        
        <div class="row g-4">
            
            <div class="col-lg-7">
                <div class="card-panel p-4 h-100">
                    <h5 class="fw-bold mb-3 text-secondary"><i class="bi bi-input-cursor-text me-2"></i>Request</h5>
                    
                    <form id="apiForm" onsubmit="sendRequest(event)">
                            <div class="input-group input-group-lg mb-4">
                                <select class="form-select method-select" id="method">
                                    <option value="GET" selected>GET</option>
                                    <option value="POST">POST</option>
                                    <option value="PUT">PUT</option>
                                    <option value="PATCH">PATCH</option>
                                    <option value="DELETE">DELETE</option>
                                </select>
                                <input type="text" class="form-control url-input" id="url" placeholder="https://dog.ceo/api/breeds/image/random" required>
                                <button class="btn btn-primary px-4 fw-bold" style="background-color: var(--api-primary); border: none;" type="submit" id="sendBtn">
                                    <span id="btnText">SEND</span>
                                    <span id="btnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                </button>
                            </div>

                        <ul class="nav nav-tabs mb-3" id="reqTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="body-tab" data-bs-toggle="tab" data-bs-target="#req-body" type="button" role="tab">Body (JSON)</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="headers-tab" data-bs-toggle="tab" data-bs-target="#req-headers" type="button" role="tab">Headers</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="reqTabsContent">
                            <div class="tab-pane fade show active" id="req-body" role="tabpanel">
                                <div class="alert alert-info py-2 px-3 small border-0 bg-opacity-10 bg-info text-info mb-2">
                                    <i class="bi bi-info-circle me-1"></i> Body hanya dikirim untuk method POST, PUT, dan PATCH.
                                </div>
                                <textarea class="form-control code-editor" id="jsonBody" placeholder="{ &quot;key&quot;: &quot;value&quot; }" spellcheck="false"></textarea>
                            </div>

                            <div class="tab-pane fade" id="req-headers" role="tabpanel">
                                <div id="headersContainer">
                                    </div>
                                <button type="button" class="btn btn-sm btn-light border text-secondary mt-2" onclick="addHeader()">
                                    <i class="bi bi-plus-lg"></i> Tambah Header
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card-panel p-4 h-100 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-secondary mb-0"><i class="bi bi-code-square me-2"></i>Response</h5>
                        
                        <div id="responseStats" class="d-none align-items-center gap-2">
                            <span class="badge bg-light text-dark border">Time: <span id="timeTaken">0</span>ms</span>
                            <span id="statusCode" class="response-status status-success">200 OK</span>
                        </div>
                    </div>

                    <div class="position-relative flex-grow-1">
                        <div id="responseLoader" class="d-none position-absolute top-50 start-50 translate-middle text-center">
                            <div class="spinner-border text-warning" role="status"></div>
                            <p class="mt-2 text-muted small">Mengirim Request...</p>
                        </div>

                        <div id="emptyState" class="text-center text-muted mt-5 pt-5">
                            <i class="bi bi-lightning-charge fs-1 opacity-25"></i>
                            <p class="mt-2">Klik <strong>SEND</strong> untuk melihat respon.</p>
                        </div>

                        <div id="responseContainer" class="d-none h-100">
                             <pre><code class="language-json" id="responseCode"></code></pre>
                        </div>
                    </div>

                     <div class="alert alert-warning small mt-3 mb-0 border-0">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> 
                        <strong>Info:</strong> Tools ini berjalan di browser. Jika mendapatkan "Network Error", kemungkinan server tujuan memblokir request (CORS).
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js"></script>

    <script>
        // --- Header Helpers ---

        function addHeaderRow(key = '', value = '') {
            const container = document.getElementById('headersContainer');
            const div = document.createElement('div');
            div.className = 'input-group mb-2 header-row';
            div.innerHTML = `
                <input type="text" class="form-control" placeholder="Key" value="${key}">
                <input type="text" class="form-control" placeholder="Value" value="${value}">
                <button class="btn btn-outline-danger" type="button" onclick="removeHeader(this)"><i class="bi bi-trash"></i></button>
            `;
            container.appendChild(div);
        }

        // Wrapper untuk tombol tambah manual
        function addHeader() {
            addHeaderRow();
        }

        function removeHeader(btn) {
            btn.parentElement.remove();
        }

        function getHeaders() {
            const headers = {};
            document.querySelectorAll('.header-row').forEach(row => {
                const inputs = row.querySelectorAll('input');
                const key = inputs[0].value.trim();
                const value = inputs[1].value.trim();
                if (key) headers[key] = value;
            });
            return headers;
        }

        // --- LOGIC PERBAIKAN CORS & HEADER OTOMATIS ---
        document.getElementById('method').addEventListener('change', function() {
            const method = this.value;
            const container = document.getElementById('headersContainer');
            
            // Bersihkan header saat ganti method agar bersih
            container.innerHTML = '';

            // Jika method yang dipilih butuh body (POST/PUT/PATCH), otomatis tambah Content-Type
            // Ini untuk mencegah error 405 pada method GET
            if (['POST', 'PUT', 'PATCH'].includes(method)) {
                addHeaderRow('Content-Type', 'application/json');
                addHeaderRow('Accept', 'application/json');
            }
        });


        // --- Main Request Logic ---
        async function sendRequest(e) {
            e.preventDefault();

            // Elements
            const sendBtn = document.getElementById('sendBtn');
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');
            const responseContainer = document.getElementById('responseContainer');
            const responseCode = document.getElementById('responseCode');
            const emptyState = document.getElementById('emptyState');
            const responseStats = document.getElementById('responseStats');
            const responseLoader = document.getElementById('responseLoader');
            const statusCode = document.getElementById('statusCode');
            const timeTakenEl = document.getElementById('timeTaken');

            // Data
            const method = document.getElementById('method').value;
            const url = document.getElementById('url').value;
            const bodyRaw = document.getElementById('jsonBody').value;
            const headers = getHeaders();

            // Reset UI State
            btnText.textContent = 'LOADING...';
            sendBtn.disabled = true;
            btnSpinner.classList.remove('d-none');
            emptyState.classList.add('d-none');
            responseContainer.classList.add('d-none');
            responseStats.classList.add('d-none');
            responseLoader.classList.remove('d-none');

            // Prepare Fetch Options
            const options = {
                method: method,
                headers: headers,
            };

            // Validasi & Attach Body hanya untuk method yang sesuai
            if (['POST', 'PUT', 'PATCH'].includes(method) && bodyRaw.trim() !== '') {
                try {
                    JSON.parse(bodyRaw); // Cek validitas JSON
                    options.body = bodyRaw;
                } catch (err) {
                    alert("Format JSON Body tidak valid!");
                    resetBtn();
                    return;
                }
            }

            const startTime = performance.now();

            try {
                // EXECUTE FETCH
                const response = await fetch(url, options);
                
                // Kalkulasi Waktu
                const endTime = performance.now();
                const duration = (endTime - startTime).toFixed(0);
                
                const status = response.status;
                const statusText = response.statusText;
                
                // Cek Content Type Response
                const contentType = response.headers.get("content-type");
                let resultData;

                if (contentType && contentType.indexOf("application/json") !== -1) {
                    const json = await response.json();
                    resultData = JSON.stringify(json, null, 2); // Pretty Print JSON
                } else {
                    resultData = await response.text();
                }

                // Render Result
                responseCode.textContent = resultData;
                Prism.highlightElement(responseCode); // Highlight Syntax

                // Update Status Bar
                statusCode.textContent = `${status} ${statusText}`;
                statusCode.className = 'response-status ' + (status >= 200 && status < 300 ? 'status-success' : 'status-error');
                timeTakenEl.textContent = duration;

                // Tampilkan Container
                responseLoader.classList.add('d-none');
                responseContainer.classList.remove('d-none');
                responseStats.classList.remove('d-none');
                responseStats.classList.add('d-flex');

            } catch (error) {
                // Handle Error (Network / CORS)
                responseLoader.classList.add('d-none');
                responseContainer.classList.remove('d-none');
                
                responseCode.textContent = `Error: ${error.message}\n\nKemungkinan Penyebab:\n1. Server tujuan memblokir request ini (CORS Policy).\n2. Koneksi internet terputus.\n3. URL tidak valid.`;
                
                statusCode.textContent = "NETWORK ERROR";
                statusCode.className = 'response-status status-error';
                responseStats.classList.remove('d-none');
                responseStats.classList.add('d-flex');
            }

            resetBtn();
        }

        function resetBtn() {
            const sendBtn = document.getElementById('sendBtn');
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');
            
            btnText.textContent = 'SEND';
            sendBtn.disabled = false;
            btnSpinner.classList.add('d-none');
        }

        // Fitur Tab di Textarea
        document.getElementById('jsonBody').addEventListener('keydown', function(e) {
            if (e.key == 'Tab') {
                e.preventDefault();
                var start = this.selectionStart;
                var end = this.selectionEnd;
                this.value = this.value.substring(0, start) + "  " + this.value.substring(end);
                this.selectionStart = this.selectionEnd = start + 2;
            }
        });
    </script>
</x-layout>