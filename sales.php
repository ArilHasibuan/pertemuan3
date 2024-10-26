<?php
session_start();

// Inisialisasi array transaksi jika belum ada
if (!isset($_SESSION['transactions'])) {
    $_SESSION['transactions'] = [];
}

// Proses data yang dikirimkan dari form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['reset'])) {
        // Menghapus semua transaksi
        unset($_SESSION['transactions']);
    } else {
        // Menyimpan transaksi baru
        $productName = $_POST['productName'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        $transaction = [
            'productName' => $productName,
            'price' => $price,
            'quantity' => $quantity,
            'total' => $price * $quantity
        ];

        $_SESSION['transactions'][] = $transaction;
    }

    header("Location: sales.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">.
    <title>Data Penjualan Toko</title>
</head>
<body>
    <h1>Form Data Penjualan</h1>
    <form action="sales.php" method="post">
        <label for="productName">Nama Produk :</label>
        <input type="text" id="productName" name="productName" placeholder="Masukkan Nama Produk" required><br>
        
        <label for="price">Harga :</label>
        <input type="number" id="price" name="price" placeholder="Masukkan Harga Produk" required><br>
        
        <label for="quantity">Jumlah Terjual :</label>
        <input type="number" id="quantity" name="quantity" placeholder=" Masukkan Jumlah terjual" required><br>
        
        <button type="submit">Simpan</button>
        <button type="submit" name="reset">Reset Data</button>
    </form>

    <h3>*Jika anda ingin mengisi ulang semua data, gunakan tombol reset dan jangan lupa untuk mengisi (apapun) disetiap kolom input yang ada</h3>
    <hr>
    
    <h2>Laporan Penjualan</h2>
    <table border="1">
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Jumlah Terjual</th>
            <th>Total Penjualan</th>
        </tr>
        <?php
        $totalSales = 0;

        if (isset($_SESSION['transactions'])) {
            foreach ($_SESSION['transactions'] as $transaction) {
                echo "<tr>
                        <td>{$transaction['productName']}</td>
                        <td>{$transaction['price']}</td>
                        <td>{$transaction['quantity']}</td>
                        <td>{$transaction['total']}</td>
                      </tr>";
                $totalSales += $transaction['total'];
            }
        }

        echo "<tr>
                <td colspan='3'>Total Penjualan</td>
                <td>{$totalSales}</td>
              </tr>";
        ?>
    <hr>

    </table>
</body>
</html>
