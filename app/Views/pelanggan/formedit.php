<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="card">
    
    <div class="card-header">
        <h5 class="card-title">Form Edit Pelanggan</h5>
    </div>
    <div class="card-body">
        <?= form_open('pelanggan/update', [
            'id' => 'formedit'
        ]) ?>
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="kdplg" value="<?= $pelanggan['kdplg'] ?>">

        <div class="form-group">
            <label for="namaplg" class="form-label">Nama Pelanggan</label>
            <input type="text" class="form-control" id="namaplg" name="namaplg" value="<?= $pelanggan['namaplg'] ?>">
            <div id="error_namaplg" class="invalid-feedback"></div>
        </div>

        <div class="form-group">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="4"><?= $pelanggan['alamat'] ?></textarea>
            <div id="error_alamat" class="invalid-feedback"></div>
        </div>

        <div class="form-group">
            <label for="nohp" class="form-label">No HP</label>
            <input type="text" class="form-control" id="nohp" name="nohp" value="<?= $pelanggan['nohp'] ?>">
            <div id="error_nohp" class="invalid-feedback"></div>
        </div>

        <button type="submit" id="tombolUpdate" class="btn btn-primary">Simpan Perubahan</button>
        <a class="btn btn-secondary" href="<?= base_url() ?>/pelanggan">Kembali</a>
        <?= form_close() ?>
    </div>
</div>
<!-- isi konten end -->
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(function() {
        $('#formedit').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('#tombolUpdate').html('<i class="fas fa-spin fa-spinner"></i> Tunggu');
                    $('#tombolUpdate').prop('disabled', true);
                },

                complete: function() {
                    $('#tombolUpdate').html('Simpan Perubahan');
                    $('#tombolUpdate').prop('disabled', false);
                },

                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.error_namaplg) {
                            $('.error_namaplg').html(err.error_namaplg);
                            $('#namaplg').addClass('is-invalid');
                        } else {
                            $('.error_namaplg').html();
                            $('#namaplg').removeClass('is-invalid');
                            $('#namaplg').addClass('is-valid');
                        }

                        if (err.error_alamat) {
                            $('.error_alamat').html(err.error_alamat);
                            $('#alamat').addClass('is-invalid');
                        } else {
                            $('.error_alamat').html();
                            $('#alamat').removeClass('is-invalid');
                            $('#alamat').addClass('is-valid');
                        }

                        if (err.error_nohp) {
                            $('.error_nohp').html(err.error_nohp);
                            $('#nohp').addClass('is-invalid');
                        } else {
                            $('.error_nohp').html();
                            $('#nohp').removeClass('is-invalid');
                            $('#nohp').addClass('is-valid');
                        }

                    }

                    if (response.sukses) {
                        toastr.success('Data Berhasil DiUpdate')
                        setTimeout(function() {
                            window.location.href = '<?= site_url('/pelanggan') ?>';
                        }, 1500);
                    }

                },

                error: function(e) {
                    alert('Error \n' + e.responseText);
                }
            });

            return false;
        });
    });
</script>
<?= $this->endSection() ?>