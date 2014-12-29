<?php 
class OnlineRmtBatch 
{
	/**
	 * 查询结果明细。为QueryResult对象的ArrayList集合。
	 */
	private $iQueryResults = array();
	

	/**
	 * 构造OnlineRmtBatch对象
	 */
	public function __construct()
	{
		
	}
	

	/**
	 * 初始化OnlineRmtBatch对象
	 */
	public function constructOnlinRmtBatch($aXMLDocument)
	{
		$xml=new XMLDocument($aXMLDocument);
		$this->iQueryResults=$xml->getValueArray('BatchItem');
	}
	
	public function  addQueryResult($aQueryResult)
	{
		$this->iQueryResults=array_push($this->iQueryResults, $aQueryResult);
	}
	/**
	 * @return the $iQueryResults
	 */
	public function getQueryResults() {
		return $this->iQueryResults;
	}

	/**
	 * @param multitype: $iQueryResults
	 */
	public function setQueryResults($iQueryResults) {
		$this->iQueryResults = $iQueryResults;
	}

	
}
$orb=new OnlineRmtBatch();

?>