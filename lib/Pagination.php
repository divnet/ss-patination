<?php

class Pagination{
	private $currentPage;
	private $total;
	private $target = '';
	
	private $rpp = 15;

	public function setCurrent($current = null)
	{
		if (!is_null($current)) {
			$this->currentPage = $current;
		}
	}

	public function getCurrent()
	{
		return $this->currentPage;
	}

	public function setTotal($total = null)
	{
		if (!is_null($total)) {
			$this->total = $total;
		}
	}

	public function getTotal()
	{
		return $this->total;
	}

	public function setTarget($target = null)
	{
		if (!is_null($target)) {
			$this->target = $target;
		}
	}

	public function getTarget()
	{
		return $this->target;
	}

	public function setRpp($rpp = null)
	{
		if (!is_null($rpp)) {
			$this->rpp = $rpp;
		}
	}

	public function getRpp()
	{
		return $this->rpp;
	}

	public function getPages()
	{
		$numberOfPages = (int) ceil($this->getTotal() / $this->getRpp());

		if ($this->getCurrent() >= $numberOfPages) $this->setCurrent($numberOfPages);
		if ($this->getCurrent() <= 1) $this->setCurrent(1);

		$prevPage = $this->getCurrent();
		$nextPage = $this->getCurrent();

		if ($this->getCurrent() > 1)
			$prevPage -= 1;

		if ($this->getCurrent() < $numberOfPages)
			$nextPage += 1;

		return array(
			'totalPages' => $numberOfPages,
			'currentPage' => $this->getCurrent(),
			'prev' => array('page' => $prevPage, 'show' => $this->getCurrent() > 1 ? 1: 0),
			'next' => array('page' => $nextPage, 'show' => $this->getCurrent() < $numberOfPages ? 1: 0)
		);
	}

	public function getNavigation()
	{
		$page = $this->getPages();

		$nav = array();
		$nav[] = '<nav class="footer-navigation"><ul>';
		$nav[] = '<li><a href="'. ($this->getTarget()) .'1"> home page</a> </li>';
		$nav[] = '<li><a rel="prev" href="'.($this->getTarget() . $page['prev']['page']).'"> previous page</a></li>';
		$nav[] = '<li><a class="activePage" href="#">'.($this->getCurrent().' of '.$page['totalPages']).'</a></li>';
		$nav[] = '<li><a rel="next" href="'.($this->getTarget() . $page['next']['page']).'"> next page</a></li>';
		$nav[] = '<li ><a href="'.($this->getTarget() . $page['totalPages']).'"> last page</a></li>';
		$nav[] = "</ul></nav>\r\n";

		return "\r\n". implode("\r\n", $nav);
	}

	public function getPrevNext()
	{
		$prevNextTags = array();
		$page = $this->getPages();

		if ($page['prev']['show']) {
			$prevNextTags = array(
				'<link rel="prev" href="'.$this->getTarget() . ($page['prev']['page']) .'" />'
			);
		}

        if ($page['next']['show']) {
            array_push(
                $prevNextTags,
                '<link rel="next" href="'. $this->getTarget() . ($page['next']['page']) .'" />'
            );
        }
        return "\r\n". implode("\r\n", $prevNextTags);
	}

	public function getCannonicalUrl()
	{
		$canonical = array();

		$page = $this->getTarget() . $this->getCurrent();

		if ($this->getCurrent() == 1) {
			$page = DOMAIN_URL;
		}

		$canonical[] = "<link rel=\"canonical\" href=\"$page\" />";
		return implode('', $canonical);
	}

}
?>