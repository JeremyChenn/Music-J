<?php
    /*根据菜名或原料中的关键字查询菜品，以Json格式输出*/
    header('Content-Type:application/json');
    /*1.接受客户端提交的数据*/
    @$kw=$_REQUEST['kw'];//查询关键字
    if( !isset($kw) ){//isset表示判断当前变量是否设置过
        echo '[]';//若客户端未提交查询关键字，则直接返回一个空数组，退出当前循环
        return;
    }

    /*2.执行数据库操作*/
    $conn=mysqli_connect('127.0.0.1','root','','kaifanla','3306');
    $sql="SET NAMES UTF8";
    mysqli_query($conn,$sql);
    $sql="SELECT did,name,price,material,img_sm FROM kf_dish WHERE name LIKE '%$kw%' OR material LIKE '%$kw%'";
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