<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 21.10.13
 * Time: 14:53
 * To change this template use File | Settings | File Templates.
 */

       /*
      :::::::::::::::::::::::::::::::::::::::::::::::::
      ::                                             ::
      ::             H O W  T O  U S E ?             ::
      ::                                             ::
      ::                                             ::
      ::  The keys are the images holder directory   ::
      ::   which created by multichars {A-Za-z0-9}   ::
      ::    and the html <span> style attribute      ::
      ::  <span stlye = "display:block; background:  ::
      ::       url(loader.php?' . $encrypted .       ::
      ::    '=' . $images[$_GET['thumb']] . ');">    ::
      ::                                             ::
      ::                                             ::
      ::                                             ::
      ::              Simple example:                ::
      ::                                             ::
      :: Create a md5 encrypted string and construct ::
      ::   a <span> element inside a <img> element   ::
      ::                                             ::
      ::                                             ::
      ::                                             ::
      :::::::::::::::::::::::::::::::::::::::::::::::::

      PHP code:

      $dir = "myimageholderdirectory1245678";
      $psw = "mypasswordforencrypt/decrypt";
      $md5_encrypt = new md5_encrypt($dir, $psw);
      $encrypted = $md5_encrypt->ret();
      $size = getImageSize($dir . "/image.gif");

      HTML code:

      <span style="display:block; background:url(loader.php?' . $encrypted . '=image.gif);">
       <img src="redirected/protector.gif" alt=""  width=' . $size[0] . ' height=' . $size[1] . '>
      </span>

      The protector.gif is a transparent gif and them size
      resized by <img> with & height attributes.

      Generated example html code:

      <html>
       <span style="display:block;
         background:url(loader.php?RgY9sjDqJVvJ+KNvqDrMNpm/L2/LLESuXtH7bsrbdrDnbk18/Y7t1rEJjDaAhyfD=circle.gif);">
           <img src="redirected/protector.gif" alt="" width=198 height=114>
       </span>
      </html>

      :::::::::::::::::::::::::::::::::::::::::::::::::
      ::                                             ::
      ::        Call the loader.php as image         ::
      ::                                             ::
      ::                                             ::
      ::                                             ::
      ::           P R O T E C T I O N S :           ::
      ::                                             ::
      :: -Disable disk file cache                    ::
      :: -Disable 'right click, save as image...'     ::
      :: -Disable images save by total web mirror    ::
      :: -Disable view image by direct loader url    ::
      :: -Set watermark on the images                ::
      ::                                             ::
      :::::::::::::::::::::::::::::::::::::::::::::::::
      */


class md5_encrypt
{
       private $psw;
       private $iv_len;


       function __construct($password, $iv_len = 16)
       {
              $this->psw = $password;
              $this->iv_len = $iv_len;
       }

       function get_rnd_iv($iv_len)
       {
              $iv = '';
              while ($iv_len-- > 0)
              {
                     $iv .= chr(mt_rand() & 0xff);
              }
              return $iv;
       }

       function ret($plain_text)
       {
              $plain_text .= "\x13";
              $n = strlen($plain_text);
              if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));
              $i = 0;
              $enc_text = $this->get_rnd_iv($this->iv_len);
              $iv = substr($this->psw ^ $enc_text, 0, 512);
              while ($i < $n)
              {
                     $block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
                     $enc_text .= $block;
                     $iv = substr($block . $iv, 0, 512) ^ $this->psw;
                     $i += 16;
              }
              return  base64_encode($enc_text);
       }

}