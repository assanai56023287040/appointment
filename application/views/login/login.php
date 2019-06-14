<html lang="en">
<head>

  	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  	<title>ระบบนัดหมายออนไลน์</title>
  	<style type="text/css">
        html{
            height: 100%;
        }
  		body {
  			/* min-height: 100%; */
  			background-image: linear-gradient(to top, #8500aa, #9a31bf, #b050d4, #c56ce9, #db87ff);
  		}
  	</style>
    <?php $this->load->view('css/mycss'); ?>
</head>
<body bgcolor="#E6E6FA">
<div class="container-fluid" id="app">

	<button type="button" class="btn btn-primary" @click="showEmSign()" data-toggle="modal" data-target="#em-sign">Show Modal</button>

	{{ idcard }}
</div>
	
	<!-- modal zone -->
	<div id="em-sign" class="modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- modal header -->
				<div class="modal-header">
					aaaaa
				</div>

				<!-- modal body -->
				<div class="modal-body">
					bbbbb
				</div>

				<!-- modal footer -->
				<div class="modal-footer">
					ccccc
				</div>
			</div>
		</div>
	</div>
<?php $this->load->view('js/myjs'); ?>

<script type="text/javascript">
	var app = new Vue({
		el: '#app',
		data: {
			idcard: '',
		},
		methods: {
			showEmSign() {
				// $('#em-sign').modal();
				console.log('pass to fnc showEmSign');
				this.idcard = 'xxxxxxxxxx';
			}
		},
		mounted() {
			var _this = this;

		},
		computed: {

		},
		filter: {

		},
		watch: {

		}
	})
</script>
</body>
</html>