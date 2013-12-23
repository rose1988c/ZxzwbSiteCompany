<?php
class ajax_page
{
	private $_total_page;
	private $_page = 1;
	private $_per_page = 30;
	public  $_total_num;
	private $_url;
	private $_function_name;
	private $_target_id;
	private $_callback = null;
	
	public function __construct( $option )
	{
		$this->_total_num = $option['total_num'];
		$this->_page = $option['page'];
		$this->_url = $option['url'];
		$this->_function_name = $option['function_name'];
		$this->_target_id = $option['target_id'];
		if( isset($option['per_page']) )
		{
			$this->_per_page = $option['per_page'];
		}
		if( isset($option['callback']) )
		{
			$this->_callback = $option['callback'];
		}
		$this->_total_page = ceil($this->_total_num / $this->_per_page);
	}
	
	public function get_full_url()
	{
		return $url = strpos($this->_url, '?') === false ? $this->_url . '?page=' . $this->_page : $this->_url . '&page=' . $this->_page;
	}
	
	private function _makeurl( $page )
	{
		if( $page < 1 || $page > $this->_total_page )
		return '';
		$url = strpos($this->_url, '?') === false ? $this->_url . '?page=' . $page : $this->_url . '&page=' . $page;
		if( $this->_callback != null )
		{
			return $this->_function_name . "('" . $url . "', '" . $this->_target_id . "', " . $this->_callback . ")";
		}
		return $this->_function_name . "('" . $url . "', '" . $this->_target_id . "')";
	}
	
	/**
	 * 
	 * Desc :cyw 自定义ajax 超链接为 js
	 * Author：cyw
	 * Time：Mar 20, 2012 12:02:18 PM    
	 * @param 页码 $page
	 * @param 参数 $diy
	 */
	private function _makeurl_diy( $page ,$diy )
	{
        if(is_array($diy)) {
            $diy = implode(',', $diy);
        }
		if( $page < 1 || $page > $this->_total_page )
		return '';
		$url = strpos($this->_url, '?') === false ? $this->_url . $diy . ',' . $page : $this->_url . '&page=' . $page;
		return $this->_function_name . "(" . $url . ")";
	}
	
