@extends('penyewa.layout')

@section('title', 'Detail Kos')

@section('active-daftarKos', 'active')

@section('styles')
    {{-- Styles are now included in the partial or layout --}}
@endsection

@section('content')
        
        <div class="container">
            <h1 class="page-title">Detail Kos</h1>
            
            @include('penyewa.partials.detailKosContent')
            
        </div>
        
        <script>
            // Fallback for full page view if not opened as modal
            function closeDetailModal() {
                window.location.href = '/daftarkos';
            }
        </script>
        
@endsection