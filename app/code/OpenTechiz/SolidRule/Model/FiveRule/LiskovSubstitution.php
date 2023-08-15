<?php


namespace OpenTechiz\SolidRule\Model\FiveRule;


class LiskovSubstitution
{
    //Bất cứ instance nào của class cha cũng có thể được thay thế bởi instance của class con của nó mà không làm thay đổi tính đúng đắn của chương trình
    // có thể hiều là ở class cha thì method này có mục đích gì thì khi ở class con override lại thì phải giữ nguyên đc tính đúng đắn và ý nghĩ của method cha
    //VD class cha có method increase() thì khi override ở class con ta ko thể xử lý giảm giá trị đc như thế sẽ vi phạm quy định và dễ gây hiểu nhầm khi sử dụng class
    protected $width;
    protected $height;

    // method có tính năng set value cho property $height
    public function setHeight($height)
    {
        $this->height = $height;
    }

    // method có tính năng set value cho property $width
    public function setWidth($width)
    {
        $this->width = $width;
    }
}

// ở class Square này kế thừa lại class trên và có override lại các method của class cha nhưng nó đã vi phạm nguyên tắc LiskovSubstitution
// do method setHeight ở class cho mục đích chính là setting value cho property $height nhưng khi override lại ở class con thì nó lại
// setting value cho property $width như vậy nếu như thế trong nhiều trường hợp có thể gây ra nhầm lẫn khi call các method này
// ĐÚng ra thì khi override lại thì ta có thể tiến hành xử lý value param truyền vào ban đầu cho đúng như mình mong muốn và cuối cùng
// vần phải set value đấy cho $height như với thẻ cha như thế sẽ tuân thủ đúng rule LiskovSubstitution (không làm thay đổi tính đúng đắn khi đc override)
//class Square extend LiskovSubstitution {
//    public function setHeight($height)
//    {
//        $this->width = $height;
//    }
//
//    public function setWidth($width)
//    {
//        $this->height = $width;
//    }
//
//}