	public function output($diy = false)
	{
		if( $this->_per_page >= $this->_total_num )
		{
			return '';
		}
		
	    if ($diy) {
	  
	        
	        $html = '<div class="ajax_pages">';
    		$html.= $this->_page == 1 
    			  ? '<span class="nextprev">上一页</span>'
    			  : '<a href="javascript:void(0)" onclick="' . $this->_makeurl_diy($this->_page - 1 ,$diy) . '" class="nextprev">上一页</a>';
    		$start = $this->_page - 4 > 1 ? $this->_page - 4 : 1;
    		$end = $this->_page + 4 < $this->_total_page ? $this->_page + 4 : $this->_total_page;
    		if( $start > 1 )
    		{
    			$html.= '<span>...</span>';
    		}
    		for ($i = $start; $i <= $end;$i++)
    		{
    			if( $this->_page == $i )
    			{
    				$html.= '<span class="current">' . $i . '</span>';
    			}
    			else 
    			{
    				$html.= '<a href="javascript:void(0)" onclick="' . $this->_makeurl_diy($i, $diy) . '">' . $i . '</a>';
    			}
    		}
    		if( $end < $this->_total_page )
    		{
    			$html.= '<span>...</span>';
    		}
    		$html.= $this->_page == $this->_total_page
    			  ? '<span class="nextprev">下一页</span>'
    			  : '<a href="javascript:void(0)" onclick="' . $this->_makeurl_diy($this->_page + 1, $diy) . '" class="nextprev">下一页</a>';
    		$html.= '</div>';
    		return $html;
	        
	    } else {
	        //default
    		$html = '<div class="ajax_pages">';
    		$html.= $this->_page == 1 
    			  ? '<span class="nextprev">上一页</span>'
    			  : '<a href="javascript:void(0)" onclick="' . $this->_makeurl($this->_page - 1) . '" class="nextprev">上一页</a>';
    		$start = $this->_page - 4 > 1 ? $this->_page - 4 : 1;
    		$end = $this->_page + 4 < $this->_total_page ? $this->_page + 4 : $this->_total_page;
    		if( $start > 1 )
    		{
    		    $html.= '<a href="javascript:void(0)" onclick="' . $this->_makeurl(1) . '">' . 1 . '</a>';
    			$html.= '<span>...</span>';
    		}
    		for ($i = $start; $i <= $end;$i++)
    		{
    			if( $this->_page == $i )
    			{
    				$html.= '<span class="current">' . $i . '</span>';
    			}
    			else 
    			{
    				$html.= '<a href="javascript:void(0)" onclick="' . $this->_makeurl($i) . '">' . $i . '</a>';
    			}
    		}
    		if( $end < $this->_total_page )
    		{
    			$html.= '<span>...</span>';
    			$html.= '<a href="javascript:void(0)" onclick="' . $this->_makeurl($this->_total_page) . '">' . $this->_total_page . '</a>';
    		}
    		$html.= $this->_page == $this->_total_page
    			  ? '<span class="nextprev">下一页</span>'
    			  : '<a href="javascript:void(0)" onclick="' . $this->_makeurl($this->_page + 1) . '" class="nextprev">下一页</a>';
    		$html.= '</div>';
    		return $html;
	    }
	}
	public function t_0pk_output()
	{
		if( !$this->_total_page )
		{	
			$this->_total_page = 1;
		}
		if( $this->_page == $this->_total_page )
		{
			$html = '<span class="noptional-right mag-t-8"></span>';
		}
		else 
		{
			$html = '<a class="optional-right mag-t-8 " href="javascript:' . $this->_makeurl($this->_page + 1) . '"></a>';
		}
		if( $this->_page == 1 )
		{
			$html.= '<span class="noptional-left mag-t-8 mag-r-7"></span>';
		}
		else 
		{			
			$html.= '<a class="optional-left mag-t-8 mag-r-7" href="javascript:' . $this->_makeurl($this->_page - 1) . '"></a>';
		}
        $html.= '<span class="f-s-16 mag-r-15 float-r">' . $this->_page . '/' . $this->_total_page . '</span>';
        return $html;
	}
	public function t_0pk_output2()
	{
		if( !$this->_total_page )
		{	
			$this->_total_page = 1;
		}
        $html = '<span class="f-c6f7">' . $this->_page . '/' . $this->_total_page . '</span>';
		if( $this->_page == 1 )
		{
			$html.= '<a class="ac-l1-icon"></a>';
		}
		else 
		{			
			$html.= '<a class="ac-l2-icon" href="javascript:' . $this->_makeurl($this->_page - 1) . '"></a>';
		}
		if( $this->_page == $this->_total_page )
		{
			$html.= '<a class="ac-r1-icon"></a>';
		}
		else 
		{
			$html.= '<a class="ac-r2-icon" href="javascript:' . $this->_makeurl($this->_page + 1) . '"></a>';
		}
        return $html;
	}
	public function t_0pk_output3()
	{
		if( !$this->_total_page )
		{	
			$this->_total_page = 1;
		}
		if( $this->_page == 1 )
		{
			$html = '<a class="jtou-L"></a>';
		}
		else 
		{			
			$html = '<a class="jtou-L" href="javascript:' . $this->_makeurl($this->_page - 1) . '"></a>';
		}
        $html.= '<p>&nbsp;&nbsp;' . $this->_page . '/' . $this->_total_page . '&nbsp;&nbsp;</p>';
		if( $this->_page == $this->_total_page )
		{
			$html.= '<a class="jtou-R"></a>';
		}
		else 
		{
			$html.= '<a class="jtou-R" href="javascript:' . $this->_makeurl($this->_page + 1) . '"></a>';
		}
        return $html;
	}
	public function t_0pk_output4()
	{   
		if( !$this->_total_page )
		{	
			$this->_total_page = 1;
		}
        $html = '<span>' . $this->_page . '/' . $this->_total_page . '</span>';
		if( $this->_page == 1 )
		{
			$html.= '<a class="viewBtn_L1"></a>';
		}
		else 
		{			
			$html.= '<a class="viewBtn_L2" href="javascript:' . $this->_makeurl($this->_page - 1) . '"></a>';
		}
		if( $this->_page == $this->_total_page )
		{
			$html.= '<a class="viewBtn_R2"></a>';
		}
		else 
		{
			$html.= '<a class="viewBtn_R1" href="javascript:' . $this->_makeurl($this->_page + 1) . '"></a>';
		}
        return $html;
	}
	
