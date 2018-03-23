<!DOCTYPE html>
<html lang="zh_cn">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
	<title>一键物业报修</title>
	<link rel="stylesheet" href="//cdn.bootcss.com/weui/0.4.0/style/weui.min.css"/>
	<link rel="stylesheet" href="style/weui.css">
	<link rel="stylesheet" href="style/example.css">
    <script src="//cdn.bootcss.com/jquery/3.0.0/jquery.min.js"></script>
	<script src="/js/login_score.js"></script>
</head>
<body>
    <!-- 使用的是WeUI -->
	<form action="./require_baoxiu.php" method="post">
		<div class="weui_cells_title">登录信息</div>
		<div class="weui_cells weui_cells_form">
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="weui_label">学号</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" name="account" type="text" placeholder="请输入学号">
				</div>
			</div>

			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="weui_label">密码</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" name="password" type="password" placeholder="请输入信息门户密码">
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					<label class="weui_label">地址</label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" name="districtname" type="text" placeholder="（例：北区）">
					<input class="weui_input" name="floorid" type="text" placeholder="（例：01B）">
					<input class="weui_input" name="dormitoryid" type="text" placeholder="（例：101）">
				</div>
			</div>
			<div class="weui_cell">
				<div class="weui_cell_hd">
					手机号码
					<label class="weui_label"></label>
				</div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" name="phone" type="text" placeholder="请填写手机号码便于联系">
				</div>
			</div>

            <div class="weui_cell weui_cell_select weui_select_after">
                <div class="weui_cell_hd">
                    报修物品
                </div>
                <div class="weui_cell_bd weui_cell_primary">
					<select class="weui_select" id="type1" name="type1"><option value="">请选择物品类别</option></select>  
					<select class="weui_select" id="type2" name="type2"></select>  
                </div>
            </div>
			<div class="weui-cells weui-cells_form">
			故障描述
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <textarea class="weui-textarea" type="textarea" name="describe" placeholder="请输入文本" rows="3"></textarea>
                    <div class="weui-textarea-counter"><span>0</span>/200</div>
                </div>
            </div>
			</div>
<!--			<div class="weui_cell weui_vcode">
				<div class="weui_cell_hd"><label class="weui_label">验证码</label></div>
				<div class="weui_cell_bd weui_cell_primary">
					<input class="weui_input" name="verify_code" type="text" placeholder="请输入验证码"/>
				</div>
				<div class="weui_cell_ft">
                <img id="verify_code" src="/verifyCodes/verifyCode_<?php print $rand_id ?>.jpg" onclick="update_verify_code()" />
				</div>
			</div>
		</div>
