<?php
    /*分页显示菜品，每页最多显示5条，以Json格式*/
    header('Content-Type:application/json');
    /*1.接受客户端提交的数据*/
    @$start=$_REQUEST['start'];//从哪一行开始读取记录 @表示压制当前行所产生的所有警告消息
    if( !isset($start) ){//isset表示判断当前变量是否设置过
        $start=0;
    }
    $count=5;//一次可以返回最多的记录数

    /*2.执行数据库操作*/
    $conn=mysqli_connect('127.0.0.1','root','','kaifanla','3306');
    $sql="SET NAMES UTF8";
    mysqli_query($conn,$sql);
    $sql="SELECT did,name,price,material,img_sm FROM kf_dish LIMIT $start,$count";
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