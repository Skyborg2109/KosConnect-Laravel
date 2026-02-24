// Initialize Dummy Data for KosConnect
function initializeDummyData() {
    const existingData = localStorage.getItem('kosconnect_data');
    
    // Only initialize if no data exists
    if (existingData) {
        console.log('Data already exists, skipping initialization');
        return;
    }

    const dummyData = [
        // Kos Data
        {
            type: 'kos',
            __backendId: 'kos-001',
            name: 'Kos Mawar Indah',
            location: 'Jl. Sudirman No. 123, Jakarta Selatan',
            price: 1500000,
            rating: 4.5,
            reviews: 28,
            isAvailable: true,
            facilities: ['WiFi', 'AC', 'Kamar Mandi Dalam', 'Parkir'],
            description: 'Kos nyaman dan strategis dekat dengan pusat kota',
            owner: 'Bu Siti',
            phone: '081234567890'
        },
        {
            type: 'kos',
            __backendId: 'kos-002',
            name: 'Kos Melati Putih',
            location: 'Jl. Gatot Subroto No. 45, Jakarta Pusat',
            price: 1200000,
            rating: 4.2,
            reviews: 15,
            isAvailable: true,
            facilities: ['WiFi', 'Kamar Mandi Dalam', 'Dapur Bersama'],
            description: 'Kos bersih dengan suasana kekeluargaan',
            owner: 'Pak Budi',
            phone: '081298765432'
        },
        {
            type: 'kos',
            __backendId: 'kos-003',
            name: 'Kos Anggrek Residence',
            location: 'Jl. Kuningan Raya No. 88, Jakarta Selatan',
            price: 2500000,
            rating: 4.8,
            reviews: 42,
            isAvailable: true,
            facilities: ['WiFi', 'AC', 'Kamar Mandi Dalam', 'Parkir', 'Laundry', 'Security 24 Jam'],
            description: 'Kos eksklusif dengan fasilitas lengkap',
            owner: 'Ibu Ani',
            phone: '081345678901'
        },
        {
            type: 'kos',
            __backendId: 'kos-004',
            name: 'Kos Dahlia Syariah',
            location: 'Jl. TB Simatupang No. 77, Jakarta Selatan',
            price: 800000,
            rating: 4.0,
            reviews: 12,
            isAvailable: true,
            facilities: ['WiFi', 'Kamar Mandi Dalam', 'Musholla'],
            description: 'Kos khusus putri dengan lingkungan islami',
            owner: 'Ustadzah Fatimah',
            phone: '081456789012'
        },
        {
            type: 'kos',
            __backendId: 'kos-005',
            name: 'Kos Tulip Modern',
            location: 'Jl. Rasuna Said No. 22, Jakarta Selatan',
            price: 1800000,
            rating: 4.6,
            reviews: 33,
            isAvailable: true,
            facilities: ['WiFi', 'AC', 'Kamar Mandi Dalam', 'Parkir', 'Gym'],
            description: 'Kos modern dengan fasilitas fitness center',
            owner: 'Pak Dedi',
            phone: '081567890123'
        },
        {
            type: 'kos',
            __backendId: 'kos-006',
            name: 'Kos Kenanga Asri',
            location: 'Jl. Cikini Raya No. 99, Jakarta Pusat',
            price: 950000,
            rating: 3.9,
            reviews: 8,
            isAvailable: true,
            facilities: ['WiFi', 'Kamar Mandi Luar', 'Parkir'],
            description: 'Kos terjangkau dekat stasiun',
            owner: 'Bu Wati',
            phone: '081678901234'
        },
        
        // Wishlist Data
        {
            type: 'wishlist',
            __backendId: 'wish-001',
            kosId: 'kos-001',
            addedAt: new Date('2024-11-01').toISOString()
        },
        {
            type: 'wishlist',
            __backendId: 'wish-002',
            kosId: 'kos-003',
            addedAt: new Date('2024-11-05').toISOString()
        },
        
        // Booking Data
        {
            type: 'booking',
            __backendId: 'book-001',
            kosId: 'kos-002',
            status: 'active',
            checkIn: '2024-12-01',
            checkOut: '2025-06-01',
            duration: '6 bulan',
            totalPrice: 7200000,
            bookingDate: new Date('2024-10-15').toISOString()
        },
        {
            type: 'booking',
            __backendId: 'book-002',
            kosId: 'kos-005',
            status: 'pending',
            checkIn: '2024-12-15',
            checkOut: '2025-12-15',
            duration: '12 bulan',
            totalPrice: 21600000,
            bookingDate: new Date('2024-11-08').toISOString()
        },
        {
            type: 'booking',
            __backendId: 'book-003',
            kosId: 'kos-001',
            status: 'completed',
            checkIn: '2024-01-01',
            checkOut: '2024-07-01',
            duration: '6 bulan',
            totalPrice: 9000000,
            bookingDate: new Date('2023-12-10').toISOString()
        },
        
        // Rental Data (Active Rentals)
        {
            type: 'rental',
            __backendId: 'rent-001',
            kosId: 'kos-002',
            status: 'active',
            startDate: '2024-12-01',
            endDate: '2025-06-01',
            monthlyPrice: 1200000,
            contractId: 'CTR-2024-001'
        },
        
        // Payment Data
        {
            type: 'payment',
            __backendId: 'pay-001',
            kosId: 'kos-002',
            amount: 1200000,
            status: 'success',
            method: 'Transfer Bank',
            description: 'Pembayaran sewa bulan Desember 2024',
            transactionId: 'TRX-20241201-001',
            timestamp: new Date('2024-12-01').toISOString()
        },
        {
            type: 'payment',
            __backendId: 'pay-002',
            kosId: 'kos-005',
            amount: 1800000,
            status: 'pending',
            method: 'Transfer Bank',
            description: 'Pembayaran booking Kos Tulip Modern',
            timestamp: new Date('2024-11-08').toISOString()
        },
        {
            type: 'payment',
            __backendId: 'pay-003',
            kosId: 'kos-001',
            amount: 1500000,
            status: 'success',
            method: 'E-Wallet',
            description: 'Pembayaran sewa bulan November 2024',
            transactionId: 'TRX-20241101-002',
            timestamp: new Date('2024-11-01').toISOString()
        },
        
        // Review Data
        {
            type: 'review',
            __backendId: 'rev-001',
            kosId: 'kos-001',
            rating: 5,
            review: 'Kos sangat nyaman dan bersih. Pemilik kos juga ramah dan responsif. Highly recommended!',
            date: new Date('2024-07-15').toLocaleDateString('id-ID'),
            timestamp: new Date('2024-07-15').toISOString()
        },
        
        // Activity Data
        {
            type: 'activity',
            __backendId: 'act-001',
            title: 'Booking Berhasil',
            description: 'Booking Kos Melati Putih berhasil dikonfirmasi',
            timestamp: '2 hari yang lalu',
            icon: 'check'
        },
        {
            type: 'activity',
            __backendId: 'act-002',
            title: 'Pembayaran Diterima',
            description: 'Pembayaran sewa bulan Desember telah diterima',
            timestamp: '3 hari yang lalu',
            icon: 'payment'
        },
        {
            type: 'activity',
            __backendId: 'act-003',
            title: 'Review Dikirim',
            description: 'Review untuk Kos Mawar Indah berhasil dikirim',
            timestamp: '1 minggu yang lalu',
            icon: 'star'
        },
        {
            type: 'activity',
            __backendId: 'act-004',
            title: 'Wishlist Ditambahkan',
            description: 'Kos Anggrek Residence ditambahkan ke wishlist',
            timestamp: '1 minggu yang lalu',
            icon: 'heart'
        },
        {
            type: 'activity',
            __backendId: 'act-005',
            title: 'Pencarian Kos',
            description: 'Mencari kos di area Jakarta Selatan',
            timestamp: '2 minggu yang lalu',
            icon: 'search'
        },
        
        // Message Data (for notification)
        {
            type: 'message',
            __backendId: 'msg-001',
            title: 'Konfirmasi Booking',
            message: 'Booking Anda untuk Kos Tulip Modern sedang diproses',
            isRead: false,
            timestamp: new Date('2024-11-09').toISOString()
        },
        {
            type: 'message',
            __backendId: 'msg-002',
            title: 'Pengingat Pembayaran',
            message: 'Pembayaran sewa bulan Januari jatuh tempo 3 hari lagi',
            isRead: false,
            timestamp: new Date('2024-11-08').toISOString()
        }
    ];

    // Save to localStorage
    localStorage.setItem('kosconnect_data', JSON.stringify(dummyData));
    console.log('Dummy data initialized successfully!');
    
    return dummyData;
}

// Auto-initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeDummyData();
});
