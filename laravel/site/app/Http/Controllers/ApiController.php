<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use \DOMDocument;

class ApiController extends Controller
{

  public function getNewProperties() {
    
    /* 
    
      what we want: (not all of these are neccessarily available)
    
      ListingId
      Title
      StartPrice
      StartDate
      EndDate
      PictureHref
      Region
      Suburb
      PriceDisplay
      Address
      District
      RateableValue
      
      GeographicLocation->Latitude
      GeographicLocation->Longitude
    
    */
        
    $url = 'https://api.tmsandbox.co.nz/v1/Search/Property/Residential.json?adjacent_suburbs=false&rows=500&oauth_consumer_key=3A43884C16A5FCF6B8BD69ACE3C9B5FC&oauth_token=C515EADAEB73D756E55FAFF92A30763C&oauth_signature_method=PLAINTEXT&oauth_timestamp=1458893971&oauth_nonce=t5RNzQ&oauth_version=1.0&oauth_signature=71DF939517EA4A02DF83C140CE3E4F2E%26312D4C2A61D110221321D3DC9FA5417C&page=1';
    
    $properties = json_decode(file_get_contents($url));    
    
    echo '<pre>';
    
    echo 'total count: ' . $properties->TotalCount . '<br />';
    echo 'page: ' . $properties->Page . '<br />';
    echo 'page size: ' . $properties->PageSize . '<br />';
    echo 'total pages: ' . ceil($properties->TotalCount / $properties->PageSize) . '<br />';
    echo '---------------------------------------' . '<br />';
    
    foreach ($properties->List as $property) {
      
      echo 'listing id: ' . (!empty($property->ListingId) ? $property->ListingId : '') . '<br />';
      echo 'title: ' . (!empty($property->Title) ? $property->Title : '') . '<br />';
      echo 'start date: ' . (!empty($property->StartDate) ? $this->convertDateToISO($property->StartDate) : '') . '<br />';
      echo 'end date: ' . (!empty($property->EndDate) ? $this->convertDateToISO($property->EndDate) : '') . '<br />';
      echo 'pic url: ' . (!empty($property->PictureHref) ? $property->PictureHref : '') . '<br />';
      echo 'region: ' . (!empty($property->Region) ? $property->Region : '') . '<br />';
      echo 'suburb: ' . (!empty($property->Suburb) ? $property->Suburb : '') . '<br />';
      echo 'address: ' . (!empty($property->Address) ? $property->Address : '') . '<br />';
      echo 'district: ' . (!empty($property->District) ? $property->District : '') . '<br />';
      echo 'price: ' . (!empty($property->PriceDisplay) ? $property->PriceDisplay : '') . '<br />';
      echo 'price int: ' . (!empty($property->PriceDisplay) ? filter_var($property->PriceDisplay, FILTER_SANITIZE_NUMBER_INT) : '') . '<br />';
      echo 'rateable value: ' . (!empty($property->RateableValue) ? $property->RateableValue : '') . '<br />';
      echo 'lat: ' . (!empty($property->GeographicLocation->Latitude) ? $property->GeographicLocation->Latitude : '') . '<br />';
      echo 'long: ' . (!empty($property->GeographicLocation->Longitude) ? $property->GeographicLocation->Longitude : '') . '<br />';
      echo '---------------------------------------' . '<br />';
      
    }

    echo '</pre>';

    //dd($properties->List[0]->Title);
    
  }
  
