<?php
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');


class AgentBatchDetail
{
	/**
	 *[状态]属性
	 *未处理：STATUS_UNDONE
	 */
	const STATUS_UNDONE='x';
	
	/**
	 *[状态]属性
	 *成功：STATUS_SUCCESS
	 */
	const STATUS_SUCCESS='0';

	/**
	 *[状态]属性
	 *失败：STATUS_FAIL
	 */
	const STATUS_FAIL='1';

	/**
	 *[状态]属性
	 *STATUS_NORESPONSE
	 */
	const STATUS_NORESPONSE='2';

	/** 订单编号最大长度 */
	const ORDER_NO_LEN=50;
	/**
	 * 商户编号
	 */
	private $iMerchantNo='';

	/** 订单有效期 */
	private $iExpiredDate=30;

	/**
	 * 批次编号
	 */
	private $iBatchNo='';

	/**
	 * 批次日期
	 */
	private $iBatchDate='';

	/**
	 * 账单编号
	 */
	private $iOrderNo='';

	/**
	 * 账单金额
	 */
	private $iOrderAmount=0;

	/**
	 * 账单币种
	 */
	private $iCurrency='';
	/**
	 * 证件号码
	 */
	private $iCertificateNo='';
	/**
	 * 签约协议号
	 */
	private $iContractID='';
	/**
	 * 商品编号
	 */
	private $iProductID='';

	/**
	 * 商品名称
	 */
	private $iProductName='';
	/**
	 * 商品数量
	 */
	private $iProductNum=0;

	/**
	 * 订单状态
	 */
	private $iOrderStatus='';
		/**
	 * 设定[商户编号]属性
	 * 
	 * @param aMerchantNo
	 *            商户编号
	 */
	public function setMerchantNo($aMerchantNo)
	{
		$this->iMerchantNo=trim($aMerchantNo);
	}

	/**
	 * 取得[商户编号]属性
	 */
	public function getMerchantNo()
	{
		return $this->iMerchantNo;
	}
	/**
	 * 设定[订单有效期]属性
	 * 
	 * @param aExpiredDate
	 *            订单有效期
	 */
	public function setExpiredDate($aExpiredDate)
	{
		$this->iExpiredDate=trim($aExpiredDate);
	}

	/**
	 * 取得[订单有效期]属性
	 */
	public function getExpiredDate()
	{
		return $this->iExpiredDate;
	}

	/**
	 * 设定[批次编号]属性
	 * 
	 * @param aBatchNo
	 *            批次编号
	 */
	public function setBatchNo($aBatchNo)
	{
		$this->iBatchNo=trim($aBatchNo);
	}


	/**
	 * 取得[批次编号]属性
	 */
	public function getBatchNo()
	{
		return $this->iBatchNo;
	}


	/**
	 * 设定[批次日期]属性
	 * 
	 * @param aOrderNo
	 *            批次日期
	 */
	public function setBatchDate($aBatchDate)
	{
		$this->iBatchDate=trim($aBatchDate);
	}


	/**
	 * 取得[批次日期]属性
	 */
	public function getBatchDate()
	{
		return $this->iBatchDate;
	}

	/**
	 * 设定[账单编号]属性
	 * 
	 * @param aOrderNo
	 *            备注
	 */
	public function setOrderNo($aOrderNo)
	{
		$this->iOrderNo=trim($aOrderNo);
	}

	/**
	 * 取得[账单编号]属性
	 */
	public function getOrderNo()
	{
		return $this->iOrderNo;
	}

	/**
	 * 设定[账单金额]属性
	 * 
	 * @param aOrderAmount
	 *            账单金额
	 */
	public function setOrderAmount($aOrderAmount)
	{
		$this->iOrderAmount=$aOrderAmount;
	}

	/**
	 * 取得[账单金额]属性
	 */
	public function getOrderAmount()
	{
		return $this->iOrderAmount;
	}

	/**
	 * 设定[币种]属性
	 * 
	 * @param aCurrency
	 *            币种
	 */
	public function setCurrency($aCurrency)
	{
		$this->iCurrency=trim($aCurrency);
	}

	/**
	 * 取得[币种]属性
	 */
	public function getCurrency()
	{
		return $this->iCurrency;
	}

	/**
	 * 设定[证件号码]属性
	 * 
	 * @param aCertificateNo
	 *            证件号码
	 */
	public function setCertificateNo($aCertificateNo)
	{
		$this->iCertificateNo=trim($aCertificateNo);
	}

	/**
	 * 取得[证件号码]属性
	 */
	public function getCertificateNo()
	{
		return $this->iCertificateNo;
	}

	/**
	 * 设定[商品编号]属性
	 * 
	 * @param aProductID
	 *            商品编号
	 */

	public function setProductID($aProductID)
	{
		$this->iProductID=trim($aProductID);
	}


	/**
	 * 取得[商品编号]属性
	 */
	public function getProductID()
	{
		return $this->iProductID;
	}

