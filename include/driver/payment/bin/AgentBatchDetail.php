<?php
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');


class AgentBatchDetail
{
	/**
	 *[״̬]����
	 *δ����STATUS_UNDONE
	 */
	const STATUS_UNDONE='x';
	
	/**
	 *[״̬]����
	 *�ɹ���STATUS_SUCCESS
	 */
	const STATUS_SUCCESS='0';

	/**
	 *[״̬]����
	 *ʧ�ܣ�STATUS_FAIL
	 */
	const STATUS_FAIL='1';

	/**
	 *[״̬]����
	 *STATUS_NORESPONSE
	 */
	const STATUS_NORESPONSE='2';

	/** ���������󳤶� */
	const ORDER_NO_LEN=50;
	/**
	 * �̻����
	 */
	private $iMerchantNo='';

	/** ������Ч�� */
	private $iExpiredDate=30;

	/**
	 * ���α��
	 */
	private $iBatchNo='';

	/**
	 * ��������
	 */
	private $iBatchDate='';

	/**
	 * �˵����
	 */
	private $iOrderNo='';

	/**
	 * �˵����
	 */
	private $iOrderAmount=0;

	/**
	 * �˵�����
	 */
	private $iCurrency='';
	/**
	 * ֤������
	 */
	private $iCertificateNo='';
	/**
	 * ǩԼЭ���
	 */
	private $iContractID='';
	/**
	 * ��Ʒ���
	 */
	private $iProductID='';

	/**
	 * ��Ʒ����
	 */
	private $iProductName='';
	/**
	 * ��Ʒ����
	 */
	private $iProductNum=0;

	/**
	 * ����״̬
	 */
	private $iOrderStatus='';
		/**
	 * �趨[�̻����]����
	 * 
	 * @param aMerchantNo
	 *            �̻����
	 */
	public function setMerchantNo($aMerchantNo)
	{
		$this->iMerchantNo=trim($aMerchantNo);
	}

	/**
	 * ȡ��[�̻����]����
	 */
	public function getMerchantNo()
	{
		return $this->iMerchantNo;
	}
	/**
	 * �趨[������Ч��]����
	 * 
	 * @param aExpiredDate
	 *            ������Ч��
	 */
	public function setExpiredDate($aExpiredDate)
	{
		$this->iExpiredDate=trim($aExpiredDate);
	}

	/**
	 * ȡ��[������Ч��]����
	 */
	public function getExpiredDate()
	{
		return $this->iExpiredDate;
	}

	/**
	 * �趨[���α��]����
	 * 
	 * @param aBatchNo
	 *            ���α��
	 */
	public function setBatchNo($aBatchNo)
	{
		$this->iBatchNo=trim($aBatchNo);
	}


	/**
	 * ȡ��[���α��]����
	 */
	public function getBatchNo()
	{
		return $this->iBatchNo;
	}


	/**
	 * �趨[��������]����
	 * 
	 * @param aOrderNo
	 *            ��������
	 */
	public function setBatchDate($aBatchDate)
	{
		$this->iBatchDate=trim($aBatchDate);
	}


	/**
	 * ȡ��[��������]����
	 */
	public function getBatchDate()
	{
		return $this->iBatchDate;
	}

	/**
	 * �趨[�˵����]����
	 * 
	 * @param aOrderNo
	 *            ��ע
	 */
	public function setOrderNo($aOrderNo)
	{
		$this->iOrderNo=trim($aOrderNo);
	}

	/**
	 * ȡ��[�˵����]����
	 */
	public function getOrderNo()
	{
		return $this->iOrderNo;
	}

	/**
	 * �趨[�˵����]����
	 * 
	 * @param aOrderAmount
	 *            �˵����
	 */
	public function setOrderAmount($aOrderAmount)
	{
		$this->iOrderAmount=$aOrderAmount;
	}

	/**
	 * ȡ��[�˵����]����
	 */
	public function getOrderAmount()
	{
		return $this->iOrderAmount;
	}

	/**
	 * �趨[����]����
	 * 
	 * @param aCurrency
	 *            ����
	 */
	public function setCurrency($aCurrency)
	{
		$this->iCurrency=trim($aCurrency);
	}

	/**
	 * ȡ��[����]����
	 */
	public function getCurrency()
	{
		return $this->iCurrency;
	}

	/**
	 * �趨[֤������]����
	 * 
	 * @param aCertificateNo
	 *            ֤������
	 */
	public function setCertificateNo($aCertificateNo)
	{
		$this->iCertificateNo=trim($aCertificateNo);
	}

	/**
	 * ȡ��[֤������]����
	 */
	public function getCertificateNo()
	{
		return $this->iCertificateNo;
	}

