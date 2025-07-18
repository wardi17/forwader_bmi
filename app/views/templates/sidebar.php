
<?php 
$log_fin = (isset($_SESSION["log_fin"]))? $_SESSION["log_fin"] : '';
$log_fam = (isset($_SESSION["log_fam"]))? $_SESSION["log_fam"] : '';

$level_us = (isset($_SESSION["level_user"]))? $_SESSION["level_user"] : '';
$level3 = (isset($_SESSION["level3"]))? $_SESSION["level3"] : '';
$page = (isset($data['page']))? $data['page'] : '';
$pages = (isset($data['pages']))? $data['pages'] : '';

?>

<div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
            <div class="sidebar-header position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="logo">
                        <h5><a href="<?=base_url?>/home"><?=$_SESSION['login_user']?></a><h5>
                    </div>
                    <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                        <div class="form-check form-switch fs-6">
                            <input class="  me-0" type="hidden" id="toggle-dark" >
                        </div>
                    </div>
                    <div class="sidebar-toggler  x">
                        <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            </div>
    <div class="sidebar-menu">
  
       
        <ul  class="menu">
            <li class="sidebar-title">Menu Forwader</li>
            <li
                class="sidebar-item <?php  if ($pages == 'home') {echo 'active'; }else { echo ''; } ?> ">
                <a  href="<?= base_url; ?>/home" class='sidebar-link'>
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>
          
            <li 
                class="sidebar-item   <?php if ($pages == 'trans') {echo 'active';} else {echo'';} ?>  " aria-current="page" >
                <a href="<?= base_url; ?>/import"  class='sidebar-link'>
                <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Import</span>
                </a>    

            </li>
           <li class="sidebar-item   <?php if ($pages == 'put') {echo 'active';} else {echo'';} ?>  " aria-current="page" >
                <a href="<?= base_url; ?>/import/put"  class='sidebar-link'>
                <i class="fa-solid fa-hotel"></i>
                    <span>Posted</span>
                </a>
            </li>
            <li 
                class="sidebar-item   <?php if ($pages == 'lapimport') {echo 'active';} else {echo'';} ?>  " aria-current="page" >
                <a href="<?= base_url; ?>/laporanimport"  class='sidebar-link'>
                <i class="fa-solid fa-folder"></i>
                    <span>Laporan Import</span>
                </a>    
            </li>
            <!-- <li 
                class="sidebar-item   <?php if ($pages == 'dinamiq') {echo 'active';} else {echo'';} ?>  " aria-current="page" >
                <a href="<?= base_url; ?>/laporan/semesterdinamiq"  class='sidebar-link'>
                <i class="fa-solid fa-folder"></i>
                    <span>Laporan Per 6 Bulan</span>
                </a>    
            </li> -->
           
        </ul>
        
        <ul class ="menu">
        <li
                class="sidebar-item" aria-current="page">
                <a  href="<?= base_url; ?>/logout" class='sidebar-link'>
                <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Sign Out</span>
                </a>
            </li> 
        </ul>
    
    </div>
</div>