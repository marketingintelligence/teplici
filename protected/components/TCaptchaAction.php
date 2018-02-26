<?php

class TCaptchaAction extends CCaptchaAction{

        public $minFont = 32;
        public $maxFont = 40;
    protected function renderImage($code) {
           $image=imagecreatetruecolor($this->width,$this->height);
           if(is_file('images/captcha.png')) {
               $image=imagecreatefrompng('images/captcha.png');
           }elseif(is_file('images/code_bg.png')) {
               $image=imagecreatefrompng('images/code_bg.png');
           }else {
               $image=imagecreatetruecolor($this->width,$this->height);

           $backColor=imagecolorallocate($image,
                   (int)($this->backColor%0x1000000/0x10000),
                   (int)($this->backColor%0x10000/0x100),
                   $this->backColor%0x100);
           imagefilledrectangle($image,0,0,$this->width,$this->height,$backColor);
           imagecolordeallocate($image,$backColor);
           }
           if($this->transparent)
               imagecolortransparent($image,$backColor);

           $foreColor=imagecolorallocate($image,
                   (int)($this->foreColor%0x1000000/0x10000),
                   (int)($this->foreColor%0x10000/0x100),
                   $this->foreColor%0x100);

           $font[1]='Duality.ttf';
           $font[2]='belli.ttf';
           $font[3]='domcasl.ttf';
           //$font[4]='Alexandra.ttf';
    //        $font[4]='kochey.ttf';

           if($this->fontFile===null)
               $this->fontFile=dirname(__FILE__).'/fonts/'.$font[rand(1,3)];

           $offset=-4;
           $length=strlen($code);
           $box=imagettfbbox(30,0,$this->fontFile,$code);
           $w=$box[4]-$box[0]-$offset*($length-1);
           $h=$box[1]-$box[5];
           $scale=min(($this->width-$this->padding*2)/$w,($this->height-$this->padding*2)/$h);
           $x=10;
           $y=round($this->height*27/40);
    //            $fontSize=(int)(rand(26,32)*$scale*0.8);

           $rcolor[1]=imagecolorallocate ($image, 191, 212, 255);
           $rcolor[2]=imagecolorallocate ($image, 212, 212, 212);
           $rcolor[3]=imagecolorallocate ($image, 255, 191, 212);
    //        $white =

           for($i=0;$i<$length;++$i) {
               $fontSize=(int)(rand($this->minFont,$this->maxFont));
               $angle=rand(-10,10);
               $letter=$code[$i];
               $foreColor=imagecolorallocate ($image, rand(50,150),  rand(50,150),  rand(50,150));
               $box=imagettftext($image,$fontSize,$angle,$x,$y,$foreColor,dirname(__FILE__).'/fonts/'.$font[rand(1,3)],$letter);
               imagettftext($image,rand(12,18),$angle,rand(0,120),rand(0,50),$rcolor[rand(1,3)],dirname(__FILE__).'/fonts/'.$font[rand(1,3)],$letter);
               imagettftext($image,rand(12,20),$angle,rand(0,120),rand(0,50),$rcolor[rand(1,3)],$this->fontFile,$letter);
               $x=$box[2]-$offset;
           }

           imagecolordeallocate($image,$foreColor);

           header('Pragma: public');
           header('Expires: 0');
           header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
           header('Content-Transfer-Encoding: binary');
           header("Content-type: image/png");
           imagepng($image);
           imagedestroy($image);
           die;
       }
}
