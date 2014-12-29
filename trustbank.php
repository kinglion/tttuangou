<html>
<head>
<title>TrustPay - 支付请求</title>
<meta http-equiv='Content-Type' content='text/html; charset=GB2312'>
</head>
<?php 
	header("charset:GB2312");
class_exists('TrxResponse') or require(dirname(__FILE__).'/bin/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/bin/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/bin/core/TrxRequest.php');
class_exists('TrxType') or require(dirname(__FILE__).'/bin/TrxType.php');
class_exists('Order') or require(dirname(__FILE__).'/bin/Order.php');
class_exists('Insure') or require(dirname(__FILE__).'/bin/Insure.php');
class_exists('PaymentRequest') or require(dirname(__FILE__).'/bin/PaymentRequest.php');
//1、取得支付请求所需要的信息
	$tOrderNo = $_POST['OrderNo'];
	$tExpiredDate = $_POST['ExpiredDate'];
	$tOrderDesc = $_POST['OrderDesc'];
	$tOrderDate = $_POST['OrderDate'];
	$tOrderTime = $_POST['OrderTime'];
	$tOrderAmountStr = $_POST['OrderAmount'];
	$tOrderURL = $_POST['OrderURL'];
	$tBuyIP = $_POST['BuyIP'];
	
	$tProductType = $_POST['ProductType'];
	$tPaymentType = $_POST['PaymentType'];
	$tNotifyType = $_POST['NotifyType'];
	$tResultNotifyURL = $_POST['ResultNotifyURL'];
	$tMerchantRemarks = $_POST['MerchantRemarks'];
	$tPaymentLinkType = $_POST['PaymentLinkType'];
//2、生成订单对象
	$ord=new Order();
	$ord->setOrderNo($tOrderNo);
	$ord->setExpiredDate($tExpiredDate);
	$ord->setOrderDesc($tOrderDesc);
	$ord->setOrderDate($tOrderDate);
	$ord->setOrderTime($tOrderTime);
	$ord->setOrderAmount($tOrderAmountStr);
	$ord->setOrderURL($tOrderURL);
	$ord->setBuyIP($tBuyIP);
//3、生成定单订单对象，并将订单明细加入定单中（可选信息）
	$ordItemOne=new OrderItem();
	$ordItemOne->__constructOrderItem($tOrderNo, $tOrderDesc, $tOrderAmountStr, 1);
	$ordItemOnexml=$ordItemOne->getXMLDocument();
	
	$ord->addOrderItem($ordItemOnexml);
	$ordxml=$ord->getXMLDocument(3);
	//echo $ord->getXMLDocument(1);
//4、生成支付请求对象
	$pr=new PaymentRequest();
	$pr->setOrder($ordxml);
	//echo $pr->getOrder();
	$pr->setProductType($tProductType);
	$pr->setPaymentType($tPaymentType);
	$pr->setNotifyType($tNotifyType);
	//$pr->setResultNotifyURL('http://localhost:8118/WebSite4/Default.aspx');
	$pr->setResultNotifyURL($tResultNotifyURL);
	$pr->setMerchantRemarks($tMerchantRemarks);
	$pr->setPaymentLinkType($tPaymentLinkType);
//5、传送支付请求并取得支付网址
	$tTrxResponse = $pr->extendPostRequest(1);
	if($tTrxResponse->isSuccess())
	{ //6、支付请求提交成功，将客户端导向支付页面
		$paymentUrl=$tTrxResponse->getValue('PaymentURL');
		echo "<script language='javascript'>";
		echo "location.href='$paymentUrl'";
		echo "</script>";
	}
	else {
   //7、支付请求提交失败，商户自定后续动作
?>

<body>
<center>支付请求<br/>
<?php 
	echo "ReturnCode   = [".$tTrxResponse->getReturnCode()."]<br>";
	echo "ErrorMessage = [".$tTrxResponse->getErrorMessage()."]<br>";
	}
?>
<a href='Merchant.html'>回商户首页</a><br/></center>
</body>
</html>