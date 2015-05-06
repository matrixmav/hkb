<?php
class MyPagination extends CPagination {
  
  /**
         * Creates the URL suitable for pagination.
         * This method is mainly called by pagers when creating URLs used to
         * perform pagination. The default implementation is to call
         * the controller's createUrl method with the page information.
         * You may override this method if your URL scheme is not the same as
         * the one supported by the controller's createUrl method.
         * @param CController the controller that will create the actual URL
         * @param integer the page that the URL should point to. This is a zero-based index.
         * @return string the created URL
         */
        public function createPageUrl($controller,$page)
        {
                $params=$this->params===null ? $_GET : $this->params;
    // All of the pages get the page number parameter now, even if it's page one
    $params[$this->pageVar]=$page+1;
                return $controller->createUrl($this->route,$params);
        }
}
?>
