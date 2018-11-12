<?php
    /*根据菜品编号返回菜品详情（detail页面），以Json格式输出*/
    header('Content-Type:application/json');
    /*1.接受客户端提交的数据*/
    @$did=$_REQUEST['did'];//待查询的菜品编号
    if( !isset($did) ){//isset表示判断当前变量是否设置过
        echo '{}';//没提交过来，则直接返回一个空对象（因为菜品详情就是一个对象），退出当前循环
        return;
    }

    /*2.执行数据库操作*/
    $conn=mysqli_connect('127.0.0.1','root','','kaifanla','3306');
    $sql="SET NAMES UTF8";
    mysqli_query($conn,$sql);
    $sql="SELECT did,name,price,material,img_lg,detail FROM kf_dish WHERE did='$did'";
    $result=mysqli_query($conn,$sql);
    //开始读取结果集
    $row=mysqli_fetch_assoc($result);//根据编号查询，结果要么返回一条记录，要么一行都没有，不可能获得多行记录，因此不用数组和循环，直接抓取这一行

    /*3.向客户端响应消息主体*/
    $jsonString=json_encode($row);//编码成json格式
    echo $jsonString;
?>