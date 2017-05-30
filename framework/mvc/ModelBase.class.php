<?php
/**
 * モデル共通の処理を記述。各モデルは本クラスを継承しなければならない。
 * Enter description here ...
 * @author apiceuser
 */
class ModelBase {
	private $orderByInsertDate;
	private $orderBySeq;
	private $curPage = 1;

	public function getOrderByInsertDate()
	{
	    return $this->orderByInsertDate;
	}

	public function setOrderByInsertDate($orderByInsertDate)
	{
	    $this->orderByInsertDate = $orderByInsertDate;
	}

	public function getOrderBySeq()
	{
	    return $this->orderBySeq;
	}

	public function setOrderBySeq($orderBySeq)
	{
	    $this->orderBySeq = $orderBySeq;
	}

	public function getCurPage()
	{
	    return $this->curPage;
	}

	public function setCurPage($curPage)
	{
	    $this->curPage = $curPage;
	}
}
?>