	public function t_0pk_output5()
	{   
		if( !$this->_total_page )
		{	
			$this->_total_page = 1;
		}
        $html = '<p class="fytj">' . $this->_page . '/' . $this->_total_page . '</p>';
		if( $this->_page == 1 )
		{
			$html.= '<span class="syy-an"><a href="javascript:void(0)"></a></span>';
		}
		else 
		{			
			$html.= '<span class="syy-an"><a href="javascript:' . $this->_makeurl($this->_page - 1) . '"></a></span>';
		}
		if( $this->_page == $this->_total_page )
		{
			$html.= '<span class="xyy-an"><a href="javascript:void(0)"></a></span>';
		}
		else 
		{
			$html.= '<span class="xyy-an"><a href="javascript:' . $this->_makeurl($this->_page + 1) . '"></a></span>';
		}
        return $html;
	}
	
	public function group_live_gift_output()
	{   
		if( !$this->_total_page )
		{	
			$this->_total_page = 1;
		}
        $html = '';
		if( $this->_page == 1 )
		{
			$html.= '<a class="arr-left" href="javascript:void(0);"></a>';
		}
		else 
		{			
			$html.= '<a class="arr-left" href="javascript:' . $this->_makeurl($this->_page - 1) . '"></a>';
		}
		if( $this->_page == $this->_total_page )
		{
			$html.= '<a class="arr-right" href="javascript:void(0);"></a>';
		}
		else 
		{
			$html.= '<a class="arr-right" href="javascript:' . $this->_makeurl($this->_page + 1) . '"></a>';
		}
        return $html;
	}
	
	function tournament_output()
	{
	 	if( !$this->_total_page )
		{	
			$this->_total_page = 1;
		}
		$html = '<div class="nextpage">';
        $html .= '<span>' . $this->_page . '/' . $this->_total_page . '</span>';
		if( $this->_page == 1 )
		{
			$html.= '<a class="viewBtn_L1"></a>';
		}
		else 
		{			
			$html.= '<a class="viewBtn_L2" href="javascript:' . $this->_makeurl($this->_page - 1) . '"></a>';
		}
		$html .= '&nbsp;&nbsp;';
		if( $this->_page == $this->_total_page )
		{
			$html.= '<a class="viewBtn_R2"></a>';
		}
		else 
		{
			$html.= '<a class="viewBtn_R1" href="javascript:' . $this->_makeurl($this->_page + 1) . '"></a>';
		}
		$html .= '</div>';
        return $html;   
	}
	public function tournament_output2()
	{
		if( !$this->_total_page )
		{	
			$this->_total_page = 1;
		}
		$html = '';
		if( $this->_page == 1 )
		{
			$html.= '<a class="jtou-Lend"></a>';
		}
		else 
		{			
			$html.= '<a class="jtou-L" href="javascript:' . $this->_makeurl($this->_page - 1) . '"></a>';
		}
		
        $html .= '<p>' . $this->_page . '/' . $this->_total_page . '</p>';
		if( $this->_page == $this->_total_page )
		{
			$html.= '<a class="jtou-Rend"></a>';
		}
		else 
		{
			$html.= '<a class="jtou-R" href="javascript:' . $this->_makeurl($this->_page + 1) . '"></a>';
		}
        return $html;
	}
	public function group_live_output()
	{
		if( !$this->_total_page )
		{	
			$this->_total_page = 1;
		}
		$html = '<div class="yema-a">';
		if( $this->_page == 1 )
		{
			$html.= '<span class="yema-aj"><a href="javascript:void(0)"></a></span>';
		}
		else 
		{			
			$html.= '<span class="yema-aj"><a href="javascript:' . $this->_makeurl($this->_page - 1) . '"></a></span>';
		}
		$html.= '<p>' . $this->_page . '/' . $this->_total_page . '</p>';
		if( $this->_page == $this->_total_page )
		{
			$html.= '<span class="yema-aj2"><a href="javascript:void(0)"></a></span>';
		}
		else 
		{			
			$html.= '<span class="yema-aj2"><a href="javascript:' . $this->_makeurl($this->_page + 1) . '"></a></span>';
		}
		$html.= '</div>';
		return $html;
	}
}
?>