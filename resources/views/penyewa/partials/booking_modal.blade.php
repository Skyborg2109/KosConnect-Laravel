<!-- Booking Modal -->
<div id="bookingModal" class="modal-overlay" style="display: none;">
    <div class="modal-booking">
        <div class="modal-header-booking">
            <h3><i class="fas fa-calendar-check"></i> Pesan Kos</h3>
            <button class="close-modal" onclick="closeBookingModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="bookingForm" action="/store-booking" method="POST">
            @csrf
            <input type="hidden" id="modal-kos-id" name="kos_id">
            <input type="hidden" id="modal-kamar-id" name="kamar_id">
            
            <div class="modal-body-booking">
                <div class="kos-info-summary">
                    <h4 id="modal-kos-name">Nama Kos</h4>
                    <p id="modal-kos-address">Alamat Kos</p>
                    <p class="modal-kos-price" id="modal-kos-price">Rp 0 <small>/Bulan</small></p>
                </div>

                <div class="form-group-modal">
                    <label for="kamar-select">
                        <i class="fas fa-door-open"></i> Pilih Kamar
                    </label>
                    <select id="kamar-select" name="kamar_id" required>
                        <option value="">-- Pilih Kamar --</option>
                    </select>
                </div>

                <div class="form-group-modal">
                    <label for="tanggal-mulai">
                        <i class="fas fa-calendar"></i> Tanggal Mulai
                    </label>
                    <input type="date" id="tanggal-mulai" name="tanggal_mulai" required>
                </div>

                <div class="form-group-modal">
                    <label for="durasi-sewa">
                        <i class="fas fa-clock"></i> Durasi Sewa (Bulan)
                    </label>
                    <select id="durasi-sewa" name="durasi_bulan" required onchange="calculateTotal()">
                        <option value="">-- Pilih Durasi --</option>
                        <option value="1">1 Bulan</option>
                        <option value="3">3 Bulan</option>
                        <option value="6">6 Bulan</option>
                        <option value="12">12 Bulan</option>
                    </select>
                </div>

                <div class="total-price-box">
                    <div class="price-detail">
                        <span>Harga per Bulan:</span>
                        <strong id="price-per-month">Rp 0</strong>
                    </div>
                    <div class="price-detail">
                        <span>Durasi:</span>
                        <strong id="duration-display">0 Bulan</strong>
                    </div>
                    <div class="price-total">
                        <span>Total Pembayaran:</span>
                        <strong id="total-price">Rp 0</strong>
                    </div>
                </div>
            </div>

            <div class="modal-footer-booking">
                <button type="button" class="btn-cancel" onclick="closeBookingModal()">Batal</button>
                <button type="submit" class="btn-confirm">
                    <i class="fas fa-check"></i> Konfirmasi Booking
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    z-index: 9999;
    overflow-y: auto;
    display: flex;
    justify-content: center;
    align-items: flex-start; /* Aligns modal to top to ensure scrolling down works */
    padding: 20px;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.modal-booking {
    margin: 40px auto; /* Explicit top/bottom margin */
    background-color: #ffffff;
    border-radius: 12px;
    width: 100%;
    max-width: 500px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    animation: slideUp 0.3s ease;
    display: flex;
    flex-direction: column;
    position: relative;
    border: none;
    flex-shrink: 0; /* Prevents modal from squishing */
}

