<!-- Pastikan FontAwesome dimuat -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="dashboard-title">
                        <i class="fa fa-home mr-2 text-primary"></i>
                        Dashboard Anggota
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard Anggota</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            <!-- Search Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="search-container">
                        <div class="search-box">
                            <div class="search-icon">
                                <i class="fa fa-search"></i>
                            </div>
                            <input type="text" id="searchBook" class="search-input" placeholder="Cari buku berdasarkan judul, pengarang, atau ISBN...">
                            <div class="search-filter">
                                <select id="filterStatus" class="filter-select">
                                    <option value="">Semua Status</option>
                                    <option value="tersedia">Tersedia</option>
                                    <option value="habis">Tidak Tersedia</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="stats-card">
                        <div class="stats-icon bg-primary">
                            <i class="fa fa-book"></i>
                        </div>
                        <div class="stats-content">
                            <h3 class="stats-number"><?= count($list_buku) ?></h3>
                            <p class="stats-label">Total Judul Buku</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="stats-card">
                        <div class="stats-icon bg-success">
                            <i class="fa fa-check-circle"></i>
                        </div>
                        <div class="stats-content">
                            <h3 class="stats-number">
                                <?php 
                                $tersedia = 0;
                                foreach($list_buku as $buku) {
                                    if($buku->stok_tersedia > 0) $tersedia++;
                                }
                                echo $tersedia;
                                ?>
                            </h3>
                            <p class="stats-label">Judul Buku Tersedia</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="stats-card">
                        <div class="stats-icon bg-warning">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>
                        <div class="stats-content">
                            <h3 class="stats-number">
                                <?php 
                                $habis = 0;
                                foreach($list_buku as $buku) {
                                    if($buku->stok_tersedia <= 0) $habis++;
                                }
                                echo $habis;
                                ?>
                            </h3>
                            <p class="stats-label">Stok Habis</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="stats-card">
                        <div class="stats-icon bg-info">
                            <i class="fa fa-bookmark"></i>
                        </div>
                        <div class="stats-content">
                            <h3 class="stats-number">
                                <?php 
                                $total_stok = 0;
                                foreach($list_buku as $buku) {
                                    $total_stok += $buku->total_stok;
                                }
                                echo $total_stok;
                                ?>
                            </h3>
                            <p class="stats-label">Total Buku</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- List Semua Buku Section -->
            <div class="row">
                <div class="col-12">
                    <div class="main-card">
                        <div class="card-header-custom">
                            <div class="header-left">
                                <h3 class="card-title-custom">
                                    <i class="fa fa-book-open mr-2"></i>
                                    Koleksi Buku Perpustakaan
                                </h3>
                                <p class="card-subtitle">Jelajahi koleksi lengkap buku perpustakaan kami</p>
                            </div>
                        </div>
                        <div class="card-body-custom">
                            <div id="bookContainer" class="book-grid">
                                <?php if(!empty($list_buku)): ?>
                                    <?php foreach($list_buku as $buku): ?>
                                    <div class="book-card" data-title="<?= strtolower($buku->title) ?>" data-author="<?= strtolower($buku->pengarang) ?>" data-isbn="<?= $buku->isbn ?>" data-status="<?= $buku->stok_tersedia > 0 ? 'tersedia' : 'habis' ?>">
                                        <div class="book-image-container">
                                            <?php if(!empty($buku->sampul) && $buku->sampul != '0'): ?>
                                                <img src="<?= base_url('assets_style/image/buku/' . $buku->sampul) ?>" 
                                                     class="book-image" 
                                                     alt="<?= $buku->title ?>"
                                                     onerror="this.parentElement.innerHTML='<div class=\'book-placeholder\'><i class=\'fa fa-book fa-2x\'></i><p>Sampul<br>Kosong</p></div>'">
                                            <?php else: ?>
                                                <div class="book-placeholder">
                                                    <i class="fa fa-book fa-2x"></i>
                                                    <p>Sampul<br>Kosong</p>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="book-overlay">
                                                <a href="<?= base_url('data/bukudetail/' . $buku->id_buku) ?>" 
                                                   class="btn-detail">
                                                    <i class="fa fa-eye"></i>
                                                    Lihat Detail
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <div class="book-info">
                                            <div class="book-badges">
                                                <span class="badge badge-isbn">ISBN: <?= $buku->isbn ?></span>
                                                <?php if($buku->stok_tersedia > 0): ?>
                                                    <span class="badge badge-available">
                                                        <i class="fa fa-check"></i> Tersedia: <?= $buku->stok_tersedia ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-unavailable">
                                                        <i class="fa fa-times"></i> Tidak Tersedia
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <h4 class="book-title"><?= $buku->title ?></h4>
                                            
                                            <div class="book-details">
                                                <p class="book-author">
                                                    <i class="fa fa-user"></i>
                                                    <?= $buku->pengarang ?>
                                                </p>
                                                <p class="book-publisher">
                                                    <i class="fa fa-building"></i>
                                                    <?= $buku->penerbit ?> (<?= $buku->thn_buku ?>)
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fa fa-book-open fa-4x"></i>
                                        </div>
                                        <h3>Belum Ada Koleksi Buku</h3>
                                        <p>Koleksi buku perpustakaan masih kosong</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- No Results Message -->
                            <div id="noResults" class="empty-state" style="display: none;">
                                <div class="empty-icon">
                                    <i class="fa fa-search fa-4x"></i>
                                </div>
                                <h3>Tidak Ada Hasil</h3>
                                <p>Tidak ada buku yang sesuai dengan pencarian Anda</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<style>
