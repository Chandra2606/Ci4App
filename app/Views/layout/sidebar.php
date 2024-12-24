 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="<?php base_url() ?>assets/index3.html" class="brand-link">
         <img src="<?php base_url() ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
         <span class="brand-text font-weight-light">AdminLTE 3</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 <img src="<?php base_url() ?>assets/dist/img/<?= user()->foto ?>" class="img-circle elevation-2" alt="User Image">
             </div>
             <div class="info">
                 <a href="#" class="d-block"><?= user()->fullname ?></a>
             </div>
         </div>

         <!-- SidebarSearch Form -->
         <div class="form-inline">
             <div class="input-group" data-widget="sidebar-search">
                 <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                 <div class="input-group-append">
                     <button class="btn btn-sidebar">
                         <i class="fas fa-search fa-fw"></i>
                     </button>
                 </div>
             </div>
         </div>

         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                 <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                 <?php if (in_groups('admin')) : ?>
                     <li class="nav-item">
                         <a href="/dashboard" class="nav-link">
                             <i class="nav-icon fas fa-tachometer-alt"></i>
                             <p>
                                 Dashboard
                                 <i class="right fas fa-angle-left"></i>
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="<?php base_url() ?>/pelanggan" class="nav-link">
                             <i class="nav-icon fas fa-user"></i>
                             <p>
                                 Pelanggan
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="<?php base_url() ?>/user" class="nav-link">
                             <i class="nav-icon fas fa-user"></i>
                             <p>
                                 List User
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="<?php base_url() ?>/laporan" class="nav-link">
                             <i class="nav-icon fas fa-book"></i>
                             <p>
                                 Laporan
                             </p>
                         </a>
                     </li>
                 <?php endif; ?>
                 <?php if (in_groups('pimpinan')) : ?>
                     <li class="nav-item">
                         <a href="<?php base_url() ?>/laporan" class="nav-link">
                             <i class="nav-icon fas fa-book"></i>
                             <p>
                                 Laporan
                             </p>
                         </a>
                     </li>
                 <?php endif; ?>
                 <li class="nav-item">
                     <a href="#" class="nav-link logout">
                         <i class="nav-icon fas fa-sign-out-alt"></i>
                         <p>
                             Keluar
                         </p>
                     </a>
                 </li>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>