--!>

        <!-- loading toast -->
            <div id="loadingToast" class="weui_loading_toast" style="display:none;">
                <div class="weui_mask_transparent"></div>
                <div class="weui_toast">
                    <div class="weui_loading">
                        <div class="weui_loading_leaf weui_loading_leaf_0"></div>
                        <div class="weui_loading_leaf weui_loading_leaf_1"></div>
                        <div class="weui_loading_leaf weui_loading_leaf_2"></div>
                        <div class="weui_loading_leaf weui_loading_leaf_3"></div>
                        <div class="weui_loading_leaf weui_loading_leaf_4"></div>
                        <div class="weui_loading_leaf weui_loading_leaf_5"></div>
                        <div class="weui_loading_leaf weui_loading_leaf_6"></div>
                        <div class="weui_loading_leaf weui_loading_leaf_7"></div>
                        <div class="weui_loading_leaf weui_loading_leaf_8"></div>
                        <div class="weui_loading_leaf weui_loading_leaf_9"></div>
                        <div class="weui_loading_leaf weui_loading_leaf_10"></div>
                        <div class="weui_loading_leaf weui_loading_leaf_11"></div>
                    </div>
                    <p class="weui_toast_content">数据加载中</p>
                </div>
            </div>

        <script>
            //Loading旋转菊花
            $(function() {
                $('#showLoadingToast').click(function() {
                    $('#loadingToast').fadeIn();
                });
            })
        </script>
		<script>
    var json = [
        {
            name: '水、电',
            id: 1,
            child: [
                {
                    name: '长灯管',
                    id: 37,
                },
				{
                    name: '短灯管',
                    id: 38,
                },
				{
                    name: '洗脸间镜前灯',
                    id: 40,
                },
				{
                    name: '地漏盖',
                    id: 77,
                },
				{
                    name: '单联开关',
                    id: 57,
                },
				{
                    name: '过道灯',
                    id: 44,
                },
				{
                    name: '三联开关',
                    id: 59,
                },
				{
                    name: '普通水龙头',
                    id: 69,
                },
				{
                    name: '三角阀',
                    id: 67,
                },
				{
                    name: '拖把池',
                    id: 75,
                },
				{
                    name: '二空开关',
                    id: 60,
                },
				{
                    name: '水箱橡皮塞',
                    id: 55,
                },
				{
                    name: '防水插座',
                    id: 61,
                },
				{
                    name: '洗脸池',
                    id: 76,
                },
				{
                    name: '单双项开关',
                    id: 58,
                },
				{
                    name: '二空开关',
                    id: 60,
                },
				{
                    name: '水箱把手',
                    id: 54,
                },
				{
                    name: '寝室内下水道',
                    id: 82,
                },
				{
                    name: '房间日光灯',
                    id: 41,
                },
				{
                    name: '便池小型疏通',
                    id: 83,
                },
				{
                    name: '地下室灯',
                    id: 45,
                },
				{
                    name: '面池下水道',
                    id: 81,
                },
				{
                    name: '五孔插座',
                    id: 62,
                },
				{
                    name: '水箱盖',
                    id: 53,
                },
				{
                    name: '下水软管',
                    id: 78,
                },
				{
                    name: '卫生间吸顶灯',
                    id: 39,
                },
				{
                    name: '通水软管',
                    id: 79,
                },
				{
                    name: '门厅灯',
                    id: 43,
                },
				{
                    name: '阳台吸顶灯',
                    id: 42,
                },
				{
                    name: '水龙头蕊/把手',
                    id: 66,
                },
				{
                    name: '蹲坑水箱及配件',
                    id: 56,
                }
            ]
        }, {
            name: '家具',
            id: 2,
            child: [
                {
                    name: '窗户玻璃',
                    id: 8,
                },
				{
                    name: '普通防盗门把手',
                    id: 32,
                },
				{
                    name: '卫生间玻璃',
                    id: 1,
                },
				{
                    name: '蚊帐架',
                    id: 72,
                },
				{
                    name: '公共活动室玻璃',
                    id: 14,
                },
				{
                    name: '门厅玻璃',
                    id: 11,
                },
				{
                    name: '蹲坑水箱及配件',
                    id: 56,
                },
				{
                    name: '地下室玻璃',
                    id: 15,
                },
				{
                    name: '厕所不锈钢架',
                    id: 74,
                },
				{
                    name: '床板',
                    id: 46,
                },
				{
                    name: '凳面',
                    id: 51,
                },
				{
                    name: '缺角',
                    id: 49,
                },
				{
                    name: '防盗门锁',
                    id: 18,
                },
				{
                    name: '普通防盗门锁',
                    id: 20,
                },
                {
                    name: '阳台门玻璃',
                    id: 7,
                },
                {
                    name: '球形锁',
                    id: 24,
                },
                {
                    name: '锁舌',
                    id: 25,
                },
                {
                    name: '油漆',
                    id: 52,
                },
                {
                    name: '防盗门钥匙断裂锁孔内',
                    id: 19,
                },
                {
                    name: '梳洗镜',
                    id: 70,
                },
                {
                    name: '厕所磨砂玻璃',
                    id: 10,
                },
                {
                    name: '窗帘拉杆',
                    id: 96,
                },
                {
                    name: '防盗门把手',
                    id: 31,
                },
                {
                    name: '公共活动室门把',
                    id: 34,
                },
                {
                    name: '公共活动室钥匙断裂锁孔内',
                    id: 28,
                },
                {
                    name: '门吸',
                    id: 35,
                },
                {
                    name: '公共区域天花板',
                    id: 88,
                },
                {
                    name: '卫生间天窗玻璃',
                    id: 2,
                },
                {
                    name: '毛巾架',
                    id: 71,
                },
                {
                    name: '凳子脚',
                    id: 50,
                },
                {
                    name: '防盗门锁体',
                    id: 27,
                },
                {
                    name: '塑料开孔管',
                    id: 80,
                },
                {
                    name: '防盗门天窗玻璃',
                    id: 6,
                },
                {
                    name: '门抽屉把手',
                    id: 33,
                },
                {
                    name: '抽屉锁',
                    id: 22,
                },
                {
                    name: '消防箱玻璃',
                    id: 12,
                },
                {
                    name: '肥皂盒',
                    id: 73,
                },
                {
                    name: '护床栏',
                    id: 47,
                },
                {
                    name: '公共活动室门吸',
                    id: 36,
                },
                {
                    name: '衣柜锁',
                    id: 21,
                },
                {
                    name: '防盗门锁芯',
                    id: 26,
                },
                {
                    name: '磁性密码锁',
                    id: 23,
                },
                {
                    name: '公共活动室门锁',
                    id: 30,
                },
                {
                    name: '隔挡',
                    id: 48,
                },
                {
                    name: '组合衣柜（含横杠）',
                    id: 87,
                },
                {
                    name: '地下室门锁',
                    id: 29,
                }
            ]
        }, {
            name: '洗浴热水',
            id: 17,
            child: [
                {
                    name: '洗浴热水水温',
                    id: 91,
                },
                {
                    name: '冷、热水阀',
                    id: 68,
                },
                {
                    name: '洗浴热水水量',
                    id: 92,
                },
                {
                    name: '洗浴热水刷卡器',
                    id: 89,
                },
                {
                    name: '淋喷头',
                    id: 63,
                },
            ]
        }, {
            name: '后勤维修',
            id: 18,
            child: [
                {
                    name: '天花板大面积塌掉',
                    id: 97,
                },
                {
                    name: '房屋渗水',
                    id: 94,
                },
                {
                    name: '天花板漏水',
                    id: 93,
                },
                {
                    name: '瓷砖脱落',
                    id: 95,
                },
            ]
        }
    ];
           var a = document.getElementById('type1');
          var b = document.getElementById('type2');
          json.map(function(s){   //相当于for循环，遍历json，这里s相当于一个json[i]
            createop(s,a);        //这个函数是创建option并添加到select的函数，第一个参数是遍历的json[i],第二个是第一个select。第一个select的创建完成了。
          });
          a.onchange = function(){    //当第一个select改变时
            b.innerHTML = '';         //清空第二个select的option   
            json.map(function(s){    //遍历json
                if(s.id==this.options[this.selectedIndex].id){ //当你选中的option的id和json[i]的id相同时，也就是取到你第一个select选择的json[i].
                    s.child.map(function(x){    //遍历这个json[i].child,得到每个分类
                        createop(x,b);          //根据每个分类创建option添加到第二个select上
                    });
                }
            }.bind(this));  //绑定this，改变this指向为a
          }
          function createop(h,parent){
              var op = document.createElement('option');  //创建option
              var op_t = document.createTextNode(h.name);  //创建option的文字
              op.appendChild(op_t);                    //添加文字到option中
			  var op_a = document.createTextNode(h.id);  //创建option的id
              op.appendChild(op_a);                    //添加id到option中
              op.id = h.id;							//option的id赋值
              parent.appendChild(op);                 //把option添加到传过来的select中
          }
</script>

		<input class="weui_btn weui_btn_primary" type="submit" value="一键报修" id="showLoadingToast"/>
	</form>		

<article class="weui_article">


<h1>
<i class="weui_icon_success_circle"></i>&nbsp;账号和密码不会保留，请放心使用。<br>
</h1>
<br>

<br><br><br>	

<section>
如数据有问题(或者网站打不开了)请联系:<br>
<a href="http://www.uknowsec.cn">Uknow</a>(uknowsec@gmail.com)<br>
Stay hungry Stay foolish.<br>
<a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=0066244a8e61e13b566e6ecd1c0cc5685aa333a187c3bbd5dcf884d6da9b4e43"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="南工程技术交流群" title="南工程技术交流群"></a><br>
适用南京工程学院<br>
</section>
</article>
</body>
</html>