@keyframes slideUp {
    from {
        transform: translateY(50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.modal-header-booking {
    background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%);
    color: white;
    padding: 20px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 12px 12px 0 0;
}

.modal-header-booking h3 {
    font-size: 20px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0;
}

.close-modal {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.close-modal:hover {
    background-color: rgba(255, 255, 255, 0.2);
    transform: rotate(90deg);
}

.modal-body-booking {
    padding: 24px;
}

.kos-info-summary {
    background-color: #f8f9fa;
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    border-left: 4px solid #0d6efd;
}

.kos-info-summary h4 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 4px;
    color: #212529;
}

.kos-info-summary p {
    font-size: 14px;
    color: #6c757d;
    margin-bottom: 8px;
}

.modal-kos-price {
    font-size: 20px;
    font-weight: 700;
    color: #0d6efd;
    margin: 0 !important;
}

.form-group-modal {
    margin-bottom: 20px;
}

.form-group-modal label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #495057;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-group-modal input,
.form-group-modal select {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #ced4da;
    border-radius: 6px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-group-modal input:focus,
.form-group-modal select:focus {
    outline: none;
    border-color: #0d6efd;
    box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
}

.total-price-box {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 20px;
    border-radius: 8px;
    margin-top: 20px;
    border: 2px solid #0d6efd;
}

.price-detail {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    font-size: 14px;
    color: #495057;
}

.price-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 12px;
    border-top: 2px solid #dee2e6;
    font-size: 16px;
    color: #212529;
}

.price-total strong {
    font-size: 24px;
    color: #0d6efd;
}

.modal-footer-booking {
    padding: 16px 24px;
    background-color: #f8f9fa;
    border-radius: 0 0 12px 12px;
    display: flex;
    gap: 12px;
    justify-content: flex-end;
}

.btn-cancel,
.btn-confirm {
    padding: 12px 24px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-cancel {
    background-color: #6c757d;
    color: white;
}

.btn-cancel:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn-confirm {
    background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%);
    color: white;
}

.btn-confirm:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
}
</style>

<script>
let currentKosData = {};

function openBookingModal(kosId, kosName, kosAddress, kosPrice) {
    currentKosData = {
        id: kosId,
        name: kosName,
        address: kosAddress,
        price: kosPrice
    };
    
    document.getElementById('modal-kos-id').value = kosId;
    document.getElementById('modal-kos-name').textContent = kosName;
    document.getElementById('modal-kos-address').textContent = kosAddress;
    document.getElementById('modal-kos-price').innerHTML = 'Rp ' + formatNumber(kosPrice) + ' <small>/Bulan</small>';
    document.getElementById('price-per-month').textContent = 'Rp ' + formatNumber(kosPrice);
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tanggal-mulai').setAttribute('min', today);
    
    // Load available rooms for this kos
    loadAvailableRooms(kosId);
    
    document.getElementById('bookingModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeBookingModal() {
    document.getElementById('bookingModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    document.getElementById('bookingForm').reset();
    resetCalculation();
}

function loadAvailableRooms(kosId) {
    const kamarSelect = document.getElementById('kamar-select');
    kamarSelect.innerHTML = '<option value="">Loading...</option>';
    
    // Fetch available rooms from API
    fetch(`/api/kos/${kosId}/kamar`)
        .then(response => response.json())
        .then(data => {
            kamarSelect.innerHTML = '<option value="">-- Pilih Kamar --</option>';
            
            if (data.length === 0) {
                const option = document.createElement('option');
                option.text = "Tidak ada kamar tersedia";
                option.disabled = true;
                kamarSelect.appendChild(option);
            } else {
                data.forEach(room => {
                    const option = document.createElement('option');
                    option.value = room.id;
                    // Check if harga attribute exists, otherwise use kos price
                    const roomPrice = room.harga || currentKosData.price;
                    // Format option text
                    const typeText = room.tipe_kamar ? ` - ${room.tipe_kamar}` : '';
                    option.textContent = `Kamar ${room.nomor_kamar}${typeText} (Rp ${formatNumber(roomPrice)}/bulan)`;
                    option.dataset.price = roomPrice;
                    kamarSelect.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error fetching rooms:', error);
            kamarSelect.innerHTML = '<option value="">Gagal memuat kamar</option>';
        });
}

function calculateTotal() {
    const kamarSelect = document.getElementById('kamar-select');
    const durasiSelect = document.getElementById('durasi-sewa');
    
    const selectedKamar = kamarSelect.options[kamarSelect.selectedIndex];
    const durasi = parseInt(durasiSelect.value) || 0;
    
    // Get price from selected room, or use kos base price if no room selected yet
    let hargaPerBulan = 0;
    if (selectedKamar && selectedKamar.dataset.price) {
        hargaPerBulan = parseInt(selectedKamar.dataset.price);
        document.getElementById('modal-kamar-id').value = kamarSelect.value;
    } else if (currentKosData.price) {
        // Use kos base price if no room selected yet
        hargaPerBulan = parseInt(currentKosData.price);
    }
    
    if (hargaPerBulan > 0 && durasi > 0) {
        const total = hargaPerBulan * durasi;
        
        document.getElementById('price-per-month').textContent = 'Rp ' + formatNumber(hargaPerBulan);
        document.getElementById('duration-display').textContent = durasi + ' Bulan';
        document.getElementById('total-price').textContent = 'Rp ' + formatNumber(total);
    } else {
        resetCalculation();
    }
}

function resetCalculation() {
    document.getElementById('price-per-month').textContent = 'Rp 0';
    document.getElementById('duration-display').textContent = '0 Bulan';
    document.getElementById('total-price').textContent = 'Rp 0';
}

function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Update calculation when kamar changes
document.addEventListener('DOMContentLoaded', function() {
    const kamarSelect = document.getElementById('kamar-select');
    if (kamarSelect) {
        kamarSelect.addEventListener('change', calculateTotal);
    }
});

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('bookingModal');
    if (event.target === modal) {
        closeBookingModal();
    }
});
</script>
