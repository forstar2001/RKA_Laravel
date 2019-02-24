<?php
mysql_connect('localhost', 'root', '') or die('NOT CONNECTED');
mysql_select_db('edditzco_realestate');

$query = mysql_query('SELECT SystemID FROM properties');

while($result = mysql_fetch_array($query)){
 
    $query1 = mysql_query('SELECT image FROM property_images WHERE property_id='.$result['SystemID'].' LIMIT 0,1');
    $property_images=mysql_fetch_array($query1);   

    mysql_query('UPDATE properties SET image_name="'.$property_images['image'].'" WHERE SystemID='.$result['SystemID'].'');     
    
}
?>