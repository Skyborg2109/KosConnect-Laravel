@extends('penyewa.layout')

@section('title', 'Sewa Saya')

@section('active-sewaSaya', 'active')

@section('styles')
<style>
        /* == CSS RESET & DASAR == */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1300px;
            margin: 20px auto;
            padding: 0 20px;
        }

        a {
            text-decoration: none;
            color: inherit;
        }
        
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: inline-block;
            text-align: center;
        }

        /* == CSS HALAMAN SEWA SAYA == */

        .page-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        /* 1. KOTAK TAB */
        .sewa-container {
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 30px;
        }
        
        .tab-nav {
            display: flex;
            border-bottom: 1px solid #e9ecef;
            background-color: #f8f9fa;
        }
        
        .tab-nav a {
            padding: 14px 24px;
            font-size: 16px;
            font-weight: 500;
            color: #6c757d;
            border-bottom: 3px solid transparent;
            margin-bottom: -1px;
            cursor: default;
        }
        
        .tab-nav a.active {
            color: #0d6efd;
            font-weight: 600;
            border-bottom-color: #0d6efd;
            background-color: #ffffff;
        }
        
        /* Konten Tab Statis */
        .tab-content {
            padding: 30px;
            min-height: 250px;
        }

        /* == KONTEN TAB: KARTU HORIZONTAL == */
        .sewa-details-card {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 24px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        
        /* Jarak antar kartu */
        .tab-content .sewa-details-card {
            margin-bottom: 20px;
        }
        .tab-content .sewa-details-card:last-child {
            margin-bottom: 0;
        }

        .sewa-info h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 4px;
        }
        
        .sewa-info .address,
        .sewa-info .date-info,
        .sewa-duration .date-info {
            font-size: 14px;
            color: #555;
            margin-bottom: 4px;
        }
        
        .sewa-duration {
            flex-shrink: 0;
            margin: 0 40px;
        }
        
        .sewa-actions {
            text-align: right;
            margin-left: auto;
        }
        
        .status-tag {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 16px;
        }
        
        /* Tag Hijau (Aktif/Lunas) */
        .status-tag.active {
            background-color: #d1fae5;
            color: #059669;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-perpanjang {
            background-color: #0d6efd;
            color: #ffffff;
        }
        .btn-perpanjang:hover {
            background-color: #0b5ed7;
        }
        
        .btn-keluhan {
            background-color: #dc3545;
            color: #ffffff;
        }
        .btn-keluhan:hover {
            background-color: #bb2d3b;
        }

        /* == MODAL STYLES == */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh; /* Ensure full viewport height */
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999; /* Higher than navbar */
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .modal-overlay.show {
            display: flex;
            opacity: 1;
        }
        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transform: translateY(-20px);
            transition: transform 0.3s ease;
        }
        .modal-overlay.show .modal-content {
            transform: translateY(0);
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .modal-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }
        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
            line-height: 1;
        }
        .close-btn:hover {
            color: #333;
        }
        .info-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
            color: #495057;
        }
        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.15s ease-in-out;
        }
        .form-control:focus {
            border-color: #86b7fe;
            outline: 0;
        }
        .form-control[readonly] {
            background-color: #e9ecef;
            color: #6c757d;
        }
        .total-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            margin-bottom: 25px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .total-label {
            font-weight: 700;
            font-size: 16px;
            color: #333;
        }
        .total-amount {
            font-size: 20px;
            font-weight: 700;
            color: #0d6efd;
        }
        .modal-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }
        .btn-cancel {
            background-color: #e9ecef;
            color: #333;
        }
        .btn-cancel:hover {
            background-color: #dee2e6;
        }
        .btn-submit {
            background-color: #0d6efd;
            color: white;
            flex-grow: 1;
        }
        .btn-submit:hover {
            background-color: #0b5ed7;
        }
        
    </style>
@endsection

