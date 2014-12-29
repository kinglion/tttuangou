<?php
class_exists('TrxException') or require(dirname(__FILE__).'/core/TrxException.php');
class_exists('DataVerifier') or require(dirname(__FILE__).'/core/DataVerifier.php');
class_exists('TrxResponse') or require(dirname(__FILE__).'/core/TrxResponse.php');

class OrderItem
{
    /** 产品代码*/
    private $iProductID = '';

    /** 产品名称*/
    private $iProductName = '';

    /**产品单价*/
    private $iUnitPrice = 0;

    /**购买数量*/
    private $iQty = 0;

    /**产品代码最大长度*/
    const PRODUCT_ID_LEN = 20;

    /**产品名称最大长度*/
    const PRODUCT_NAME_LEN = 50;

   
    /**
     * Class OrderItem 默认构造函数
     */
	public function __construct(){
	
	}

    /**
     * 给OrderItem对象[产品代码]、[产品名称]、[产品单价]及[购买数量]赋初始值。
     * @param aProductID   产品代码
     * @param aProductName 产品名称
     * @param aUnitPrice   产品单价
     * @param aQty         购买数量
     */
	 public function __constructOrderItem($aProductID,$aProductName,$aUnitPrice,$aQty){
		$this->iProductID=$aProductID;
		$this->iProductName=$aProductName;
		$this->iUnitPrice=$aUnitPrice;
		$this->iQty=$aQty;
	 }
    /**
     * 给 OrderItem 使用XML文件初始化属性。
     * @param aXMLDocument 初始对象的XML文件。<br>XML文件范例：<br>
     * &lt;OrderItem&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;ProductID&gt;IP000001&lt;/ProductID&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;ProductName&gt;中国移动IP卡&lt;/ProductName&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;UnitPrice&gt;10000&lt;/UnitPrice&gt;<br>
     * &nbsp;&nbsp;&nbsp;&lt;Qty&gt;1&lt;/Qty&gt;<br>
     * &lt;/OrderItem&gt;<br>
     */
	public function __constructXMlDocument($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->iProductID=$xml->getValueNoNull('ProductID');
		$this->iProductName=$xml->getValueNoNull('ProductName');
	    $this->iUnitPrice=$xml->getValueNoNull('UnitPrice');
		$this->iQty=$xml->getValueNoNull('Qty');

	}

    public function getProductID()
    {
        return $this->iProductID;
    }
    public function setProductID($productID)
    {
        $this->iProductID = trim($productID);
    }
    
    public function getProductName()
    {
        return $this->iProductName;
    }
    public function setProductName($productName)
    {
        $this->iProductName = trim($productName);
    }

    public function getUnitPrice()
    {
        return $this->iUnitPrice;
    }
    public function setUnitPrice($unitPrice)
    {
        $this->iUnitPrice = $unitPrice;
    }

    public function getQty()
    {
        return $this->iQty;
    }
    public function setQty($qty)
    {
        $this->iQty = $qty;
    }
	//获取总金额
    public function getAmount()
    {
        return $this->iUnitPrice *$this->iQty;
    }
	
	 /**
     * 订单明细信息是否合法
     * @return 订单明细信息是否合法
     */
    public function isValid()
	{
		
		if($this->iProductID == null) return false;
		if($this->iProductName == null) return false;
		if($this->iUnitPrice<=0) return false;
		if($this->iQty<=0) return false;
		
		if(strlen(trim($this->iProductID))==0) return false;
		if(count(DataVerifier::stringToByteArray($this->iProductID))> self::PRODUCT_ID_LEN ) return false;
		if(strlen(trim($this->iProductName))==0) return false;
		if(count(DataVerifier::stringToByteArray($this->iProductName)) > self::PRODUCT_NAME_LEN ) return false;
		if(!DataVerifier::isValidAmount($this->iUnitPrice,2)) return false;
		return true;
	}
    /**  
     * 取得对象的XML文件
     * @return 购买数量
     */
	public function getXMLDocument(){
		return '<OrderItem>'.
				'<ProductID>'.$this->iProductID.'</ProductID>'.
				'<ProductName>'.$this->iProductName.'</ProductName>'.
				'<UnitPrice>'.strval($this->iUnitPrice).'</UnitPrice>'.
				'<Qty>'.strval($this->iQty).'</Qty>'.
				'</OrderItem>';
	}
}
/*
$o=new orderItem();
$xml='<OrderItem><ProductID>111</ProductID><ProductName>jw</ProductName><UnitPrice>0.25</UnitPrice><Qty>5</Qty></OrderItem>';
$o->__constructXMlDocument($xml);
//$o->__constructOrderItem('111','jw','0.25','4');
echo $o->getProductID()."<br>";
echo $o->getProductName()."<br>";
echo $o->getUnitPrice()."<br>";
echo $o->getQty()."<br>";
echo $o->getAmount()."<br>";
echo $o->isValid();
echo $o->getXMLDocument();
//$o->setProductID('111');
//$o->setProductName('jw');
//$o->setUnitPrice(0.25);
//$o->setQty(4);
echo $o->getAmount();
*/
?>