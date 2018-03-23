---
title: PHP爬虫-物业报修系统一键校园物业报修
date: 2018-03-23 13:14:30
categories: 笔记
---

## 前言

前面两个爬虫都是基于正方教务系统的，这个爬虫是根据学校的一个物业报修系统写的。

login_baoxiu.php页面有用到一个js做的select二级联动的操作。

require_baoxiu.php页面也就是三个post请求。

## 正文

### login_baoxiu.php

![](http://obr4sfdq7.bkt.clouddn.com/psb2.png)

以上界面中的保修物品里是需要一个select的二级联动的。

### select二级联动

这里简单的看一个二级联动的JS代码。

```
    <select  id="a"></select>
    <select id="b">
        <option value="">请选择</option>
    </select>
```

两个select标签，id=a的标签是第一级，id=b的标签是第二级。


再看JS代码，
```
<script>
    var json = [{

              id: 1,
              name: '蔬菜',
              child: [{
                  id: '1',
                  name: '白菜'
              }, {
                  id: '2',
                  name: '萝卜'
              }, {
                  id: '3',
                  name: '菠菜'
              }]
          }, {
              id: 2,
              name: '肉类',
              child: [{
                  id: '1',
                  name: '猪肉'
              }, {
                  id: '2',
                  name: '羊肉'
              }, {
                  id: '3',
                  name: '牛肉'
              }]
          }, {
              id: 3,
              name: '蛋类',
              child: [{
                  id: '1',
                  name: '鸡蛋'
              }, {
                  id: '2',
                  name: '鹅蛋'
              }, {
                  id: '3',
                  name: '鸭蛋'
              }]
          }];
    var a = document.getElementById('a');
    var b = document.getElementById('b');
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
              op.id = h.id;                            //option的id赋值
              parent.appendChild(op);                 //把option添加到传过来的select中
          }
</script>
```

在这个JS代码里定义了一个JSON对象来存放select的value值，从JSON中可以看出一共有3个父节点，每个父节点都有自己的子节点。

然后通过下面的js代码实现，当我们第一个select创建option时，遍历json把第一个select的子节点创建option添加到第二个select上

实现select标签的二级联动功能。这里根据require_baoxiu.php里面的提交数据POST包，把以上代码demo进行了一下修改

```
	function createop(h,parent){
              var op = document.createElement('option');  //创建option
              var op_t = document.createTextNode(h.name);  //创建option的文字
              op.appendChild(op_t);                    //添加文字到option中
			  var op_a = document.createTextNode(h.id);  //创建option的id
              op.appendChild(op_a);                    //添加id到option中
              op.id = h.id;							//option的id赋值
              parent.appendChild(op);                 //把option添加到传过来的select中
          }
```

在这里，我把json中的id和name值都添加到了select,因为传给后面的参数需要这个ID值作为POST提交参数。



### require_baoxiu.php

获取到login_baoxiu.php提交过来的表单变量

```
$userId=$_POST['account'];
$password=$_POST['password'];
$patterns = "/\d+/";
preg_match_all($patterns,$_POST['type1'],$arr1);
$type1=$arr1[0][0];
preg_match_all($patterns,$_POST['type2'],$arr2);
$type2=$arr2[0][0];
$districtname=$_POST['districtname'];
$floorid=$_POST['floorid'];
$dormitoryid=$_POST['dormitoryid'];
$phone=$_POST['phone'];
$describe=$_POST['describe'];
```

由于$type1和$type2变量传过来的是一个name+id的值，我们需要把name剔除。利用正则得到id值。


下面还是用到CURL

```
function login_post($url,$cookie,$post){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  //不自动输出数据，要echo才行
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  //重要，抓取跳转后数据
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie); 
        curl_setopt($ch, CURLOPT_REFERER, 'http://localhost/Repair/');  //重要，302跳转需要referer，可以在Request Headers找到 
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post);  //post提交数据
        $result=curl_exec($ch);
        curl_close($ch);
        return $result;
    }
```

同样先获取cookie值，保存cookie。步骤跟正方教务系统是相同的。

整体的分析下代码

```
	$login_url= 'http://localhost/Repair/UserServlet';
	$post=array(
		'flag'=> 'toCheckStuLogin',
		'userId' => $userId,
		'password' => $password
    );
	
	$login_con = login_post($login_url,$cookie,http_build_query($post));
```

登录到报修系统，这里用到的http_build_query()函数，而post请求包也是用到array，在上一篇说到的问题。

因为我们用到了http_build_query()函数，所以Content-Type还是application/x-www-form-urlencoded。

http_build_query()函数的作用就是是使用给出的关联(或下标)数组生成一个经过 URL-encode 的请求字符串。

然后更加抓包分析，我们需要把用户提交的地址更新一下

```
	$add_url1 = 'http://localhost/Repair/jsp/student/repair_add.jsp';
	$add_con=login_post($add_url1  ,$cookie,'');
	preg_match_all('/<input.+?(value=\"(.+?)\")/',$add_con, $view); //获取__VIEWSTATE字段并存到$view数组中
	//var_dump($view[1][1]);
	preg_match_all($patterns,$view[1][1],$arr3);
	$tusersid = $arr3[0][0];
	
	$updateAddress_url = 'http://localhost/Repair/StudentServlet?flag=updateAddress';
	$updateAddress_post=array(	
		'tId' => $tusersid,
		'districtname' => $districtname,
		'floorid' => $floorid,
		'dormitoryid' => $dormitoryid
	);
	
	$updateAddress_con = login_post($updateAddress_url,$cookie,http_build_query($updateAddress_post));
```

将变量值传入更新用户的地址信息。

接下来就是提交报修信息了，也是用到一个post请求包

```
	$repair_add_url = "http://localhost/Repair/StudentServlet?userId=".$userId;
	$repair_add_post=array(	
		'flag'=> 'repairAdd',
		'tusersid' => $tusersid,
		'districtname' => $districtname,
		'floorid' => $floorid,
		'dormitoryid'=> $dormitoryid,
		'phone' => $phone,
		'goodsType' => $type1,
		'goodsid' => $type2,
		'describe'=> $describe
	);
	$repair_add_con = login_post($repair_add_url,$cookie,http_build_query($repair_add_post));
```

到这里模拟提交报修信息的工作就完成了，后续我还做了一个简单的判断，判断是否登录成功。


## Github

https://github.com/uknowsec/RepairCrawler


## Reference

[select二级联动](https://segmentfault.com/q/1010000011880594)
