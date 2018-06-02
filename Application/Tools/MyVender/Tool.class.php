<?php

namespace Tools\MyVender;

class Tool
{
    /**
     * 图像二值化
     *
     * @param Image $img
     * @return array 灰度图二维数组
     */
    public static function imgToHash($img)
    {
        $data = [];
        for ($i = 0; $i < $img->height; $i++) {
            for ($j = 0; $j < $img->width; $j++) {
                $rgb = imagecolorat($img->inImg, $j, $i);
                $rgb = imagecolorsforindex($img->inImg, $rgb);
                if ($rgb['red'] == $rgb['green'] && $rgb['red'] == $rgb['blue']) {
                    $data[$i][$j] = 0;
                } else {
                    $data[$i][$j] = 1;
                }
            }
        }
        $img->hashData = $data;
        return $data;
    }

    /**
     * 字符切割
     *
     * @param Image $img
     * @return array
     */
    public static function split($img)
    {
        $blocks = ['', '', '', '', ''];
        for ($i = 5; $i < 17; $i++) {
            for ($j = 5; $j < 49; $j++) {
                if (($j - 5) % 9 == 8) {
                    continue;
                }

                $num = ($j - 5) / 9;
                $blocks[$num] .= $img->hashData[$i][$j];
            }
        }
        return $blocks;
    }

    /**
     * 字符匹配
     *
     * @param array $blocks
     * @return string $result
     */
    public static function match($blocks)
    {
        $codes = [
            0 => '001111000111111011100111110000111100001111000011110000111100001111000011111001110111111000111100',
            1 => '000011000001110000111100011011000100110000001100000011000000110000001100000011000000110000001100',
            2 => '001111000111111011100011110000110000001100000110000011100001110000111000011000001111111111111111',
            3 => '001111100111111111000011000000110001111000011110000001110000001111000011111001110111111000111100',
            4 => '000001100000111000001110000111100011011000110110011001101100011011111111111111110000011000000110',
            5 => '011111100111111001100000111000001111110011111110110001110000001111000011111001110111111000111100',
            6 => '001111100111111101100011110000001101110011111110111001111100001111000011011000110111111000111100',
            7 => '111111111111111100000110000011000000110000011000000110000001100000111000001100000011000000110000',
            8 => '001111000111111011000011110000111100001101111110011111101100001111000011110000110111111000111100',
            9 => '001111000111111011000110110000111100001111100111011111110011101100000011110001101111111001111100',
        ];

        $result = '';
        foreach ($blocks as $block) {
            $maxScore = 0;
            $maxScoreKey = 0;
            foreach ($codes as $key => $code) {
                $score = 0;
                for ($i = 0, $j = strlen($code); $i < $j; $i++) {
                    if ($code[$i] == $block[$i]) {
                        $score++;
                    }
                }

                if ($score > $maxScore) {
                    $maxScore = $score;
                    $maxScoreKey = $key;
                }
            }
            $result .= $maxScoreKey;
        }
        return $result;
    }

    /**
     * 画出二值图
     *
     * @param Image $data
     * @return void
     */
    public static function draw($img)
    {
        foreach ($img->hashData as $v) {
            foreach ($v as $val) {
                $color = $val ? '#000' : '#eee';
                echo "<span style='color: $color;font-family: Consolas, Monaco, monospace;'>&#x2022;</span>";
            }
            echo "<br>";
        }
    }
}
