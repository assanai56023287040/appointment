<html lang="en">
<head>

  	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  	<title>ระบบนัดหมายออนไลน์</title>
    <?php 
    	// $this->load->view('css/mycss');
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
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#" @click="changepage('home')">
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
          <i class="far fa-calendar-alt"></i>
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
          <i class="far fa-folder-open"></i>
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
            <div class="d-sm-flex">
              <i class="fa-2x text-gray-800 ml-2 mr-4" :class="currentpage.iconclass"></i>
              <h1 class="h3 font-weight-bold mb-0 text-gray-800">{{ currentpage.txt }}</h1>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

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
                <span class="mr-3 d-none d-lg-inline text-gray-600 small">{{ admindata.STAFF_NAME }}</span>
                <i class="fas fa-crown fa-2x text-gray-600"></i>
                <!-- <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60"> -->
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  ข้อมูลส่วนตัว
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  ตั้งค่า
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" @click="logout()">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  ออกจากระบบ
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <section id="home" v-show="currentpage.kw == 'home'" style="display: none;">
          <div class="container-fluid">
            <div class="row mt-4">

              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2 shadow-primary" @click="changepage('apmlist')">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <!-- <div class="text-xs font-weight-bold text-gray-800 text-uppercase mb-1">Earnings (Monthly)</div> -->
                        <div class="h5 mb-0 font-weight-bold text-primary">รายการขอทำนัด</div>
                      </div>
                      <div class="col-auto">
                        <i class="far fa-list-alt fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2 shadow-success" @click="changepage('dctschedule')">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <!-- <div class="text-xs font-weight-bold text-success text-gray-800 text-uppercase mb-1">Earnings (Annual)</div> -->
                        <div class="h5 mb-0 font-weight-bold text-success">ตารางออกตรวจแพทย์</div>
                      </div>
                      <div class="col-auto">
                        <i class="far fa-calendar-alt fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              

            </div>

            <div class="row mt-4">

              <!-- Earnings (Monthly) Card Example -->
              <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2 shadow-warning" @click="changepage('report')">
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
                        <i class="far fa-folder-open fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>

          </div>
        </section>
        <!-- /.container-fluid -->

        <!-- start appointment page -->
        <section id="apmlist" v-show="currentpage.kw == 'apmlist'" style="display: none;">
          <div class="container-fluid px-3">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <!-- <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
              </div> -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-hover-primary" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>ลำดับ</th>
                        <th>HN</th>
                        <th>ชื่อ</th>
                        <th>รายละเอียดอาการ</th>
                        <th>วันที่ขอทำนัด</th>
                        <th>เวลา</th>
                        <th>สถานะ</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>ลำดับ</th>
                        <th>HN</th>
                        <th>ชื่อ</th>
                        <th>รายละเอียดอาการ</th>
                        <th>วันที่ขอทำนัด</th>
                        <th>เวลา</th>
                        <th>สถานะ</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      <tr v-for="(r,i) in apms" @click="selectrowdetect($event,i)" :class="{ 'selrow' : selrow == i }">
                        <td>{{ i+1 }}</td>
                        <td>{{ r.hn }}</td>
                        <td>{{ r.fname }}  {{ r.lname }}</td>
                        <td>{{ r.sicktxt }}</td>
                        <td>{{ r.apmdate }}</td>
                        <td>{{ r.apmtime }}</td>
                        <td>{{ r.stname }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </section>

        <!-- chat page -->
        <section id="apmchat" v-show="currentpage.kw == 'apmchat'" style="display: none;">
          <div class="container-fluid px-3">
          <div class="card shadow">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-3 px-3 text-center" style="position: relative;">
                  <div class="vl-yellow my-3" style="top: 0;right: 0; position: absolute;"></div>
                  <button class="btn btn-block x-btn-white my-3" style="border-radius: 10px;" @click="onlyshowmodal('patient-profile')">
                    <i class="far fa-user-circle align-middle" style="font-size: 1.8rem"></i>
                    <span class="align-middle mx-2" style="font-size: 1rem;">ข้อมูลคนไข้</span> <!-- ขอทำนัด -->
                  </button>
                  <hr/>
                  <button class="btn btn-block x-btn-orenge my-3" style="border-radius: 10px;" @click="apmload(selapm.apmid)">
                    <i class="fa fa-info align-middle" style="font-size: 1.8rem"></i>
                    <span class="align-middle mx-2" style="font-size: 1rem;">ดูข้อมูลการขอทำนัด</span> <!-- ขอทำนัด -->
                  </button>
                  <div class="text-center w-100 my-2">
                    <h3 class="font-weight-bold">ข้อมูลการขอทำนัด</h3>
                    <div class="form-group px-3">
                      <label class="small font-weight-bold" for="header">รายละเอียดอาการ : </label>
                      <textarea class="form-control non-edit" type="text" :value="selapm.sicktxt" rows="4"></textarea> 
                    </div>
                    <div class="form-group px-3">
                      <label class="small font-weight-bold" for="apmdate">วันที่ขอทำนัด : </label>
                      <input class="form-control non-edit text-center" type="text" :value="selapm.apmdate">
                    </div>
                    <div class="form-group px-3">
                      <label class="small font-weight-bold" for="apmdate">เวลาที่ขอทำนัด : </label>
                      <input class="form-control non-edit text-center" type="text" :value="selapm.apmtime+'.00'">
                    </div>
                    <div class="form-group px-3">
                      <label class="small font-weight-bold" for="apmdate">เบอร์โทรศัพท์ที่ติดต่อได้ : </label>
                      <input class="form-control non-edit text-center" type="text" :value="selapm.tel">
                    </div>
                  </div>
                </div>
                <!-- chat and option zone -->
                <div class="col-9 container text-center" style="display: flex;">
                  <div class="m-0 p-0 w-100 h-100" style="display: flex;flex: 1;">
                    <div class="container-fluid mt-3 px-0" style="flex: 1;height: 75vh;background-color: #ffffcc;position: relative;padding-bottom: 60px;">
                      <div class="row m-0 p-0 sticky-top h-100" style="display: flex;flex-direction: column;">
                        <div class="container-fluid px-0 col-12" id="messages-area" style="align-self: stretch;overflow-y: auto;">
                          <div class="row m-0 p-0 sticky-top">
                            <div class="col-12 m-0 p-0 text-right bg-white">
                              <button class="btn x-btn-yellow my-1 mx-2" style="border-radius: 10px;" @click="changepage('apmlist')">
                                <i class="fa fa-times-circle align-middle" style="font-size: 1.8rem"></i>
                                <span class="align-middle mx-2" style="font-size: 1rem;">ปิดหน้าแชท</span> <!-- ขอทำนัด -->
                              </button>
                              <hr class="my-2">
                            </div>
                          </div>
                          <div class="text-center x-btn-white px-5 mx-5 my-2" v-show="false" style="border-radius: 10px;">
                            <i class="fa fa-angle-up align-middle" style="font-size: 1.5rem"></i>
                            <span class="align-middle mx-2" style="font-size: 1rem;">โหลดเพิ่มเติม</span>
                          </div>
                          <div class="d-block m-2" v-for="(msg ,idx) in messages" :class="msg.side == 'a'? 'text-right':'text-left'">
                            <span class="text-muted" v-if="msg.side == 'a'" style="font-size: 14px;">{{ msg.msgtime | hourminute }}</span>
                            <div class="d-inline-block bg-light py-2 px-4 text-wrap chat-msg-area text-left">
                              {{ msg.msgtxt }}
                            </div>
                            <span class="text-muted" v-if="msg.side == 'p'" style="font-size: 14px;">{{ msg.msgtime | hourminute }}</span>
                          </div>
                        </div>
                      </div>

                      <div class="input-group sticky-bottom" style="height: 55px;"><!-- min-height: 30px; -->
                        <input type="text" id="create-msg-box" class="form-control form-control-lg font-weight-bold" placeholder="พิมพ์ เพื่อตอบแชท..." style="font-size: 24px;height: auto;" @keyup.enter="createmsg()" v-model="currmsg">
                        <div class="input-group-append" @click="createmsg()">
                            <span class="input-group-text x-btn-purple">
                              <i class="fa fa-angle-double-up align-middle mx-3" style="font-size: 24px"></i>
                            </span>
                          </div>
                      </div>
                    </div> <!-- end of content flex -->
                  </div> <!-- end of parent div for flex -->
                </div>
              </div>
            </div> <!-- end of div card-body --> 
          </div> <!-- end of div card -->
          </div> <!-- end of big div container fluid -->
        </section>


      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <!-- <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer> -->
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
	// $this->load->view('js/myjs');
	$this->load->view('js/adminjs');
?>
<script type="text/javascript">

	var app = new Vue({
		el: '#wrapper',
		data: {
      clicks: 0,
      clickcounter: null,
      selrow: null,
      selapm: {},
			// for form search
			skeyword: '',
			sfdate: '',
			stdate: '',
			apmlist: [],
      admindata: {},
      currentpage: {},
      pages: [
        {
          kw:'home',
          txt:'หน้าหลัก',
          iconclass:'fas fa-home'
        },
        {
          kw:'apmlist',
          txt:'รายการขอทำนัด',
          iconclass:'far fa-list-alt'
        },
        {
          kw:'dctschedule',
          txt:'ตารางออกตรวจแพทย์',
          iconclass:'far fa-calendar-alt'
        },
        {
          kw:'report',
          txt:'รายงาน',
          iconclass:'far fa-folder-open'
        },
        {
          kw:'apmchat',
          txt:'รายการขอทำนัด > CHAT',
          iconclass:'far fa-list-alt'
        },
      ],
      apms: [],
      listInterval: null, // interval for show bagde message in chat list
      chatInterval: null, // for update message in chat page
      currmsg: "",
      messages: [],
      offsetchat: 0,
		},
		methods: {
			onlyShowModal(modal_id){
				$('#'+modal_id).modal();
			},
			showHomePage(){
				this.homepage = true;
        this.currentpage = this.pages.find(v => v.kw == 'home');
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
							ssremove('adminusername');
							lcremove('admindata');
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
      // activeDataTable(){
      //   $('#dataTable').DataTable();
      // },
      changepage(id = ''){
        if(this.currentpage.kw == id){return;}
        this.currentpage = this.pages.find(v => v.kw == id);

        switch(id){
          case 'home': break;
          case 'apmlist': 
              this.apmlistload();
            break;
          case 'apmchat': break;
          case 'dctschedule': break;
          case 'report': break;
          default :
        }
      },
      apmlistload(){
        Swal.fire({
            title: "กรุณารอสักครู่...",
            allowOutsideClick: false,
        });
        Swal.showLoading();
        axios.post("<?php echo site_url('appointment/alllistload'); ?>",{
          params : {

          }
        })
        .then(res => {
          this.apms = [];
          Swal.close();
          this.apms = res.data.row;
          this.apms.forEach((item,idx) =>{
            item.apmdate = this.dateforth(item.apmdate);
          });
        });
      },
      selectrowdetect(event,idx){
          this.clicks++ 
          if(this.clicks === 1) {
            this.selrow = idx;
            this.clickcounter = setTimeout(() => {
              this.clicks = 0
            }, 700);
          } else if(this.clicks === 2) {
            this.selrow = idx;
            clearTimeout(this.clickcounter);
            this.clicks = 0;
            this.openchat(idx);
            
          }
      },
      dateforth(sqldate){
        if(sqldate){
          let strdate = sqldate.split('-');
          if(strdate.length == 3){
            return strdate[2]+'/'+strdate[1]+'/'+(parseInt(strdate[0],10)+543);
          }else{return v;}
        }else{
          return "";
        }
      },
      //  **********************************************************************************
      //  ******************************  chat function zone  ******************************
      //  **********************************************************************************
      async openchat(idx){
        this.changepage('apmchat');
        this.selapm = this.apms[idx];
        await this.loadchat();
        this.scrolltobottom();
        this.inquirychat();
        // this.currentpage.txt += this.selapm.fname + "   " + this.selapm.lname;
      },
      async loadchat(){
        this.messages = [];
        Swal.fire({
            title: "กำลังตรวจสอบข้อมูล กรุณารอสักครู่...",
            allowOutsideClick: false,
        });
        Swal.showLoading();
        await axios.get("<?php echo site_url("appointment/loadchat"); ?>",{
            params : {
              apmid : this.selapm.apmid,
              offset : this.offsetchat,
              nowside : 'a',
            }
        })
        .then(res => {
          Swal.close();
          res = res.data;
          if(res.success && res.cnt > 0){
            res.msg.forEach((item,idx) => {
              this.messages.push(item);
            });
          }
        });
      },
      inquirychat(){
        this.chatInterval = setInterval(() => {
          axios.get("<?php echo site_url("appointment/inquirychat"); ?>",{
            params : {
              apmid : this.selapm.apmid,
              nowside: 'a',
            }
          })
          .then(res => {
            res = res.data;
            if(res.success && res.cnt > 0){
              res.msg.forEach((item,idx) => {
                this.messages.push(item);
              });
              this.scrolltobottom();
            }
          });
        },5000);
      },
      createmsg(){
        if(!this.currmsg){return false;}
        clearInterval(this.chatInterval);
        let dt = new Date();
        let d = dt.getFullYear()+'-'+(dt.getMonth()+1)+'-'+dt.getDate();
        let t = dt.getHours() + ':' + dt.getMinutes().toString().padStart(2,0); // + ":" + dt.getSeconds()
        this.messages.push({
          side:"a"
          ,msgtxt: this.currmsg
          ,msgdate: d
          ,msgtime: t
        });
        
        let params = new URLSearchParams({
          'apmid' : this.selapm.apmid,
          'side' : 'a',
          'msgtxt' : this.currmsg,
          'msgdate' : d,
          'msgtime' : t,
        });

        this.currmsg = "";
        this.scrolltobottom();
        $("#create-msg-box").focus();

        axios.post("<?php echo site_url('appointment/createmsg'); ?>",params)
          .then(res => {
            this.inquirychat();
          });
      },
      scrolltobottom(){
        let messagesArea = document.getElementById("messages-area");
        $("#messages-area").animate({ scrollTop: messagesArea.scrollHeight }, "slow");
      },

      //  *****************************************************************************************
      //  ******************************  end of chat function zone  ******************************
      //  *****************************************************************************************


		},
		mounted() {
			var _this = this;
			let ssusername = ssget('adminusername');
			if(ssusername != null && ssusername != ''){
        this.admindata = JSON.parse(lcget('admindata'));
				this.showHomePage();
				this.activeEvent();
				this.activeDatePicker();
        // this.activeDataTable();
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
		filters: {
      thdate(v){
        if(v){
          let strdate = v.split('-');
          if(strdate.length == 3){
            return strdate[2]+'/'+strdate[1]+'/'+(parseInt(strdate[0],10)+543);
          }else{return v;}
        }else{
          return "";
        }
      },
      hourminute(v){
        let strtime = v.split(':');
        if(strtime.length == 3 || strtime.length == 2){
          return strtime[0]+':'+strtime[1];
        }else{
          return "";
        }
      },
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