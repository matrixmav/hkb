<?php
class MyLinkPager extends CLinkPager {

  // Add my custom pager css where I remove the hidden property from the first and the last item.
  public function __construct() {
    $this->cssFile = Yii::app()->request->baseUrl.'/css/pager.css';
  }
  
  /**
         * Creates the page buttons.
         * @return array a list of page buttons (in HTML code).
         */
        protected function createPageButtons()
        {
                if(($pageCount=$this->getPageCount())<=1)
                        return array();

                list($beginPage,$endPage)=$this->getPageRange();
                $currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
                $buttons=array();

                // first page
                $buttons[]=$this->createPageButton($this->firstPageLabel,0,self::CSS_FIRST_PAGE,false,false);

                // prev page
                if(($page=$currentPage-1)<0)
                        $page=0;
                $buttons[]=$this->createPageButton($this->prevPageLabel,$page,self::CSS_PREVIOUS_PAGE,$currentPage<=0,false);

                // internal pages
                for($i=$beginPage;$i<=$endPage;++$i)
                        $buttons[]=$this->createPageButton($i+1,$i,self::CSS_INTERNAL_PAGE,false,$i==$currentPage);

                // next page
                if(($page=$currentPage+1)>=$pageCount-1)
                        $page=$pageCount-1;
                $buttons[]=$this->createPageButton($this->nextPageLabel,$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount-1,false);

                // last page
                $buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,self::CSS_LAST_PAGE,$endPage>=$pageCount-1,false);

                return $buttons;
        }

  /**
         * Creates the default pagination.
         * This is called by {@link getPages} when the pagination is not set before.
         * @return CPagination the default pagination instance.
         */
        protected function createPages()
        {
                return new MyPagination;
        }

}
?>
