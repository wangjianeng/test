<?php
function getAccountTypes(){
    return array(
        'Amazon','Site'
    );
}

function getAsinSites(){
    return array(
        'www.amazon.com','www.amazon.ca','www.amazon.mx','www.amazon.co.uk','www.amazon.fr','www.amazon.de','www.amazon.it','www.amazon.es','www.amazon.co.jp'
    );
}
function getMarks(){
    return array(
        'Follow','Important'
    );
}


function getForbidWords(){
	return json_encode(array(
        'review'
    ));
}

function getClosedReson(){
	return array(
		'Customer refused',
		'Listing abandoned',
		'Listing removed' ,
		'Listing limited By Amazon',
		'Review removed by Amazon',
		'Lack information',
		'No reply',
		'Other'
	);
}
function getWarnWords(){
	return json_encode(array(
        'positive','remove','correct','edit','update','negative','neutral','star'
    ));
}

function getReviewWarnWords(){
	return array(
        'fire','explosion','smoke' ,'burn' ,'explode', 'swell', 'flame', 'spark', 'blow-up', 'blow up', 'blowup'
    );
}

function getEType(){
    return array(
        'Listing description issues','Order issues','Customer experience issues',' Manual issues','Transportation issues','Quality issues',' Accessories','Invoice','Gift','Other issues'
    );
}

function getAsinStatus(){
    return array('A'=>'Important','B'=>'Normal','C'=>'Abandon','D'=>'Unlisted');
}

function getReviewStatus(){
    return array(
        '1'=>'None',
		'2'=>'Wait Reply',
		'3'=>'Removed',
		'4'=>'Update 4 stars',
		'5'=>'Update 5 stars',
		'6'=>'Closed',
		'7'=>'Need Buy',
		'8'=>'Need Delete',
    );
}

function getSiteCode(){
     return array(
         'United States' =>'ATVPDKIKX0DER',
         'Canada' =>'A2EUQ1WTGCTBG2',
         'Mexico' =>'A1AM78C64UM0Y8',
         'United Kingdom' =>'A1F83G8C2ARO7P',
         'Germany' =>'A1PA6795UKMFR9',
         'France' =>'A13V1IB3VIYZZH',
         'Italy' =>'APJ6JRA9NG5V4',
         'Spain' =>'A1RKKUPIHCS9HS',
         'Japan' =>'A1VC38T7YXB528'
     );
}

function getSiteConfig(){

    $configUS=array(
        'key_id'=>'AKIAI7UMHLA4P6BPW5AQ',
        'secret_key'=>'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',
        'serviceUrl'=>'https://mws.amazonservices.com'
    );
    $configEU=array(
        'key_id'=>'AKIAIBAZLYIM2J4TS5AA',
        'secret_key'=>'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',
        'serviceUrl'=>'https://mws-eu.amazonservices.com'
    );
    $configJP=array(
        'key_id'=>'AKIAIS5RFQJDH5UFEWSA',
        'secret_key'=>'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',
        'serviceUrl'=>'https://mws.amazonservices.jp'
    );
    return array(
        'ATVPDKIKX0DER' =>$configUS,
        'A2EUQ1WTGCTBG2' =>$configUS,
        'A1AM78C64UM0Y8' =>$configUS,
        'A1F83G8C2ARO7P' =>$configEU,
        'A1PA6795UKMFR9' =>$configEU,
        'A13V1IB3VIYZZH' =>$configEU,
        'APJ6JRA9NG5V4' =>$configEU,
        'A1RKKUPIHCS9HS' =>$configEU,
        'A1VC38T7YXB528' =>$configJP
    );
}

function processResponse($response)
{
    return simplexml_load_string($response->toXML());
}


function getSiteUrl(){
    return array(
        'A2EUQ1WTGCTBG2'=>'amazon.ca',
        'A1PA6795UKMFR9'=>'amazon.de',
        'A1RKKUPIHCS9HS'=>'amazon.es',
        'A13V1IB3VIYZZH'=>'amazon.fr',
        'A21TJRUUN4KGV'=>'amazon.in',
        'APJ6JRA9NG5V4'=>'amazon.it',
        'A1VC38T7YXB528'=>'amazon.co.jp',
        'A1F83G8C2ARO7P'=>'amazon.co.uk',
        'A1AM78C64UM0Y8'=>'amazon.com.mx',
        'ATVPDKIKX0DER'=>'amazon.com'
    );
}

function getSiteCur(){
    return array(
        'amazon.ca'=>'CAD',
        'amazon.de'=>'EUR',
        'amazon.es'=>'EUR',
        'amazon.fr'=>'EUR',
        'amazon.in'=>'INR',
        'amazon.it'=>'EUR',
        'amazon.co.jp'=>'JPY',
        'amazon.co.uk'=>'GBP',
        'amazon.com.mx'=>'MXN',
        'amazon.com'=>'USD'
    );
}


function getReportById($client,$id, $sellerId, $auth_token) {
    ob_start();
    $fileHandle = @fopen('php://memory', 'rw+');
    $parameters = array (
        'Merchant' => $sellerId,
        'Report' => $fileHandle,
        'ReportId' => $id,
        'MWSAuthToken' => $auth_token, // Optional
    );
    $request = new \MarketplaceWebService_Model_GetReportRequest($parameters);
    $response = $client->getReport($request);
    $getReportResult = $response->getGetReportResult();
    $responseMetadata = $response->getResponseMetadata();
    rewind($fileHandle);
    $responseStr = stream_get_contents($fileHandle);
    @fclose($fileHandle);
    ob_end_clean();
    return csv_to_array($responseStr, PHP_EOL, "\t");
}


