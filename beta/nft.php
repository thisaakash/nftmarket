<?php

  if(isset($_POST['userId']))
  $address = $_POST['userId'];
else{
  header("location:new/login.php");
}


  //$address = "0x287A2b0d030cbEbC45b2238d11B4FA65C1a83F6b";

$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt_array($curl, [
  //CURLOPT_URL => "https://api.nftport.xyz/v0/nfts/".$thash."/". $tid."?chain=polygon&refresh_metadata=true",
  CURLOPT_URL => "https://api.nftport.xyz/v0/accounts/".$address."?chain=polygon",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "Authorization: 129c97b6-e30e-48db-bedd-a56489059577",
    "Content-Type: application/json"
  ],
]);

$str = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else 
{

  if(strpos($str,'invalid_address'))
  {
    echo "Invalid Address";
  }
  else{
      $array=array(array());
      while($i=strpos($str,'contract_address')!==false||$i=strpos($str,'token_id')!==false)
      {  
      $str=substr($str,strpos($str,'contract_address":"')+19);
      $contractAddress= substr($str,0,strpos($str,'","'));
      $str=substr($str,strpos($str,'token_id":"')+11);
      $token_idMAIN= substr($str,0,strpos($str,'","'));
      $array=array_merge($array,array(array("contractAddress"=>"$contractAddress","token_id"=>"$token_idMAIN")));
      }
      array_shift($array);
          
      foreach ($array as $k=>$v)
      {
          
       //   echo $array[$k]["contractAddress"]."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
       //   echo $array[$k]["token_id"];
          
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
          curl_setopt_array($curl, [
          CURLOPT_URL => "https://api.nftport.xyz/v0/nfts/".$array[$k]["contractAddress"]."/".$array[$k]["token_id"]."?chain=polygon&refresh_metadata=true",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => [
                "Authorization: 129c97b6-e30e-48db-bedd-a56489059577",
                "Content-Type: application/json"
              ],
            ]);

          $got = curl_exec($curl);
          $err = curl_error($curl);
          curl_close($curl);     
         
  //        echo $got;

          $array2=array(array());
          while($i=strpos($got,'cached_file_url')!==false)
          {  
          
          $got=substr($got,strpos($got,'cached_file_url":"')+18);
          $token_idMAIN= substr($got,0,strpos($got,'","'));
          $array2=array_merge($array2,array(array("url"=>"$token_idMAIN")));
          }
          array_shift($array2);

          
          foreach ($array2 as $a=>$b)
          {   
          
          ?>       
       <img src="<?php echo $array2[$a]["url"];?>" height="200px" width="200px">     
        <?php      
          }
      }     
    }
  }
?>



 
