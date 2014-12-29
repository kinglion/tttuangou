<?php
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');

class SettleFile
{

	    /** 对账类型 - 交易对账 */
	const SETTLE_TYPE_TRX='TRX';
    
    /** 对账类型 - 贷记卡交易对账 */
	const SETTLE_TYPE_CREDIT_TRX='CREDIT_TRX';


    /** 对账类型 - 结算对账 */
    const SETTLE_TYPE_SETTLE='SETTLE';

    /** 对帐类型 - 交易按照指定时间段 */
	const SETTLE_TYPE_TRX_BYHOUR='TRXBYHOUR';

	 /** 对账日期（YYYY/MM/DD）*/
	private $iSettleDate='';
    
    /** 对账类型 */
	private $iSettleType='';

    /** 批次号 */
	private $iBatchNo='';

    /** 支付总笔数 */
	private $iNumOfPayments=0;

    /** 支付总金额 */
	private $iSumOfPayAmount=0;

    /** 退货总笔数 */
	private $iNumOfRefunds=0;

    /** 退货总金额 */
	private $iSumOfRefundAmount=0;
    
    /** 结算金额（划入商户结算账户的金额，已扣除手续费）*/
	private $iSettleAmount=0;

    /** 手续费合计 */
	private $iFee=0;

    /** 交易明细 */
	private $iDetailRecords=array();

	
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
     * 设定批次号
     * @param aBatchNo 批次号
     */
	public function setBatchNo($aBatchNo)
	{
		$this->iBatchNo=trim($aBatchNo);
	}

    /**
     * 批次号
     * @return 批次号
     */
	public function getBatchNo()
	{
		return $this->iBatchNo;
	}

    /**
     * 设定支付总笔数
     * @param aNumOfPayments 支付总笔数
     */
	public function setNumOfPayments($aNumOfPayments)
	{
		$this->iNumOfPayments=$aNumOfPayments;
	}

    /**
     * 支付总笔数
     * @return 支付总笔数
     */
	public function getNumOfPayments()
	{
		return $this->iNumOfPayments;
	}

    /**
     * 设定支付总金额
     * @param aSumOfPayAmount 支付总金额
     */
	public function setSumOfPayAmount($aSumOfPayAmount)
	{
		$this->iSumOfPayAmount=$aSumOfPayAmount;
	}

    /**
     * 支付总金额
     * @return 支付总金额
     */
	public function getSumOfPayAmount()
	{
		return $this->iSumOfPayAmount;
	}


    /**
     * 设定退货总笔数
     * @param aNumOfRefunds 退货总笔数
     */
	public function setNumOfRefunds($aNumOfRefunds)
	{
		$this->iNumOfRefunds=$aNumOfRefunds;
	}

    /**
     * 退货总笔数
     * @return 退货总笔数
     */
	public function getNumOfRefunds()
	{
		return $this->iNumOfRefunds;
	}

    /**
     * 设定退货总金额
     * @param aSumOfRefundAmount 退货总金额
     */
	public function setSumOfRefundAmount($aSumOfRefundAmount)
	{
		$this->iSumOfRefundAmount=$aSumOfRefundAmount;
	}

    /**
     * 退货总金额
     * @return 退货总金额
     */
	public function getSumOfRefundAmount()
	{
		return $this->iSumOfRefundAmount;
	}

    /**
     * 设定结算金额
     * @param aSumOfRefundAmount 结算金额（划入商户结算账户的金额，已扣除手续费）
     */
	public function setSettleAmount($aSettleAmount)
	{
		$this->iSettleAmount=$aSettleAmount;
	}

    /**
     * 结算金额
     * @return 结算金额（划入商户结算账户的金额，已扣除手续费）
     */
	public function getSettleAmount()
	{
		return $this->iSettleAmount;
	}

    /**
     * 设定手续费合计
     * @param aFee 手续费合计
     */
	public function setFee($aFee)
	{
		$this->iFee=$aFee;
	}

    /**
     * 手续费合计
     * @return 手续费合计
     */
	public function getFee()
	{
		return $this->iFee;
	}

    /**
     * 交易明细
     * @return 交易明细，交易资料每个栏位间使用逗号分隔。<br>
     * 栏位一：P表示支付交易，R表示退货交易
     * 栏位二：订单号
     * 栏位三：金额
     * 栏位四：凭证号
     */
	public function getDetailRecords()
	{
		return $this->iDetailRecords;
	}
	/**
     * Class SettleFile 构造函数。
     */
	public function __construct()
	{
	}
    
    /**
     * 为Class SettleFile TrxResponse对象初始化对象的属性。
     * @param aTrxResponse 初始对象的TrxResponse对象。
     */
	public function constructSettleFile($aTrxResponse)
	{
		$this->init($aTrxResponse);
	}
    
