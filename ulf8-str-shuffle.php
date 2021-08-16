<?php

$str = '一位日本法學教師去星巴克點飲料意外發現店員也在杯身上寫下六法全書的內容圖擷取自推特';

//如果想要名字更有真實性，可以把姓氏與名字，做不同陣列再串接
//將一個字轉為一個陣列
//limit:-1
$chrArray = preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);

// print_r($chrArray);

// 會將陣列弄亂，變成隨機
shuffle($chrArray);

//offset:0, length:3；取前面三個元素
$ar = array_slice($chrArray, 0, 3);
// implode() 函數把數組元素組合為一個字符串；重新整理可以得到新的假名
echo implode('', $ar);




// 其他亂數產生器: uniqid()、rand()