  public function getAllProperties() {
    
    // this is just my setup method
    
    $url = 'https://api.tmsandbox.co.nz/v1/Search/Property/Residential.json?adjacent_suburbs=false&rows=500&oauth_consumer_key=3A43884C16A5FCF6B8BD69ACE3C9B5FC&oauth_token=C515EADAEB73D756E55FAFF92A30763C&oauth_signature_method=PLAINTEXT&oauth_timestamp=1458893971&oauth_nonce=t5RNzQ&oauth_version=1.0&oauth_signature=71DF939517EA4A02DF83C140CE3E4F2E%26312D4C2A61D110221321D3DC9FA5417C&page=6';
    
    $properties = json_decode(file_get_contents($url));
    
    $i = 0;
    
    foreach ($properties->List as $property) {
      
      DB::table('properties')->insert([
        
        'listing_id'      => (!empty($property->ListingId) ? $property->ListingId : ''),
        'title'           => (!empty($property->Title) ? $property->Title : ''),
        'start_date'      => (!empty($property->StartDate) ? $this->convertDateToISO($property->StartDate) : ''),
        'end_date'        => (!empty($property->EndDate) ? $this->convertDateToISO($property->EndDate) : ''),
        'pic_url'         => (!empty($property->PictureHref) ? $property->PictureHref : ''),
        'region'          => (!empty($property->Region) ? $property->Region : ''),
        'suburb'          => (!empty($property->Suburb) ? $property->Suburb : ''),
        'address'         => (!empty($property->Address) ? $property->Address : ''),
        'district'        => (!empty($property->District) ? $property->District : ''),
        'price'           => (!empty($property->PriceDisplay) ? $property->PriceDisplay : ''),
        'price_int'       => (!empty($property->PriceDisplay) ? filter_var($property->PriceDisplay, FILTER_SANITIZE_NUMBER_INT) : ''),
        'rateable_value'  => (!empty($property->RateableValue) ? $property->RateableValue : ''),
        'lat'             => (!empty($property->GeographicLocation->Latitude) ? $property->GeographicLocation->Latitude : ''),
        'long'            => (!empty($property->GeographicLocation->Longitude) ? $property->GeographicLocation->Longitude : ''),
        'last_update'     => date('Y-m-d H:i:s')
        
      ]);
      
      $i++;
      
    }
    
    echo $i . ' rows added.';
    
  }
  
  public function generateKML() {
    
    // get properties
    $properties = DB::table('properties')->get();
    
    /* create a dom document with encoding utf8 */
    $domTree = new DOMDocument('1.0', 'UTF-8');

    /* create the root element of the xml tree */
    //$xmlRoot = $domtree->createElement('kml');
    $xmlRoot = $domTree->createElementNS('http://www.opengis.net/kml/2.2', 'kml');
    
    /* append it to the document created */
    $xmlRoot = $domTree->appendChild($xmlRoot);
    
    $document = $domTree->createElement('Document');
    $document = $xmlRoot->appendChild($document);
    
    $name = $domTree->createElement('name');
    $name = $document->appendChild($name);
    
    $nameText = $domTree->createTextNode('Properties');
    $name->appendChild($nameText);
    
    foreach ($properties as $property) {
      
      $placemark = $domTree->createElement('Placemark');
      $placemark = $document->appendChild($placemark);
      
      $name = $domTree->createElement('name');
      $placemark->appendChild($name);

      $nameText = $domTree->createTextNode($property->title);
      $name->appendChild($nameText);
      
      $description = $domTree->createElement('description');
      $placemark->appendChild($description);

      $descriptionText = $domTree->createTextNode($property->address);
      $description->appendChild($descriptionText);
      
      
      // now add coordinates
      
      $point = $domTree->createElement('Point');
      $placemark->appendChild($point);
      
      $coordinates = $domTree->createElement('coordinates');
      $point->appendChild($coordinates);
      
      $coordinatesText = $domTree->createTextNode($property->long . ',' . $property->lat . ',0');
      $coordinates->appendChild($coordinatesText);
        
      
    }


    /* get the xml printed */
    return response($domTree->saveXML())->header('Content-Type', 'application/vnd.google-earth.kml+xml');
    
  }
  
  private function convertDateToISO($date) {
                     
    $date = preg_replace('/[^\d]/','', $date);
    
    return date('Y-m-d H:i:s', intval($date/1000));
    
  }
  
}
