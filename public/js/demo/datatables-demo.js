// Call the dataTables jQuery plugin
$(document).ready(function() {
    $('#dataTable').DataTable();
});

$(document).ready(function() {
    $('#pengeluaran').DataTable({
        paging: false,
    });
});

$(document).ready(function() {
    $('#harga_paket').DataTable({
        paging: false,
    });
});

$(document).ready(function() {
    $('#booking').DataTable({
        ordering: true, // Mengaktifkan pengurutan
        scrollX: true, // Mengaktifkan scroll horizontal
        paging: false, // Mengaktifkan pagination
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ], // Pilihan entri per halaman
        fixedColumns: {
            leftColumns: 4 // Mengunci 4 kolom pertama
        },
        // columnDefs: [
        //     { orderable: false, targets: [0, 1, 2, 3] } // Menonaktifkan sorting hanya pada kolom tertentu
        // ]
    });
});



$(document).ready(function() {
    $('#pesanan').DataTable({
        ordering: true, // Menonaktifkan fitur pengurutan
        scrollX: true, // Mengaktifkan horizontal scrolling
        paging: false, // Mengaktifkan pagination
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        fixedColumns: {
            left: 4 // Mengunci 3 kolom pertama agar tetap terlihat saat di-scroll
        }
        // scrollY: 300, // Mengatur tinggi tabel
    });
});