@section('content')
        
        <h1 class="page-title">Sewa Saya</h1>

        <section class="sewa-container">
            <nav class="tab-nav">
                <a class="tab-link active" href="#">Sewa Aktif</a>
                <a class="tab-link" href="/riwayatSewa">Riwayat Sewa</a>
            </nav>
            
            <div class="tab-content">
                
                <div class="sewa-details-card">
                    <div class="sewa-info">
                        <h4>Kos Melati Indah</h4>
                        <p class="address">Jl. Melati No. 15, Yogyakarta</p>
                        <p class="date-info"><strong>Tanggal Mulai:</strong> 10/11/2025</p>
                    </div>
                    <div class="sewa-duration">
                        <p class="date-info"><strong>Durasi:</strong> 1 bulan</p>
                        <p class="date-info"><strong>Berakhir Pada:</strong> 10/12/2025</p>
                    </div>
                    <div class="sewa-actions">
                        <span class="status-tag active">Lunas</span>
                        <div class="action-buttons">
                            <button type="button" 
                                    class="btn btn-perpanjang" 
                                    onclick="openPerpanjangModal('Kos Melati Indah', '10/12/2025', 800000)">
                                Perpanjang Sewa
                            </button>
                            <a href="/submitKeluhan" class="btn btn-keluhan">Submit Keluhan</a>
                        </div>
                    </div>
                </div>
                
                <div class="sewa-details-card">
                    <div class="sewa-info">
                        <h4>Kos Anggrek Putih</h4>
                        <p class="address">Jl. Anggrek No. 22, Bandung</p>
                        <p class="date-info"><strong>Tanggal Mulai:</strong> 1/11/2025</p>
                    </div>
                    <div class="sewa-duration">
                        <p class="date-info"><strong>Durasi:</strong> 3 bulan</p>
                        <p class="date-info"><strong>Berakhir Pada:</strong> 1/2/2026</p>
                    </div>
                    <div class="sewa-actions">
                        <span class="status-tag active">Lunas</span>
                        <div class="action-buttons">
                            <button type="button" 
                                    class="btn btn-perpanjang" 
                                    onclick="openPerpanjangModal('Kos Anggrek Putih', '01/02/2026', 1500000)">
                                Perpanjang Sewa
                            </button>
                            <a href="/submitKeluhan" class="btn btn-keluhan">Submit Keluhan</a>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- EXTEND LEASE MODAL -->
        <div class="modal-overlay" id="perpanjangModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Perpanjang Sewa</h3>
                    <button class="close-btn" onclick="closePerpanjangModal()">&times;</button>
                </div>
                <div class="info-box">
                    Anda akan memperpanjang sewa untuk <strong id="modalKosName">Nama Kos</strong>.<br>
                    Sewa Anda saat ini berakhir pada: <strong id="modalEndDate">DD/MM/YYYY</strong>
                </div>
                
                <form action="/pembayaran" method="GET"> <!-- Assuming GET to payment page for prototype -->
                    <div class="form-group">
                        <label class="form-label" for="durasiSelect">Durasi Perpanjangan (bulan)</label>
                        <select id="durasiSelect" name="durasi" class="form-control" onchange="calculateExtension()" required>
                            <option value="">Pilih durasi</option>
                            <option value="1">1 Bulan</option>
                            <option value="3">3 Bulan</option>
                            <option value="6">6 Bulan</option>
                            <option value="12">12 Bulan</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Tanggal Berakhir Baru</label>
                        <input type="text" id="newEndDate" class="form-control" readonly placeholder="DD/MM/YYYY">
                    </div>
                    
                    <div class="total-section">
                        <span class="total-label">Total Biaya:</span>
                        <span class="total-amount" id="totalCost">Rp 0</span>
                    </div>
                    
                    <div class="modal-actions">
                        <button type="button" class="btn btn-cancel" onclick="closePerpanjangModal()">Batal</button>
                        <button type="submit" class="btn btn-submit">Lanjut Ke Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Move modal to body to avoid z-index/stacking context issues
                const modal = document.getElementById('perpanjangModal');
                if (modal) {
                    document.body.appendChild(modal);
                }
            });

            let currentPrice = 0;
            let currentEndDateStr = '';

            function openPerpanjangModal(kosName, endDate, price) {
                // Set data to Info Box
                document.getElementById('modalKosName').textContent = kosName;
                document.getElementById('modalEndDate').textContent = endDate;
                
                // Show Modal
                document.getElementById('perpanjangModal').classList.add('show');
                
                // Store state
                currentPrice = price;
                currentEndDateStr = endDate; 
                
                // Reset Function
                document.getElementById('durasiSelect').value = '';
                document.getElementById('newEndDate').value = '';
                document.getElementById('totalCost').textContent = 'Rp 0';
            }

            function closePerpanjangModal() {
                document.getElementById('perpanjangModal').classList.remove('show');
            }

            function calculateExtension() {
                const duration = parseInt(document.getElementById('durasiSelect').value);
                if(!duration) {
                    document.getElementById('newEndDate').value = '';
                    document.getElementById('totalCost').textContent = 'Rp 0';
                    return;
                }

                // 1. Calculate Cost
                const total = duration * currentPrice;
                const formattedCost = new Intl.NumberFormat('id-ID', { 
                    style: 'currency', 
                    currency: 'IDR', 
                    minimumFractionDigits: 0 
                }).format(total);
                document.getElementById('totalCost').textContent = formattedCost;

                // 2. Calculate New Date
                // Expecting DD/MM/YYYY format
                const parts = currentEndDateStr.split('/');
                if (parts.length === 3) {
                    const day = parseInt(parts[0]);
                    const month = parseInt(parts[1]) - 1; // 0-based index
                    const year = parseInt(parts[2]);
                    
                    const date = new Date(year, month, day);
                    
                    // Add months
                    date.setMonth(date.getMonth() + duration);
                    
                    // Format back to DD/MM/YYYY
                    const newDay = String(date.getDate()).padStart(2, '0');
                    const newMonth = String(date.getMonth() + 1).padStart(2, '0');
                    const newYear = date.getFullYear();
                    
                    document.getElementById('newEndDate').value = `${newDay}/${newMonth}/${newYear}`;
                }
            }
            
            // Close modal when clicking outside
            document.getElementById('perpanjangModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closePerpanjangModal();
                }
            });
        </script>

@endsection