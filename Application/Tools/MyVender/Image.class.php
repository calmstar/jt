<?php

namespace Tools\MyVender;

class Image
{
    public $inImg;
    public $width;
    public $height;
    public $hashData;

    public function __construct($imgPath)
    {
        $this->inImg = imagecreatefromgif($imgPath);

        //获取图像的大小信息
        $size = getimagesize($imgPath);
        $this->width = $size[0];
        $this->height = $size[1];

        Tool::imgToHash($this);
    }
}