/* Modern Color Palette - Updated with #0D47A1 base */
:root {
    --primary-color: #0D47A1;
    --primary-light: #1976D2;
    --primary-gradient: linear-gradient(135deg, #0D47A1 0%, #1976D2 100%);
    --success-color: #2E7D32;
    --success-light: #43A047;
    --warning-color: #F57C00;
    --warning-light: #FF9800;
    --danger-color: #C62828;
    --danger-light: #E53935;
    --info-color: #00695C;
    --info-light: #00897B;
    --light-bg: #F8FAFB;
    --card-shadow: 0 4px 6px -1px rgba(13, 71, 161, 0.1), 0 2px 4px -1px rgba(13, 71, 161, 0.06);
    --card-shadow-hover: 0 20px 25px -5px rgba(13, 71, 161, 0.15), 0 10px 10px -5px rgba(13, 71, 161, 0.08);
    --border-radius: 12px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Dashboard Title */
.dashboard-title {
    font-size: 2rem;
    font-weight: 700;
    color: #263238;
    margin-bottom: 0;
}

/* Search Container */
.search-container {
    background: linear-gradient(135deg, #0D47A1 0%, #1976D2 100%);
    border-radius: var(--border-radius);
    padding: 2rem;
    margin-bottom: 1rem;
}

.search-box {
    display: flex;
    align-items: center;
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    overflow: hidden;
    transition: var(--transition);
}

.search-box:focus-within {
    box-shadow: var(--card-shadow-hover);
    transform: translateY(-2px);
}

.search-icon {
    padding: 1rem;
    color: #90A4AE;
    background: #F8FAFB;
}

.search-input {
    flex: 1;
    padding: 1rem;
    border: none;
    outline: none;
    font-size: 1rem;
    color: #263238;
}

.search-input::placeholder {
    color: #90A4AE;
}

.search-filter {
    padding: 0.5rem;
    background: #F8FAFB;
    border-left: 1px solid #E0E7FF;
}

.filter-select {
    border: none;
    outline: none;
    background: transparent;
    color: #455A64;
    font-size: 0.9rem;
    padding: 0.5rem;
}

/* Statistics Cards */
.stats-card {
    background: white;
    border-radius: var(--border-radius);
    padding: 1.5rem;
    display: flex;
    align-items: center;
    box-shadow: var(--card-shadow);
    transition: var(--transition);
    margin-bottom: 1rem;
    border: 1px solid #E0E7FF;
}

.stats-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--card-shadow-hover);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: white;
    font-size: 1.5rem;
}

.stats-icon.bg-primary { 
    background: linear-gradient(135deg, #0D47A1, #1976D2); 
}
.stats-icon.bg-success { 
    background: linear-gradient(135deg, #2E7D32, #43A047); 
}
.stats-icon.bg-warning { 
    background: linear-gradient(135deg, #F57C00, #FF9800); 
}
.stats-icon.bg-info { 
    background: linear-gradient(135deg, #00695C, #00897B); 
}

.stats-content h3 {
    font-size: 2rem;
    font-weight: 700;
    color: #263238;
    margin: 0;
    line-height: 1;
}

.stats-content p {
    color: #607D8B;
    margin: 0;
    font-size: 0.9rem;
    font-weight: 500;
}

/* Main Card */
.main-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--card-shadow);
    overflow: hidden;
    border: 1px solid #E0E7FF;
}

.card-header-custom {
    background: linear-gradient(135deg, #F8FAFB 0%, #E8EAF6 100%);
    padding: 2rem;
    border-bottom: 1px solid #E0E7FF;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-title-custom {
    font-size: 1.5rem;
    font-weight: 700;
    color: #263238;
    margin: 0;
}

.card-subtitle {
    color: #607D8B;
    margin: 0.5rem 0 0 0;
    font-size: 0.9rem;
}

.card-body-custom {
    padding: 2rem;
}

/* Book Grid */
.book-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2rem;
    margin-top: 1rem;
}

.book-card {
    background: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--card-shadow);
    transition: var(--transition);
    border: 1px solid #E0E7FF;
    position: relative;
}

.book-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--card-shadow-hover);
}