	/**
	 * �趨[��Ʒ���]����
	 * 
	 * @param aProductID
	 *            ��Ʒ���
	 */

	public function setProductID($aProductID)
	{
		$this->iProductID=trim($aProductID);
	}


	/**
	 * ȡ��[��Ʒ���]����
	 */
	public function getProductID()
	{
		return $this->iProductID;
	}

	/**
	 * �趨[��Ʒ����]����
	 * 
	 * @param aProductName
	 *            ��Ʒ����
	 */
	public function setProductName($aProductName)
	{
		$this->iProductName=trim($aProductName);
	}

	/**
	 * ȡ��[��Ʒ����]����
	 */
	public function getProductName()
	{
		return $this->iProductName;
	}


	/**
	 * �趨[��Ʒ����]����
	 * 
	 * @param aProductNum
	 *            ��Ʒ����
	 */

	public function setProductNum($aProductNum)
	{
		$this->iProductNum=$aProductNum;
	}

	/**
	 * ȡ��[��Ʒ����]����
	 */
	public function getProductNum()
	{
		return $this->iProductNum;
	}

	/**
	 * �趨[ǩԼЭ���]����
	 * 
	 * @param aContractInfo
	 *            ǩԼ��¼
	 */
	public function setContractID($aContractID)
	{
		$this->iContractID=trim($aContractID);
	}

	/**
	 * ȡ��[ǩԼЭ���]����
	 */
	public function getContractID()
	{
		return $this->iContractID;
	}

	/**
	 * �趨[״̬]����
	 * 
	 * @param aOrderStatus
	 *            ״̬
	 * @return self
	 */
	public function setOrderStatus($aOrderStatus)
	{
		$this->iOrderStatus=trim($aOrderStatus);
	}

	/**
	 * ȡ��[״̬]����
	 */
	public function getOrderStatus()
	{
		return $this->iOrderStatus;
	}
	
   /**
    * ����AgentBatchDetail����
	*
    */
	public function __construct()
	{
	}
	/**
	*��XML�ļ���ʼ��������ԡ�
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
		//ԭ��java����orderitem������û�и�agentbatchdetail�κζ������Ը�ֵ
		//���˾���ԭ����2��û����
		//$tOrderItems = $xml->getValueArray('OrderItem');
		//for($i=0;$i<count(tOrderItems);$i++)
		//{

		//}
	}
	/**
	 * �趨״̬
	 * 
	 * @param aStatus
	 *            ״̬<br>
	 *            self::STATUS_UNDONE : δ����<br>
	 *            self::STATUS_SUCCESS : ����ɹ�<br>
	 *            self::STATUS_FAIL : ����ʧ��<br>
	 *            self::STATUS_NORESPONSE : �޻�Ӧ<br>
	 */
	public function getStatusChinese($aStatus)
	{
		/*
		 * ����������״̬���룬�ش�״̬������˵��
		 */
		$tStatusChinese='';
		if($aStatus==self::STATUS_UNDONE)
		{
			$tStatusChinese='δ����';
		}else if($aStatus==self::STATUS_SUCCESS)
		{
			$tStatusChinese='����ɹ�';
		}else if($aStatus==self::STATUS_FAIL)
		{
			$tStatusChinese='����ʧ��';
		}else if($aStatus==self::STATUS_NORESPONSE)
		{
			$tStatusChinese='�޻�Ӧ';
		}else 
		{
			$tStatusChinese='δ֪״̬';
		}
		return $tStatusChinese;
	}

	public function checkRequest()
	{
		 //TODO �Զ����ɵķ������
		if(!DataVerifier::isValidString($this->iOrderNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100,TrxException::TRX_EXC_MSG_1101,'�����Ų��Ϸ�');
		if(!DataVerifier::isValidCertificateNo($this->iCertificateNo))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100,TrxException::TRX_EXC_MSG_1101,'�ͻ����֤�Ų��Ϸ�');
		if(!DataVerifier::isValidString($this->iContractID))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100,TrxException::TRX_EXC_MSG_1101,'ǩԼЭ��Ų��Ϸ�');
		if(!DataVerifier::isValidAmount($this->iOrderAmount,2))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100,TrxException::TRX_EXC_MSG_1101,'�˵����Ϸ�');
		if(!DataVerifier::isValidString($this->iProductID))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100,TrxException::TRX_EXC_MSG_1101,'��Ʒ��Ų��Ϸ�');
		if(!DataVerifier::isValidString($this->iProductName))
			throw new TrxException(TrxException::TRX_EXC_CODE_1100,TrxException::TRX_EXC_MSG_1101,'��Ʒ���Ʋ��Ϸ�');
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