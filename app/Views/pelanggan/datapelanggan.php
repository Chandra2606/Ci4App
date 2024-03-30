<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<!-- isi konten Start -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title">
            <?= $title ?>
        </h5>
    </div>
    <div class="card-body">
        <div class="buttons">
            <a href="<?= site_url('pelanggan/formtambah') ?>" class="btn btn-primary">Tambah Data</a>
        </div>
        <div class="table-responsive datatable-minimal mt-4">
            <table class="table table-hover" id="myTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Pelanggan</th>
                        <th>Nama Pelanggan</th>
                        <th>Alamat</th>
                        <th>No HP</th>
                        <th class="no-short">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detail-content">
                <!-- Detail pelanggan akan dimuat melalui AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- isi konten end -->
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: 'pelanggan/view',
            info: true,
            ordering: true,
            paging: true,
            order: [
                [0, 'desc']
            ],
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": ["no-short"]
            }],
        });

        $(document).on('click', '.btn-delete', function() {
            var kdplg = $(this).data('kdplg');

            Swal.fire({
                title: 'Apakah Anda yakin ingin menghapus data ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo route_to('pelanggan.delete'); ?>",
                        data: {
                            kdplg: kdplg
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.sukses) {
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: response.sukses,
                                    icon: 'success'
                                });
                                // Refresh DataTable
                                $('#myTable').DataTable().ajax.reload();
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Gagal menghapus data',
                                    icon: 'error'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal menghapus data',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    });

    $(document).on('click', '.btn-edit', function() {
        var kdplg = $(this).data('kdplg');
        window.location.href = "<?php echo site_url('pelanggan/edit/'); ?>" + kdplg;
    });

    $(document).on('click', '.btn-detail', function() {
        var kdplg = $(this).data('kdplg');
        $.ajax({
            type: "GET",
            url: "<?= site_url('pelanggan/detail/') ?>" + kdplg,
            dataType: 'html',
            success: function(response) {
                $('#detail-content').html(response);
                $('#detailModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Gagal memuat detail pelanggan');
            }
        });
    });
</script>
<?= $this->endSection() ?>