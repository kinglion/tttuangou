<html>
<head>
<title>TrustPay - ֧������</title>
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
//1��ȡ��֧����������Ҫ����Ϣ
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
//2�����ɶ�������
	$ord=new Order();
	$ord->setOrderNo($tOrderNo);
	$ord->setExpiredDate($tExpiredDate);
	$ord->setOrderDesc($tOrderDesc);
	$ord->setOrderDate($tOrderDate);
	$ord->setOrderTime($tOrderTime);
	$ord->setOrderAmount($tOrderAmountStr);
	$ord->setOrderURL($tOrderURL);
	$ord->setBuyIP($tBuyIP);
//3�����ɶ����������󣬲���������ϸ���붨���У���ѡ��Ϣ��
	$ordItemOne=new OrderItem();
	$ordItemOne->__constructOrderItem($tOrderNo, $tOrderDesc, $tOrderAmountStr, 1);
	$ordItemOnexml=$ordItemOne->getXMLDocument();
	
	$ord->addOrderItem($ordItemOnexml);
	$ordxml=$ord->getXMLDocument(3);
	//echo $ord->getXMLDocument(1);
//4������֧���������
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
//5������֧������ȡ��֧����ַ
	$tTrxResponse = $pr->extendPostRequest(1);
	if($tTrxResponse->isSuccess())
	{ //6��֧�������ύ�ɹ������ͻ��˵���֧��ҳ��
		$paymentUrl=$tTrxResponse->getValue('PaymentURL');
		echo "<script language='javascript'>";
		echo "location.href='$paymentUrl'";
		echo "</script>";
	}
	else {
   //7��֧�������ύʧ�ܣ��̻��Զ���������
?>

<body>
<center>֧������<br/>
<?php 
	echo "ReturnCode   = [".$tTrxResponse->getReturnCode()."]<br>";
	echo "ErrorMessage = [".$tTrxResponse->getErrorMessage()."]<br>";
	}
?>
<a href='Merchant.html'>���̻���ҳ</a><br/></center>
</body>
</html>