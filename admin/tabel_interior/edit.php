<?php
include '../../kon/koneksi.php';

$id = $_GET['id'];
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_interior WHERE id = $id"));

// Memisahkan fasilitas dari string menjadi array
$fasilitas = explode(',', $row['fasilitas']);

if (isset($_POST['submit'])) {
    $category = $_POST['category'];
    $type = $_POST['type'];
    $harga = $_POST['harga'];
    $fasilitas = $_POST['fasilitas'];
    $fasilitasStr = implode(',', $fasilitas);  // Menggabungkan array fasilitas menjadi string
    $nomor_whatsapp = $_POST['nomor_whatsapp'];
    $pesan_otomatis = $_POST['pesan_otomatis'];

    $sql = "UPDATE tb_interior SET category = '$category', type = '$type', harga = '$harga', fasilitas = '$fasilitasStr', 
            nomor_whatsapp = '$nomor_whatsapp', pesan_otomatis = '$pesan_otomatis' 
            WHERE id = $id"; // Menghapus koma setelah pesan_otomatis

    if (mysqli_query($conn, $sql)) {
        header('Location: index.php');
        exit(); // Pastikan untuk menghentikan eksekusi setelah redirect
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<?php include "../layout/header-admin.php"; ?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center">
            <h5>Edit Type Jasa Bangun</h5>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="category" class="form-label">Kategori:</label>
                    <select name="category" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Interior" <?= $row['category'] == 'Interior' ? 'selected' : ''; ?>>Interior</option>
                        <option value="Eksterior" <?= $row['category'] == 'Eksterior' ? 'selected' : ''; ?>>Eksterior</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Type:</label>
                    <input type="text" name="type" class="form-control" value="<?= $row['type']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga:</label>
                    <input type="text" name="harga" class="form-control" value="<?= $row['harga']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="fasilitas" class="form-label">Fasilitas:</label>
                    <div id="fasilitasContainer">
                        <?php foreach ($fasilitas as $fas) : ?>
                            <input type="text" name="fasilitas[]" class="form-control mb-2" value="<?= $fas; ?>" required>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" onclick="addFasilitasField()">Tambah Fasilitas</button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeFasilitasField()">Hapus Fasilitas</button>
                </div>

                <div class="mb-3">
                    <label for="nomor_whatsapp" class="form-label">Nomor WhatsApp:</label>
                    <input type="text" name="nomor_whatsapp" class="form-control" value="<?= $row['nomor_whatsapp']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="pesan_otomatis" class="form-label">Pesan Otomatis:</label>
                    <input type="text" name="pesan_otomatis" class="form-control" value="<?= $row['pesan_otomatis']; ?>" required>
                </div>

                <button type="submit" name="submit" class="btn btn-success btn-sm">Update</button>
            </form>
        </div>
    </div>
</div>

<?php include "../layout/footer-admin.php"; ?>

<script>
    function addFasilitasField() {
        var container = document.getElementById("fasilitasContainer");
        var input = document.createElement("input");
        input.type = "text";
        input.name = "fasilitas[]";
        input.placeholder = "Masukkan fasilitas";
        input.classList.add("form-control", "mb-2");
        container.appendChild(input);
    }

    function removeFasilitasField() {
        var container = document.getElementById("fasilitasContainer");
        if (container.children.length > 1) {
            container.removeChild(container.lastChild);
        }
    }
</script>