function csv_to_array($string='', $row_delimiter=PHP_EOL, $delimiter = "," , $enclosure = '"' , $escape = "\\" )
{
    $rows = array_filter(explode($row_delimiter, $string));
    $header = NULL;
    $data = array();

    foreach($rows as $row)
    {
        $row = str_getcsv ($row, $delimiter, $enclosure , $escape);

        if(!$header)
            $header = $row;
        else
            $data[] = array_combine($header, $row);
    }

    return $data;
}

function format_num($string){
    $string=trim($string);
    $d = substr($string,-3,1);
    $string = str_replace(array(',','.'),'',$string);
    if($d==',' || $d=='.'){
        $string = substr_replace($string,'.',-2,0);
    }
    return round($string,2);
}


function html2text($str){
    $str = preg_replace("/<style .*?<\\/style>/is", "", $str);
    $str = preg_replace("/<script .*?<\\/script>/is", "", $str);
    $str = preg_replace("/<br \\s*\\/>/i", "", $str);
    $str = preg_replace("/<\\/?p>/i", "", $str);
    $str = preg_replace("/<\\/?td>/i", "", $str);
    $str = preg_replace("/<\\/?div>/i", "", $str);
    $str = preg_replace("/<\\/?blockquote>/i", "", $str);
    $str = preg_replace("/<\\/?li>/i", "", $str);
    $str = preg_replace("/ /i", " ", $str);
    $str = preg_replace("/ /i", " ", $str);
    $str = preg_replace("/&/i", "&", $str);
    $str = preg_replace("/&/i", "&", $str);
    $str = preg_replace("/</i", "<", $str);
    $str = preg_replace("/</i", "<", $str);
    $str = preg_replace("/“/i", '"', $str);
    $str = preg_replace("/&ldquo/i", '"', $str);
    $str = preg_replace("/‘/i", "'", $str);
    $str = preg_replace("/&lsquo/i", "'", $str);
    $str = preg_replace("/'/i", "'", $str);
    $str = preg_replace("/&rsquo/i", "'", $str);
    $str = preg_replace("/>/i", ">", $str);
    $str = preg_replace("/>/i", ">", $str);
    $str = preg_replace("/”/i", '"', $str);
    $str = preg_replace("/&rdquo/i", '"', $str);
    $str = strip_tags($str);
    $str = html_entity_decode($str, ENT_QUOTES, "utf-8");
    $str = preg_replace("/&#.*?;/i", "", $str);
    return $str;
}

function textimage($content){
	$pattern="/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/";  
	preg_match_all($pattern,$content,$matchContent);  
	if(isset($matchContent[1][0])){  
		$temp=$matchContent[1][0];  
	}else{  
		$temp="./assets/layouts/layout/img/01.jpg";//在相应位置放置一张命名为no-image的jpg图片  
	}
	return $temp;
}

function getSapNumber($str,$decimal){
	if( substr ($str, -1) == '-' ){
		return '-'.round($str,$decimal);
	}else{
		return round($str,$decimal);
	}
}

function getComparisonSymbol(){
	return array('>','>=','=','<=','<');
}
function getComparisonfield(){
	return array('Review','FBA Stock Days','Total Stock Days','Total Stock Value','Daily sales','Profit margin');
}
function getFieldtoField(){
	return array(
				'Review'=>'avg_star',
				'FBA Stock Days'=>'fba_stock_keep',
				'Total Stock Days'=>'stock_keep',
				'Total Stock Value'=>'stock_amount',
				'Daily sales'=>'sales',
				'Profit margin'=>'profits',
			);
}
function getFieldtoSort(){
	return array(
				'sales'=>3,
				'avg_star'=>4,
				'profits'=>7,
				'stock_keep'=>11,
				'stock_amount'=>12,
				'fba_stock_keep'=>9,
			);
}

function siteToMarketplaceid(){
	return array(
			 'amazon.com' =>'ATVPDKIKX0DER',
			 'www.amazon.com' =>'ATVPDKIKX0DER',
			 'www.amazon.ca' =>'A2EUQ1WTGCTBG2',
			 'amazon.ca' =>'A2EUQ1WTGCTBG2',
			 'www.amazon.com.mx' =>'A1AM78C64UM0Y8',
			 'amazon.com.mx' =>'A1AM78C64UM0Y8',
			 'www.amazon.co.uk' =>'A1F83G8C2ARO7P',
			 'www.amazon.uk' =>'A1F83G8C2ARO7P',
			 'amazon.co.uk' =>'A1F83G8C2ARO7P',
			 'amazon.uk' =>'A1F83G8C2ARO7P',
			 'amazon.de' =>'A1PA6795UKMFR9',
			 'www.amazon.de' =>'A1PA6795UKMFR9',
			 'amazon.fr' =>'A13V1IB3VIYZZH',
			 'www.amazon.fr' =>'A13V1IB3VIYZZH',
			 'www.amazon.it' =>'APJ6JRA9NG5V4',
			 'amazon.it' =>'APJ6JRA9NG5V4',
			 'www.amazon.es' =>'A1RKKUPIHCS9HS',
			 'amazon.es' =>'A1RKKUPIHCS9HS',
			 'www.amazon.co.jp' =>'A1VC38T7YXB528',
			 'www.amazon.jp' =>'A1VC38T7YXB528',
			 'amazon.co.jp' =>'A1VC38T7YXB528',
			 'amazon.jp' =>'A1VC38T7YXB528'
		 );
}