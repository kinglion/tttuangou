<?php
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('XMLDocument') or require(dirname(__FILE__).'/core/XMLDocument.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');

class AgentBatch
{
	/**
	 *[��׼״̬]���� ���������ˣ�STATUS_UNCHECK
	 */
	const STATUS_UNCHECK='0';

	/**
	 *[��׼״̬]���� ����ͨ�������ͣ�STATUS_CHECKSUCCESS
	 */
	const STATUS_CHECKSUCCESS='1';

	/**
	 *[��׼״̬]���� ���˲��أ�STATUS_REJECT
	 */
	const STATUS_REJECT='2';

	/**
	 *[����״̬]���� ����ͨ�����ѷ���(�ȴ�����)��STATUS_SEND
	 */
	const STATUS_SEND='3';
	/**
	 *[����״̬]���� ����ɹ���STATUS_SUCCESS
	 */
	const STATUS_SUCCESS='4';
	/**
	 *[����״̬]���� ����ʧ�ܣ�STATUS_FAIL
	 */
	const STATUS_FAIL='5';

	// ��������״̬����Դ�����ɵ�������ͨ����ѯ�����ڲ����������������̬��ã�������ҳ����ʾ������������״̬��һ��
	/**
	 *[����״̬]���� ���������ж����˿�ɹ���STATUS_ALL_SUCCESS
	 */
	const STATUS_ALL_SUCCESS='6';

	/**
	 *[����״̬]���� ���������ж����˿�ʧ�ܣ�STATUS_ALL_FAIL
	 */
	const STATUS_ALL_FAIL='7';

	/**
	 *[����״̬]���� �����ڲ��ֶ����˿�ɹ���STATUS_PART_SUCCESS
	 */
	const STATUS_PART_SUCCESS='8';

	/**
	 * �̻����
	 */
	private $iMerchantNo='';

	/**
	 * �������
	 */
	private $iBatchNo='';

	/**
	 * ��������
	 */
	private $iBatchDate='';
	/**
	 * ����ʱ��
	 */
	private $iBatchTime=0;

	/**
	 * ί�пۿ��ܽ��
	 */
	private $iAgentAmount=0;

	/**
	 * ί�пۿ��ܱ���
	 */
	private $iAgentCount=0;

	/**
	 * �������ʹ���
	 */
	private $iTrnxTypeNo='';
	/**
	 * ����״̬
	 */
	private $iBatchStatus='';

	/** ί�пۿ�����������ϸ��ΪAgentBatchDetail�����ArrayList���ϡ� */
	private $iAgentBatchDetail=array();

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
	 * �趨[ί���������κ�]����
	 * 
	 * @param aBatchNo
	 *            �������κ�
	 */
	public function setBatchNo($aBatchNo)
	{
		$this->iBatchNo=trim($aBatchNo);
	}

	/**
	 * ȡ��[ί���������κ�]����
	 */
	public function getBatchNo()
	{
		return $this->iBatchNo;
	}

	/**
	 * �趨[ί��������������]����
	 * 
	 * @param aBatchDate
	 *            ��������
	 */
	public function setBatchDate($aBatchDate)
	{
		$this->iBatchDate=trim($aBatchDate);
	}

	/**
	 * ȡ��[ί��������������]����
	 */
	public function getBatchDate()
	{
		return $this->iBatchDate;
	}

	/**
	 * �趨[ί����������ʱ��]����
	 * 
	 * @param aBatchTime
	 *            ����ʱ��
	 */
	public function setBatchTime($aBatchTime)
	{
		$this->iBatchTime=$aBatchTime;
	}

	/**
	 * ȡ��[ί����������ʱ��]����
	 */
	public function getBatchTime()
	{
		return $this->iBatchTime;
	}

	/**
	 * �趨[ί����������״̬]����
	 * 
	 * @param aBatchStatus
	 *            ����״̬
	 */
	public function setBatchStatus($aBatchStatus)
	{
		$this->iBatchStatus=trim($aBatchStatus);
	}

	/**
	 * ȡ��[ί����������״̬]����
	 */
	public function getBatchStatus()
	{
		return $this->iBatchStatus;
	}

	/**
	 * �趨[�����ܽ��]����
	 * 
	 * @param aRefundAmount
	 *            �����ܽ��
	 */
	public function setAgentAmount($aAgentAmount)
	{
		$this->iAgentAmount=$aAgentAmount;
	}

	/**
	 * ȡ��[�����ܽ��]����
	 */
	public function getAgentAmount()
	{
		return $this->iAgentAmount;
	}

	/**
	 * �趨[�����ܱ���]����
	 * 
	 * @param aRefundCount
	 *            �����ܱ���
	 */
	public function setAgentCount($aAgentCount)
	{
		$this->iAgentCount=$aAgentCount;
	}

	/**
	 * ȡ��[�����ܱ���]����
	 */
	public function getAgentCount()
	{
		return $this->iAgentCount;
	}

	/**
	 * �趨[�������ʹ���]����
	 * 
	 * @param aTrnxTypeNo
	 *            �������ʹ���
	 */
	public function setTrnxTypeNo($aTrnxTypeNo)
	{
		$this->iTrnxTypeNo=trim($aTrnxTypeNo);
	}