.book-image-container {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: #F8FAFB;
}

.book-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.book-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #90A4AE;
    background: linear-gradient(135deg, #F8FAFB 0%, #ECEFF1 100%);
}

.book-placeholder i {
    margin-bottom: 0.5rem;
    font-size: 2.5rem;
}

.book-placeholder p {
    margin: 0;
    font-size: 0.8rem;
    font-weight: 600;
    text-align: center;
    line-height: 1.2;
}

.book-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(13, 71, 161, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: var(--transition);
}

.book-card:hover .book-overlay {
    opacity: 1;
}

.btn-detail {
    background: white;
    color: var(--primary-color);
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: var(--transition);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.btn-detail:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    color: var(--primary-color);
    text-decoration: none;
}

.book-info {
    padding: 1.5rem;
}

.book-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.badge-isbn {
    background: #ECEFF1;
    color: #455A64;
}

.badge-available {
    background: #E8F5E8;
    color: #2E7D32;
}

.badge-unavailable {
    background: #FFEBEE;
    color: #C62828;
}

.book-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #263238;
    margin: 0 0 1rem 0;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.book-details p {
    margin: 0.5rem 0;
    color: #607D8B;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.book-details i {
    color: #90A4AE;
    width: 16px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem;
    color: #607D8B;
    grid-column: 1 / -1;
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h3 {
    color: #455A64;
    margin-bottom: 0.5rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .search-box {
        flex-direction: column;
    }
    
    .search-filter {
        border-left: none;
        border-top: 1px solid #E0E7FF;
        width: 100%;
    }
    
    .card-header-custom {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .book-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
    }
    
    .stats-card {
        margin-bottom: 1rem;
    }
}

@media (max-width: 480px) {
    .book-grid {
        grid-template-columns: 1fr;
    }
    
    .search-container {
        padding: 1rem;
    }
    
    .card-body-custom {
        padding: 1rem;
    }
}

/* Animation for filtered results */
.book-card.fade-out {
    opacity: 0;
    transform: scale(0.8);
}

.book-card.fade-in {
    opacity: 1;
    transform: scale(1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchBook');
    const filterSelect = document.getElementById('filterStatus');
    const bookContainer = document.getElementById('bookContainer');
    const noResultsDiv = document.getElementById('noResults');
    const bookCards = document.querySelectorAll('.book-card');

    // Search and filter functionality
    function filterBooks() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusFilter = filterSelect.value;
        let visibleCount = 0;

        bookCards.forEach(card => {
            const title = card.dataset.title;
            const author = card.dataset.author;
            const isbn = card.dataset.isbn;
            const status = card.dataset.status;

            const matchesSearch = title.includes(searchTerm) || 
                                author.includes(searchTerm) || 
                                isbn.includes(searchTerm);
            
            const matchesStatus = !statusFilter || status === statusFilter;

            if (matchesSearch && matchesStatus) {
                card.style.display = 'block';
                card.classList.add('fade-in');
                card.classList.remove('fade-out');
                visibleCount++;
            } else {
                card.classList.add('fade-out');
                card.classList.remove('fade-in');
                setTimeout(() => {
                    card.style.display = 'none';
                }, 300);
            }
        });

        // Show/hide no results message
        if (visibleCount === 0) {
            noResultsDiv.style.display = 'block';
        } else {
            noResultsDiv.style.display = 'none';
        }
    }

    // Event listeners
    searchInput.addEventListener('input', filterBooks);
    filterSelect.addEventListener('change', filterBooks);
    // Add smooth scrolling to search results
    searchInput.addEventListener('focus', function() {
        this.parentElement.parentElement.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'center' 
        });
    });
});
</script>