<?php

$cek_username_ks = $koneksi->query("SHOW COLUMNS FROM kas_sosial LIKE 'username_ks'");
if ($cek_username_ks && $cek_username_ks->num_rows == 0) {
    $koneksi->query("ALTER TABLE kas_sosial ADD COLUMN username_ks VARCHAR(50) NOT NULL DEFAULT ''");
}
?>