	/**
	 * ȡ��[�������ʹ���]����
	 */
	public function getTrnxTypeNo()
	{
		return $this->iTrnxTypeNo;
	}

	/**
	 * ����ί����ϸ
	 * 
	 * @return AgentBatch�����AgentBatchDetail���顣
	 */
	public function getAgentBatchDetail()
	{
		return $this->iAgentBatchDetail;
	}

	/**
	 * ��������ί����ϸ
	 * 
	 * @param aAgentBatchDetail
	 *            ����ί����ϸ��AgentBatchDetail������
	 */
	public function addAgentBatchDetail($aAgentBatchDetail)
	{
		$this->iAgentBatchDetail = array_push($this->iAgentBatchDetail,$aAgentBatchDetail);
	}
	
	/**
	 * ����AgentBatch����
	 */
	public function __construct()
	{
	}
	/**
	*��ʼ��AgentBatch����
	*
	*/
	public function constructAgentBatch($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->setMerchantNo($xml->getValueNoNull('MerchantNo'));
		$this->setBatchNo($xml->getValueNoNull('BatchNo'));
		$this->setBatchDate($xml->getValueNoNull('BatchDate'));
		$this->setBatchTime($xml->getValueNoNull('BatchTime'));
		$this->setBatchStatus($xml->getValueNoNull('BatchStatus'));
		$this->setAgentAmount($xml->getValueNoNull('AgentAmount'));
		$this->setAgentCount($xml->getValueNoNull('AgentCount'));
		$this->iAgentBatchDetail=$xml->getDocuments('AgentBatchDetail');
	}
	public function checkRequest()
	{
		if(!DataVerifier::isValidStringLen($this->iBatchNo,30))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101,TrxException::TRX_EXC_MSG_1101,'���κų��ȳ������ƻ�Ϊ��');
		if(!DataVerifier::isValidDate8($this->iBatchDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101,TrxException::TRX_EXC_MSG_1101,'�������ڸ�ʽ����ȷ');
		if(!DataVerifier::isValidAmount($this->iAgentAmount,2))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101,TrxException::TRX_EXC_MSG_1101,'ί�пۿ��ܽ���ȷ');
	}

	/**
	 * ȡ�ú�׼״̬������˵����
	 * 
	 * @param aStatus
	 *            ����״̬����
	 * @return tStatusChinese ����״̬������˵����
	 */
	public function getBatchSatusChinese($aStatus)
	{
		$tStatusChinese='';
		if($aStatus==self::STATUS_UNCHECK)
		{
			$tStatusChinese='����������';
		}
		else if($aStatus==self::STATUS_CHECKSUCCESS)
		{
			$tStatusChinese='��������ͨ��������';
		}
		else if($aStatus==self::STATUS_REJECT)
		{
			$tStatusChinese='�������˱�����';
		}
		else if($aStatus==self::STATUS_SEND)
		{
			$tStatusChinese='�����ȴ�����';
		}
		else if($aStatus==self::STATUS_SUCCESS)
		{
			$tStatusChinese='�����ύ�ɹ�';
		}
		else if($aStatus==self::STATUS_FAIL)
		{
			$tStatusChinese='�����ύʧ��';
		}
		else
		{
			$tStatusChinese='δ֪״̬';
		}
		return $tStatusChinese;
	}
}
/*
$ab=new AgentBatch();
$xml='<MerchantNo>555555555555</MerchantNo><BatchNo>1</BatchNo><BatchDate>20090527</BatchDate>
	  <BatchTime>12:08:09</BatchTime><BatchStatus>0</BatchStatus><AgentAmount>10.00</AgentAmount>
	  <AgentCount>10</AgentCount>
	  <AgentBatchDetail>
	  <OrderNo>3333</OrderNo><OrderAmount>5.00</OrderAmount><CertificateNo>123456789012345</CertificateNo>
	  <ContractID>44444</ContractID><ProductID>ppppp</ProductID><ProductName>name</ProductName><ProductNum>2</ProductNum>
	  <OrderStatus>0</OrderStatus>
	  <OrderNo>2222</OrderNo><OrderAmount>2.00</OrderAmount><CertificateNo>123456789012435</CertificateNo>
	  <ContractID>44445</ContractID><ProductID>pppqqq</ProductID><ProductName>name2</ProductName><ProductNum>4</ProductNum>
	  <OrderStatus>0</OrderStatus>
	  </AgentBatchDetail>';
$ab->constructAgentBatch($xml);
var_dump($ab->getAgentBatchDetail());
echo "<br>";
echo $ab->getAgentAmount()."<br>";
echo $ab->getBatchSatusChinese($ab->getBatchStatus())."<br>";
echo $ab->getAgentCount()."<br>";
echo $ab->getBatchDate()."<br>";
echo $ab->getBatchNo()."<br>";
echo $ab->getBatchTime()."<br>";
echo $ab->getMerchantNo()."<br>";
echo $ab->getTrnxTypeNo()."<br>";//Ϊ�գ�xml��û�и�trnxtypeno��ֵ
if($ab->checkRequest()) echo 'nan '; else echo 'ok ';
*/
?>