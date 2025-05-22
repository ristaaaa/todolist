<?php
session_start();
include 'functions.php';

// Inisialisasi jika belum ada
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

$tasks = $_SESSION['tasks'];

// Tambah tugas baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['judul'])) {
    $judul = trim($_POST['judul']);
    if (!empty($judul)) {
        $tasks[] = ['judul' => $judul, 'status' => 'belum'];
    }
}

// Ubah status tugas (selesai <-> belum)
if (isset($_POST['toggle_index'])) {
    $i = (int) $_POST['toggle_index'];
    if (isset($tasks[$i])) {
        $tasks[$i]['status'] = $tasks[$i]['status'] === 'selesai' ? 'belum' : 'selesai';
    }
}

// Hapus tugas
if (isset($_POST['hapus_index'])) {
    $i = (int) $_POST['hapus_index'];
    if (isset($tasks[$i])) {
        unset($tasks[$i]);
        $tasks = array_values($tasks); // reset index array
    }
}

// Simpan ke session
$_SESSION['tasks'] = $tasks;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>To Do Listttt Ristaaa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <header class="text-center mb-4">
        <h1 class="text-primary">To Do Listttt Ristaaaa</h1>
        <p class="text-muted">Gunakan centang untuk menandai selesai dan tombol untuk menghapus tugas.</p>
    </header>

    <!-- Form tambah tugas -->
    <div class="card">
        <div class="card-body">
            <form method="post" class="d-flex gap-2">
                <input type="text" name="judul" class="form-control" placeholder="Tulis tugas baru..." required>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
        </div>
    </div>

    <!-- Tabel daftar tugas -->
    <?php tampilkanDaftar($tasks); ?>
</div>

</body>
</html>