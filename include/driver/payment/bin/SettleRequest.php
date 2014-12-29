<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');

class SettleRequest extends TrxRequest
{
	/** �������� */
	private $iSettleDate = '';
	
	/** �������� */
	private $iSettleType = '';
	
	/** ���ʿ�ʼʱ��*/
	private $iSettleStartHour = '';
	
	/** ���ʽ���ʱ��*/
	private $iSettleEndHour = '';
	
	/**
     * �趨���˿�ʼʱ��
     * @param $aSettleStartHour ���˿�ʼʱ��
     */
	public function setSettleStartHour($aSettleStartHour)
	{
		$this->iSettleStartHour=trim($aSettleStartHour);
	}
	
	/**
	 * �ش����˿�ʼʱ���
	 * @return ���˿�ʼʱ���
	 */
	public  function  getSettleStartHour()
	{
		return $this->iSettleStartHour;
	}
	/**
	 * �趨���˽�ֹʱ���
	 * @param aSettleStartHour ���˽�ֹʼʱ���
	 * @return ������
	 */
	public function setSettleEndHour($aSettleEndHour)
	{
		$this->iSettleEndHour=trim($aSettleEndHour);
	}
	/**
	 * �ش����˽�ֹʱ���
	 * @return ���˽�ֹʱ���
	 */
	public function getSettleEndHour()
	{
		return $this->iSettleEndHour;
	}
	/**
     * �趨��������
     * @param aSettleDate �������ڣ�YYYY/MM/DD��
     */
	public function setSettleDate($aSettleDate)
	{
		$this->iSettleDate=trim($aSettleDate);
	}

    /**
     * ��������
     * @return ��������
     */
	public function getSettleDate()
	{
		return $this->iSettleDate;
	}

    /**
     * �趨��������
     * @param aSettleType ��������
     */
	public function setSettleType($aSettleType)
	{
		$this->iSettleType=trim($aSettleType);
	}

    /**
     * �ش���������
     * @return ��������
     */
	public function getSettleType()
	{
		return $this->iSettleType;
	}
	
	/**
	 * Class SettleRequest Ĭ�Ϲ��캯��
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/**
	 * �ش����ױ��ġ�
	 * @throws 500001����ɽ��ױ��ĵĹ����з������ݲ��Ϸ�
	 * @return ���ױ�����Ϣ
	 */
	protected function getRequestMessage()
	{
		$str='<TrxRequest>'.
			 '<TrxType>'.TrxType::TRX_TYPE_SETTLE.'</TrxType>'.
			 '<SettleDate>'.$this->iSettleDate.'</SettleDate>'.
			 '<SettleStartHour>'.$this->iSettleStartHour.'</SettleStartHour>'.
			 '<SettleEndHour>'.$this->iSettleEndHour.'</SettleEndHour>'.
			 '<SettleType>'.$this->iSettleType.'</SettleType>'.
			 '<ZIP>YES</ZIP>'.
			 '</TrxRequest>';
		return $str;
	}
	/**
	 * ���˵�����������Ϣ�Ƿ�Ϸ�
	 * @throws TrxException: ���˵��������󲻺Ϸ�
	 */
	protected function checkRequest()
	{
		if(!DataVerifier::isValidDate($this->iSettleDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�������ڲ��Ϸ���');
		if($this->iSettleType != SettleFile::SETTLE_TYPE_SETTLE && $this->iSettleType != SettleFile::SETTLE_TYPE_TRX && $this->iSettleType != SettleFile::SETTLE_TYPE_TRX_BYHOUR && $this->iSettleType != SettleFile::SETTLE_TYPE_CREDIT_TRX)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'�������Ͳ��Ϸ���');
		if($this->iSettleType == SettleFile::SETTLE_TYPE_TRX_BYHOUR)
		{
			if(trim($this->iSettleStartHour) == '' || trim($this->iSettleEndHour) == '')
				throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'������ֹʱ�䲻�Ϸ�����������0-23֮�����Чʱ��Σ�');
			$this->iSettleStartHour=strlen(trim($this->iSettleStartHour))<2 ? '0'.$this->iSettleStartHour : $this->iSettleStartHour;
			$this->iSettleEndHour=strlen(trim($this->iSettleEndHour))<2 ? '0'.$this->iSettleEndHour : $this->iSettleEndHour;
			if(strcmp($this->iSettleStartHour,'0') < 0 || strcmp($this->iSettleStartHour, '23') > 0 || strcmp($this->iSettleEndHour, '0') < 0 || strcmp($this->iSettleEndHour, 23) > 0)
				throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'������ֹʱ�䲻�Ϸ�����������0-23֮�����Чʱ��Σ��ҽ�ֹʱ�䲻С�ڿ�ʼʱ�䣡');
			
		}
	}
	/**
	 * �ش�������Ӧ����
	 * @throws 500001����ɽ��ױ��ĵĹ����з������ݲ��Ϸ�
	 * @return ���ױ�����Ϣ
	 */
	protected function constructResponse($aResponseMessage)
	{
		$tDownloadedTrxnLogs='';
			$arm = new XMLDocument($aResponseMessage);
		    $tTrnxLogs = $arm->getValueNoNull('ZIPDetailRecords');
		    if($tTrnxLogs != null&&$tTrnxLogs != "")
		    {
		    	//���룬��ѹ����
				$tgzdecode=gzinflate(substr(base64_decode($tTrnxLogs), 10));
				 //����ѹ����Ľ��׼�¼���ӵ�ԭʼ������
				$aResponseMessage = $aResponseMessage.
								  '<DetailRecords>'.$tgzdecode.'</DetailRecords>';
				$trxRes=new TrxResponse();
				$trxRes->initWithXML(new XMLDocument($aResponseMessage));
				return $trxRes;
		    }
		    else {
		    	$trxRes = new TrxResponse();
				$trxRes->initWithXML($aResponseMessage);
				return $trxRes;
		    }
	}
	
}
?>