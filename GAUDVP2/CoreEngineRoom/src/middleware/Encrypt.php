<?php

class Aes
{
    const M_CBC = 'cbc';
    const M_CFB = 'cfb';
    const M_ECB = 'ecb';
    const M_NOFB = 'nofb';
    const M_OFB = 'ofb';
    const M_STREAM = 'stream';

    protected $key;
    protected $cipher;
    protected $data;
    protected $mode;
    protected $IV;
/**
*
* @param type $data
* @param type $key
* @param type $blockSize
* @param type $mode
*/
    function __construct($data = null, $key = null, $blockSize = null, $mode = null)
    {
        $this->setData($data);
        $this->setKey($key);
        $this->setBlockSize($blockSize);
        $this->setMode($mode);
        $this->setIV("1234567891234567");
    }

/**
*
* @param type $data
*/
    public function setData($data)
    {
        $this->data = $data;
    }

/**
*
* @param type $key
*/
  public function setKey($key) {
    $this->key = $key;
  }

/**
*
* @param type $blockSize
*/
  public function setBlockSize($blockSize)
  {
    switch ($blockSize) {
      case 128:
      $this->cipher = MCRYPT_RIJNDAEL_128;
      break;

      case 192:
      $this->cipher = MCRYPT_RIJNDAEL_192;
      break;

      case 256:
      $this->cipher = MCRYPT_RIJNDAEL_256;
      break;
    }
  }

/**
*
* @param type $mode
*/
  public function setMode($mode) {
    switch ($mode) {
      case AES::M_CBC:
      $this->mode = MCRYPT_MODE_CBC;
      break;
      case AES::M_CFB:
      $this->mode = MCRYPT_MODE_CFB;
      break;
      case AES::M_ECB:
      $this->mode = MCRYPT_MODE_ECB;
      break;
      case AES::M_NOFB:
      $this->mode = MCRYPT_MODE_NOFB;
      break;
      case AES::M_OFB:
      $this->mode = MCRYPT_MODE_OFB;
      break;
      case AES::M_STREAM:
      $this->mode = MCRYPT_MODE_STREAM;
      break;
      default:
      $this->mode = MCRYPT_MODE_ECB;
      break;
    }
  }

/**
*
* @return boolean
*/
  public function validateParams() {
    if ($this->data != null &&
        $this->key != null &&
        $this->cipher != null) {
      return true;
    } else {
      return FALSE;
    }
  }

  public function setIV($IV) {
        $this->IV = ($IV);
    }
  protected function getIV() {
      if ($this->IV == "") {
        $this->IV = mcrypt_create_iv(mcrypt_get_iv_size($this->cipher, $this->mode), MCRYPT_RAND);
      }
      return $this->IV;
  }

/**
* @return type
* @throws Exception
*/
  public function encrypt() {

    if ($this->validateParams()) {

      return
        mcrypt_encrypt(
          $this->cipher, $this->key, $this->data, $this->mode);

    } else {
      throw new \Exception('Invlid params!');
    }
  }
/**
*
* @return type
* @throws Exception
*/
    public function decrypt()
    {
        if ($this->validateParams()) {
          return (mcrypt_decrypt(
            $this->cipher, $this->key, $this->data, $this->mode));
        } else {
          throw new \Exception('Invlid params!');
        }
    }

  public function pkcs5_pad ($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        
//        echo '$text : '.$text.'<br>';
//        echo 'strlen($text) : '.strlen($text).'<br>';
//        echo '$blocksize : '.$blocksize.'<br>';
//        echo '$pad : '.$pad.'<br>';
//        die('133');
        return $text . str_repeat(chr($pad), $pad);
    }


    public function encode($image,$key=null)
    {
//        echo $image;
//        $imageType=substr($image, strpos($image, ".") + 1);
        $blockSize = 128;
//        $inputKey = "1234567891234567";
        if(empty($key)) {
            $inputKey = AES_ENCRYPTION_KEY;
        } else {
            $inputKey = $key;
        }
        
        $aes = new AES("", $inputKey, $blockSize);
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
$image = $image;
        $input = $aes->pkcs5_pad($image, $size);
        $aes->setData($input);
//        $aes->setData($image);
        $enc = $aes->encrypt();

        $enc = trim(base64_encode($enc));
        return $enc;
    }

    public function decode($image,$key=null) {
        
        $image = base64_decode($image);
        
//        $imageType=substr($image, strpos($image, ".") + 1);
        $blockSize = 128;
//        $inputKey = "1234567891234567";
        if(empty($key)) {
            $inputKey = AES_ENCRYPTION_KEY;
        } else {
            $inputKey = $key;
        }
        $aes = new AES("", $inputKey, $blockSize);
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);

//        $input = $aes->pkcs5_pad($image, $size);
//        $aes->setData($input);
        $aes->setData($image);

        $dec = $aes->decrypt();        
        
        
        $url = filter_var($dec, FILTER_VALIDATE_URL);
//        if(!empty($url) && !empty($dec)) {
            $dec_s = strlen($dec);
            $padding = ord($dec[$dec_s-1]);
            $dec = substr($dec, 0, -$padding); 
//        } 


        return $dec;
    }

    public function encoded($images)
    {
       // return $enc;
    }
}

?>