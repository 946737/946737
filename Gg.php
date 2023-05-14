<?php
session_start();
$guest = true;

require_once '../mainconfig.php';

$query_slide = mysqli_query($db, "SELECT * FROM slider WHERE posisi = 'Guest'");
require_once '../layouts/headeruser.php';
?>

<div class="content">
<div class="header">
<img src="https://junaastore.com/assets/1678711180_64011f9823106a9a53ea.png" alt="">
</div>
	<?php if (mysqli_num_rows($query_slide) !== 0): ?>
        <div class="row justify-content-center">
    	    <div class="col-md-8 col-12">
    	        <?php if($_SESSION['user']['username'] == "" || $_SESSION['user']['level'] == ""):?>
    	        <?php else:?>
    	        <div class="alert alert-success" role="alert">
                    <a href="#" class="close mt-0 ml-0 mr-2 text-danger" data-dismiss="alert" aria-label="close"><b>×</b></a>
                    <div class="alert-body">
                        <small>Hai <?= $_SESSION['user']['username'];?> <br>
                        WhatsApp Group
                            <a href="https://wa.me/6283809200616" target="_blank"> Klik Disini Untuk Bergabung<br></a>
                            Telegram Group <a href="https://t.me/" target="_blank" > Klik Disini Untuk Bergabung</a>
                        </small>
                    </div>
                </div>
                <?php endif;?>
                <div class="row justify-content-center">
    	        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <?php $no = 1; while($fetch_slide = mysqli_fetch_assoc($query_slide)): ?>
                        <div style="padding:20px;" class="carousel-item <?= $no == 1 ? 'active' : ''; ?>">
                    		<a href="../assets/slide/<?= $fetch_slide['img']; ?>" class="image-popup">
                    			<img style="border-radius:15px; box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;" class="d-block img-fluid" src="../assets/slide/<?= $fetch_slide['img']; ?>">
                    		</a>
                    	</div>
                    	<a  style="width:20%;" class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                             </a>
                                <a  style="width:20%;" class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                    	<?php $no++; endwhile; ?>
                    </div>
                </div>
                </div>
    	    </div>
        </div>
    <?php endif; ?>
            <div class=" row justify-content-center">
                <div class="col-12 col-md-8">
                    <?php if(!$_SESSION['user']['level'] == ""):?>
                    <div class="col-12">
                    <div class="formss shadow">
                        <div class="formss-body pb-0">
                            <div class="row">   
                                <div class="col text-center">
                                    <p>Rp <?= number_format($_SESSION['user']['saldo'],0,',','.');?><br><small class="text-mute"><b>Saldo</b></small></p>
                                </div>
                                <div class="col text-center">
                                <p><?= $_SESSION['user']['level'];?><br><small class="text-mute"><b>Level</b></small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <br>
                    <?php endif;?>
                <ul class="nav nav-pills nav-fill horitab-scroll nav-justified" role="tablist">
                <?php $menu = $db->query("SELECT DISTINCT * FROM games_kategori WHERE kategori_id='0' ORDER BY urutan ASC");
                while($kat = $menu->fetch_assoc()):
                $cuk = mysqli_query($db, "SELECT * FROM games_guest WHERE category = '".$sub['sub_kategori']."' ORDER BY urutan DESC");?>
                <?php $te = str_replace(' ', '', $kat['kategori']);?>
                <?php if($cuk->num_row !== 0):?>
                <?php if($kat['kategori'] == 'Games'):?>
                    <li class="nav-item ml-1 mr-1">
                        <a class="nav-link active" data-toggle="tab" href="#Games">Games</a>
                    </li>
                <?php else:?>
                <li class="nav-item ml-1 mr-1">
                        <a class="nav-link" data-toggle="tab" href="#<?= $te;?>"><?= $kat['kategori'];?></a>
                    </li>
                <?php endif?>
                <?php endif;?>
                <?php endwhile;?>
                </ul>
                </div>
                <div class="col-12 col-md-8">
                <div class="tab-content ml-1">
            <?php
            $query_games_kategori = mysqli_query($db, "SELECT DISTINCT * FROM games_kategori WHERE kategori_id='' ORDER BY urutan DESC");
            while($cat = mysqli_fetch_assoc($query_games_kategori)):?>
            <?php $te = str_replace(' ', '', $cat['kategori']);?>
            <?php if($cat['kategori'] == 'Games'):?>
                <div id="<?= $cat['kategori'];?>" class="tab-pane active">
            <?php else:?>
            <div id="<?= $te;?>" class="tab-pane fade">
            <?php endif;?>
            <?php
            $sub = $db->query("SELECT * FROM games_kategori WHERE kategori_id='".$cat['id']."' ORDER BY urutan ASC");
            while($subs = $sub->fetch_assoc()):?>
            <h5><?=$subs['kategori'];?></h5>
            <span class="d-block mb-1" style="background:#b19973;width: 65px;height: 5px;border-radius: 10px;"></span>
                <?php
                $query_games = mysqli_query($db, "SELECT * FROM games_guest WHERE category = '".$subs['kategori']."' ORDER BY urutan DESC");
                while($fetch_games = mysqli_fetch_assoc($query_games)): 
                ?>
                <?php if ($fetch_games['status'] == 'On'): ?>
                <div class="daftar-games">
                <div class="card ml-0 mr-0">
                <div class="card-body p-0">
                    <a href="<?= base_url(); ?>id/product/<?= $fetch_games['slug']; ?>">
                        <img src="/assets/games/<?= $fetch_games['img']; ?>" class="mt-0">
                        <div class="clip-path"></div>
                        
                        <small class="cg-4-title text-sm"><?= $fetch_games['name']; ?></small>       
                    </a>
                </div>
                </div>
                </div>
                <?php endif; ?>
                <?php endwhile;?>
                <?php endwhile; ?>
            </div>
            <?php endwhile; ?>
            </div>
            </div>
	</div>
<br>
<br>
<?php 
include_once '../layouts/footeruser.php'; ?>
<?php if (opt_get('cG9wdXBfZ3Vlc3Rfc3RhdHVz') == 'On'): ?>
<div class="modal fade" id="modal-info" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
                <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalScrollableTitle"><i class="fas fa-info-circle"></i> Pengumuman</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
            <div class="modal-body">                                            
            <img src="<?= opt_get('cG9wdXBfZ3Vlc3RfbGluaw=='); ?>" class="w-100">
            
<br><h5>Informasi</h5>
<div class="text-center text-danger">
<P>SOURCE CODE INI DI JUAL JIKA BERMINAT HUBUNGI ADMIN UREEXCODE</p>
</div>
<p> Halo semua Ini adalah website Demo dari Youtube UREEXCODE, Jika Anda Berminat Dengan Source code ini Silahkan Untuk Chat Whatsapp Kami , Jika Ada Orang Yang Mencantumkan web ini sebagai demo dari mereka Harap Berhati Hati, Kami Tidak Bertanggung Jawab Jika Anda Bukan Membeli Kepada Kami Dan Anda Tidak Akan Mendapat Update Source code kedepan nya</p>
<div class="text-center">
<a href="https://wa.me/6285935290187" class="btn btn-primary">Beli Source Code</a>
</div>

<br><p class="text-primary"><small><?= config('web','title_web');?></p></small>

            <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary text-right" data-dismiss="modal">Tutup</button>
                                                        </div>
        </div>
    </div>
</div>
<script>
    $("#modal-info").modal('show');
</script>
<?php endif; ?>