    /**
     * TrxResponse对象初始对象的属性。
     * @param aTrxResponse 初始对象的TrxResponse对象。
     */
	public function init($aTrxResponse)
	{
		
		//$trxres=new TrxResponse();
		//$trxres->initWithXML(new XMLDocument($aTrxResponse));
		$this->setSettleDate($aTrxResponse->getValue('SettleDate'));
		$this->setSettleType($aTrxResponse->getValue('SettleType'));
		$this->setBatchNo($aTrxResponse->getValue('BatchNo'));
		$this->setNumOfPayments($aTrxResponse->getValue('NumOfPayments'));
		$this->setSumOfPayAmount($aTrxResponse->getValue('SumOfPayAmount'));
		$this->setNumOfRefunds($aTrxResponse->getValue('NumOfRefunds'));
		$this->setSumOfRefundAmount($aTrxResponse->getValue('SumOfRefundAmount'));
		if($this->iSettleType==self::SETTLE_TYPE_SETTLE)
		{
			$this->setSettleAmount($aTrxResponse->getValue('SettleAmount'));
			$this->setFee($aTrxResponse->getValue('Fee'));
		}
		$tDetailRecords = new XMLDocument($aTrxResponse->getValue('DetailRecords'));
		//$tRecords=$tDetailRecords->getValueArray('Record');
		$this->iDetailRecords=$this->iDetailRecords+$tDetailRecords->getValueArray('Record');
	}
	    
    /**
     * 保存交易记录至文件
     * @param aFileName 文件名
     * @return 
     */
	public function save ($aFileName)
	{
			$handle = fopen($aFileName, 'a');
			if($handle!=false)
			{
				try
				{
				fwrite($handle,"<SettleFile>\n");
				fwrite($handle,"<SettleDate>");
				fwrite($handle,$this->iSettleDate);
				fwrite($handle,"</SettleDate>\n");
				fwrite($handle,"<SettleType>");
				fwrite($handle,$this->iSettleType);
				fwrite($handle,"</SettleType>\n");
				fwrite($handle,"<BatchNo>");
				fwrite($handle,$this->iBatchNo);
				fwrite($handle,"</BatchNo>\n");
				fwrite($handle,"<NumOfPayments>");
				fwrite($handle,$this->iNumOfPayments);
				fwrite($handle,"</NumOfPayments>\n");
				fwrite($handle,"<SumOfPayAmount>");
				fwrite($handle,$this->iSumOfPayAmount);
				fwrite($handle,"</SumOfPayAmount>\n");
				fwrite($handle,"<NumOfRefunds>");
				fwrite($handle,$this->iNumOfRefunds);
				fwrite($handle,"</NumOfRefunds>\n");
				fwrite($handle,"<SumOfRefundAmount>");
				fwrite($handle,$this->iSumOfRefundAmount);
				fwrite($handle,"</SumOfRefundAmount>\n");
				if($this->iSettleType==self::SETTLE_TYPE_SETTLE)
				{
					fwrite($handle,"<SettleAmount>");
					fwrite($handle,$this->iSettleAmount);
					fwrite($handle,"</SettleAmount>\n");
					fwrite($handle,"<Fee>");
					fwrite($handle,$this->iFee);
					fwrite($handle,"</Fee>\n");
				}
				fwrite($handle,"<DetailRecords>\n");
					for($i=0;$i<count($this->iDetailRecords);$i++)
					{
						fwrite($handle,"<Record>");
						fwrite($handle,$this->iDetailRecords[$i]);
						fwrite($handle,"</Record>");
						fwrite($handle,"\n");
					}
				fwrite($handle,"</DetailRecords>\n");
				fwrite($handle,"</SettleFile>\n");
				//finally
				fclose($handle);
				}
				catch(Exception $e)
				{
					throw $e;
					//finally
					fclose($handle);
				}
				

			}
	}
	    /**
     * 由文件中读入交易记录
     * @param aFileName 文件名
     * @return
     */
	public function load($aFileName)
	{
		//file_get_contents把文档读入字符串性能更稳定  file_exists
		if(is_readable($aFileName))
		{
			$handle = fopen($aFileName, "r");
			if($handle!=false)
			{
				$contents = fread($handle, filesize ($aFileName));
				fclose($handle);
				$contents.="<ReturnCode>0000</ReturnCode>";
				$this->init($contents);

			}
		}
	}

}
/*
$xml='<SettleDate>2012/03/01</SettleDate><SettleType>SETTLE</SettleType><BatchNo>000002</BatchNo>
	  <NumOfPayments>5</NumOfPayments><SumOfPayAmount>50.00</SumOfPayAmount>
	  <NumOfRefunds>2</NumOfRefunds><SumOfRefundAmount>20.00</SumOfRefundAmount>
	  <SettleAmount>28.00</SettleAmount><Fee>2.00</Fee>
	  <DetailRecords>
	  <Record>jw</Record><Record>cxl</Record>
	  </DetailRecords><ReturnCode>0000</ReturnCode>';
$sf=new SettleFile();
$aFileName='d://settlefile.txt';
$sf->load($aFileName);
//$sf->constructSettleFile($xml);
echo $sf->getFee();
echo $sf->getSettleType();
echo $sf->getSettleDate();
echo $sf->getNumOfPayments();
echo $sf->getSumOfPayAmount();
echo $sf->getNumOfRefunds();
echo $sf->getSumOfRefundAmount();
echo $sf->getSettleAmount();
var_dump( $sf->getDetailRecords());
//$sf->save($aFileName);
*/

?>