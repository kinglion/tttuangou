<?php 
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('TrxRequest') or require(dirname(__FILE__).'/core/TrxRequest.php');
class_exists('TrxType') or require(dirname(__FILE__).'/TrxType.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');

class SettleRequest extends TrxRequest
{
	/** 对账日期 */
	private $iSettleDate = '';
	
	/** 对账类型 */
	private $iSettleType = '';
	
	/** 对帐开始时间*/
	private $iSettleStartHour = '';
	
	/** 对帐结束时间*/
	private $iSettleEndHour = '';
	
	/**
     * 设定对账开始时间
     * @param $aSettleStartHour 对账开始时间
     */
	public function setSettleStartHour($aSettleStartHour)
	{
		$this->iSettleStartHour=trim($aSettleStartHour);
	}
	
	/**
	 * 回传对账开始时间段
	 * @return 对账开始时间段
	 */
	public  function  getSettleStartHour()
	{
		return $this->iSettleStartHour;
	}
	/**
	 * 设定对账截止时间段
	 * @param aSettleStartHour 对账截止始时间段
	 * @return 对象本身
	 */
	public function setSettleEndHour($aSettleEndHour)
	{
		$this->iSettleEndHour=trim($aSettleEndHour);
	}
	/**
	 * 回传对账截止时间段
	 * @return 对账截止时间段
	 */
	public function getSettleEndHour()
	{
		return $this->iSettleEndHour;
	}
	/**
     * 设定对账日期
     * @param aSettleDate 对账日期（YYYY/MM/DD）
     */
	public function setSettleDate($aSettleDate)
	{
		$this->iSettleDate=trim($aSettleDate);
	}

    /**
     * 对账日期
     * @return 对账日期
     */
	public function getSettleDate()
	{
		return $this->iSettleDate;
	}

    /**
     * 设定对账类型
     * @param aSettleType 对账类型
     */
	public function setSettleType($aSettleType)
	{
		$this->iSettleType=trim($aSettleType);
	}

    /**
     * 回传对账类型
     * @return 对账类型
     */
	public function getSettleType()
	{
		return $this->iSettleType;
	}
	
	/**
	 * Class SettleRequest 默认构造函数
	 */
	public function __construct()
	{
		$this->iECMerchantType=TrxRequest::EC_MERCHANT_TYPE_B2C;
	}
	/**
	 * 回传交易报文。
	 * @throws 500001：组成交易报文的过程中发现内容不合法
	 * @return 交易报文信息
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
	 * 对账单下载请求信息是否合法
	 * @throws TrxException: 对账单下载请求不合法
	 */
	protected function checkRequest()
	{
		if(!DataVerifier::isValidDate($this->iSettleDate))
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'对账日期不合法！');
		if($this->iSettleType != SettleFile::SETTLE_TYPE_SETTLE && $this->iSettleType != SettleFile::SETTLE_TYPE_TRX && $this->iSettleType != SettleFile::SETTLE_TYPE_TRX_BYHOUR && $this->iSettleType != SettleFile::SETTLE_TYPE_CREDIT_TRX)
			throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'对账类型不合法！');
		if($this->iSettleType == SettleFile::SETTLE_TYPE_TRX_BYHOUR)
		{
			if(trim($this->iSettleStartHour) == '' || trim($this->iSettleEndHour) == '')
				throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'对账起止时间不合法，必须输入0-23之间的有效时间段！');
			$this->iSettleStartHour=strlen(trim($this->iSettleStartHour))<2 ? '0'.$this->iSettleStartHour : $this->iSettleStartHour;
			$this->iSettleEndHour=strlen(trim($this->iSettleEndHour))<2 ? '0'.$this->iSettleEndHour : $this->iSettleEndHour;
			if(strcmp($this->iSettleStartHour,'0') < 0 || strcmp($this->iSettleStartHour, '23') > 0 || strcmp($this->iSettleEndHour, '0') < 0 || strcmp($this->iSettleEndHour, 23) > 0)
				throw new TrxException(TrxException::TRX_EXC_CODE_1101, TrxException::TRX_EXC_MSG_1101,'对账起止时间不合法，必须输入0-23之间的有效时间段，且截止时间不小于开始时间！');
			
		}
	}
	/**
	 * 回传交易响应对象。
	 * @throws 500001：组成交易报文的过程中发现内容不合法
	 * @return 交易报文信息
	 */
	protected function constructResponse($aResponseMessage)
	{
		$tDownloadedTrxnLogs='';
			$arm = new XMLDocument($aResponseMessage);
		    $tTrnxLogs = $arm->getValueNoNull('ZIPDetailRecords');
		    if($tTrnxLogs != null&&$tTrnxLogs != "")
		    {
		    	//解码，解压缩流
				$tgzdecode=gzinflate(substr(base64_decode($tTrnxLogs), 10));
				 //将解压缩后的交易记录附加到原始报文中
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