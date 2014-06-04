<?php
class XmlTools{
	public function convertXmlObjToArr($obj, &$arr)
	{
	    $children = $obj->children();
	    foreach ($children as $elementName => $node)
	    {
	        $nextIdx = count($arr);
	        $arr[$nextIdx] = array();
	        $arr[$nextIdx]['@name'] = strtolower((string)$elementName);
	        $arr[$nextIdx]['@attributes'] = array();
	        $attributes = $node->attributes();
	        foreach ($attributes as $attributeName => $attributeValue)
	        {
	            $attribName = strtolower(trim((string)$attributeName));
	            $attribVal = trim((string)$attributeValue);
	            $arr[$nextIdx]['@attributes'][$attribName] = $attribVal;
	        }
	        $text = (string)$node;
	        $text = trim($text);
	        if (strlen($text) > 0)
	        {
	            $arr[$nextIdx]['@text'] = $text;
	        }
	        $arr[$nextIdx]['@children'] = array();
	        $this->convertXmlObjToArr($node, $arr[$nextIdx]['@children']);
	    }
	    return;
	}  
}