	/**
	 * 设定[商品名称]属性
	 * 
	 * @param aProductName
	 *            商品名称
	 */
	public function setProductName($aProductName)
	{
		$this->iProductName=trim($aProductName);
	}

	/**
	 * 取得[商品名称]属性
	 */
	public function getProductName()
	{
		return $this->iProductName;
	}


	/**
	 * 设定[商品数量]属性
	 * 
	 * @param aProductNum
	 *            商品数量
	 */

	public function setProductNum($aProductNum)
	{
		$this->iProductNum=$aProductNum;
	}

	/**
	 * 取得[商品数量]属性
	 */
	public function getProductNum()
	{
		return $this->iProductNum;
	}

	/**
	 * 设定[签约协议号]属性
	 * 
	 * @param aContractInfo
	 *            签约记录
	 */
	public function setContractID($aContractID)
	{
		$this->iContractID=trim($aContractID);
	}

	/**
	 * 取得[签约协议号]属性
	 */
	public function getContractID()
	{
		return $this->iContractID;
	}

	/**
	 * 设定[状态]属性
	 * 
	 * @param aOrderStatus
	 *            状态
	 * @return self
	 */
	public function setOrderStatus($aOrderStatus)
	{
		$this->iOrderStatus=trim($aOrderStatus);
	}

	/**
	 * 取得[状态]属性
	 */
	public function getOrderStatus()
	{
		return $this->iOrderStatus;
	}
	
   /**
    * 构造AgentBatchDetail对象
	*
    */
	public function __construct()
	{
	}
	/**
	*用XML文件初始对象的属性。
    */
	public function constructAgentBatchDetail($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setOrderNo($xml->getValueNoNull('OrderNo'));
		$this->setOrderAmount($xml->getValueNoNull('OrderAmount'));
		$this->setCertificateNo($xml->getValueNoNull('CertificateNo'));
		$this->setContractID($xml->getValueNoNull('ContractID'));
		$this->setProductID($xml->getValueNoNull('ProductID'));
		$this->setProductName($xml->getValueNoNull('ProductName'));
		$this->setProductNum($xml->getValueNoNull('ProductNum'));
		$this->setOrderStatus($xml->getValueNoNull('OrderStatus'));
		//原来java版有orderitem，但是没有给agentbatchdetail任何对象属性赋值
		//个人觉得原来那2行没有用
		//$tOrderItems = $xml->getValueArray('OrderItem');
		//for($i=0;$i<count(tOrderItems);$i++)
		//{

		//}
	}
	/**
	 * 设定状态
	 * 
	 * @param aStatus
	 *            状态<br>
	 *            self::STATUS_UNDONE : 未处理<br>
	 *            self::STATUS_SUCCESS : 处理成功<br>
	 *            self::STATUS_FAIL : 处理失败<br>
	 *            self::STATUS_NORESPONSE : 无回应<br>
	 */
	public function getStatusChinese($aStatus)
	{
		/*
		 * 传入批量内状态代码，回传状态的中文说明
		 */
		$tStatusChinese='';
		if($aStatus==self::STATUS_UNDONE)
		{
			$tStatusChinese='未处理';
		}else if($aStatus==self::STATUS_SUCCESS)
		{
			$tStatusChinese='处理成功';
		}else if($aStatus==self::STATUS_FAIL)
		{
			$tStatusChinese='处理失败';
		}else if($aStatus==self::STATUS_NORESPONSE)
		{
			$tStatusChinese='无回应';
		}else 
		{
			$tStatusChinese='未知状态';
		}
		return $tStatusChinese;
	}

	public function checkRequest()
	{
		 //TODO 自动生成的方法存根
		if(!DataVerifier::isValidString($this->iOrderNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100,TrxException::TRX_EXC_MSG_1101,'订单号不合法');
		if(!DataVerifier::isValidCertificateNo($this->iCertificateNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100,TrxException::TRX_EXC_MSG_1101,'客户身份证号不合法');
		if(!DataVerifier::isValidString($this->iContractID))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100,TrxException::TRX_EXC_MSG_1101,'签约协议号不合法');
		if(!DataVerifier::isValidAmount($this->iOrderAmount,2))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100,TrxException::TRX_EXC_MSG_1101,'账单金额不合法');
		if(!DataVerifier::isValidString($this->iProductID))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100,TrxException::TRX_EXC_MSG_1101,'商品编号不合法');
		if(!DataVerifier::isValidString($this->iProductName))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100,TrxException::TRX_EXC_MSG_1101,'商品名称不合法');
	}
}
/*
$abd=new AgentBatchDetail();
$xml='<OrderNo>3333</OrderNo><OrderAmount>5.00</OrderAmount><CertificateNo>123456789012345</CertificateNo>
	  <ContractID>44444</ContractID><ProductID>ppppp</ProductID><ProductName>name</ProductName><ProductNum>2</ProductNum>
	  <OrderStatus>0</OrderStatus>';
$abd->constructAgentBatchDetail(new XMLDocument($xml));
echo $abd->getStatusChinese($abd->getOrderStatus());
 $abd->checkRequest();
*/

?>