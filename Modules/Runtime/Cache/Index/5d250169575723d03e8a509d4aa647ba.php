<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>购物车</title>
		<meta name="description" content="light7: Build mobile apps with simple HTML, CSS, and JS components.">
		<meta name="author" content="任行">
		<meta name="viewport" content="initial-scale=1, maximum-scale=1">
		<link rel="shortcut icon" href="/ffhysc/View/Index/Public/img/icon.jpg">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="/ffhysc/View/Index/Public/css/light7e0da.css?r=201603281">
		<link rel="stylesheet" href="/ffhysc/View/Index/Public/css/light7-swiper.css">
		<link rel="stylesheet" href="/ffhysc/View/Index/Public/css/light7-swipeout.css">
		<link rel="stylesheet" href="/ffhysc/View/Index/Public/css/demos.css">

		<link rel="apple-touch-icon-precomposed" href="/ffhysc/View/Index/Public/img/apple-touch-icon-114x114.png">
		<script src="/ffhysc/View/Index/Public/js/jquery-2.1.4.js"></script>
		<script>
			//ga
		</script>
		<style>
			/* 购物车条目样式*/
			
			.label-checkbox .item-inner {
				border-bottom: none;
			}
			
			.price {
				color: orangered;
			}
			
			.label-checkbox.item-content {
				border-bottom: 1px solid #dccbcb;
			}
			
			.label-switch {
				margin-left: 70%;
			}
			
			.list-block {
				margin: 0;
			}
			
			.bar.bar-footer {
				padding: 0;
				margin: 0;
			}
			
			.bar.bar-footer button {
				width: 30%;
				height: 100%;
				float: right;
				background: orangered;
				margin: 0;
				top: 0;
				color: #000000;
				font-weight: bolder;
			}
			
			.bar.bar-footer .text {
				font-size: 1.3rem;
				float: left;
				width: 50%;
				margin-left: 1.0rem;
			}
		</style>
	</head>

	<body>
		<div id="page-check-list" class="page">
			<header class="bar bar-nav">
				<a id="confirmed" class="button button-link button-nav pull-left">
					<span class="icon icon-left">返回</span>
				</a>
				<h1 class="title">收货地址管理</h1>
				<!--<a class="button button-link button-nav pull-right back">
					确认使用
				</a>-->
			</header>
			<div class="content">

				<div class="list-block media-list">
					<ul id="addressContainer">

					</ul>
				</div>
			</div>
		</div>

		<script src="/ffhysc/View/Index/Public/js/light7.js"></script>
		<script src="/ffhysc/View/Index/Public/js/light7-swiper.js"></script>
		<script src="/ffhysc/View/Index/Public/js/light7-city-picker.js"></script>
		<script src="/ffhysc/View/Index/Public/js/light7-swipeout.js"></script>
		<script src="/ffhysc/View/Index/Public/js/demose0da.js?r=201603281"></script>
		<script>
			//加载收货人信息列表
			$.loadAddressMSG = function() {
				$.ajax({
					type: "post",
					url: "<?php echo U('user/loadAddressMSG');?>",
					async: true,
					data: {
						userID: sessionStorage.getItem("userID")
					},
					success: function(d) {
						var data = JSON.parse(d);
						/*通过交易码来检查与后端的换流是否正常,0000表示正常*/
						if(data.code == "0000") {

							var tempStr = [];
							data.data.forEach(function(arg, index) {
								tempStr.push('<li class="swipeout">');
								tempStr.push('<div  class="swipeout-content">');
								tempStr.push('<label onclick="$.changeReceiveDefault(' + arg.receiveid + ')" class="label-checkbox item-content">');
								tempStr.push('<input class="checked" type="radio" name="my-radio">');
								tempStr.push('<div class="item-media"><i class="icon icon-form-checkbox"></i></div>');
								tempStr.push('<div class="item-inner">');
								tempStr.push('<div class="item-title-row">');
								tempStr.push('<div class="item-title">收货人</div>');
								tempStr.push('<div class="item-after">' + arg.receivername + '</div>');
								tempStr.push(' </div>');
								tempStr.push('<div class="item-subtitle">收货地址：</div>');
								tempStr.push(' <div class="item-text">' + arg.address + '</div>');
								tempStr.push('<div class="item-title-row">');
								tempStr.push('<div class="item-title">联系电话</div>');
								tempStr.push('<div class="item-after">' + arg.phone + '</div>');
								tempStr.push('</div>');
								tempStr.push('</div>');
								tempStr.push('</label>');
								tempStr.push('</div>');
								tempStr.push('<div class="swipeout-actions-right">');
								tempStr.push('<a onclick="$.removeReceiveItem(' + arg.receiveid + ')" class="bg-danger swipeout" href="#" >移除</a>');
								tempStr.push('</div>');
								tempStr.push('</li>');
							});
							$('#addressContainer').empty();
							$('#addressContainer').append(tempStr.join(''));
						} else {
							$.toast("通讯异常");
						}

					}
				});

			}
			$.loadAddressMSG();
			//更改默认收货人信息
			$.changeReceiveDefault = function(receiveID) {
				$.ajax({
					type: "post",
					url: "<?php echo U('user/changeReceiveDefault');?>",
					async: true,
					data: {
						receiveID: receiveID,
						userID: sessionStorage.getItem("userID")
					},
					success: function(d) {
						var data = JSON.parse(d);
						/*通过交易码来检查与后端的换流是否正常,0000表示正常*/
						if(data.code == "0000") {
							$.toast("修改默认地址成功！");
						} else {
							$.toast("通讯异常");
						}

					}
				});

			}

			$.removeReceiveItem = function(receiveID) {
				$.confirm("是否移除这个收货信息？", function() {
					$.ajax({
						type: "post",
						url: "<?php echo U('user/removeReceiveItem');?>",
						async: true,
						data: {
							receiveID: receiveID
						},
						success: function(d) {
							var data = JSON.parse(d);
							/*通过交易码来检查与后端的换流是否正常,0000表示正常*/
							if(data.code == "0000") {
								$.toast("收货信息移除成功！");
							} else {
								$.toast("通讯异常");
							}

						}
					});
				})
			}
			//检测退出页面时候是否选择了地址
			$("#confirmed").on("click", function() {
				var flag = 1;
				for(var i = 0; i < $(".checked").length; i++) {
					if($(".checked")[i].checked == true) {
						flag = 0;
					}
				}
				if(flag) {
					$.toast("您还未选择默认地址！");
				} else {
					window.history.back(1);
				}
			})
		</script>
	</body>

</html>