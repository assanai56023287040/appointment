<html lang="en">
<head>

  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  	<title>ระบบนัดหมายออนไลน์</title>
    <?php 
    	$this->load->view('css/mycss');
    	$this->load->view('css/admincss');
    ?>
  	<!-- <style type="text/css">
        html{
            height: 100%;
        }
  		body {
  			/* min-height: 100%; */
  			background-image: linear-gradient(to bottom, #e9e9e9, #e6e6e6, #e2e2e2, #dfdfdf, #dcdcdc, #d6d6d6, #d0d0d0, #cacaca, #c0c0c0, #b5b5b5, #ababab, #a1a1a1);
  		}

  	</style> -->
    
</head>
<body id="page-top" class="admin-page">
<!-- <div id="app"> -->
  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <!-- <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div> -->
        <div class="sidebar-brand-icon"><!-- rotate-n-15 -->
          <i class="far fa-flag"></i>
        </div>
        <div class="sidebar-brand-text mx-3">เจ้าหน้าที่</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard --> 
      <li class="nav-item" :class="{active : currentpage == 'home'}">
        <a class="nav-link" @click="changepage('home')">
          <i class="fas fa-home"></i>
          <span>หน้าหลัก</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        จัดการข้อมูล
      </div>

      <li class="nav-item" :class="{active : currentpage == 'apmlist'}">
        <a class="nav-link" @click="changepage('apmlist')">
          <i class="far fa-list-alt"></i>
          <span>รายการขอทำนัด</span></a>
      </li>

      <li class="nav-item" :class="{active : currentpage == 'dctschedule'}">
        <a class="nav-link" @click="changepage('dctschedule')">
          <i class="fas fa-calendar-alt"></i>
          <span>ตารางออกตรวจแพทย์</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        รายงาน
      </div>

      <li class="nav-item" :class="{active : currentpage == 'report'}">
        <a class="nav-link" @click="changepage('report')">
          <i class="fas fa-folder-open"></i>
          <span>รายงาน</span>
        </a>
      </li>

      <hr class="sidebar-divider">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                    <div class="small text-gray-500">Jae Chun · 1d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Valerie Luna</span>
                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" @click="logout()">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <section id="home" v-show="currentpage == 'home'">
        <div class="container-fluid">

          <!-- Page Heading -->
          <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">หน้าหลัก</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
          </div> -->

          <!-- Content Row -->
          <div class="row mt-4">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2" @click="changepage('apmlist')">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <!-- <div class="text-xs font-weight-bold text-gray-800 text-uppercase mb-1">Earnings (Monthly)</div> -->
                      <div class="h5 mb-0 font-weight-bold text-primary">รายการขอทำนัด</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2" @click="changepage('dctschedule')">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <!-- <div class="text-xs font-weight-bold text-success text-gray-800 text-uppercase mb-1">Earnings (Annual)</div> -->
                      <div class="h5 mb-0 font-weight-bold text-success">ตารางออกตรวจแพทย์</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-table fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            

          </div>

          <div class="row mt-4">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2" @click="changepage('report')">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <!-- <div class="text-xs font-weight-bold text-gray-800 text-uppercase mb-1">Tasks</div> -->
                          <div class="h5 mb-0 mr-3 font-weight-bold text-warning">รายงาน</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-folder-open fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>
        </section>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal" >Cancel</button>
          <button class="btn btn-primary" type="button" @click="logout()">Logout</button>
        </div>
      </div>
    </div>
  </div>

<!-- </div> end off div app -->


<?php
	$this->load->view('js/myjs');
	$this->load->view('js/adminjs');
?>
<script type="text/javascript">

	var app = new Vue({
		el: '#wrapper',
		data: {
			homepage: false,
			tt: 'XXXXX Test XXXXX',
			// for form search
			skeyword: '',
			sfdate: '',
			stdate: '',
			apmlist: [],
      currentpage: '',
		},
		methods: {
			onlyShowModal(modal_id){
				$('#'+modal_id).modal();
			},
			showHomePage(){
				this.homepage = true;
        this.currentpage = 'home';
			},
			showLoginForm(){
				window.location = "<?php echo site_url('login'); ?>";
			},
			activeDatePicker(){
				$('.datepicker').datepicker({
						language:'th-th',
						format:'dd/mm/yyyy',	
						autoclose: true,
						todayHighlight: true,
				});

				// $('#apmdate').datepicker()
				// 	.on('hide', v =>{
				// 		this.newapm.apmdate = $('#apmdate').val();
				// 	});
			},
			clearForm(type){
				switch(type){

				}
			},
			emSignin(){
				$('#em-sign').modal('hide');
				Swal.fire({
	                title: "กำลังตรวจสอบข้อมูล กรุณารอสักครู่...",
	                allowOutsideClick: false,	
	            });
	            Swal.showLoading();
	            axios.get("<?php echo site_url('login/emSignin'); ?>",{
	            	params : {
	            		uid: this.adminusername
	            		,pwd: this.adminpassword
	            	}
	            }).then(res => {
	            	console.log(res);
	            	Swal.close();
	            	res = res.data;

	            	if(res.success){
	            		Swal.fire({
						  type: 'success',
						  title: 'เข้าสู่ระบบเสร็จสิ้น',
						  text: 'กรุณารอสักครู่.....',
						  confirmButtonText: '',
						  timer: 2000,
						  showConfirmButton: false,
		                  allowOutsideClick: false,
						}).then(() => {
							window.location = "<?php echo site_url('employee'); ?>";
						});
	            	}else{
	            		Swal.fire({
						  type: 'error',
						  title: 'ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง!',
						  confirmButtonText: 'ปิด'
						});
	            	}
	            });
			},
			logout(){
				Swal.fire({
					title: 'ยืนยันการออกจากระบบ?'
					// text: "You won't be able to revert this!",
					,type: 'warning'
					,showCancelButton: true
					,confirmButtonColor: '#dd3333'
					,confirmButtonText: 'ออกจากระบบ'
					,cancelButtonColor: '#bfbfbf'
					,cancelButtonText: ' ไม่'
				}).then((result) => {
					if (result.value) {
						Swal.fire({
							type: 'success'
					  		,title: 'ออกจากระบบเรียบร้อย!'
					  		,text: 'กรุณารอสักครู่...'
					  		,timer: 2000
					  		,showConfirmButton: false
		                  	,allowOutsideClick: false
						}).then(() => {
							sessionStorage.setItem('adminusername',null);
							localStorage.setItem('admindata',null);
							window.location = "<?php echo site_url('login'); ?>";
						});
					}
				});
			},
			activeEvent(){
				"use strict"; // Start of use strict

				// Toggle the side navigation
				$("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
					$("body").toggleClass("sidebar-toggled");
					$(".sidebar").toggleClass("toggled");
					if ($(".sidebar").hasClass("toggled")) {
				  		$('.sidebar .collapse').collapse('hide');
					};
				});

				// Close any open menu accordions when window is resized below 768px
				$(window).resize(function() {
					if ($(window).width() < 768) {
				  		$('.sidebar .collapse').collapse('hide');
					};
				});

				// Prevent the content wrapper from scrolling when the fixed side navigation hovered over
				$('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
					if ($(window).width() > 768) {
						var e0 = e.originalEvent,
						delta = e0.wheelDelta || -e0.detail;
						this.scrollTop += (delta < 0 ? 1 : -1) * 30;
						e.preventDefault();
					}
				});

				// Scroll to top button appear
				$(document).on('scroll', function() {
					var scrollDistance = $(this).scrollTop();
					if (scrollDistance > 100) {
				  		$('.scroll-to-top').fadeIn();
					} else {
							$('.scroll-to-top').fadeOut();
					}
				});

				// Smooth scrolling using jQuery easing
				$(document).on('click', 'a.scroll-to-top', function(e) {
					var $anchor = $(this);
					$('html, body').stop().animate({
				  		scrollTop: ($($anchor.attr('href')).offset().top)
					}, 1000, 'easeInOutExpo');
					e.preventDefault();
				});
			},
      changepage(id = ''){
        if(this.currentpage == id){return;}
        this.currentpage = id;
      },
		},
		mounted() {
			var _this = this;
			let ssusername = sessionStorage.getItem('adminusername');
			if(ssusername != null && ssusername != ''){
				this.showHomePage();
				this.activeDatePicker();
				this.activeEvent();
			}else{
				Swal.fire({
				  type: 'error',
				  title: 'ท่านไม่มีสิทธิ์เข้าใช้งานหน้านี้!',
				  text: 'กรุณาเข้าสู่ระบบใหม่อีกครั้ง!',
				  timer: 2000,
				  showConfirmButton: false,
		          allowOutsideClick: false,
				}).then(() => {
					window.location = "<?php echo site_url('login'); ?>";
				});
			}
			
		},
		computed: {

		},
		filter: {

		},
		watch: {

		},
		// created () {
		// 	document.addEventListener("backbutton", this.showLoginForm(), false);
		// },
		// beforeDestroy () {
		// 	document.removeEventListener("backbutton", this.showLoginForm());
		// }
	});
</script>
</body>
</html>