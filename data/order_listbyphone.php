<?php
    /*根据客户端提交的电话号码来列出此人的所有订单，以Json格式输出*/
    header('Content-Type:application/json');
    /*1.接受客户端提交的数据*/
    @$phone=$_REQUEST['phone'];//
    if( !isset($phone) ){
        echo '[]';//若客户端未提交电话号码，则返回一个空数组
        return;
    }

    /*2.执行数据库操作*/
    $conn=mysqli_connect('127.0.0.1','root','','kaifanla','3306');
    $sql="SET NAMES UTF8";
    mysqli_query($conn,$sql);
    $sql="SELECT oid,user_name,order_time,img_sm FROM kf_order,kf_dish
          WHERE kf_order.did=kf_dish.did AND phone='$phone'";//多表查询
    $result=mysqli_query($conn,$sql);
    //开始读取结果集
    $output=[];
    while(($row=mysqli_fetch_assoc($result))!==NULL){
        $output[]=$row;
    }

    /*3.向客户端响应消息主体*/
    $jsonString=json_encode($output);//编码成json格式
    echo $jsonString;
?>