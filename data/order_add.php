<?php
    /*接受客户端提交的订单信息，保存订单，生成订单号，输出执行的结果，以Json格式输出*/
    header('Content-Type:application/json');
    /*1.接受客户端提交的数据*/
    @$user_name=$_REQUEST['user_name'];//接收人姓名
    @$sex=$_REQUEST['sex'];//性别
    @$phone=$_REQUEST['phone'];//练习电话
    @$addr=$_REQUEST['addr'];//收货地址
    @$did=$_REQUEST['did'];//菜品编号
    $order_time=time()*1000;//以毫秒为单位的当前系统时间

    //客户端输入的服务器端校验--真正可靠的校验！
    if( !isset($user_name)|| !isset($sex)||!isset($phone)||!isset($addr)||!isset($did)){
        /*$output=[];
        $output["status"]="err";
        $output["msg"]="客户端提交的请求数据不足";
        echo json_encode($output);*/
        echo '{"status":"err","msg":"客户端提交的请求数据不足"}';//若客户端未提交任意一个信息，则返回提示消息
        return;
    }

    /*2.执行数据库操作*/
    $conn=mysqli_connect('127.0.0.1','root','','kaifanla','3306');
    $sql="SET NAMES UTF8";
    mysqli_query($conn,$sql);
    $sql="INSERT INTO kf_order(oid,user_name,sex,phone,addr,did,order_time)
          VALUES(NULL,'$user_name','$sex','$phone','$addr','$did','$order_time')";
    $result=mysqli_query($conn,$sql);
    $output=[];
    if($result){
        $output['status']='succ';
        $output['oid']=mysqli_insert_id($conn);//获取最近的一条INSERT语句所生成的自增主键
    }else{
        $output['status']='err';
        $output['msg']="数据库访问失败！SQL:$sql";
    }

    /*3.向客户端响应消息主体*/
    $jsonString=json_encode($output);//编码成json格式
    echo $jsonString;
?>