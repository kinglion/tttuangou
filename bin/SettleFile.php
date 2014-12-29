<?php
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');

class SettleFile
{

	    /** �������� - ���׶��� */
	const SETTLE_TYPE_TRX='TRX';
    
    /** �������� - ���ǿ����׶��� */
	const SETTLE_TYPE_CREDIT_TRX='CREDIT_TRX';


    /** �������� - ������� */
    const SETTLE_TYPE_SETTLE='SETTLE';

    /** �������� - ���װ���ָ��ʱ��� */
	const SETTLE_TYPE_TRX_BYHOUR='TRXBYHOUR';

	 /** �������ڣ�YYYY/MM/DD��*/
	private $iSettleDate='';
    
    /** �������� */
	private $iSettleType='';

    /** ���κ� */
	private $iBatchNo='';

    /** ֧���ܱ��� */
	private $iNumOfPayments=0;

    /** ֧���ܽ�� */
	private $iSumOfPayAmount=0;

    /** �˻��ܱ��� */
	private $iNumOfRefunds=0;

    /** �˻��ܽ�� */
	private $iSumOfRefundAmount=0;
    
    /** ����������̻������˻��Ľ��ѿ۳������ѣ�*/
	private $iSettleAmount=0;

    /** �����Ѻϼ� */
	private $iFee=0;

    /** ������ϸ */
	private $iDetailRecords=array();

	
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
     * �趨���κ�
     * @param aBatchNo ���κ�
     */
	public function setBatchNo($aBatchNo)
	{
		$this->iBatchNo=trim($aBatchNo);
	}

    /**
     * ���κ�
     * @return ���κ�
     */
	public function getBatchNo()
	{
		return $this->iBatchNo;
	}

    /**
     * �趨֧���ܱ���
     * @param aNumOfPayments ֧���ܱ���
     */
	public function setNumOfPayments($aNumOfPayments)
	{
		$this->iNumOfPayments=$aNumOfPayments;
	}

    /**
     * ֧���ܱ���
     * @return ֧���ܱ���
     */
	public function getNumOfPayments()
	{
		return $this->iNumOfPayments;
	}

    /**
     * �趨֧���ܽ��
     * @param aSumOfPayAmount ֧���ܽ��
     */
	public function setSumOfPayAmount($aSumOfPayAmount)
	{
		$this->iSumOfPayAmount=$aSumOfPayAmount;
	}

    /**
     * ֧���ܽ��
     * @return ֧���ܽ��
     */
	public function getSumOfPayAmount()
	{
		return $this->iSumOfPayAmount;
	}


    /**
     * �趨�˻��ܱ���
     * @param aNumOfRefunds �˻��ܱ���
     */
	public function setNumOfRefunds($aNumOfRefunds)
	{
		$this->iNumOfRefunds=$aNumOfRefunds;
	}

    /**
     * �˻��ܱ���
     * @return �˻��ܱ���
     */
	public function getNumOfRefunds()
	{
		return $this->iNumOfRefunds;
	}

    /**
     * �趨�˻��ܽ��
     * @param aSumOfRefundAmount �˻��ܽ��
     */
	public function setSumOfRefundAmount($aSumOfRefundAmount)
	{
		$this->iSumOfRefundAmount=$aSumOfRefundAmount;
	}

    /**
     * �˻��ܽ��
     * @return �˻��ܽ��
     */
	public function getSumOfRefundAmount()
	{
		return $this->iSumOfRefundAmount;
	}

    /**
     * �趨������
     * @param aSumOfRefundAmount ����������̻������˻��Ľ��ѿ۳������ѣ�
     */
	public function setSettleAmount($aSettleAmount)
	{
		$this->iSettleAmount=$aSettleAmount;
	}

    /**
     * ������
     * @return ����������̻������˻��Ľ��ѿ۳������ѣ�
     */
	public function getSettleAmount()
	{
		return $this->iSettleAmount;
	}

    /**
     * �趨�����Ѻϼ�
     * @param aFee �����Ѻϼ�
     */
	public function setFee($aFee)
	{
		$this->iFee=$aFee;
	}

    /**
     * �����Ѻϼ�
     * @return �����Ѻϼ�
     */
	public function getFee()
	{
		return $this->iFee;
	}

    /**
     * ������ϸ
     * @return ������ϸ����������ÿ����λ��ʹ�ö��ŷָ���<br>
     * ��λһ��P��ʾ֧�����ף�R��ʾ�˻�����
     * ��λ����������
     * ��λ�������
     * ��λ�ģ�ƾ֤��
     */
	public function getDetailRecords()
	{
		return $this->iDetailRecords;
	}
	/**
     * Class SettleFile ���캯����
     */
	public function __construct()
	{
	}
    
    /**
     * ΪClass SettleFile TrxResponse�����ʼ����������ԡ�
     * @param aTrxResponse ��ʼ�����TrxResponse����
     */
	public function constructSettleFile($aTrxResponse)
	{
		$this->init($aTrxResponse);
	}
    
    /**
     * TrxResponse�����ʼ��������ԡ�
     * @param aTrxResponse ��ʼ�����TrxResponse����
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
     * ���潻�׼�¼���ļ�
     * @param aFileName �ļ���
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
     * ���ļ��ж��뽻�׼�¼
     * @param aFileName �ļ���
     * @return
     */
	public function load($aFileName)
	{
		//file_get_contents���ĵ������ַ������ܸ��ȶ�  file_exists
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