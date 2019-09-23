<?php
/* Template Name: Change PassWord*/
if(!is_user_logged_in()) {
    wp_redirect(home_url('/'));
}
get_header();?>
<div class="main_box center_box_1 animated fadeIn">
   <div class="container">
      <div class="center_box text-center">
         <div class="center_title text-left">
            <h2 class="text-light">Quản lý tài khoản
               <span class="fr" id="btn_edit" onclick="saveInfo()" style="display: inline;">Lưu</span>
            </h2>
         </div>
         <div class="center_cnt">
            <div class="row">
               <div class="col-5">
                  <div class="grid-content text-center left_user">
                     <div class="avatar-uploader">
                        <span>Cập nhật</span>
                        <?php
                            $user_id = get_current_user_id();
                            $user = get_user_by('id',$user_id);
                            $imgdefault = HENTAI_URL.'/img/user1.png';
                            $img = get_user_meta($user_id,'avatar',true);
                            $userimg = $img != ''? $img: $imgdefault;
                        ?>
                        <img src="<?php echo $userimg;?>" alt="user">
                        <input type="file" name="file" class="el-upload__input" id="imgFile">
                     </div>
                     
                     <hr>
                     <div class="liker">
                        <a href="<?php echo home_url('/').'my-playlist';?>"><img src="<?php echo HENTAI_URL.'/img/rect.png';?>" alt="dsp">Danh sách phát của tôi</a>
                     </div>
                  </div>
               </div>
               <div class="col-7 step1">
                  <div class="grid-content">
                    <?php
                        $error = '';
                        $success = '';
                        if(isset($_POST['rnpassword'])) {
                            $oldpass = $_POST['password'];
                            $newpass = $_POST['npassword'];
                            $rnewpass = $_POST['rnpassword'];
                            if(!empty($oldpass)) {
                                if(wp_check_password($oldpass,$user->data->user_pass,$user->ID)) {
                                    if(!empty($newpass) && !empty($rnewpass)) {
                                        if($newpass === $rnewpass) {
                                            if(wp_set_password( $newpass, $user->ID )) {
                                                $error = 'Có Lỗi Xảy Ra';
                                            } else {
                                                $success = 'Đổi Mật Khẩu Thành Công';
                                            }
                                        } else {
                                            $error = 'Mật Khẩu Nhập Lại Không Trùng Khớp';
                                        }
                                    }else {
                                        $error = 'Mật Khẩu Mới Không Được Để Trống';
                                    }
                                }else {
                                    $error = 'Mật Khẩu Hiện Tại Không Đúng';
                                }
                            }
                        
                        }

                        if($error != '') echo '<p class="error">'.$error.'</p>';
                        if($success != '') echo '<p class="success">'.$success.'</p>';
                    ?>
                     
                     <form class="user_info text-left" id="step2" method="POST" action="<?php echo  $_SERVER['REQUEST_URI'];?>">
                        <div class="info_list"><span class="title">Mật Khẩu Cũ</span><input type="password" name="password" value="" class="cnt"></div>
                        <div class="info_list"><span class="title">Mật Khẩu Mới</span><input type="password" name="npassword" value="" class="cnt"></div>
                        <div class="info_list"><span class="title">Nhập Lại Mật Khẩu Mới</span><input type="password" name="rnpassword" value="" class="cnt"><i class="el-icon-key"></i></div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
    var nonce = "<?php echo wp_create_nonce('hentaivn');?>";
    jQuery(document).ready(function($) {
        $('#imgFile').change(function(e) {
            var file = e.target.files[0];
            var name = file.name;
            var type = name.split('.');
            
            if($.inArray(type[1],['gif','png','jpg','jpeg']) == -1) {
                alert('Không Đúng Định Dạng Ảnh');
            } else {
                var Fdata = new FormData();
                Fdata.append('file',file);
                Fdata.append('nonce',nonce);
                Fdata.append('uid',<?php echo get_current_user_id();?>);
                Fdata.append('action','hentaivn_upload_avatar');
                $.ajax({
                    type:'POST',
                    url: '<?php echo admin_url('admin-ajax.php');?>',
                    dataType:'json',
                    data:Fdata,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        console.log(data);
                        if(data.status === 'ok') {
                            var img = data.img;
                            $('.avatar-uploader img').attr('src',img);
                            $('.nav-link.dropdown-toggle.text-light img').attr('src',img);
                        } else {
                            var error = data.error;
                            alert(error);
                        }
                    }
                })
            }
        });
    });
    function saveInfo() {
        jQuery('form#step2').submit();
    }
</script>
<?php get_footer();?>