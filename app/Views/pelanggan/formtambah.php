<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Tambah Data Pelanggan</h3>
            </div>
            <div class="card-body">
                <?= form_open('pelanggan/save', ['id' => 'formpelanggan']) ?>
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="kdplg">Kode Pelanggan</label>
                    <input type="text" id="kdplg" name="kdplg" class="form-control">
                    <div class="invalid-feedback error_kdplg"></div>
                </div>
                <div class="form-group">
                    <label for="namaplg">Nama Pelanggan</label>
                    <input type="text" id="namaplg" name="namaplg" class="form-control">
                    <div class="invalid-feedback error_namaplg"></div>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-control" rows="4"></textarea>
                    <div class="invalid-feedback error_alamat"></div>
                </div>
                <div class="form-group">
                    <label for="nohp">No Handphone</label>
                    <input type="text" id="nohp" name="nohp" class="form-control">
                    <div class="invalid-feedback error_nohp"></div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-success" id="tombolSimpan">
                            <i class="fas fa-save"></i> SIMPAN
                        </button>
                        <a class="btn btn-secondary" href="<?= base_url() ?>/pelanggan">Kembali</a>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(function() {
        $('#formpelanggan').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('#tombolSimpan').html('<i class="fas fa-spin fa-spinner"></i> Tunggu');
                    $('#tombolSimpan').prop('disabled', true);
                },

                complete: function() {
                    $('#tombolSimpan').html('<i class="fas fa-save"></i> Simpan');
                    $('#tombolSimpan').prop('disabled', false);
                },

                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.error_kdplg) {
                            $('#kdplg').addClass('is-invalid').removeClass('is-valid');
                            $('.error_kdplg').html(err.error_kdplg);
                        } else {
                            $('#kdplg').removeClass('is-invalid').addClass('is-valid');
                            $('.error_kdplg').html('');
                        }

                        if (err.error_namaplg) {
                            $('#namaplg').addClass('is-invalid').removeClass('is-valid');
                            $('.error_namaplg').html(err.error_namaplg);
                        } else {
                            $('#namaplg').removeClass('is-invalid').addClass('is-valid');
                            $('.error_namaplg').html('');
                        }

                        if (err.error_alamat) {
                            $('#alamat').addClass('is-invalid').removeClass('is-valid');
                            $('.error_alamat').html(err.error_alamat);
                        } else {
                            $('#alamat').removeClass('is-invalid').addClass('is-valid');
                            $('.error_alamat').html('');
                        }

                        if (err.error_nohp) {
                            $('#nohp').addClass('is-invalid').removeClass('is-valid');
                            $('.error_nohp').html(err.error_nohp);
                        } else {
                            $('#nohp').removeClass('is-invalid').addClass('is-valid');
                            $('.error_nohp').html('');
                        }
                    }

                    if (response.sukses) {
                        toastr.success('Data Berhasil Disimpan')
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