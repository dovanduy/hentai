<?php
/* Template Name: Image Gallery */

get_header();?>

<div class="search_box" id="gallery">
    <div class="title">Thư Viện Ảnh</div>
    <div class="search_cnt">
        <ul class="cnt_box" v-if="images.length">
            <li v-for="(img,index) in images" :key="index">
                <img :src="img" alt="img" width="100%" @click="openDialog(img)">
            </li>
            
        </ul>
    </div>
    <div id="ampagination-bootstrap" >
        <ul class="pagination" v-if="pageNumber.length">
            <li v-for="(page,index) in pageNumber" :key="index" :class="page == currentPage ? 'active':''">
                <a href="javascript:;" @click="updatePage(page)">{{page}}</a>
            </li>
        </ul>
    </div>
    <div class="dialog_pic" v-if="isDialogOpen && currentPic !=''">
        <div class="pic_box">
            <div class="close" @click="closeDialog()">×</div>
            <div class="pic_img"><img :src="currentPic" alt="img"></div>
        </div>
    </div>
</div>
<script>

    const Gallery = new Vue({
        el:'#gallery',
        data: {
            galleries:[],
            currentPage:1,
            picPerPage:25,
            isDialogOpen: false,
            currentPic:''
        },
        methods: {
            async getGallery() {
                let data = new FormData;
                data.append('action','get_gallery_vue');
                data.append('nonce','<?php echo wp_create_nonce('hentaivn');?>');

                const res = await axios.post('<?php echo admin_url('admin-ajax.php');?>',data);
                if(res.data) {
                    this.galleries = res.data;
                }
            },
            pagination(c, m) {
                var current = c,
                    last = m,
                    delta = 2,
                    left = current - delta,
                    right = current + delta + 1,
                    range = [],
                    rangeWithDots = [],
                    l;

                for (let i = 1; i <= last; i++) {
                    if (i == 1 || i == last || i >= left && i < right) {
                        range.push(i);
                    }
                }

                for (let i of range) {
                    if (l) {
                        if (i - l === 2) {
                            rangeWithDots.push(l + 1);
                        } else if (i - l !== 1) {
                            rangeWithDots.push('...');
                        }
                    }
                    rangeWithDots.push(i);
                    l = i;
                }

                return rangeWithDots;
            },
            updatePage(number) {
                if(number == '...') return;
                this.currentPage = number;
            },
            openDialog(img) {
                this.isDialogOpen = true;
                this.currentPic = img;
            },
            closeDialog() {
                this.isDialogOpen = false;
                this.currentPic = '';
            }
        },
        created() {
            this.getGallery();
        },

        computed: {
            images() {
                let cur = this.currentPage;
                let total = this.picPerPage;
                let c = parseInt((cur -1)*total);
                let m = parseInt(total*cur);
                return this.galleries.slice(c,m);
            },
            pageNumber() {
                if(this.picPerPage > this.galleries.length ) return [];
                var totalpage = Math.ceil(this.galleries.length / this.picPerPage);
                return this.pagination(this.currentPage, totalpage);
            }
        }

    });


</script>

<?php get_footer();?>