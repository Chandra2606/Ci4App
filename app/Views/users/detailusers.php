<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="<?= base_url() ?>assets/dist/img/<?= $users->foto; ?>" alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center"><?= $users->fullname; ?> (<?= $users->username; ?>)</h3>

                    <p class="text-muted text-center"><?= $users->email; ?></p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Status Akun</b>
                            <a class="float-right">
                                <?= $users->aktif == 1 ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Tidak Aktif</span>'; ?>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>Role </b> <a class="float-right"><?= $users->name; ?></a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
<?= $this->endSection() ?>